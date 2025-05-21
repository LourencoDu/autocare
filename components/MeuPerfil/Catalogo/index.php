<?php

use AutoCare\Controller\PrestadorCatalogoController;

$controller = new PrestadorCatalogoController();

$usuario = $_SESSION["usuario"];
$prestador = $usuario->prestador;

$catalogo = $controller->listar($prestador->id);
$quantidade = count($catalogo);

$add_button_label = "Novo Serviço";
?>

<div class="flex flex-col w-full pb-4 overflow-x-auto col-span-1 lg:col-span-2">
  <div class="flex flex-1 flex-col border border-gray-300 rounded-xl justify-between">
    <div class="flex flex-row items-center justify-between h-14 px-5 border-b border-gray-300">
      <span class="text-lg font-semibold">Catálogo de Serviços (<?= $quantidade ?>)</span>
      <a href="/<?= BASE_DIR_NAME ?>/catalogo/cadastrar" class="button small flex flex-row items-center">
        <i class="fa-solid fa-plus mt-[1px]"></i>
        <span class="hidden lg:block ml-1"><?= $add_button_label ?></span>
      </a>
    </div>
    <div class="flex flex-1 items-center justify-center overflow-x-auto p-5">
      <?php
      if ($quantidade > 0) :
      ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <?php foreach ($catalogo as $item) : ?>
            <div class="relative flex flex-col border border-gray-300 rounded-xl px-3.5 py-3.5 gap-2">
              <span class="font-semibold"><?= e($item->titulo) ?></span>
              <p class="text-sm text-gray-700 break-words"><?= nl2br(e($item->descricao)) ?></p>

              <div class="flex items-center pt-2">
                <div class="flex items-center justify-center px-2 text-sm font-medium border border-gray-300 bg-gray-200 rounded-md"><?= $item->especialidade->nome ?></div>
              </div>

              <?php if ($tipo == "prestador" || $tipo == "funcionario") : ?>
                <div class="absolute top-2 right-2 flex gap-2">
                  <a href="/<?= BASE_DIR_NAME ?>/catalogo/alterar?id=<?= $item->id ?>" class="flex flex-row items-center justify-center w-8 h-8 rounded-md text-gray-600 hover:text-primary hover:bg-primary/10 transition cursor-pointer">
                    <i class="fa-solid fa-pen mt-[2px] transition"></i>
                  </a>

                  <a onclick="handleServicoDeleteClick(<?= $item->id ?>, '<?= $item->titulo ?>')" class="flex flex-row items-center justify-center w-8 h-8 rounded-md text-gray-600 hover:text-red-500 hover:bg-red-500/10 transition cursor-pointer">
                    <i class="fa-solid fa-trash mt-[2px] transition"></i>
                  </a>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else : ?>
        <div class="flex flex-col items-center justify-center py-10">
          <i class="text-primary text-6xl fa-solid fa-screwdriver-wrench mb-4"></i>
          <span class="text-lg font-semibold mb-4 text-center">Você ainda não tem serviços adicionadas ao catálogo da sua empresa</span>

          <a href="/<?= BASE_DIR_NAME ?>/catalogo/cadastrar" class="button small flex flex-row items-center gap-1.5">
            <i class="fa-solid fa-plus mt-[2px]"></i>
            <span><?= $add_button_label ?></span>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  <?= require COMPONENTS."MeuPerfil/Catalogo/script.js"; ?>
</script>