<?php

/* =========================
   CONFIGURACIÓN GENERAL
========================= */

define('BASE_URL', 'http://localhost/auditoria/public');
define('BASE_PATH', __DIR__);
define('APP_PATH', BASE_PATH . '/app');

define('VIEW_PATH', APP_PATH . '/views');
define('MODEL_PATH', APP_PATH . '/models');
define('CONTROLLER_PATH', APP_PATH . '/controllers');

date_default_timezone_set('America/Lima');

/* =========================
   BASE DE DATOS TRUFA
========================= */

define('DB_HOST', 'localhost');
define('DB_NAME', 'TRUFA');
define('DB_USER', 'root');
define('DB_PASS', '');

/* =========================
   SMTP (GMAIL REAL)
========================= */

define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'validacionotp@gmail.com');
define('SMTP_PASS', 'xunp itup fpam aond'); // App Password
define('SMTP_PORT', 587);

/* =========================
   FUNCIONES
========================= */

function redirect($url) {
    header("Location: $url");
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function authRequired() {
    if (!isLoggedIn()) {
        redirect(BASE_URL . '/index.php?controller=auth&action=login');
    }
}

/* =========================
   PHPMailer
========================= */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once BASE_PATH . '/libs/PHPMailer/src/Exception.php';
require_once BASE_PATH . '/libs/PHPMailer/src/PHPMailer.php';
require_once BASE_PATH . '/libs/PHPMailer/src/SMTP.php';

function sendOTPEmail($toEmail, $otp) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;

        $mail->setFrom(SMTP_USER, 'Sistema TRUFA');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Tu código de verificación';
        $mail->Body = "
            <h2>Código OTP</h2>
            <h1 style='font-size:40px;letter-spacing:5px;'>$otp</h1>
            <p>Expira en 5 minutos.</p>
        ";

        return $mail->send();

    } catch (Exception $e) {
        error_log("SMTP ERROR: " . $mail->ErrorInfo);
        return false;
    }
}