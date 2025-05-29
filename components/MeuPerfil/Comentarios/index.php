<?php

use AutoCare\Controller\ServicoComentarioController;
use AutoCare\Helper\Util;

$controller = new ServicoComentarioController();

$usuario = $_SESSION["usuario"];
$tipo = $usuario->tipo;

$prestador = $usuario->prestador;
$comentarios = array();

$id_prestador = $_GET["id"] ?? null;

$is_usuario_dono_ou_funcionario = false;
if(isset($prestador)) {
  $is_usuario_dono_ou_funcionario = !$id_prestador || $id_prestador == $prestador->id;
}

if ($is_usuario_dono_ou_funcionario) {
  $comentarios = $controller->listar($prestador->id);
} else if (isset($_GET["id"])) {
  $comentarios = $controller->listar($_GET["id"]);
}

$quantidade = count($comentarios);

?>

<div class="flex flex-col w-full pb-4 overflow-x-auto col-span-1 lg:col-span-2">
  <div class="flex flex-1 flex-col border border-gray-300 rounded-xl justify-between">
    <div class="flex flex-row items-center justify-between h-14 px-5 border-b border-gray-300">
      <span class="text-lg font-semibold">Comentários (<?= $quantidade ?>)</span>
    </div>
    <div class="flex flex-1 items-center justify-center overflow-x-auto p-5">
      <?php
      if ($quantidade > 0) :
      ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 w-full">
          <?php foreach ($comentarios as $item) : ?>
            <div class="relative flex flex-col border border-gray-300 rounded-xl px-3.5 py-3.5 gap-2">
              <p class="text-gray-700 break-words"><?= nl2br(e($item->texto)) ?></p>
              <span class="text-sm text-gray-500 flex flex-1 items-end"><?= Util::formatarDataHora($item->data, "d/m/Y") ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else : ?>
        <div class="flex flex-col items-center justify-center py-10">
          <i class="text-primary text-6xl fa-solid fa-comments mb-4"></i>
          <span class="text-lg font-semibold mb-4 text-center"><?= $is_usuario_dono_ou_funcionario ? "A sua empresa ainda não recebeu comentários" : "O prestador ainda não recebeu comentários" ?></span>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  <?= require COMPONENTS . "MeuPerfil/Catalogo/script.js"; ?>
</script>