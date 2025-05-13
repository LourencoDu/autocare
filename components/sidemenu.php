<?php
$menuItens = [
  ['rota' => 'home', 'icone' => 'fa-home', 'label' => "Início"],
  ['rota' => 'veiculo', 'icone' => 'fa-car', 'label' => "Meus Veículos"],
  ['rota' => 'prestador', 'icone' => 'fa-screwdriver-wrench', 'label' => "Prestadores"],
  ['rota' => 'usuario', 'icone' => 'fa-user', 'label' => "Usuários"],
  ['rota' => 'funcionario', 'icone' => 'fa-user-group', 'label' => "Funcionários"],
  ['rota' => 'servico', 'icone' => 'fa-gear', 'label' => "Serviços"],
  ['rota' => 'mapa', 'icone' => 'fa-map-location-dot', 'label' => "Mapa"],
];

function isActiveRoute($rotaItem)
{
  $rotaAtual = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

  // Nome da pasta base do projeto (ajuste conforme necessário)
  $basePath = '/autocare'; // Substitua por sua pasta se for diferente

  // Remove o basePath da URL atual
  if (strpos($rotaAtual, $basePath) === 0) {
    $rotaAtual = substr($rotaAtual, strlen($basePath));
  }

  $rotaAtual = trim($rotaAtual, '/');

  if ($rotaItem === 'home') {
    return ($rotaAtual === '' || $rotaAtual === 'home') ? "true" : "false";
  }

  return strpos($rotaAtual, $rotaItem) !== false ? "true" : "false";
}
?>

<div class="flex flex-col flex-1 max-w-12 items-center gap-4">
  <div class="flex flex-1 w-full flex-col justify-start items-center border-y border-y-gray-700/40 py-4 gap-2">
    <?php foreach ($menuItens as $item): ?>
      <div class="relative group">
        <a
          aria-selected="<?= isActiveRoute($item['rota']); ?>"
          href="/<?= BASE_DIR_NAME ?>/<?= $item['rota'] ?>"
          class="sidemenu item">
          <i class="fa-solid <?= $item['icone'] ?>"></i>
        </a>
        <div class="absolute left-full ml-2 top-1/2 -translate-y-1/2 whitespace-nowrap px-2 py-1 bg-black text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">
          <?= $item['label'] ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Botão de logout -->
  <div class="flex flex-col justify-end items-center relative group">
    <a href="/<?= BASE_DIR_NAME ?>/logout" class="sidemenu item">
      <i class="fa-solid fa-arrow-right-from-bracket"></i>
    </a>
    <div class="absolute left-full ml-2 top-1/2 -translate-y-1/2 whitespace-nowrap px-2 py-1 bg-black text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">
      Sair
    </div>
  </div>
</div>