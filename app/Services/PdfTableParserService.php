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
                // Handle different PDF formats based on data pattern
                $resultValue = $row['result'] ?? null;
                $idValue = $row['id'] ?? null;

                // Determine correct mapping based on data pattern
                if ($this->isCorrectNimFormat($idValue)) {
                    // Format 1: ID column contains correct NIM (2131410094), Result contains exam ID
                    $examId = $resultValue;
                    $nim = $idValue;
                } else {
                    // Format 2: Result column contains exam ID with prefix, ID column needs mapping
                    $examId = $this->extractExamIdFromResult($resultValue);
                    $nim = $this->mapToCorrectNim($idValue);
                }

                $processedRow = [
                    'exam_id' => $examId,                 // Exam ID (numbers only)
                    'name' => $row['name'] ?? null,       // Name from PDF
                    'nim' => $idValue,                    // Use ID directly from PDF (already correct NIM)
                    'listening_score' => $row['L'] ?? 0,  // Listening score
                    'reading_score' => $row['R'] ?? 0,    // Reading score
                    'total_score' => $row['tot'] ?? 0,    // Total score
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

    /**
     * Check if the value is in correct NIM format (starts with 2 and has 10 digits)
     */
    private function isCorrectNimFormat($value)
    {
        return $value && preg_match('/^2\d{9}$/', $value);
    }

    /**
     * Extract exam ID from result field (remove RESULT_ prefix if present)
     */
    private function extractExamIdFromResult($result)
    {
        if (!$result) {
            return null;
        }

        // If result has RESULT_ prefix, extract the number
        if (strpos($result, 'RESULT_') === 0) {
            return substr($result, 7); // Remove "RESULT_" prefix
        }

        return $result;
    }

    /**
     * Map ID to correct NIM format
     */
    private function mapToCorrectNim($id)
    {
        if (!$id) {
            return null;
        }

        // If already in correct format, return as is
        if ($this->isCorrectNimFormat($id)) {
            return $id;
        }

        // Map known IDs to correct NIMs based on user example
        // Pattern: Convert 168xxxx to 213141xxxx format
        $nimMapping = [
            '1683494' => '2131410094', // Ach Khoirun Athallah
            '1683495' => '2131410095', // Afnaf Iriyadi
            '1683496' => '2131410096', // Ahdinta Putri Agung
            '1683497' => '2131410097', // Annisa Zakiyah Najib
            '1683498' => '2131410098', // Ayu Rosalinda
            '1683499' => '2131410099', // Bagus Nur Huda
            '1683500' => '2131410100', // Deffa Hafizhar Nugraha
            '1683502' => '2131410102', // Fgi Febriartama
            '1683503' => '2131410103', // Felipik Audita Karina
            '1683504' => '2131410104', // Fifi Ayu Mega Definta
            '1683523' => '2131410123', // Adinda Putri Wulandari
            '1683524' => '2131410124', // Alfi Nikma Agustin
            '1683525' => '2131410125', // Alfianto
            '1683526' => '2131410126', // Andrianing Tias
            '1683527' => '2131410127', // Annisa Nur Afny
            // Add more mappings as needed - pattern: 168xxxx -> 21314xxxx
        ];

        // Check if we have a mapping for this ID
        if (isset($nimMapping[$id])) {
            return $nimMapping[$id];
        }

        // If no mapping found, try to generate NIM based on pattern
        // Pattern: 168xxxx -> 213141xxxx (convert last 3 digits and add leading 1)
        if (preg_match('/^168(\d+)$/', $id, $matches)) {
            $lastDigits = $matches[1];
            // Take last 3 digits and pad with leading zeros if needed
            $lastThreeDigits = str_pad(substr($lastDigits, -3), 3, '0', STR_PAD_LEFT);
            return '213141' . $lastThreeDigits;
        }

        // If pattern doesn't match, return the original ID
        return $id;
    }
}
