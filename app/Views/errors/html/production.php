<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terjadi Kesalahan Sistem</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background-color: #f8fafc; color: #334155; text-align: center; padding: 10% 20px; }
        .error-container { background: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); max-width: 550px; margin: 0 auto; border-top: 6px solid #ef4444; }
        h1 { color: #ef4444; margin-bottom: 12px; font-size: 24px;}
        p { color: #64748b; line-height: 1.6; font-size: 15px; }
        .alert-box { background: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; padding: 12px; border-radius: 6px; margin: 20px 0; font-size: 13px; text-align: left; }
        .btn { display: inline-block; margin-top: 15px; padding: 10px 24px; background: #10B981; color: #fff; text-decoration: none; border-radius: 6px; font-weight: 500; transition: background 0.3s; }
        .btn:hover { background: #059669; }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Terjadi Kesalahan (500)</h1>
        <p>Maaf, sistem sedang mengalami kendala teknis (Internal Server Error) dalam memproses permintaan Anda. Tim teknis kami telah menerima laporan otomatis ini.</p>
        
        <div class="alert-box">
            <i><strong>Catatan Keamanan:</strong> Stack Trace, struktur direktori, dan Query Database telah <b>disembunyikan secara paksa</b> pada mode Production demi melindungi integritas sistem. Detail masalah ini telah dicatat dengan aman di system.log (Server).</i>
        </div>

        <a href="/" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>
