<?php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../config.php';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear cuenta — Auditoría</title>

  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/register.css?v=1.0.5"></head>

<body>

  <div class="bg-grid"></div>
  <div class="glow-orb orb1"></div>
  <div class="glow-orb orb2"></div>

  <div class="container">
    <div class="card">

      <div class="card-header">
        <h1 class="title">Crear cuenta</h1>
        <p class="subtitle">Completa tus datos para registrarte</p>
      </div>

      <!-- 🔥 FORM CORREGIDO -->
      <form method="POST" action="<?= BASE_URL ?>/index.php?controller=auth&action=register">

        <!-- NOMBRE -->
        <div class="field-group">
          <label for="nombre">Nombre</label>
          <input type="text"
                 id="nombre"
                 name="nombre"
                 placeholder="Carlos"
                 required>
        </div>

        <!-- APELLIDO -->
        <div class="field-group">
          <label for="apellido">Apellido</label>
          <input type="text"
                 id="apellido"
                 name="apellido"
                 placeholder="Mendoza"
                 required>
        </div>

        <!-- EMAIL -->
        <div class="field-group">
          <label for="email">Correo electrónico</label>
          <input type="email"
                 id="email"
                 name="email"
                 placeholder="correo@empresa.com"
                 required>
        </div>

        <!-- PASSWORD -->
        <div class="field-group">
          <label for="password">Contraseña</label>
          <input type="password"
                 id="password"
                 name="password"
                 placeholder="••••••••"
                 required>
        </div>

        <!-- BOTÓN -->
        <button type="submit" class="btn-primary">
          Registrarse
        </button>

        <!-- LINK LOGIN -->
        <p class="login-text">
          ¿Ya tienes cuenta?
          <a href="<?= BASE_URL ?>/index.php?controller=auth&action=login">
            Inicia sesión
          </a>
        </p>

      </form>

    </div>
  </div>

  <script src="<?= BASE_URL ?>/public/js/register.js"></script>

</body>
</html>