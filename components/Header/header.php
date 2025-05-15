<?php
$usuario = $_SESSION["usuario"];
?>

<div class="flex flex-row w-full justify-between relative">
  <!-- Logo ou Link -->
  <a href="/<?= BASE_DIR_NAME ?>/home" class="flex flex-row h-10 w-12 items-center justify-center gap-1 hover:text-primary transition">
    <i class="fa-solid fa-car-side text-3xl"></i>
  </a>

  <!-- Usuário -->
  <div class="flex flex-row items-center gap-2 relative">
    <!-- Info -->
    <div class="flex flex-col items-end">
      <span class="text-base/5 font-medium"><?= htmlspecialchars($usuario->nome_completo) ?></span>
      <span class="text-sm/4 text-gray-600"><?= htmlspecialchars($usuario->email) ?></span>
    </div>

    <!-- Ícone de usuário com botão -->
    <button id="userMenuButton" class="w-10 h-10 flex items-center justify-center border border-gray-400 rounded-4xl relative focus:outline-none">
      <i class="fa-regular <?= htmlspecialchars($usuario->icone) ?> text-xl text-gray-700"></i>
    </button>

    <!-- Menu Dropdown -->
    <div id="userDropdown" class="hidden absolute right-0 top-14 bg-white border border-gray-300 rounded shadow-lg z-50 w-40">
      <ul class="flex flex-col text-sm text-gray-800">
        <li><a href="/<?= BASE_DIR_NAME ?>/perfil" class="px-4 py-2 hover:bg-gray-100">Meu Perfil</a></li>
        <li><a href="/<?= BASE_DIR_NAME ?>/configuracoes" class="px-4 py-2 hover:bg-gray-100">Configurações</a></li>
        <li><a href="/<?= BASE_DIR_NAME ?>/logout" class="px-4 py-2 hover:bg-gray-100 text-red-600">Sair</a></li>
      </ul>
    </div>
  </div>
</div>

<!-- Script para toggle do menu -->
<script>
  const button = document.getElementById('userMenuButton');
  const menu = document.getElementById('userDropdown');

  document.addEventListener('click', function (event) {
    const isClickInside = button.contains(event.target) || menu.contains(event.target);

    if (isClickInside) {
      menu.classList.toggle('hidden');
    } else {
      menu.classList.add('hidden');
    }
  });
</script>
