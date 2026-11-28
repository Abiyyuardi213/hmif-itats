<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Token Surat Suara Rahasia</title>
</head>
{{-- Email clients strip CSS custom properties; inline hex matches DESIGN.md 4.1 primitives: --p-paper-50 (#F5F7FC), --p-ink-900 (#0F1C38), --p-ink-950 (#0A1429), --p-gold-400 (#D4A340), --p-muted-light (#4A5878), --p-orbit-700 (#0369A1). --}}
<body style="font-family: sans-serif; background-color: #F5F7FC; color: #0F1C38; line-height: 1.6; max-width: 580px; margin: 0 auto; padding: 24px;">
    <div style="background-color: #FFFFFF; border: 1px solid #0F1C38; border-radius: 16px; padding: 24px;">
        <h2 style="margin-top: 0; margin-bottom: 8px; color: #0F1C38;">{{ $election->title }}</h2>
        <p>Halo, <strong>{{ $voterName }}</strong>.</p>
        <p>
            Anda telah meminta tautan surat suara rahasia untuk menggunakan hak pilih pada
            <strong>{{ $election->title }}</strong>. Tautan ini hanya berlaku satu kali dan akan kadaluarsa pada
            <strong>{{ $expiresAtFormatted }} WIB</strong>.
        </p>
        <p style="margin: 24px 0;">
            <a href="{{ $ballotUrl }}" style="display: inline-block; background-color: #D4A340; color: #0A1429; text-decoration: none; padding: 12px 22px; border-radius: 9999px; font-weight: bold;">
                Buka Surat Suara Rahasia
            </a>
        </p>
        <p style="font-size: 13px; color: #4A5878;">
            Jika tombol tidak dapat diklik, salin tautan berikut:
            <a href="{{ $ballotUrl }}" style="color: #0369A1; word-break: break-all;">{{ $ballotUrl }}</a>
        </p>
        <p style="font-size: 13px; color: #4A5878; margin-bottom: 0;">
            Jangan bagikan tautan ini kepada siapa pun. Jika Anda tidak merasa meminta tautan ini, abaikan email ini dan segera hubungi panitia pemilu HMIF ITATS.
        </p>
    </div>
</body>
</html>
