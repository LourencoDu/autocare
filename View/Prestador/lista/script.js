document.addEventListener("DOMContentLoaded", function () {
  const input = document.getElementById("search-input");
  const cards = document.querySelectorAll(".search-item");

  input.addEventListener("input", function () {
    let termo = input.value.toLowerCase();    
    termo = removerAcentos(termo);
    termo = removerMascara(termo);

    cards.forEach((card) => {
      const nome = card.dataset.search;
      const visivel = nome.includes(termo);
      card.style.display = visivel ? "" : "none";
    });
  });
});
