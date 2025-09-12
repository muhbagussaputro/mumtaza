<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Password - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #0d9488;
            color: white;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 30px;
            background-color: #f9fafb;
            border-left: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #0d9488;
            color: white !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #6b7280;
            background-color: #f3f4f6;
            border-radius: 0 0 8px 8px;
            border: 1px solid #e5e7eb;
            border-top: none;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('icon.png') }}" alt="{{ config('app.name') }}" class="logo">
        <h1>Atur Ulang Kata Sandi</h1>
    </div>
    
    <div class="content">
        <p>Halo,</p>
        <p>Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda. Klik tombol di bawah ini untuk melanjutkan:</p>
        
        @php
            $resetUrl = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], true));
        @endphp
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $resetUrl }}" class="button">Atur Ulang Kata Sandi</a>
        </div>
        
        <p>Atau salin dan tempel tautan berikut ke browser Anda:</p>
        <p style="word-break: break-all;">{{ $resetUrl }}</p>
        
        <p>Jika Anda tidak meminta pengaturan ulang kata sandi, Anda dapat mengabaikan email ini. Tautan ini hanya berlaku selama {{ $count ?? 60 }} menit.</p>
        
        <p>Terima kasih,<br>{{ config('app.name') }}</p>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} {{ config('app.name') }}. Semua hak dilindungi.</p>
        <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
    </div>
</body>
</html>
