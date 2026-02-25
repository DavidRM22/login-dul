document.addEventListener('DOMContentLoaded', () => {
  let currentStep = 1;
  const formData = {
    name: '', email: '', password: ''
  };

  // Utilidades
  function setError(inputEl, errEl, msg) {
    if (inputEl) inputEl.classList.toggle('invalid', !!msg);
    if (errEl) errEl.textContent = msg || '';
  }

  function clearError(inputEl, errEl) {
    setError(inputEl, errEl, '');
  }

  function isValidEmail(v) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim());
  }

  function getPasswordScore(v) {
    let score = 0;
    if (v.length >= 8) score++;
    if (/[A-Z]/.test(v)) score++;
    if (/\d/.test(v)) score++;
    if (/[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/.test(v)) score++;
    return score;
  }

  // Step navigation
  function goToStep(n) {
    document.querySelectorAll('.step-view').forEach(el => el.classList.add('hidden'));
    const target = document.getElementById(`step${n}`);
    if (target) {
      target.classList.remove('hidden');
      target.style.animation = 'none';
      void target.offsetWidth;
      target.style.animation = 'cardIn .4s cubic-bezier(.22,1,.36,1) both';
    }
    currentStep = n;
  }

  // Step 1: Datos personales
  const firstNameEl = document.getElementById('firstName');
  const lastNameEl  = document.getElementById('lastName');
  const emailEl     = document.getElementById('regEmail');
  const pw1El       = document.getElementById('password1');
  const nextStep1   = document.getElementById('nextStep1');

  if (nextStep1) {
    nextStep1.addEventListener('click', () => {
      let valid = true;

      if (!firstNameEl?.value.trim()) {
        setError(firstNameEl, document.getElementById('firstNameErr'), 'El nombre es requerido.');
        valid = false;
      } else {
        clearError(firstNameEl, document.getElementById('firstNameErr'));
      }

      if (!lastNameEl?.value.trim()) {
        setError(lastNameEl, document.getElementById('lastNameErr'), 'El apellido es requerido.');
        valid = false;
      } else {
        clearError(lastNameEl, document.getElementById('lastNameErr'));
      }

      if (!emailEl?.value.trim()) {
        setError(emailEl, document.getElementById('regEmailErr'), 'El correo es requerido.');
        valid = false;
      } else if (!isValidEmail(emailEl.value)) {
        setError(emailEl, document.getElementById('regEmailErr'), 'Ingresa un correo válido.');
        valid = false;
      } else {
        clearError(emailEl, document.getElementById('regEmailErr'));
      }

      if (!pw1El?.value) {
        setError(pw1El, document.getElementById('password1Err'), 'La contraseña es requerida.');
        valid = false;
      } else if (getPasswordScore(pw1El.value) < 1) {
        setError(pw1El, document.getElementById('password1Err'), 'La contraseña es demasiado débil.');
        valid = false;
      } else {
        clearError(pw1El, document.getElementById('password1Err'));
      }

      if (!valid) return;

      formData.name     = firstNameEl.value.trim() + ' ' + lastNameEl.value.trim();
      formData.email    = emailEl.value.trim().toLowerCase();
      formData.password = pw1El.value;

      goToStep(2);
    });
  }

  // Limpiar errores al escribir
  [firstNameEl, lastNameEl, emailEl, pw1El].forEach(el => {
    if (el) {
      el.addEventListener('input', () => clearError(el, el.nextElementSibling));
    }
  });

  // Toggle contraseña
  document.querySelectorAll('.toggle-pw').forEach(btn => {
    btn.addEventListener('click', () => {
      const targetId = btn.dataset.target;
      const inp = document.getElementById(targetId);
      if (inp) inp.type = inp.type === 'password' ? 'text' : 'password';
    });
  });

  // Submit final (si tienes botón submit en el último step)
  const submitBtn = document.getElementById('submitReg');
  if (submitBtn) {
    submitBtn.addEventListener('click', async () => {
      submitBtn.classList.add('loading');
      submitBtn.disabled = true;

      try {
        const form = document.getElementById('registerForm');
        const formDataObj = new FormData(form);
        const response = await fetch(form.action, {
          method: 'POST',
          body: formDataObj,
        });

        if (response.redirected) {
          window.location.href = response.url;
        } else {
          const text = await response.text();

          if (text.includes('El email ya está registrado')) {
            alert('Este correo ya está registrado.');
          } else if (text.includes('Todos los campos son obligatorios')) {
            alert('Completa todos los campos requeridos.');
          } else {
            alert('Error inesperado. Intenta de nuevo.');
          }

          submitBtn.classList.remove('loading');
          submitBtn.disabled = false;
        }
      } catch (err) {
        console.error('Error en registro:', err);
        alert('Error de conexión. Intenta de nuevo.');
        submitBtn.classList.remove('loading');
        submitBtn.disabled = false;
      }
    });
  }
});