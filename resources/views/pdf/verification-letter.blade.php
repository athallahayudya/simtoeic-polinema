<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>TOEIC Exam Verification Letter</title>
    <style>
        @page {
            margin: 2cm;
            size: A4;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
        }
        
        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }
        
        .institution-name {
            font-size: 16pt;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }
        
        .institution-address {
            font-size: 10pt;
            margin: 2px 0;
        }
        
        .letter-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin: 30px 0 20px 0;
            text-decoration: underline;
        }
        
        .letter-number {
            text-align: center;
            font-size: 12pt;
            margin-bottom: 30px;
        }
        
        .content {
            text-align: justify;
            margin: 20px 0;
        }
        
        .student-info {
            margin: 20px 0;
            padding-left: 40px;
        }
        
        .student-info table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .student-info td {
            padding: 3px 0;
            vertical-align: top;
        }
        
        .student-info td:first-child {
            width: 150px;
        }
        
        .student-info td:nth-child(2) {
            width: 20px;
            text-align: center;
        }
        
        .signature-section {
            margin-top: 50px;
            display: table;
            width: 100%;
        }
        
        .signature-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        
        .signature-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            text-align: center;
        }
        
        .signature-box {
            margin-top: 80px;
            border-bottom: 1px solid #000;
            width: 200px;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
        
        .signature-name {
            font-weight: bold;
            margin-top: 5px;
        }
        
        .signature-title {
            font-size: 10pt;
            margin-top: 2px;
        }
        
        .barcode-section {
            position: absolute;
            bottom: 2cm;
            right: 2cm;
            text-align: center;
        }
        
        .barcode {
            font-family: 'Courier New', monospace;
            font-size: 8pt;
            border: 1px solid #000;
            padding: 5px;
            background-color: #f0f0f0;
        }
        
        .date-place {
            text-align: right;
            margin: 30px 0;
        }
        
        .footer-note {
            font-size: 10pt;
            font-style: italic;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="institution-name">STATE POLYTECHNIC OF MALANG</div>
        <div class="institution-address">Jl. Soekarno Hatta No. 9 Malang 65141</div>
        <div class="institution-address">Phone. (0341) 404424, 404425 Fax. (0341) 404420</div>
        <div class="institution-address">Website: www.polinema.ac.id Email: info@polinema.ac.id</div>
    </div>

    <!-- Letter Title -->
    <div class="letter-title">VERIFICATION LETTER</div>
    <div class="letter-number">Number: {{ $barcode_data }}/UN30.7/KM/{{ date('Y') }}</div>

    <!-- Content -->
    <div class="content">
        <p>The undersigned, Director of State Polytechnic of Malang, hereby certifies that:</p>
        
        <div class="student-info">
            <table>
                <tr>
                    <td>Name</td>
                    <td>:</td>
                    <td><strong>{{ $student_name }}</strong></td>
                </tr>
                <tr>
                    <td>Student ID</td>
                    <td>:</td>
                    <td><strong>{{ $student_nim }}</strong></td>
                </tr>
                <tr>
                    <td>Study Program</td>
                    <td>:</td>
                    <td>{{ $student_study_program }}</td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td>:</td>
                    <td>{{ $student_major }}</td>
                </tr>
            </table>
        </div>

        <p>Is truly a student of State Polytechnic of Malang who has participated in the TOEIC (Test of English for International Communication) examination organized by our institution.</p>

        <p>The aforementioned student has demonstrated good commitment and effort in participating in the English language improvement program through the TOEIC examination, although they have not yet achieved the minimum required score.</p>

        <p>This verification letter is issued for administrative purposes and can be used as proof of participation in the TOEIC examination program at State Polytechnic of Malang.</p>

        <p>This verification letter is made truthfully and can be used as deemed appropriate.</p>
    </div>

    <!-- Date and Place -->
    <div class="date-place">
        Malang, {{ $approval_date }}
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-left">
            <!-- Empty space for left side -->
        </div>
        <div class="signature-right">
            <div>Director,</div>
            <div class="signature-box"></div>
            <div class="signature-name">{{ $admin_name }}</div>
            <div class="signature-title">NIP. 196X0X0X 198X0X X XXX</div>
        </div>
    </div>

    <!-- Barcode Section -->
    <div class="barcode-section">
        <div class="barcode">{{ $barcode_data }}</div>
        <div style="font-size: 8pt; margin-top: 5px;">Verification Code</div>
    </div>

    <!-- Footer Note -->
    <div class="footer-note">
        This letter is electronically generated and valid without wet signature
    </div>
</body>
</html>
