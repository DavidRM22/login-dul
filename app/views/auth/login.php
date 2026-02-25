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
    <title>Inicio de Sesión — Auditoría</title>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/styleLogin.css?v=1.0.5">
  </head>

  <body>

    <div class="bg-grid"></div>
    <div class="glow-orb orb1"></div>
    <div class="glow-orb orb2"></div>

    <div class="container">
      <div class="card">

        <div class="card-header">
          <h1 class="title">Bienvenido</h1>
          <p class="subtitle">Ingresa tus credenciales para continuar</p>
        </div>

        <form method="POST"
        action="<?= BASE_URL ?>/index.php?controller=auth&action=login">

          <!-- EMAIL -->
          <div class="field-group">
            <label for="email">Correo electrónico</label>
            <div class="input-wrapper">
              <input type="email"
                    id="email"
                    name="email"
                    placeholder="usuario@empresa.com"
                    required>
            </div>
          </div>

          <!-- PASSWORD -->
          <div class="field-group">
            <label for="password">Contraseña</label>
            <div class="input-wrapper">
              <input type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required>
            </div>
          </div>

          <!-- RECORDAR -->
          <div class="options-row">
            <label>
              <input type="checkbox" name="remember">
              Recordar sesión
            </label>
          </div>

          <!-- BOTÓN -->
          <button type="submit" class="btn-primary">
            Iniciar sesión
          </button>

          <!-- LINK REGISTER -->
          <p class="register-text">
            ¿No tienes cuenta?
            <a href="<?= BASE_URL ?>/index.php?controller=auth&action=register">
              Regístrate aquí
            </a>
          </p>

        </form>

      </div>
    </div>

    <script src="<?= BASE_URL ?>/public/js/login.js"></script>

  </body>
  </html>