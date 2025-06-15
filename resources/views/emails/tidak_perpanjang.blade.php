
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Informasi Kontrak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8fafc;
            padding: 20px;
            color: #333;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            max-width: 600px;
            margin: auto;
        }
        h2 {
            color: #e3342f;
        }
        .info {
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.85rem;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Kontrak Tidak Diperpanjang</h2>

        <p>Halo {{ $data['nama'] }},</p>

        <p>
            Kami ingin memberitahukan bahwa kontrak Anda di <strong>{{ $data['judul'] }}</strong> 
            dengan status <strong>{{ $data['status'] }}</strong> per tanggal <strong>{{ $data['date'] }}</strong>.
        </p>

        <div class="info">
            <p>Terima kasih atas dedikasi dan kerja keras Anda selama ini. Kami mendoakan yang terbaik untuk perjalanan karier Anda selanjutnya.</p>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem. Jangan membalas email ini.</p>
        </div>
    </div>
</body>
</html>
