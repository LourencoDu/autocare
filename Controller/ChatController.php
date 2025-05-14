<?php

namespace AutoCare\Controller;

use AutoCare\Model\Chat;

final class ChatController extends Controller
{
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Chat/listar.php";
    $this->titulo = "Conversas";
    $this->render();
  }

  public function listarPorUsuario(): void
  { 
    parent::isProtected();

    $model = new Chat();

    $lista = $model->getRowsByIdUsuario($_SESSION['usuario']->id);

    $baseDirName = BASE_DIR_NAME;

    $this->data = [
      "lista" => $lista,
    //   "addLink" => "/$baseDirName/servico/cadastrar",
    //   "editLink" => "/$baseDirName/servico/alterar",
    //   "deleteLink" => "/$baseDirName/servico/deletar",
    ];

    $this->index();
  }

  public function listarPorPrestador(): void
  {
    parent::isProtected();

    $model = new Chat();

    $lista = $model->getRowsByIdPrestador($_SESSION['usuario']->id);

    $baseDirName = BASE_DIR_NAME;

    $this->data = [
      "lista" => $lista,
    //   "addLink" => "/$baseDirName/servico/cadastrar",
    //   "editLink" => "/$baseDirName/servico/alterar",
    //   "deleteLink" => "/$baseDirName/servico/deletar",
    ];

    $this->index();
  }

  private function backToIndex(): void {
    Header("Location: /".BASE_DIR_NAME."/servico");
  }
}
