<?php

use AutoCare\Controller\ChatController;

switch ($url) {
  case '/chat':
    
    if ($_SESSION['usuario']->tipo == 'usuario'){
        (new ChatController())->listarPorUsuario();
    } else{
        (new ChatController())->listarPorPrestador();
    }
    exit;
}
