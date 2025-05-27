<?php

use AutoCare\Controller\RecuperarSenhaController;

switch ($url) {
    case '/recuperar':
        (new RecuperarSenhaController())->index();
        exit;

    case '/recuperarSenha':
        (new RecuperarSenhaController())->recuperarSenha();
        exit;

    case '/novaSenha':
        (new RecuperarSenhaController())->novaSenha();
        exit;

    case '/atualizarSenha':
        (new RecuperarSenhaController())->salvarNovaSenha();
        exit;
}
