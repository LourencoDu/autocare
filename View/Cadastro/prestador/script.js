const form = document.getElementById("form");

const validators = {
  nome: (val) => val.trim().length >= 2,
  sobrenome: (val) => val.trim().length >= 2,
  email: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
  senha: (val) => /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(val),
  telefone: (val) => /^\(\d{2}\)\s?\d{4,5}-\d{4}$/.test(val),
  cnpj: (val) => validarCNPJ(val)
};

Inputmask({
  mask: ["(99) 9999-9999", "(99) 99999-9999"], // para fixo e celular
  keepStatic: true,
}).mask(document.getElementById("telefone"));

Inputmask({
  mask: "99.999.999/9999-99",
  placeholder: "0"
}).mask(document.getElementById("documento"));

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

function validarCNPJ(cnpj) {
      cnpj = cnpj.replace(/[^\d]+/g, '');

      if (cnpj.length !== 14 || /^(\d)\1{13}$/.test(cnpj)) return false;

      let tamanho = cnpj.length - 2;
      let numeros = cnpj.substring(0, tamanho);
      let digitos = cnpj.substring(tamanho);
      let soma = 0;
      let pos = tamanho - 7;

      for (let i = tamanho; i >= 1; i--) {
        soma += parseInt(numeros.charAt(tamanho - i)) * pos--;
        if (pos < 2) pos = 9;
      }

      let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
      if (resultado != parseInt(digitos.charAt(0))) return false;

      tamanho += 1;
      numeros = cnpj.substring(0, tamanho);
      soma = 0;
      pos = tamanho - 7;

      for (let i = tamanho; i >= 1; i--) {
        soma += parseInt(numeros.charAt(tamanho - i)) * pos--;
        if (pos < 2) pos = 9;
      }

      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
      return resultado == parseInt(digitos.charAt(1));
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
