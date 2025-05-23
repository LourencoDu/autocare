<?php
$lista = $data["lista"] ?? [];
$mensagens = $data["mensagens"] ?? [];
$usuarioLogado = $data["usuarioLogado"] ?? null;
?>

<div class="flex flex-col h-[80vh] border border-gray-300 rounded shadow-md overflow-hidden bg-white">
  <div class="flex flex-1 overflow-hidden">
    <div class="w-1/3 border-r border-gray-200 bg-gray-50 overflow-y-auto">
      <div class="h-full" id="lista-de-chats">
        <?php
        $chatSelecionado = $_GET['id'] ?? null;

        if (count($lista)) {
          foreach ($lista as $chat) {
            $isSelecionado = ($chatSelecionado == $chat->id);
            $classeAtiva = $isSelecionado
              ? 'bg-blue-100 border-l-4 border-blue-500 font-semibold text-blue-900'
              : 'hover:bg-gray-100';

            echo '<a href="#" data-id="' . $chat->id . '" class="chat-item flex justify-between items-center px-4 py-3 border-b border-gray-200 transition duration-200 ' . $classeAtiva . '">';
            echo '<div>';
            echo '<div class="text-sm font-medium">' . htmlspecialchars($chat->nome ?? 'Sem nome') . '</div>';
            echo '<div class="text-xs text-gray-500">ID: ' . $chat->id . '</div>';
            echo '</div>';
            if (!empty($chat->visualizado) && $chat->visualizado == 0) {
              echo '<div class="absolute top-2 right-2 w-2.5 h-2.5 bg-green-500 rounded-full"></div>';
            }


            echo '</a>';
          }
        } else {
          echo '<div class="p-4 text-gray-600 text-sm">Nenhum chat encontrado...</div>';
        }
        ?>
      </div>
    </div>

    <div class="w-2/3 flex flex-col">
      <div class="flex-1 flex flex-col p-4 overflow-y-auto" id="mensagensContainer">
      </div>

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
  <p class="whitespace-pre-line break-words">${escapeHTML(mensagem.texto)}</p>
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
    marcarVisualizado();
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
    marcarVisualizado();
  }

  function atualizarListaChats() {
    fetch('<?= BASE_URL ?>chat/listarConversas')
      .then(response => {
        if (!response.ok) throw new Error('Erro na requisição');
        return response.json();
      })
      .then(data => {
        if (data.status === 'success') {
          const lista = document.getElementById('lista-de-chats');
          lista.innerHTML = '';

          if (data.dados.length === 0) {
            lista.innerHTML = '<div class="p-4 text-gray-600 text-sm">Nenhum chat encontrado...</div>';
            return;
          }

          const chatSelecionado = <?= (int) ($_GET['id'] ?? 0) ?>;

          data.dados.forEach(chat => {
            const isSelecionado = (chatSelecionado === chat.id);
            const classeAtiva = isSelecionado ?
              'bg-blue-100 border-l-4 border-blue-500 font-semibold text-blue-900' :
              'hover:bg-gray-100';

            const item = document.createElement('a');
            item.href = '<?= BASE_URL ?>chat/conversa?id=' + chat.id;
            item.dataset.id = chat.id;
            item.className = `chat-item block px-4 py-3 border-b border-gray-200 transition duration-200 ${classeAtiva}`;
            item.innerHTML = `
    <div class="text-sm font-medium">${chat.nome ? escapeHtml(chat.nome) : 'Sem nome'}</div>
    <div class="text-xs text-gray-500">ID: ${chat.id}</div>
`;
            lista.appendChild(item);

            if (chat.visualizado === 0) {
              const badge = document.createElement('div');
              badge.className = 'w-2.5 h-2.5 bg-green-500 rounded-full';
              item.appendChild(badge);
            }
          });
        } else {
          console.error('Erro na resposta:', data.erros);
        }
      })
      .catch(error => {
        console.error('Erro no fetch:', error);
      });
  }

  function escapeHtml(text) {
    const map = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) {
      return map[m];
    });
  }

  function marcarVisualizado() {
    fetch("<?= BASE_URL ?>chat/visualizarMensagens?id=" + chatId)
      .then(response => response.json())
      .catch(console.error);
  }

  setInterval(atualizarListaChats, 1000);

  if (chatId) {
    setInterval(buscarNovasMensagens, 1000);
  }

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

    if (textarea) {
      textarea.addEventListener("keydown", function(e) {
        if (e.key === "Enter" && !e.shiftKey) {
          e.preventDefault();
          form.requestSubmit();
        }
      });
    }

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
          atualizarListaChats();
        }).catch(err => {
          console.error('Erro ao enviar mensagem:', err);
        });
        mensagemInput.value = '';
      });
    }
  });
</script>