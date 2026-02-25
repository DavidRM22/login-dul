document.addEventListener("DOMContentLoaded", () => {

  const form = document.getElementById("verifyForm");
  const inputs = document.querySelectorAll(".otp-input");
  const hiddenInput = document.getElementById("otpHidden");
  const errorBox = document.getElementById("otpError");

  // Mover automáticamente entre inputs
  inputs.forEach((input, index) => {

    input.addEventListener("input", () => {
      input.value = input.value.replace(/[^0-9]/g, '');

      if (input.value && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
    });

    input.addEventListener("keydown", (e) => {
      if (e.key === "Backspace" && !input.value && index > 0) {
        inputs[index - 1].focus();
      }
    });
  });

  form.addEventListener("submit", function (e) {

    e.preventDefault();

    let code = "";

    inputs.forEach(input => {
      code += input.value;
    });

    if (code.length !== 6) {
      errorBox.textContent = "Ingresa los 6 dígitos del código.";
      return;
    }

    hiddenInput.value = code;

    // 🔥 Ahora sí enviamos el formulario REAL
    form.submit();
  });

});