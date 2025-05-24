<?php

namespace AutoCare\Model;

use AutoCare\DAO\VeiculoDAO;

final class Veiculo extends Model {
  public $id, $ano, $apelido, $id_usuario, $id_modelo_veiculo, $modelo, $fabricante;
  
  public static function getById(int $id) : ?Veiculo {
    return (new VeiculoDAO())->selectById($id);
  }

  public function getAllByIdUsuario(int $id_usuario) : array {
    return (new VeiculoDAO())->selectByUser($id_usuario);
  }

  public function getAllByLoggedUser() : array {
    $id_usuario = $_SESSION["usuario"]->id;
    return (new VeiculoDAO())->selectByUser($id_usuario);
  }

  public function getAllRows() : array {
    return (new VeiculoDAO())->select();
  }

  public function save() : Veiculo {
    return (new VeiculoDAO())->save($this);
  }

  public static function delete(int $id) : bool {
    return (new VeiculoDAO())->delete($id);
  }
}