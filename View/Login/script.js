const form = document.getElementById("form");

const validators = {
  senha: (val) => /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(val),
};

function setError(input, showErro) {
  const erroMsg = input.parentElement.querySelector(".helper-text");
  if (showErro) {
    input.classList.remove("border-gray-300");
    input.classList.add("border-red-500", "focus:ring-red-200");
    erroMsg.classList.remove("hidden");
  } else {
    input.classList.remove("border-red-500", "focus:ring-red-200");
    input.classList.add("border-green-500", "focus:ring-green-200");
    erroMsg.classList.add("hidden");
  }
}

// Validação em tempo real
form.querySelectorAll("[data-validate]").forEach((input) => {
  input.addEventListener("input", () => {
    const tipo = input.dataset.validate;
    const valido = validators[tipo](input.value);
    setError(input, !valido);
  });
});

// Validação no submit antes do POST
form.addEventListener("submit", (e) => {
  let valido = true;

  form.querySelectorAll("[data-validate]").forEach((input) => {
    const tipo = input.dataset.validate;
    const ok = validators[tipo](input.value);
    setError(input, !ok);
    if (!ok) valido = false;
  });

  if (!valido) {
    e.preventDefault(); // Impede o POST se tiver erro
  }
});
