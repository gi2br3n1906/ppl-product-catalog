<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Seller Diterima</title>
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
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #ACEB02;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info-box h3 {
            margin-top: 0;
            color: #01343B;
        }
        .info-row {
            margin: 10px 0;
        }
        .info-label {
            font-weight: 600;
            color: #01343B;
        }
        .email-footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
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
            <h1>Pendaftaran Berhasil Diterima!</h1>
        </div>
        
        <div class="email-body">
            <p>Halo <strong>{{ $registration->nama_pic }}</strong>,</p>
            
            <p>Terima kasih telah mendaftar sebagai seller di <strong>CampusMarket</strong>!</p>
            
            <p>Kami telah menerima pendaftaran Anda dengan detail sebagai berikut:</p>
            
            <div class="info-box">
                <h3>Informasi Toko</h3>
                <div class="info-row">
                    <span class="info-label">Nama Toko:</span> {{ $registration->nama_toko }}
                </div>
                <div class="info-row">
                    <span class="info-label">Deskripsi:</span> {{ $registration->deskripsi_singkat }}
                </div>
            </div>
            
            <div class="info-box">
                <h3>Informasi PIC (Person In Charge)</h3>
                <div class="info-row">
                    <span class="info-label">Nama:</span> {{ $registration->nama_pic }}
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span> {{ $registration->email_pic }}
                </div>
                <div class="info-row">
                    <span class="info-label">No. HP:</span> {{ $registration->no_hp_pic }}
                </div>
            </div>
            
            <p><strong>Status Pendaftaran:</strong> Menunggu Verifikasi Admin</p>
            
            <p>Pendaftaran Anda sedang dalam proses verifikasi oleh tim admin kami. Kami akan mengirimkan email pemberitahuan setelah verifikasi selesai.</p>
            
            <p>Proses verifikasi biasanya memakan waktu <strong>1-3 hari kerja</strong>.</p>
            
            <p>Jika Anda memiliki pertanyaan, silakan hubungi kami melalui email ini.</p>
            
            <p>Terima kasih atas kesabaran Anda!</p>
            
            <p>Salam hangat,<br><strong>Tim CampusMarket</strong></p>
        </div>
        
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} CampusMarket. All rights reserved.</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
