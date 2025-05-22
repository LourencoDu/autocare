const toggleBtn = document.getElementById("toggle-sidemenu-button");

const sidemenuContent = document.getElementById("sidemenu-content");
const sidemenuBackdrop = document.getElementById("sidemenu-backdrop");

toggleBtn.addEventListener("click", () => {
  if (window.innerWidth < 640) {
    sidemenuContent.classList.toggle("hidden");
    sidemenuBackdrop.classList.toggle("hidden");
    document.body.classList.toggle("overflow-hidden");

    requestAnimationFrame(() => {
        sidemenuContent.classList.remove("-translate-x-full");
      });
  }
});

// Fecha o menu ao clicar fora
sidemenuBackdrop.addEventListener("click", (e) => {
  // Fecha apenas se clicar fora do menu (não dentro dele)
  if (!sidemenuContent.contains(e.target)) {
    sidemenuContent.classList.add("-translate-x-full");


    setTimeout(() => {
  sidemenuContent.classList.toggle("hidden");
    sidemenuBackdrop.classList.toggle("hidden");
    document.body.classList.remove("overflow-hidden");
    }, 150)
  }
});
