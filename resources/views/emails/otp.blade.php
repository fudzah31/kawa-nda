<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kode OTP Reset Password</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4; padding:30px 0;">
        <tr>
            <td align="center">

                <!-- Card Utama -->
                <table width="500" cellpadding="0" cellspacing="0" border="0" 
                       style="background:#ffffff; border-radius:12px; overflow:hidden; 
                              box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center" bgcolor="#1e3a8a" 
                            style="padding:20px; color:#ffffff; font-size:22px; font-weight:bold; letter-spacing:0.5px;">
                            🔐 Kawa-Nda | Reset Password
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px; color:#111827; font-size:15px; line-height:1.6;">
                            <p>Halo,</p>
                            <p>Kami menerima permintaan untuk mereset password akun Anda. Silakan gunakan kode OTP berikut:</p>

                            <p style="text-align:center; margin:28px 0;">
                                <span style="display:inline-block; font-size:32px; font-weight:bold; 
                                             letter-spacing:10px; padding:16px 32px; 
                                             border:2px dashed #2563eb; border-radius:10px; 
                                             color:#1d4ed8; background:#f0f9ff;">
                                    {{ $otp }}
                                </span>
                            </p>

                            <p style="text-align:center; font-size:14px; color:#555;">
                                Kode OTP ini <strong>hanya berlaku 5 menit</strong>, demi keamanan akun Anda.
                            </p>

                            <p style="font-size:14px; color:#444; margin-top:20px;">
                                Jika Anda tidak meminta reset password, abaikan email ini. 
                                Password Anda tetap aman dan tidak ada perubahan yang dilakukan.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" bgcolor="#f9fafb" 
                            style="padding:16px; font-size:12px; color:#6b7280; line-height:1.4;">
                            © {{ date('Y') }} <strong>Kawa-Nda</strong>.  
                            Semua hak dilindungi.
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>
</html>
