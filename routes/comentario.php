<?php

use AutoCare\Controller\ServicoComentarioController;

switch ($url) {
  case '/api/comentario/listarTabela':
    (new ServicoComentarioController())->listarTabela();
    exit;
  case '/api/admin/comentario/deletar':
    (new ServicoComentarioController())->deletarAdmin();
    exit;
  case '/api/comentario/deletar':
    (new ServicoComentarioController())->deletar();
    exit;
}
