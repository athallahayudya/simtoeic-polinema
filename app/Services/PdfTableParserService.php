<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Exception;

class PdfTableParserService
{
    /**
     * Parse PDF file and extract table data
     *
     * @param string $pdfPath Path to the PDF file
     * @return array Parsed table data
     * @throws Exception
     */
    public function parsePdfTables($pdfPath)
    {
        try {
            // Check if file exists
            if (!file_exists($pdfPath)) {
                throw new Exception("PDF file not found: {$pdfPath}");
            }

            // Create a temporary directory for processing
            $tempDir = storage_path('app/temp/pdf_parsing');
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // Generate unique filename for output
            $outputFile = $tempDir . '/' . uniqid('parsed_') . '.json';

            // Use Node.js script to parse PDF
            $nodeScript = base_path('resources/js/pdf-parser.js');

            // Create the Node.js script if it doesn't exist
            if (!file_exists($nodeScript)) {
                $this->createNodeScript($nodeScript);
            }

            // Execute Node.js script
            $command = "node \"{$nodeScript}\" \"{$pdfPath}\" \"{$outputFile}\" 2>&1";

            Log::info("Executing PDF parsing command: {$command}");

            $output = [];
            $returnCode = 0;
            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                $errorOutput = implode("\n", $output);
                Log::error("PDF parsing command failed with return code {$returnCode}: {$errorOutput}");
                throw new Exception("PDF parsing failed: " . $errorOutput);
            }

            Log::info("PDF parsing command output: " . implode("\n", $output));

            // Read the parsed data
            if (!file_exists($outputFile)) {
                throw new Exception("Parsing output file not found");
            }

            $jsonData = file_get_contents($outputFile);
            $parsedData = json_decode($jsonData, true);

            // Clean up temporary file
            unlink($outputFile);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Invalid JSON output from parser: " . json_last_error_msg());
            }

            return $this->processTableData($parsedData);
        } catch (Exception $e) {
            Log::error("PDF parsing error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create Node.js script for PDF parsing
     *
     * @param string $scriptPath
     */
    private function createNodeScript($scriptPath)
    {
        $scriptDir = dirname($scriptPath);
        if (!is_dir($scriptDir)) {
            mkdir($scriptDir, 0755, true);
        }

        $scriptContent = <<<'JS'
const fs = require('fs');
const path = require('path');

// Import the PDF parser (you'll need to install this via npm)
// For now, we'll use a simple PDF text extraction approach
const pdf = require('pdf-parse');

async function parsePdfTables(pdfPath, outputPath) {
    try {
        const dataBuffer = fs.readFileSync(pdfPath);
        const data = await pdf(dataBuffer);
        
        // Extract text and try to parse table structure
        const text = data.text;
        const lines = text.split('\n').filter(line => line.trim());
        
        // Look for table patterns in TOEIC results
        const tableData = [];
        let headerFound = false;
        let headers = [];
        
        for (let i = 0; i < lines.length; i++) {
            const line = lines[i].trim();
            
            // Skip empty lines
            if (!line) continue;
            
            // Look for header row (contains RESULT, NAME, ID, L, R, TOT)
            if (!headerFound && (line.includes('RESULT') || line.includes('NAME') || line.includes('ID'))) {
                // Try to extract headers
                const possibleHeaders = line.split(/\s+/);
                if (possibleHeaders.some(h => ['RESULT', 'NAME', 'ID', 'L', 'R', 'TOT'].includes(h.toUpperCase()))) {
                    headers = possibleHeaders.map(h => h.toUpperCase());
                    headerFound = true;
                    continue;
                }
            }
            
            // If we found headers, try to parse data rows
            if (headerFound) {
                // Look for lines that might contain student data
                // Pattern: RESULT_# Name ID L_score R_score Total
                const dataMatch = line.match(/^(RESULT[_#]?\d+)\s+(.+?)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/i);
                
                if (dataMatch) {
                    const [, result, name, id, l, r, tot] = dataMatch;
                    tableData.push({
                        result: result.trim(),
                        name: name.trim(),
                        id: id.trim(),
                        L: parseInt(l),
                        R: parseInt(r),
                        tot: parseInt(tot)
                    });
                }
            }
        }
        
        // If no structured data found, try alternative parsing
        if (tableData.length === 0) {
            // Look for any numeric patterns that might be scores
            for (const line of lines) {
                const scorePattern = /(\w+)\s+(.+?)\s+(\d{8,})\s+(\d{1,3})\s+(\d{1,3})\s+(\d{3,4})/;
                const match = line.match(scorePattern);
                
                if (match) {
                    const [, result, name, id, l, r, tot] = match;
                    tableData.push({
                        result: result.trim(),
                        name: name.trim(),
                        id: id.trim(),
                        L: parseInt(l),
                        R: parseInt(r),
                        tot: parseInt(tot)
                    });
                }
            }
        }
        
        const result = {
            success: true,
            tables: [{
                headers: ['result', 'name', 'id', 'L', 'R', 'tot'],
                data: tableData
            }],
            rawText: text
        };
        
        fs.writeFileSync(outputPath, JSON.stringify(result, null, 2));
        console.log(`Parsed ${tableData.length} records`);
        
    } catch (error) {
        const errorResult = {
            success: false,
            error: error.message,
            tables: []
        };
        fs.writeFileSync(outputPath, JSON.stringify(errorResult, null, 2));
        console.error('Error parsing PDF:', error.message);
        process.exit(1);
    }
}

// Get command line arguments
const pdfPath = process.argv[2];
const outputPath = process.argv[3];

if (!pdfPath || !outputPath) {
    console.error('Usage: node pdf-parser.js <pdf-path> <output-path>');
    process.exit(1);
}

parsePdfTables(pdfPath, outputPath);
JS;

        file_put_contents($scriptPath, $scriptContent);
    }

    /**
     * Process and normalize table data
     *
     * @param array $parsedData
     * @return array
     */
    private function processTableData($parsedData)
    {
        if (!$parsedData['success']) {
            throw new Exception("PDF parsing failed: " . ($parsedData['error'] ?? 'Unknown error'));
        }

        $processedData = [];

        foreach ($parsedData['tables'] as $table) {
            if (empty($table['data'])) {
                continue;
            }

            foreach ($table['data'] as $row) {
                // Map PDF columns to our database structure
                $processedRow = [
                    'exam_id' => $row['result'] ?? null,
                    'name' => $row['name'] ?? null,
                    'nim' => $row['id'] ?? null,
                    'listening_score' => $row['L'] ?? 0,
                    'reading_score' => $row['R'] ?? 0,
                    'total_score' => $row['tot'] ?? 0,
                ];

                // Validate required fields
                if (empty($processedRow['nim']) || empty($processedRow['name'])) {
                    Log::warning("Skipping row with missing required data", $processedRow);
                    continue;
                }

                // Determine status based on total score
                $processedRow['status'] = $processedRow['total_score'] >= 500 ? 'pass' : 'fail';

                $processedData[] = $processedRow;
            }
        }

        Log::info("Processed " . count($processedData) . " valid records from PDF");

        return $processedData;
    }
}
