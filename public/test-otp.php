<?php
require_once __DIR__ . '/../config.php';

$email = 'gomezsanjean@gmail.com'; // Tu correo
$otp   = '987654';

if (sendOTPEmail($email, $otp)) {
    echo "<h1 style='color: green; text-align: center;'>¡CÓDIGO OTP ENVIADO CON ÉXITO!</h1>";
    echo "<p style='text-align: center;'>Revisa tu bandeja de entrada, spam o promociones. Deberías ver el código 987654.</p>";
} else {
    echo "<h1 style='color: red; text-align: center;'>ERROR AL ENVIAR EL EMAIL</h1>";
    echo "<p style='text-align: center;'>Revisa el log de errores: C:\\xampp\\php\\logs\\php_error_log</p>";
    echo "<p style='text-align: center;'>Busca líneas con 'PHPMailer' o 'SMTP' y copia las últimas 5-10 aquí.</p>";
}
?>