<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Token Surat Suara Rahasia</title>
</head>
<body style="font-family: sans-serif; color: #0b1933; line-height: 1.6; max-width: 580px; margin: 0 auto; padding: 24px;">
    <h2 style="margin-bottom: 8px;">{{ $election->title }}</h2>
    <p>Halo, <strong>{{ $voterName }}</strong>.</p>
    <p>
        Anda telah meminta tautan surat suara rahasia untuk menggunakan hak pilih pada
        <strong>{{ $election->title }}</strong>. Tautan ini hanya berlaku satu kali dan akan kadaluarsa pada
        <strong>{{ $expiresAtFormatted }} WIB</strong>.
    </p>
    <p style="margin: 24px 0;">
        <a href="{{ $ballotUrl }}" style="display: inline-block; background: #1d4ed8; color: #ffffff; text-decoration: none; padding: 12px 20px; border-radius: 8px; font-weight: bold;">
            Buka Surat Suara Rahasia
        </a>
    </p>
    <p style="font-size: 13px; color: #475569;">
        Jangan bagikan tautan ini kepada siapa pun. Jika Anda tidak merasa meminta tautan ini, abaikan email ini dan segera hubungi panitia pemilu HMIF ITATS.
    </p>
</body>
</html>
