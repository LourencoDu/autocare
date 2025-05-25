<?php

namespace AutoCare\Controller;

use AutoCare\Model\Chat;
use AutoCare\Helper\JsonResponse;

final class ChatController extends Controller
{
  public function index(): void
  {
    parent::isProtected(["prestador", "administrador"]);

    $this->view = "Chat/listar.php";
    $this->titulo = "Conversas";
    $this->render();
  }

  public function listarPorUsuario(): void
  {
    parent::isProtected(["prestador", "administrador"]);

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
    parent::isProtected(["prestador", "administrador"]);

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

  public function getMensagensByIdChat(): void
  {
    parent::isProtected(["prestador", "administrador"]);

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

  public function atualizarMensagensChat(): void
  {
    parent::isProtected(["prestador", "administrador"]);

    $chatId = $_GET['id'] ?? null;

    $model = new Chat();
    $mensagens = $model->getMensagensByIdChat($chatId);

    $response = JsonResponse::sucesso("Mensagens carregadas com sucesso", $mensagens);
    $response->enviar();
  }

  public function listarConversas(): void
  {
    parent::isProtected(["prestador", "administrador"]);

    if ($_SESSION['usuario']->tipo == 'usuario') {
      $lista = ChatController::getChatsPorUsuario();
    } else {
      $lista = ChatController::getChatsPorPrestador();
    }

    $response = JsonResponse::sucesso("Chats carregados com sucesso", $lista);
    $response->enviar();
  }

  public function incluirMensagem(): void
  {
    parent::isProtected(["prestador", "administrador"]);

    $chat_id = intval($_POST['chatId']);
    $mensagem = $_POST['texto'];

    $model = new Chat();
    $model->incluirMensagem($chat_id, $mensagem);

    $response = JsonResponse::sucesso("Mensagens Cadastrada");
    $response->enviar();
  }

  public function visualizarMensagensChat(): void
  {
    parent::isProtected(["prestador", "administrador"]);

    $chatId = $_GET['id'] ?? null;

    $model = new Chat();
    $model->visualizarMensagensChat($chatId);

    $response = JsonResponse::sucesso("Mensagens visualizadas com sucesso");
    $response->enviar();
  }

  public function criaNovaConversa(): void
  {
    parent::isProtected(["prestador", "administrador"]);

    $idPrestador = $_GET['id'] ?? null;

    $model = new Chat();
    $id = $model->criaNovaConversa($idPrestador);

    $response = JsonResponse::sucesso($id);
    $response->enviar();
  }
}
