<?php
  $usuario = $_SESSION["usuario"];
  $tipo = $usuario->tipo;
?>

<div class="flex flex-col pb-4 overflow-x-auto col-span-1">
  <div class="flex flex-1 flex-col border border-gray-300 rounded-xl justify-between">
    <div class="flex flex-row items-center h-14 px-5 border-b border-gray-300">
      <span class="text-lg font-semibold">Localização da Empresa</span>
    </div>
    <div class="flex flex-1 items-center justify-center overflow-x-auto p-5">
      <span class="">MAPA</span>
    </div>
    <?php if($tipo == "prestador") : ?>
      <div class="flex flex-row-reverse items-center h-14 px-5 border-t border-gray-300">
      <button class="button small">Salvar localização</button>
    </div>
    <?php endif; ?>

  </div>
</div>