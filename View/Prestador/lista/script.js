document.addEventListener("DOMContentLoaded", function () {
  const input = document.getElementById("search-input");
  const cards = document.querySelectorAll(".search-item");
  const contador = document.getElementById("search-count");

  const valueLabelEl = document.getElementById("search-value-label");
  const valueEl =  document.getElementById("search-value");

  input.addEventListener("input", function () {
    let termo = input.value.toLowerCase();    
    termo = removerAcentos(termo);
    termo = removerMascara(termo);

    if(!!termo) {
      valueLabelEl.classList.toggle("hidden", false);
      valueEl.textContent = input.value;      
    } else {
      valueLabelEl.classList.toggle("hidden", true);
    }

    let totalVisiveis = 0;

    cards.forEach((card) => {
      const nome = card.dataset.search;
      const visivel = nome.includes(termo);
      card.style.display = visivel ? "" : "none";      
      
      if (visivel) totalVisiveis++;
    });

    contador.textContent = `${totalVisiveis}`;
  });
});
