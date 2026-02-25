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

  <style>
    .otp-single {
        width: 100%;
        padding: 14px;
        font-size: 22px;
        text-align: center;
        letter-spacing: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        outline: none;
    }

    .otp-single:focus {
        border-color: #000;
    }
  </style>
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

    <!-- FORM SIMPLIFICADO -->
    <form method="POST"
          action="<?= BASE_URL ?>/index.php?controller=auth&action=doVerify">

      <div class="field-group">
        <label for="otp">Código de verificación</label>
        <input 
            type="text"
            name="otp"
            id="otp"
            class="otp-single"
            maxlength="6"
            pattern="\d{6}"
            inputmode="numeric"
            placeholder="123456"
            required
            autocomplete="one-time-code"
        >
      </div>

      <div class="error-text">
        <!-- Aquí puedes imprimir errores si luego decides pasarlos por sesión -->
      </div>

      <button type="submit" class="btn-primary">
        Verificar código
      </button>

    </form>

    <div class="footer-actions">
      <a href="<?= BASE_URL ?>/index.php?controller=auth&action=login">
        Volver al inicio de sesión
      </a>
    </div>

  </div>
</div>

</body>
</html>