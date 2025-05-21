<?php
$lista = $data["lista"] ?? [];
$mensagens = $data["mensagens"] ?? [];
$usuarioLogado = $data["usuarioLogado"] ?? null;
?>

<div class="flex flex-col h-[80vh] border border-gray-300 rounded shadow-md overflow-hidden bg-white">
  <div class="flex flex-1 overflow-hidden">
    <!-- Lista de chats -->
    <div class="w-1/3 border-r border-gray-200 bg-gray-50 overflow-y-auto">
      <div class="h-full">
        <?php
        $chatSelecionado = $_GET['id'] ?? null;

        if (count($lista)) {
          foreach ($lista as $chat) {
            $isSelecionado = ($chatSelecionado == $chat->id);
            $classeAtiva = $isSelecionado
              ? 'bg-blue-100 border-l-4 border-blue-500 font-semibold text-blue-900'
              : 'hover:bg-gray-100';

            echo '<a href="#" data-id="' . $chat->id . '" class="chat-item block px-4 py-3 border-b border-gray-200 transition duration-200 ' . $classeAtiva . '">';
            echo '<div class="text-sm font-medium">' . htmlspecialchars($chat->nome ?? 'Sem nome') . '</div>';
            echo '<div class="text-xs text-gray-500">ID: ' . $chat->id . '</div>';
            echo '</a>';
          }
        } else {
          echo '<div class="p-4 text-gray-600 text-sm">Nenhum chat encontrado...</div>';
        }
        ?>
      </div>
    </div>

    <!-- Área de mensagens -->
    <div class="w-2/3 flex flex-col">
      <div class="flex-1 flex flex-col p-4 overflow-y-auto" id="mensagensContainer">
        <!-- Mensagens serão renderizadas por JavaScript -->
      </div>

      <!-- Área de digitação -->
      <?php if ($chatSelecionado) : ?>
        <form id="formMensagem" method="post" action="<?= BASE_URL ?>chat/mensagem" class="p-4 border-t border-gray-200 flex items-end gap-2">
          <input type="hidden" id="chat_id" name="chat_id" value="<?= htmlspecialchars($chatSelecionado) ?>">
          <textarea name="mensagem" id="mensagem" rows="2" placeholder="Digite sua mensagem..." class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Enviar</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  const mensagensIniciais = <?= json_encode($mensagens, JSON_UNESCAPED_UNICODE) ?>;
  const usuarioTipo = "<?= $usuarioLogado->tipo ?? '' ?>";
  const chatId = "<?= $chatSelecionado ?? '' ?>";
</script>

<script>
  const mensagensContainer = document.getElementById("mensagensContainer");

  function escapeHTML(text) {
    const div = document.createElement("div");
    div.innerText = text;
    return div.innerHTML;
  }

  function criarMensagemHTML(mensagem) {
    const div = document.createElement("div");
    const isUsuarioLogado = usuarioTipo === "usuario";
    const isMsgFuncionario = mensagem.autor === "funcionario";

    let classeAlinhamento;

    if (isUsuarioLogado) {
      classeAlinhamento = isMsgFuncionario ?
        "self-start bg-gray-200 text-gray-900 rounded-r-lg rounded-tl-lg" :
        "self-end bg-blue-600 text-white rounded-l-lg rounded-tr-lg";
    } else {
      classeAlinhamento = isMsgFuncionario ?
        "self-end bg-blue-600 text-white rounded-l-lg rounded-tr-lg" :
        "self-start bg-gray-200 text-gray-900 rounded-r-lg rounded-tl-lg";
    }

    div.className = `max-w-[70%] px-4 py-2 my-1 ${classeAlinhamento}`;
    div.innerHTML = `
      <p class="whitespace-pre-line">${escapeHTML(mensagem.texto)}</p>
      <small class="text-xs text-gray-400">${escapeHTML(mensagem.data)}</small>
    `;
    return div;
  }

  function renderizarMensagens(lista) {
    mensagensContainer.innerHTML = "";
    lista.forEach(msg => {
      mensagensContainer.appendChild(criarMensagemHTML(msg));
    });
    mensagensContainer.scrollTop = mensagensContainer.scrollHeight;
  }

  renderizarMensagens(mensagensIniciais);

  let ultimaQtdMensagens = mensagensIniciais.length;

  function buscarNovasMensagens() {
    fetch("<?= BASE_URL ?>chat/atualizar?id=" + chatId)
      .then(response => response.json())
      .then(mensagens => {
        if (mensagens.dados.length > ultimaQtdMensagens) {
          const novas = mensagens.dados.slice(ultimaQtdMensagens);
          novas.forEach(msg => {
            mensagensContainer.appendChild(criarMensagemHTML(msg));
          });
          mensagensContainer.scrollTop = mensagensContainer.scrollHeight;
          ultimaQtdMensagens += novas.length;
        }
      })
      .catch(console.error);
  }

  if (chatId) {
    setInterval(buscarNovasMensagens, 1000);
  }

  // Navegação entre chats
  document.addEventListener("DOMContentLoaded", function() {
    const chatItems = document.querySelectorAll(".chat-item");

    chatItems.forEach(item => {
      item.addEventListener("click", function(e) {
        e.preventDefault();
        const chatId = this.dataset.id;
        window.location.href = "<?= BASE_URL ?>chat/conversa?id=" + chatId;
      });
    });

    const textarea = document.getElementById("mensagem");
    const form = document.getElementById("formMensagem");

    // 🔥 Enviar com Enter
    if (textarea) {
      textarea.addEventListener("keydown", function(e) {
        if (e.key === "Enter" && !e.shiftKey) {
          e.preventDefault();
          form.requestSubmit(); // 🔥 dispara o submit do formulário
        }
      });
    }

    // 🔥 Evento de submit do formulário
    if (form) {
      form.addEventListener("submit", function(e) {
        e.preventDefault();

        const mensagemInput = document.getElementById("mensagem");
        const chatIdInput = document.getElementById("chat_id");

        const texto = mensagemInput.value.trim();
        const chatId = chatIdInput.value;

        if (!texto || !chatId) return;

        post(
          "<?= BASE_URL ?>chat/mensagem",
          new URLSearchParams({
            chatId,
            texto
          })
        ).then(response => {
          console.log(response);
          buscarNovasMensagens();
        }).catch(err => {
          console.error('Erro ao enviar mensagem:', err);
        });

        console.log('chegou aqui');
        mensagemInput.value = '';
      });
    }
  });
</script>