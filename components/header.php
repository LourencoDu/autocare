<?php
$usuario = $_SESSION["usuario"];
?>

<div class="flex flex-row w-full justify-between">
  <div class="flex flex-row h-10 w-12 items-center justify-center gap-1">
    <i class="fa-solid fa-car-side text-3xl"></i>
  </div>

  <div class="flex flex-row items-center gap-2">
    <div class="flex flex-col items-end">
      <span class="text-base/5 font-medium"><?= htmlspecialchars($usuario->nome_completo) ?></span>
      <span class="text-sm/4 text-gray-600"><?= htmlspecialchars($usuario->email) ?></span>
    </div>
    <div class="w-10 h-10 flex items-center justify-center border border-gray-400 rounded-4xl">
      <i class="fa-regular <?= htmlspecialchars($usuario->icone) ?> text-xl text-gray-700"></i>
    </div>
  </div>
</div>
