<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Ditolak</title>
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
        .info-icon {
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
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .reason-box {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .reason-box strong {
            color: #721c24;
        }
        .btn-retry {
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
            <div class="info-icon">
                <svg width="35" height="35" viewBox="0 0 24 24" fill="#dc3545">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
            </div>
            <h1>Pemberitahuan Pendaftaran Seller</h1>
        </div>
        
        <div class="email-body">
            <p>Halo <strong>{{ $registration->nama_pic }}</strong>,</p>
            
            <p>Terima kasih atas minat Anda untuk bergabung sebagai seller di CampusMarket.</p>
            
            <p>Setelah melakukan peninjauan, kami mohon maaf harus memberitahukan bahwa pendaftaran toko <strong>{{ $registration->nama_toko }}</strong> Anda <strong>belum dapat disetujui</strong> pada saat ini.</p>
            
            @if($registration->rejection_reason)
            <div class="reason-box">
                <p><strong>Alasan Penolakan:</strong></p>
                <p>{{ $registration->rejection_reason }}</p>
            </div>
            @endif
            
            <div class="info-box">
                <p><strong>Apa yang bisa Anda lakukan?</strong></p>
                <ul>
                    <li>Silakan periksa kembali data dan dokumen yang Anda kirimkan</li>
                    <li>Pastikan semua informasi akurat dan lengkap</li>
                    <li>Perbaiki hal-hal yang menjadi alasan penolakan</li>
                    <li>Anda dapat mendaftar kembali setelah melakukan perbaikan</li>
                </ul>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ config('app.url') }}/seller/register" class="btn-retry">Daftar Ulang</a>
            </div>
            
            <p>Jika Anda memiliki pertanyaan atau memerlukan klarifikasi lebih lanjut mengenai penolakan ini, jangan ragu untuk menghubungi tim support kami.</p>
            
            <p>Kami berharap dapat bekerja sama dengan Anda di masa mendatang.</p>
            
            <p>Terima kasih atas pengertiannya.</p>
            
            <p>Salam hormat,<br><strong>Tim CampusMarket</strong></p>
        </div>
        
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} CampusMarket. All rights reserved.</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
