<?php

use Autocare\Helper\Util;

$prestador = $data["prestador"];
?>

<div class="flex flex-col gap-8">
  <div class="flex flex-col items-center gap-4">
    <div class="flex items-center justify-center w-25 h-25 border border-gray-300 rounded-full text-gray-600 shadow-lg bg-white">
      <i class="fa-solid fa-wrench text-5xl"></i>
    </div>
    <div class="flex gap-4 items-center">
      <div class="font-semibold text-xl"><?= $prestador->usuario->nome ?></div>

      <div class="flex items-center gap-1 px-1.5 min-h-6 h-fit rounded-full bg-yellow-400 text-white text-sm">
        <i class="fa-solid fa-star"></i>
        <span class="font-semibold">5.0</span>
      </div>
    </div>
    <div class="flex flex-wrap flex-col items-center sm:items-start sm:flex-row gap-6">
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
      <?php if ($_SESSION["usuario"]->tipo == "usuario"): ?>
        <a id="botaoMensagem" href="#" class="button medium flex items-center gap-2">
          <i class="fa-solid fa-comments"></i>
          Enviar mensagem
        </a>
      <?php endif; ?>
    </div>
  </div>

  <?php require COMPONENTS . "/MeuPerfil/Catalogo/index.php"; ?>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const botaoMensagem = document.getElementById('botaoMensagem');
    if (botaoMensagem) {
      botaoMensagem.addEventListener('click', function(e) {
        e.preventDefault();
        const params = new URLSearchParams(window.location.search);
        const id_prestador = params.get('id');

        if (id_prestador) {
          fetch("<?= BASE_URL ?>chat/criaNovaConversa?id=" + id_prestador)
            .then(response => response.json())
            .then(data => {
              chatId = data.mensagem
              window.location.href = '/<?= BASE_DIR_NAME ?>/chat/conversa?id=' + chatId;
            })
            .catch(error => {
              console.error('Erro no novo chat:', error);
            });

        } else {
          alert('Prestador não encontrado');
        }
      });
    }
  });
</script>