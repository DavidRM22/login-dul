// Espera a que el DOM esté cargado
document.addEventListener('DOMContentLoaded', () => {
  // ── Toggle password visibility ──
  const togglePw = document.getElementById('togglePw');
  const pwInput  = document.getElementById('password');
  const eyeIcon  = document.getElementById('eyeIcon');

  if (togglePw && pwInput && eyeIcon) {
    togglePw.addEventListener('click', () => {
      const isPassword = pwInput.type === 'password';
      pwInput.type = isPassword ? 'text' : 'password';

      eyeIcon.innerHTML = isPassword
        ? `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
           <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
           <line x1="1" y1="1" x2="23" y2="23"/>`
        : `<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>`;
    });
  }

  // ── Validation helpers ──
  function validateEmail(value) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim());
  }

  function setError(field, msgEl, message) {
    if (field && msgEl) {
      field.classList.toggle('invalid', !!message);
      msgEl.textContent = message || '';
    }
  }

  // ── Form submit ──
  const form      = document.getElementById('loginForm');
  const submitBtn = document.getElementById('submitBtn');
  const emailEl   = document.getElementById('email');
  const emailErr  = document.getElementById('emailError');
  const pwErr     = document.getElementById('passwordError');

  if (form) {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      let isValid = true;

      // Validación cliente
      if (!emailEl?.value.trim()) {
        setError(emailEl, emailErr, 'El correo es requerido.');
        isValid = false;
      } else if (!validateEmail(emailEl.value)) {
        setError(emailEl, emailErr, 'Ingresa un correo válido.');
        isValid = false;
      } else {
        setError(emailEl, emailErr, '');
      }

      if (!pwInput?.value) {
        setError(pwInput, pwErr, 'La contraseña es requerida.');
        isValid = false;
      } else if (pwInput.value.length < 6) {
        setError(pwInput, pwErr, 'Mínimo 6 caracteres.');
        isValid = false;
      } else {
        setError(pwInput, pwErr, '');
      }

      if (!isValid) return;

      // Mostrar loader y deshabilitar botón
      submitBtn?.classList.add('loading');
      submitBtn.disabled = true;

      try {
        const formData = new FormData(form);
        const response = await fetch(form.action, {
          method: 'POST',
          body: formData,
        });

        if (response.redirected) {
          window.location.href = response.url;
        } else {
          const text = await response.text();

          if (text.includes('Credenciales incorrectas')) {
            setError(pwInput, pwErr, 'Credenciales incorrectas.');
            pwInput.value = '';
          } else {
            setError(pwInput, pwErr, 'Error inesperado. Intenta de nuevo.');
          }

          submitBtn?.classList.remove('loading');
          submitBtn.disabled = false;
        }
      } catch (err) {
        console.error('Error en login:', err);
        setError(pwInput, pwErr, 'Error de conexión. Intenta de nuevo.');
        submitBtn?.classList.remove('loading');
        submitBtn.disabled = false;
      }
    });

    // Limpiar errores al escribir
    [emailEl, pwInput].forEach(el => {
      if (el) {
        el.addEventListener('input', () => {
          el.classList.remove('invalid');
          if (el === emailEl) setError(emailEl, emailErr, '');
          if (el === pwInput) setError(pwInput, pwErr, '');
        });
      }
    });
  }
});
