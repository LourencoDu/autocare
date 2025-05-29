<?php

use AutoCare\Helper\Util;

$prestadores = isset($data["lista"]) ? $data["lista"] : [];
$quantidade = count($prestadores);

?>

<div class="flex flex-col items-stretch gap-8">
  <div class="form-control medium flex-col has-search">
    <i class="fa-solid fa-search"></i>
    <input id="search-input" type="text" placeholder="Buscar por prestador" />
  </div>

  <div class="flex items-center justify-between">
    <span class="font-medium">
      Exibindo
      <span id="search-count"><?= $quantidade ?></span>
      de <?= $quantidade ?> <?= $quantidade == 1 ? "resultado" : "resultados" ?>
      <span id="search-value-label" class="hidden">para "<span id="search-value" class="text-red-500">Nike</span>"</span>
    </span>
  </div>

  <div id="lista" class="flex flex-col gap-4">
    <?php foreach ($prestadores as $index => $prestador) : ?>
      <?php
      $nome_sem_acentos = Util::removerAcentos($prestador->usuario->nome);
      $telefone = $prestador->usuario->telefone;
      $documento = $prestador->documento;
      $nota = "5.0";
      ?>

      <div data-search="<?= strtolower($nome_sem_acentos . " " . $telefone . " " . $documento . " ") ?>" class="search-item flex flex-row flex-wrap justify-between p-2.5 pe-5 border border-gray-300 rounded-xl gap-4">
        <div class="flex flex-col sm:flex-row w-full sm:w-auto items-center gap-4">
          <div class="flex flex-row items-center justify-center bg-gray-200/50 border border-gray-300 h-18 w-26 rounded-xl">
            <i class="fa-solid fa-building text-gray-600 text-2xl"></i>
          </div>

          <div class="flex flex-col items-center sm:items-start gap-2">
            <div class="flex flex-row items-center gap-2">
              <a href="/<?= BASE_DIR_NAME ?>/prestador?id=<?= $prestador->id ?>" class="font-medium leading-5.5 hover:text-primary transition cursor-pointer w-fit"><?= $prestador->usuario->nome ?></a>
              <div class="flex sm:hidden items-center gap-1 px-1.5 min-h-5 rounded-full bg-yellow-400 text-white text-xs">
                <i class="fa-solid fa-star"></i>
                <span class="font-medium"><?= $prestador->nota ?? "não avaliado" ?></span>
              </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center flex-wrap gap-4">
              <div class="hidden sm:flex items-center gap-1 px-1.5 min-h-5 rounded-full bg-yellow-400 text-white text-xs">
                <i class="fa-solid fa-star"></i>
                <span class="font-medium"><?= $prestador->nota ?? "não avaliado" ?></span>
              </div>

              <div class="flex flex-col sm:flex-row items-center gap-2 lg:gap-4">
                <span class="text-sm">
                  Telefone:
                  <span class="font-medium"><?= Util::formatarTelefone($telefone) ?></span>
                </span>

                <span class="text-sm">
                  CNPJ:
                  <span class="font-medium"><?= Util::formatarCnpj($documento) ?></span>
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row w-full sm:w-auto items-center gap-4">
          <span class="font-medium"></span>

          <a href="/<?= BASE_DIR_NAME ?>/prestador?id=<?= $prestador->id ?>" class="button small ghost flex items-center gap-1">
            <i class="fa-solid fa-flag"></i>
            Ver Catálogo de Serviços
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>