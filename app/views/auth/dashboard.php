<?php
// Aseguramos que BASE_URL esté disponible (cargamos config si no está)
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../config.php';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio de Sesión</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/styleLogin.css?v=1.0.3">
</head>
<body>
  <div class="bg-grid"></div>
  <div class="glow-orb orb1"></div>
  <div class="glow-orb orb2"></div>

  <div class="container">
    <div class="card" id="card">
      <div class="card-header">
        <div class="logo">
          <div class="logo-icon">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
              <path d="M14 2L26 9V19L14 26L2 19V9L14 2Z" stroke="#60A5FA" stroke-width="1.5" fill="none"/>
              <path d="M14 8L20 11.5V18.5L14 22L8 18.5V11.5L14 8Z" fill="#60A5FA" fill-opacity="0.15" stroke="#60A5FA" stroke-width="1"/>
              <circle cx="14" cy="15" r="2.5" fill="#60A5FA"/>
            </svg>
          </div>
        </div>
        <h1 class="title">Bienvenido de vuelta</h1>
        <p class="subtitle">Ingresa tus credenciales para continuar</p>
      </div>

      <form class="form" id="loginForm" method="POST" action="<?= BASE_URL ?>/index.php?controller=auth&action=doLogin">
        <div class="field-group">
          <label for="email">Correo electrónico</label>
          <div class="input-wrapper">
            <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <rect x="2" y="4" width="20" height="16" rx="2"/>
              <path d="m2 7 10 8 10-8"/>
            </svg>
            <input type="email" id="email" name="email" placeholder="usuario@empresa.com" autocomplete="email" required/>
          </div>
          <span class="error-msg" id="emailError"></span>
        </div>

        <div class="field-group">
          <label for="password">Contraseña</label>
          <div class="input-wrapper">
            <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <rect x="3" y="11" width="18" height="11" rx="2"/>
              <circle cx="12" cy="16" r="1.5"/>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password" required/>
            <button type="button" class="toggle-pw" id="togglePw" aria-label="Mostrar contraseña">
              <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
          <span class="error-msg" id="passwordError"></span>
        </div>

        <div class="options-row">
          <label class="checkbox-label">
            <input type="checkbox" id="remember" />
            <span class="checkmark"></span>
            Recordar sesión
          </label>
          <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="btn-primary" id="submitBtn">
          <span class="btn-text">Iniciar sesión</span>
          <div class="btn-loader" id="btnLoader"></div>
        </button>

        <div class="divider"><span>o continúa con</span></div>

        <div class="social-row">
          <button type="button" class="btn-social">
            <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
            Google
          </button>
          <button type="button" class="btn-social">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
            GitHub
          </button>
        </div>

        <p class="register-text">¿No tienes cuenta? <a href="<?= BASE_URL ?>/index.php?controller=auth&action=register">Regístrate aquí</a></p>
      </form>
    </div>
  </div>

  <!-- Script con ruta absoluta -->
  <script src="<?= BASE_URL ?>/js/login.js"></script>
</body>
</html>