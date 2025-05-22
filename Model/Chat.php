<?php

namespace AutoCare\Model;

use AutoCare\DAO\ChatDAO;

final class Chat extends Model
{
  public $id, $id_usuario, $id_prestador, $autor, $nome;

  public static function getById(int $id): ?Chat
  {
    return (new ChatDAO())->selectById($id);
  }

  public static function getPrestadorByIdUsuario(int $idUsuario): int
  { 
    return (new ChatDAO())->getPrestadorByIdUsuario($idUsuario);
  }

  public static function getRowsByIdUsuario(int $idUsuario): array
  {
    return (new ChatDAO())->selectByidUsuario($idUsuario);
  }

  public static function getRowsByIdPrestador(int $idUsuario): array
  {
    $idPrestador = Chat::getPrestadorByIdUsuario($idUsuario);
    return (new ChatDAO())->selectByIdPrestador($idPrestador);
  }

  public static function getMensagensByIdChat($chatId): array
  {
    return (new ChatDAO())->getMensagensByIdChat($chatId);
  }

  public static function incluirMensagem($chatId, $mensagem): void
  { 
    if ($_SESSION['usuario']->tipo == 'usuario') {
      (new ChatDAO())->incluirMensagem($chatId, $mensagem);
    } else {
      $idPrestador = Chat::getPrestadorByIdUsuario($_SESSION['usuario']->id);
      (new ChatDAO())->incluirMensagem($chatId, $mensagem, $idPrestador);
    }
    return;
  }
}
