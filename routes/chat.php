<?php

use AutoCare\Controller\ChatController;

switch ($url) {
    case '/chat':

        if ($_SESSION['usuario']->tipo == 'usuario') {
            (new ChatController())->listarPorUsuario();
        } else {
            (new ChatController())->listarPorPrestador();
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
}
