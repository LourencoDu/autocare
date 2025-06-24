<?php

use AutoCare\Controller\ChatController;

switch ($url) {
    case '/chat':
        $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
        if ($usuario != null && $usuario->tipo == 'usuario') {
            (new ChatController())->listarPorUsuario();
        } else if ($usuario != null && $usuario->tipo == 'funcionario'){
            (new ChatController())->listarPorPrestador();
        } else {
            (new ChatController())->avisoFuncionarioPrestador();
        }
        exit;

    case '/chat/conversa':
        (new ChatController())->getMensagensByIdChat();
        exit;

    case '/chat/atualizar':
        (new ChatController())->atualizarMensagensChat();
        exit;

    case '/api/chat/mensagem':
        (new ChatController())->incluirMensagem();
        exit;

    case '/chat/listarConversas':
        (new ChatController())->listarConversas();
        exit;

    case '/chat/visualizarMensagens':
        (new ChatController())->visualizarMensagensChat();
        exit;

    case '/chat/criaNovaConversa':
        (new ChatController())->criaNovaConversa();
        exit;
}
