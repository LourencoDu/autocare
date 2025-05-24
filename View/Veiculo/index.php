<?php

use AutoCare\Controller\ServicoController;

$veiculos = $data["veiculos"] ?? [];
$quantidade = count($veiculos);
?>

<?php if ($quantidade > 0): ?>
  <div class="flex flex-row justify-between items-center gap-2">
    <span class="text font-semibold"><?php
                                        if ($quantidade == 0) {
                                          echo "Nenhum veículo cadastrado";
                                        } else {
                                          echo "Você tem <span class='text-primary'>".$quantidade. "</span> " . ($quantidade > 1 ? "veículos cadastrados" : "veículo cadastrado");
                                        }
                                        ?></span>

    <div class="flex flex-row items-center justify-between gap-2">
      <a href="/<?= BASE_DIR_NAME ?>/veiculo/cadastrar" class="button small flex flex-row items-center">
        <i class="fa-solid fa-plus mt-[1px]"></i>
        <span class="hidden lg:block ml-1">Novo Veículo</span>
      </a>
    </div>
  </div>

  <div class="flex flex-row lg:flex-col flex-wrap gap-5 pt-5">
    <?php foreach ($veiculos as $index => $veiculo) : ?>
      <div class="relative flex flex-row flex-wrap justify-between p-4 lg:p-8 border border-gray-300 rounded-xl gap-4 max-w-[320px] lg:max-w-full">
        <div class="flex flex-col lg:flex-row items-center lg:items-start w-full lg:w-fit">
          <div class="flex flex-row items-center justify-center h-12 w-12 border border-gray-300 rounded-4xl">
            <i class="fa-solid fa-car"></i>
          </div>
          <div class="flex flex-col lg:pl-3 items-center lg:items-start">
            <span class="text-lg font-semibold"><?= $veiculo->apelido ?></span>
            <span class="hidden sm:block text-sm"><?= $veiculo->fabricante . " - " . $veiculo->modelo . " - " . $veiculo->ano ?></span>
          </div>
        </div>

        <div class="flex flex-col lg:flex-row items-center gap-6 lg:gap-14 w-full lg:w-fit">
          <div class="flex flex-row justify-center lg:justify-start gap-2 lg:gap-4 flex-wrap">
            <div class="flex flex-col border border-dashed border-gray-300 rounded-xl px-2.5 py-2 min-w-24 max-w-auto gap-1">
              <span class="text-sm font-semibold"><?= $veiculo->fabricante ?></span>
              <span class="text-xs text-gray-700">Fabricante</span>
            </div>

            <div class="flex flex-col border border-dashed border-gray-300 rounded-xl px-2.5 py-2 min-w-24 max-w-auto gap-1">
              <span class="text-sm font-semibold"><?= $veiculo->modelo ?></span>
              <span class="text-xs text-gray-700">Modelo</span>
            </div>

            <div class="flex flex-col border border-dashed border-gray-300 rounded-xl px-2.5 py-2 min-w-24 max-w-auto gap-1">
              <span class="text-sm font-semibold"><?= $veiculo->ano ?></span>
              <span class="text-xs text-gray-700">Ano</span>
            </div>
          </div>

          <div class="absolute lg:static left-2 top-2 flex flex-row items-center h-6 px-2 border border-gray-300 rounded-md bg-gray-200">
            <?= ServicoController::getServicoBadgeByIdVeiculo($veiculo->id) ?>
          </div>

          <div class="absolute lg:static right-2 top-2 flex flex-row items-center gap-2">
          <a href="/<?= BASE_DIR_NAME ?>/veiculo/alterar?id=<?= $veiculo->id ?>" class="flex flex-row items-center justify-center w-8 h-8 rounded-md text-gray-600 hover:text-primary hover:bg-primary/10 transition cursor-pointer">
            <i class="fa-solid fa-pen mt-[2px] transition"></i>
          </a>

          <a onclick="handleDeleteClick(<?= $veiculo->id ?>, '<?= $veiculo->apelido ?>')" class="flex flex-row items-center justify-center w-8 h-8 rounded-md text-gray-600 hover:text-red-500 hover:bg-red-500/10 transition cursor-pointer">
            <i class="fa-solid fa-trash mt-[2px] transition"></i>
          </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="flex flex-col items-center justify-center pt-20">
    <i class="text-primary text-6xl fa-solid fa-car mb-4"></i>
    <span class="text-lg font-semibold mb-4 text-center">Você ainda não tem veículos adicionados ao seu perfil</span>

    <a href="/<?= BASE_DIR_NAME ?>/veiculo/cadastrar" class="button flex flex-row items-center gap-1.5">
      <i class="fa-solid fa-plus mt-[2px]"></i>
      <span>Novo Veículo</span>
    </a>
  </div>
<?php endif; ?>