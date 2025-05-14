<?php

namespace AutoCare\Model;

use AutoCare\DAO\ChatDAO;

final class Chat extends Model {
  public $id, $id_usuario, $id_prestador;
  
  public static function getById(int $id) : ?Chat {
    return (new ChatDAO())->selectById($id);
  }

  public static function getPrestadorByIdUsuario(int $idUsuario): int{
    return (new ChatDAO())->getPrestadorByIdUsuario($idUsuario);
  }

  public static function getRowsByIdUsuario(int $idUsuario) : array {
    return (new ChatDAO())->selectByidUsuario($idUsuario);
  }

  public static function getRowsByIdPrestador(int $idUsuario) : array {
    $idPrestador = Chat::getPrestadorByIdUsuario($idUsuario);
    return (new ChatDAO())->selectByIdPrestador($idPrestador);
  }
}