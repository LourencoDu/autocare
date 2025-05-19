<?php
$usuario = $_SESSION["usuario"];

$entradas_menu = array([
  "texto" => "Meu Perfil",
  "icone" => "fa-address-card",
  "rota" => "meu-perfil"
]);

if ($usuario->tipo == "usuario") {
  array_push($entradas_menu, [
    "texto" => "Meus Veículos",
    "icone" => "fa-car",
    "rota" => "veiculo"
  ]);
}

if ($usuario->tipo == "prestador") {
  array_push($entradas_menu, [
    "texto" => "Meus Funcionários",
    "icone" => "fa-users-gear",
    "rota" => "funcionario"
  ]);
}
?>

  <div class="flex flex-row items-center gap-2 relative">
    <!-- Ícone de usuário com botão -->
    <button id="userMenuButton" class="w-10 h-10 flex items-center justify-center border border-gray-300 text-gray-700 bg-white rounded-4xl relative focus:outline-none hover:border-primary/60 hover:text-primary cursor-pointer transition">
      <i class="fa-regular <?= htmlspecialchars($usuario->icone) ?> text-xl"></i>
    </button>

    <!-- Menu Dropdown -->
    <div id="userDropdown" class="hidden absolute left-0 bottom-12 bg-white border border-gray-300 rounded-md shadow-lg z-50 w-[250px]">
      <div class="flex gap-2 px-5 py-4 border-b border-gray-300">
        <div class="w-10 min-w-10 h-10 min-h-10 flex items-center justify-center border border-gray-400 rounded-4xl relative focus:outline-none">
          <i class="fa-regular <?= htmlspecialchars($usuario->icone) ?> text-xl text-gray-700"></i>
        </div>

        <div class="flex flex-col max-w-[160px]">
          <span class="text-sm/5 font-medium truncate"><?= htmlspecialchars($usuario->nome_completo) ?></span>
          <span class="text-xs/4 font-medium text-gray-600 truncate"><?= htmlspecialchars($usuario->email) ?></span>
        </div>
      </div>

      <div class="flex flex-col gap-1 px-2 py-2">
        <?php foreach ($entradas_menu as $index => $entrada) : ?>
          <a href="/<?= BASE_DIR_NAME ?>/<?= $entrada["rota"] ?>" class="flex items-center gap-2 px-4 py-2 rounded-md text-sm transition hover:bg-gray-200">
            <i class="fa-solid text-gray-700 mt-[2px] <?= $entrada["icone"] ?>"></i>
            <span class="text-700 font-medium truncate"><?= $entrada["texto"] ?></span>
          </a>
        <?php endforeach; ?>
      </div>

      <div class="flex gap-2 px-5 py-4 border-t border-gray-300">
        <a href="/<?= BASE_DIR_NAME ?>/logout" class="button ghost medium w-full flex items-center justify-center text-sm">
          Sair
        </a>
      </div>
    </div>
  </div>


<!-- Script para toggle do menu -->
<script>
  const button = document.getElementById('userMenuButton');
  const menu = document.getElementById('userDropdown');

  document.addEventListener('click', function(event) {
    const isClickInside = button.contains(event.target) || menu.contains(event.target);

    if (isClickInside) {
      menu.classList.toggle('hidden');
    } else {
      menu.classList.add('hidden');
    }
  });
</script>