document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("verifyForm");
  const inputs = Array.from(document.querySelectorAll(".otp-input"));
  const hiddenInput = document.getElementById("otpHidden");
  const errorBox = document.getElementById("otpError");

  if (!form || inputs.length !== 6 || !hiddenInput || !errorBox) {
    return;
  }

  const sanitizeCode = (value) => value.replace(/\D/g, "").slice(0, 6);

  const setCode = (value) => {
    const digits = sanitizeCode(value).split("");

    inputs.forEach((input, index) => {
      const digit = digits[index] || "";
      input.value = digit;
      input.classList.toggle("filled", Boolean(digit));
    });

    const nextIndex = Math.min(digits.length, inputs.length - 1);
    inputs[nextIndex].focus();
    errorBox.textContent = "";
  };

  inputs.forEach((input, index) => {
    input.addEventListener("input", () => {
      input.value = input.value.replace(/\D/g, "").slice(0, 1);
      input.classList.toggle("filled", Boolean(input.value));

      if (input.value && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }

      errorBox.textContent = "";
    });

    input.addEventListener("keydown", (event) => {
      if (event.key === "Backspace" && !input.value && index > 0) {
        inputs[index - 1].focus();
      }

      if (event.key === "ArrowLeft" && index > 0) {
        inputs[index - 1].focus();
      }

      if (event.key === "ArrowRight" && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
    });

    input.addEventListener("paste", (event) => {
      event.preventDefault();
      const pasted = event.clipboardData?.getData("text") || "";
      setCode(pasted);
    });
  });

  form.addEventListener("submit", (event) => {
    event.preventDefault();

    const code = inputs.map((input) => input.value).join("");

    if (code.length !== 6) {
      errorBox.textContent = "Ingresa los 6 dígitos del código.";
      inputs.forEach((input) => {
        input.classList.add("invalid-shake");
        setTimeout(() => input.classList.remove("invalid-shake"), 350);
      });
      return;
    }

    hiddenInput.value = code;
    form.submit();
  });
});
