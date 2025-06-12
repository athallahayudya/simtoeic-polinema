<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keterangan Ujian TOEIC</title>
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
        <div class="institution-name">POLITEKNIK NEGERI MALANG</div>
        <div class="institution-address">Jl. Soekarno Hatta No. 9 Malang 65141</div>
        <div class="institution-address">Telp. (0341) 404424, 404425 Fax. (0341) 404420</div>
        <div class="institution-address">Website: www.polinema.ac.id Email: info@polinema.ac.id</div>
    </div>

    <!-- Letter Title -->
    <div class="letter-title">SURAT KETERANGAN</div>
    <div class="letter-number">Nomor: {{ $barcode_data }}/UN30.7/KM/{{ date('Y') }}</div>

    <!-- Content -->
    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Direktur Politeknik Negeri Malang, dengan ini menerangkan bahwa:</p>
        
        <div class="student-info">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><strong>{{ $student_name }}</strong></td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td>:</td>
                    <td><strong>{{ $student_nim }}</strong></td>
                </tr>
                <tr>
                    <td>Program Studi</td>
                    <td>:</td>
                    <td>{{ $student_study_program }}</td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <td>:</td>
                    <td>{{ $student_major }}</td>
                </tr>
            </table>
        </div>

        <p>Adalah benar mahasiswa Politeknik Negeri Malang yang telah mengikuti ujian TOEIC (Test of English for International Communication) yang diselenggarakan oleh institusi kami.</p>

        <p>Mahasiswa tersebut telah menunjukkan komitmen dan usaha yang baik dalam mengikuti program peningkatan kemampuan bahasa Inggris melalui ujian TOEIC, meskipun belum mencapai skor minimum yang ditetapkan.</p>

        <p>Surat keterangan ini dibuat untuk keperluan administrasi dan dapat digunakan sebagai bukti partisipasi dalam program ujian TOEIC di Politeknik Negeri Malang.</p>

        <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
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
            <div>Direktur,</div>
            <div class="signature-box"></div>
            <div class="signature-name">{{ $admin_name }}</div>
            <div class="signature-title">NIP. 196X0X0X 198X0X X XXX</div>
        </div>
    </div>

    <!-- Barcode Section -->
    <div class="barcode-section">
        <div class="barcode">{{ $barcode_data }}</div>
        <div style="font-size: 8pt; margin-top: 5px;">Kode Verifikasi</div>
    </div>

    <!-- Footer Note -->
    <div class="footer-note">
        Surat ini dibuat secara elektronik dan sah tanpa tanda tangan basah
    </div>
</body>
</html>
