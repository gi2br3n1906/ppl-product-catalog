<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Disetujui</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background: #01343B;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 30px;
            color: #333;
            line-height: 1.6;
        }
        .success-icon {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #ACEB02;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info-box strong {
            color: #01343B;
        }
        .btn-login {
            display: inline-block;
            background: #ACEB02;
            color: #01343B;
            padding: 15px 35px;
            text-decoration: none;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: 700;
            transition: all 0.2s;
        }
        .email-footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="success-icon">
                <svg width="35" height="35" viewBox="0 0 24 24" fill="#ACEB02">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
            </div>
            <h1>🎉 Selamat! Pendaftaran Disetujui</h1>
        </div>
        
        <div class="email-body">
            <p>Halo <strong>{{ $registration->nama_pic }}</strong>,</p>
            
            <p>Kabar gembira! Pendaftaran toko <strong>{{ $registration->nama_toko }}</strong> Anda telah <strong>DISETUJUI</strong> oleh tim admin CampusMarket.</p>
            
            <div class="info-box">
                <p><strong>Status:</strong> Aktif ✅</p>
                <p><strong>Nama Toko:</strong> {{ $registration->nama_toko }}</p>
                <p><strong>Email Login:</strong> {{ $registration->email_pic }}</p>
            </div>
            
            <p><strong>Langkah Selanjutnya:</strong></p>
            <ol>
                <li>Login ke akun seller Anda menggunakan email dan password yang telah didaftarkan</li>
                <li>Lengkapi profil toko Anda</li>
                <li>Mulai upload produk pertama Anda</li>
                <li>Kelola toko dan transaksi melalui dashboard seller</li>
            </ol>
            
            <div style="text-align: center;">
                <a href="{{ config('app.url') }}/login" class="btn-login">Login Sekarang</a>
            </div>
            
            <p>Jika Anda mengalami kesulitan atau memiliki pertanyaan, jangan ragu untuk menghubungi kami.</p>
            
            <p>Selamat berjualan di CampusMarket!</p>
            
            <p>Salam sukses,<br><strong>Tim CampusMarket</strong></p>
        </div>
        
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} CampusMarket. All rights reserved.</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
