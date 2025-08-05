{{-- filepath: resources/views/emails/verification.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
</head>
<body>
    <h2>Verifikasi Email Anda</h2>
    <p>Terima kasih telah mendaftar. Silakan klik tombol di bawah ini untuk memverifikasi email Anda:</p>
    <a href="{{ $verificationUrl ?? '#' }}" style="display:inline-block;padding:10px 20px;background:#3490dc;color:#fff;text-decoration:none;border-radius:4px;">Verifikasi Email</a>
    <p>Jika Anda tidak mendaftar, abaikan email ini.</p>
</body>
</html>