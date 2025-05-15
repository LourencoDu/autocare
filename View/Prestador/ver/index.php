<?php

use Autocare\Helper\Util;

$prestador = $data["prestador"];
?>

<div class="flex flex-col gap-8">
  <div class="flex flex-col items-center gap-4">
    <div class="flex items-center justify-center w-25 h-25 border border-gray-300 rounded-full text-gray-600 shadow-lg bg-white">
      <i class="fa-solid fa-wrench text-5xl"></i>
    </div>
    <div class="font-semibold text-lg"><?= $prestador->usuario->nome ?></div>
    <div class="flex gap-6">
      <!-- Localização -->
      <div class="relative group flex items-center gap-2 text-gray-600">
        <i class="fa-solid fa-location-dot"></i>
        <span>Curitiba, PR</span>
        <div class="absolute top-full left-1/2 -translate-x-1/2 mt-2 whitespace-nowrap px-2 py-1 bg-black text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">
          Localização
        </div>
      </div>

      <!-- Telefone -->
      <div class="relative group flex items-center gap-2 text-gray-600">
        <i class="fa-solid fa-phone text-[13px] mt-[2px]"></i>
        <span><?= Util::formatarTelefone($prestador->usuario->telefone) ?></span>
        <div class="absolute top-full left-1/2 -translate-x-1/2 mt-2 whitespace-nowrap px-2 py-1 bg-black text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">
          Telefone
        </div>
      </div>

      <!-- Email -->
      <div class="relative group flex items-center gap-2 text-gray-600">
        <i class="fa-solid fa-envelope mt-[2px]"></i>
        <span><?= $prestador->usuario->email ?></span>
        <div class="absolute top-full left-1/2 -translate-x-1/2 mt-2 whitespace-nowrap px-2 py-1 bg-black text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">
          E-mail
        </div>
      </div>
    </div>
  </div>

  <div class="flex items-center justify-between gap-6 border-b border-gray-300 pb-4">
    <div></div>
    <div class="flex items-center gap-2">
      <a href="/<?= BASE_DIR_NAME ?>/chat" class="button medium flex items-center gap-2">
        <i class="fa-solid fa-comments"></i>
        Enviar mensagem
      </a>
    </div>
  </div>
</div>