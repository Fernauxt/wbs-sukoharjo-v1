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
        .alert-badge { display: inline-block; background: #e74c3c; color: white; padding: 8px 12px; border-radius: 4px; font-weight: bold; font-size: 12px; margin-bottom: 16px; }
        .content { padding: 24px; }
        h1 { font-size: 24px; font-weight: bold; margin-bottom: 16px; color: #e74c3c; }
        p { margin: 12px 0; }
        .semibold { font-weight: 600; }
        .detail-box { background: #f5f5f5; padding: 12px; border-radius: 6px; border-left: 4px solid #e74c3c; margin-bottom: 12px; }
        .detail-label { font-weight: 600; color: #e74c3c; font-size: 13px; }
        .detail-value { color: #333; margin-top: 4px; }
        .token-box { font-family: 'Courier New', monospace; background: #f3f4f6; padding: 12px; border-radius: 6px; color: #2563eb; border: 1px solid #bfdbfe; word-break: break-all; }
        .button { display: inline-block; margin-top: 16px; padding: 12px 16px; background: #e74c3c; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; }
        .button:hover { background: #c0392b; }
        .footer { margin-top: 24px; font-size: 14px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('https://wbs.sukoharjokab.go.id/images/wbs.png') }}" alt="Logo WBS">
            <div class="alert-badge">⚠️ LAPORAN BARU</div>
        </div>

        <div class="content">
            <h1>Halo {{ $admin->username }}</h1>
            <p>Ada laporan baru yang diterima. Berikut adalah detail singkatnya:</p>

            <div class="detail-box">
                <div class="detail-label">Judul Laporan</div>
                <div class="detail-value">{{ $report->subject }}</div>
            </div>

            <div class="detail-box">
                <div class="detail-label">Deskripsi Singkat</div>
                <div class="detail-value">{{ Str::limit($report->description, 150) }}</div>
            </div>

            <div class="detail-box">
                <div class="detail-label">Tanggal Laporan</div>
                <div class="detail-value">{{ $report->reported_at ? $report->reported_at->format('d-m-Y H:i') : 'Tanggal tidak tersedia' }}</div>
            </div>

            <div class="detail-box">
                <div class="detail-label">Token Laporan</div>
                <div class="token-box">{{ $report->token }}</div>
            </div>

            @if(Route::has('report.details'))
                <p>Untuk melihat detail lengkap laporan, klik tombol berikut:</p>
                <a href="{{ route('report.details', ['token' => $report->token]) }}" class="button">Lihat Detail Laporan</a>
            @endif

            <div class="footer">
                <p>Salam,<br>Tim Whistle Blowing System</p>
            </div>
        </div>
    </div>
</body>
</html>