<?php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../config.php';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verificación de Código</title>

  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/verify.css">
</head>
<body>

<div class="container">
  <div class="card">

    <div class="card-header">
      <h1 class="title">Verificación en dos pasos</h1>
      <p class="subtitle">
        Enviamos un código a<br>
        <strong>
          <?= isset($_SESSION['otp_email'])
              ? htmlspecialchars($_SESSION['otp_email'])
              : 'correo@ejemplo.com' ?>
        </strong>
      </p>
    </div>

    <form id="verifyForm" class="form" method="POST" action="<?= BASE_URL ?>/index.php?controller=auth&action=doVerify">
      <div class="field-group">
        <label for="otp-0">Código de verificación</label>

        <div class="otp-group" aria-label="Ingresa los 6 dígitos del código">
          <input type="text" id="otp-0" class="otp-input" maxlength="1" inputmode="numeric" autocomplete="one-time-code" required>
          <input type="text" id="otp-1" class="otp-input" maxlength="1" inputmode="numeric" required>
          <input type="text" id="otp-2" class="otp-input" maxlength="1" inputmode="numeric" required>
          <input type="text" id="otp-3" class="otp-input" maxlength="1" inputmode="numeric" required>
          <input type="text" id="otp-4" class="otp-input" maxlength="1" inputmode="numeric" required>
          <input type="text" id="otp-5" class="otp-input" maxlength="1" inputmode="numeric" required>
        </div>

        <input type="hidden" name="otp" id="otpHidden">
      </div>

      <div class="error-msg" id="otpError" aria-live="polite"></div>

      <button type="submit" class="btn-primary">
        Verificar código
      </button>
    </form>

    <div class="footer-actions">
      <a class="btn-back" href="<?= BASE_URL ?>/index.php?controller=auth&action=login">
        Volver al inicio de sesión
      </a>
    </div>

  </div>
</div>

<script src="<?= BASE_URL ?>/js/verify.js"></script>
</body>
</html>
