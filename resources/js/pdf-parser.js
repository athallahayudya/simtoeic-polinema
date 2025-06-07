const fs = require('fs');
const path = require('path');

// Import the PDF parser
const pdf = require('pdf-parse');

async function parsePdfTables(pdfPath, outputPath) {
    try {
        console.log(`Starting PDF parsing for: ${pdfPath}`);
        
        const dataBuffer = fs.readFileSync(pdfPath);
        const data = await pdf(dataBuffer);
        
        // Extract text and try to parse table structure
        const text = data.text;
        const lines = text.split('\n').filter(line => line.trim());
        
        console.log(`Extracted ${lines.length} lines from PDF`);
        
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
                    console.log('Found headers:', headers);
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
                    const record = {
                        result: result.trim(),
                        name: name.trim(),
                        id: id.trim(),
                        L: parseInt(l),
                        R: parseInt(r),
                        tot: parseInt(tot)
                    };
                    tableData.push(record);
                    console.log('Parsed record:', record);
                }
            }
        }
        
        // If no structured data found, try alternative parsing methods
        if (tableData.length === 0) {
            console.log('No structured data found, trying alternative parsing...');

            // Method 1: Parse the specific format from the PDF
            // Format appears to be: NIM \n L R TOT Name Category
            for (let i = 0; i < lines.length; i++) {
                const line = lines[i].trim();

                // Look for NIM pattern (7-digit number starting with 168)
                const nimMatch = line.match(/^(168\d{4})$/);
                if (nimMatch && i + 1 < lines.length) {
                    const nim = nimMatch[1];
                    const nextLine = lines[i + 1].trim();

                    // Parse the next line for scores and name
                    // Pattern: L R TOT Name Category
                    const scoreMatch = nextLine.match(/^(\d{1,3})\s+(\d{1,3})\s+(\d{3,4})(.+?)(\d+)\s*$/);

                    if (scoreMatch) {
                        const [, l, r, tot, nameWithSpaces, category] = scoreMatch;
                        const name = nameWithSpaces.trim();

                        // Validate score ranges
                        const listeningScore = parseInt(l);
                        const readingScore = parseInt(r);
                        const totalScore = parseInt(tot);

                        if (listeningScore >= 5 && listeningScore <= 495 &&
                            readingScore >= 5 && readingScore <= 495 &&
                            totalScore >= 10 && totalScore <= 990) {

                            const record = {
                                result: `RESULT_${nim}`,
                                name: name,
                                id: nim,
                                L: listeningScore,
                                R: readingScore,
                                tot: totalScore
                            };
                            tableData.push(record);
                            console.log('Parsed record:', record);
                        }
                    }
                }
            }

            // Method 2: Try parsing the raw text as a continuous string
            if (tableData.length === 0) {
                console.log('Trying continuous text parsing...');

                // Remove line breaks and parse as continuous text
                const continuousText = text.replace(/\n/g, ' ').replace(/\s+/g, ' ');

                // Look for pattern: NIM followed by scores and name
                const pattern = /(168\d{4})\s+(\d{1,3})\s+(\d{1,3})\s+(\d{3,4})([A-Za-z\s]+?)(?=168\d{4}|\d+\s*$|$)/g;
                let match;

                while ((match = pattern.exec(continuousText)) !== null) {
                    const [, nim, l, r, tot, nameWithExtra] = match;

                    // Clean up the name (remove trailing numbers/categories)
                    const name = nameWithExtra.replace(/\s+\d+\s*$/, '').trim();

                    const listeningScore = parseInt(l);
                    const readingScore = parseInt(r);
                    const totalScore = parseInt(tot);

                    if (name && listeningScore >= 5 && listeningScore <= 495 &&
                        readingScore >= 5 && readingScore <= 495 &&
                        totalScore >= 10 && totalScore <= 990) {

                        const record = {
                            result: `RESULT_${nim}`,
                            name: name,
                            id: nim,
                            L: listeningScore,
                            R: readingScore,
                            tot: totalScore
                        };
                        tableData.push(record);
                        console.log('Continuous parsed record:', record);
                    }
                }
            }
        }
        
        const result = {
            success: true,
            tables: [{
                headers: ['result', 'name', 'id', 'L', 'R', 'tot'],
                data: tableData
            }],
            rawText: text.substring(0, 1000) // Include first 1000 chars for debugging
        };
        
        fs.writeFileSync(outputPath, JSON.stringify(result, null, 2));
        console.log(`Successfully parsed ${tableData.length} records and saved to ${outputPath}`);
        
    } catch (error) {
        console.error('Error parsing PDF:', error.message);
        
        const errorResult = {
            success: false,
            error: error.message,
            tables: []
        };
        fs.writeFileSync(outputPath, JSON.stringify(errorResult, null, 2));
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

// Validate input file exists
if (!fs.existsSync(pdfPath)) {
    console.error(`PDF file not found: ${pdfPath}`);
    process.exit(1);
}

parsePdfTables(pdfPath, outputPath);
