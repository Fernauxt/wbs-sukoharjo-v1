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
        h1 { font-size: 20px; font-weight: bold; margin-bottom: 16px; text-align: center; }
        p { margin: 12px 0; }
        .semibold { font-weight: 600; }
        .status-box { font-size: 18px; font-weight: bold; color: #2563eb; margin: 12px 0; }
        .notes-box { background: #fef9e7; padding: 12px; border-radius: 6px; font-size: 14px; color: #333; font-style: italic; margin-top: 16px; }
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
            <h1>Hai {{ $report->informant->name }}</h1>

            <p>Status laporan dengan subjek:</p>
            <p class="semibold">"{{ $report->subject }}"</p>

            <p>Telah diperbarui menjadi:</p>
            <div class="status-box">{{ ucwords(str_replace('-', ' ', $statusName)) }}</div>

            @if ($notes)
                <div class="notes-box">
                    <p class="semibold">Catatan dari Admin:</p>
                    <p>{{ $notes }}</p>
                </div>
            @endif

            @if(Route::has('report.track'))
                <p>Klik tombol berikut untuk melihat status laporan Anda secara lengkap dengan memasukkan token laporan anda:</p>
                <a href="{{ route('report.track') }}" class="button">Cek Status Laporan</a>
            @endif

            <div class="footer">
                <p>Terima kasih,<br>Tim Whistle Blowing System</p>
            </div>
        </div>
    </div>
</body>
</html>