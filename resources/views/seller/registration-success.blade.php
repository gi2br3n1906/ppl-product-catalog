<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Berhasil - Product Catalog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ACEB02 0%, #8BC900 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .success-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            padding: 50px 40px;
            text-align: center;
        }
        
        .success-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #ACEB02 0%, #8BC900 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
        }
        
        h1 {
            color: #01343B;
            font-size: 32px;
            margin-bottom: 20px;
        }
        
        .success-message {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #01343B;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
            border-radius: 5px;
        }
        
        .info-box h3 {
            color: #01343B;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .info-box ul {
            margin-left: 20px;
            color: #555;
        }
        
        .info-box li {
            margin-bottom: 8px;
        }
        
        .btn-home {
            display: inline-block;
            padding: 14px 40px;
            background: linear-gradient(135deg, #01343B 0%, #023840 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.2s ease;
        }
        
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(1, 52, 59, 0.3);
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">✅</div>
        
        <h1>Registrasi Berhasil!</h1>
        
        <p class="success-message">
            Terima kasih telah mendaftar sebagai penjual di Product Catalog. 
            Data Anda telah kami terima dan sedang dalam proses verifikasi.
        </p>
        
        <div class="info-box">
            <h3>Langkah Selanjutnya:</h3>
            <ul>
                <li>Tim kami akan melakukan verifikasi data yang Anda kirimkan</li>
                <li>Proses verifikasi biasanya memakan waktu 1-3 hari kerja</li>
                <li>Anda akan menerima email notifikasi di <strong>{{ session('email', 'email Anda') }}</strong></li>
                <li>Jika disetujui, Anda dapat login menggunakan email dan password yang telah didaftarkan</li>
                <li>Jika ditolak, Anda akan diberitahu alasannya dan dapat mendaftar ulang</li>
            </ul>
        </div>
        
        <a href="{{ route('login') }}" class="btn-home">Kembali ke Halaman Login</a>
    </div>
</body>
</html>
