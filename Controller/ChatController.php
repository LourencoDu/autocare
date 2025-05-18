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

    $listaDeChats = ChatController::getChatsPorUsuario();

    $this->data = [
      "lista" => $listaDeChats
    ];

    $this->index();
  }

  public static function getChatsPorUsuario(): array
  {
    $model = new Chat();
    return $model->getRowsByIdUsuario($_SESSION['usuario']->id);
  }

  public function listarPorPrestador(): void
  {
    parent::isProtected();

    $listaDeChats = ChatController::getChatsPorPrestador();

    $this->data = [
      "lista" => $listaDeChats
    ];

    $this->index();
  }

  public static function getChatsPorPrestador(): array
  {
    $model = new Chat();
    return $model->getRowsByIdPrestador($_SESSION['usuario']->id);
  }

  private function backToIndex(): void
  {
    Header("Location: /" . BASE_DIR_NAME . "/servico");
  }

  public function getMensagensByIdChat(): void
  {
    parent::isProtected();

    header("Content-Type: application/json");

    $chatId = $_GET['id'] ?? null;

    if (!$chatId) {
      http_response_code(400);
      echo json_encode(["error" => "ID do chat não informado."]);
      return;
    }

    $model = new Chat();
    $mensagens = $model->getMensagensByIdChat($chatId);

    if ($_SESSION['usuario']->tipo == 'usuario') {
      $lista = ChatController::getChatsPorUsuario();
    } else {
      $lista = ChatController::getChatsPorPrestador();
    }

    $this->data = [
      "lista" => $lista,
      "mensagens" => $mensagens,
      "chatIdSelecionado" => $chatId,
      "usuarioLogado" => $_SESSION['usuario'],
    ];

    $this->index();
  }
}
