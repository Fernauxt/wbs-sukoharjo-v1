<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; line-height: 1.6; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: white; }
        .header { text-align: center; margin-bottom: 24px; }
        .header img { height: 64px; }
        .content { padding: 24px; }
        h1 { font-size: 24px; font-weight: bold; margin-bottom: 16px; }
        p { margin: 16px 0; }
        .semibold { font-weight: 600; }
        .token-box { font-size: 20px; font-family: 'Courier New', monospace; background: #f3f4f6; padding: 12px; border-radius: 6px; color: #2563eb; border: 1px solid #bfdbfe; word-break: break-all; }
        .button { display: inline-block; margin-top: 16px; padding: 12px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; }
        .button:hover { background: #1d4ed8; }
        .footer { margin-top: 24px; font-size: 14px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('https://wbs.sukoharjokab.go.id/images/wbs.png') }}" alt="Logo WBS">
        </div>

        <div class="content">
            <h1>Halo {{ $report->informant->name }}</h1>
            <p>Terima kasih telah mengirim laporan ke sistem kami.</p>

            <p class="semibold">Token laporan Anda:</p>
            <div class="token-box">{{ $report->token }}</div>

            @if(Route::has('report.track'))
                <p>Untuk mengecek status laporan, klik tombol berikut untuk masuk ke laman, kemudian masukkan token laporan anda:</p>
                <a href="{{ route('report.track') }}" class="button">Cek Status Laporan</a>
            @endif

            <div class="footer">
                <p>Salam,<br>Tim Whistle Blowing System</p>
            </div>
        </div>
    </div>
</body>
</html>