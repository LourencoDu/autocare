function toggleLoading(isLoading = false) {
  const fullLoadingEl = document.getElementById("full-loading");

  if (fullLoadingEl) {
    fullLoadingEl.classList.toggle("hidden", !isLoading);
  }
}

function limitarDigitos(input, maxLength) {
  if (input.value.length > maxLength) {
    input.value = input.value.slice(0, maxLength);
  }
}

function removerMascara(texto) {
  return texto.replace(/[^a-zA-Z0-9]/g, "");
}

function removerAcentos(texto) {
  return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
}

function limparTextoBusca(texto = "") {
  return removerAcentos(removerMascara(texto)).toLowerCase();
}

function setError(input, showErro) {
  const erroMsg = input.parentElement.querySelector(".helper-text");
  if (showErro) {
    input.classList.remove("border-gray-300");
    input.classList.add("border-red-500", "focus:ring-red-200");
    erroMsg?.classList.remove("hidden");
  } else {
    input.classList.remove("border-red-500", "focus:ring-red-200");
    input.classList.add("border-green-500", "focus:ring-green-200");
    erroMsg?.classList.add("hidden");
  }
}