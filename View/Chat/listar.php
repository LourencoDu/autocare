<?php
$lista = $data["lista"] ?? [];
$mensagens = $data["mensagens"] ?? [];
$usuarioLogado = $data["usuarioLogado"] ?? null;
?>

<div class="flex h-[80vh] border border-gray-300 rounded shadow-md overflow-hidden bg-white">
  <!-- Lista de chats -->
  <div class="w-1/3 border-r border-gray-200 bg-gray-50 overflow-y-auto">
    <div class="h-full">
      <?php if (count($lista)) { ?>
        <?php foreach ($lista as $chat) { ?>
          <a href="#" data-id="<?= $chat->id ?>"
            class="chat-item block px-4 py-3 border-b border-gray-200 hover:bg-gray-100 transition duration-200">
            <div class="text-sm font-medium"><?= htmlspecialchars($chat->nome ?? 'Sem nome') ?></div>
            <div class="text-xs text-gray-500">ID: <?= $chat->id ?></div>
          </a>
        <?php } ?>
      <?php } else { ?>
        <div class="p-4 text-gray-600 text-sm">Nenhum chat encontrado...</div>
      <?php } ?>
    </div>
  </div> <!-- FECHAMENTO da coluna da lista de chats -->

  <!-- Área de mensagens -->
  <div class="w-2/3 flex flex-col p-4 overflow-y-auto" id="mensagensContainer">
    <?php if ($usuarioLogado && count($mensagens)) : ?>
      <?php foreach ($mensagens as $msg) : ?>
        <?php
        $isUsuarioLogado = ($usuarioLogado->tipo === 'usuario');
        $isMsgFuncionario = ($msg['autor'] === 'funcionario');

        if ($isUsuarioLogado) {
          $classeAlinhamento = $isMsgFuncionario
            ? 'self-start bg-gray-200 text-gray-900 rounded-r-lg rounded-tl-lg'
            : 'self-end bg-blue-600 text-white rounded-l-lg rounded-tr-lg';
        } else {
          $classeAlinhamento = $isMsgFuncionario
            ? 'self-end bg-blue-600 text-white rounded-l-lg rounded-tr-lg'
            : 'self-start bg-gray-200 text-gray-900 rounded-r-lg rounded-tl-lg';
        }
        ?>
        <div class="max-w-[70%] px-4 py-2 my-1 <?= $classeAlinhamento ?>">
          <p class="whitespace-pre-line"><?= htmlspecialchars($msg['texto']) ?></p>
          <small class="text-xs text-gray-400"><?= htmlspecialchars($msg['data']) ?></small>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p class="text-sm text-gray-400">Selecione um chat à esquerda para visualizar a conversa.</p>
    <?php endif; ?>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const chatItems = document.querySelectorAll(".chat-item");

    chatItems.forEach(item => {
      item.addEventListener("click", function (e) {
        e.preventDefault();
        const chatId = this.dataset.id;

        window.location.href = "<?= BASE_URL ?>chat/conversa?id=" + chatId;
      });
    });
  });
</script>
