<?php

use AutoCare\Controller\PrestadorEspecialidadeController;

$controller = new PrestadorEspecialidadeController();

$usuario = $_SESSION["usuario"];
$prestador = $usuario->prestador;

$prestador_especialidades = $controller->listar($prestador->id);
$quantidade = count($prestador_especialidades);
?>

<div class="flex flex-col w-full pb-4 overflow-x-auto col-span-1 lg:col-span-2">
  <div class="flex flex-1 flex-col border border-gray-300 rounded-xl justify-between">
    <div class="flex flex-row items-center justify-between h-14 px-5 border-b border-gray-300">
      <span class="text-lg font-semibold">Especialidades (<?= $quantidade ?>)</span>
      <a href="/<?= BASE_DIR_NAME ?>/especialidade/cadastrar" class="button small flex flex-row items-center">
        <i class="fa-solid fa-plus mt-[1px]"></i>
        <span class="hidden lg:block ml-1">Nova Especialidade</span>
      </a>
    </div>
    <div class="flex flex-1 items-center justify-center overflow-x-auto p-5">
      <?php
      if ($quantidade > 0) :
      ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4">
          <?php foreach ($prestador_especialidades as $prestador_especialidade) : ?>
          <?php $especialidade = $prestador_especialidade->especialidade; ?>
            <div class="flex flex-col border border-gray-300 rounded-xl px-3.5 py-3.5 gap-2">
              <span class="font-semibold"><?= e($especialidade->titulo) ?></span>
              <p class="text-sm text-gray-700 break-words"><?= nl2br(e($especialidade->descricao)) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else : ?>
        <div class="flex flex-col items-center justify-center py-10">
          <i class="text-primary text-6xl fa-solid fa-screwdriver-wrench mb-4"></i>
          <span class="text-lg font-semibold mb-4 text-center">Ainda não tem especialidades adicionadas ao perfil da empresa</span>

          <a href="/<?= BASE_DIR_NAME ?>/especialidade/cadastrar" class="button small flex flex-row items-center gap-1.5">
            <i class="fa-solid fa-plus mt-[2px]"></i>
            <span>Nova Especialidade</span>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>