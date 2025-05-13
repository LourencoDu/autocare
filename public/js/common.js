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

function removerMascara(valor) {
  return valor.replace(/[^a-zA-Z0-9]/g, "");
}

function removerAcentos(texto) {
  return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
}
