function toggleLoading(isLoading = false) {
  const fullLoadingEl = document.getElementById("full-loading");

  if(fullLoadingEl) {
    fullLoadingEl.classList.toggle("hidden", !isLoading);
  }
}

function limitarDigitos(input, maxLength) {
  if (input.value.length > maxLength) {
    input.value = input.value.slice(0, maxLength);
  }
}