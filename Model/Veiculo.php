<?php

namespace AutoCare\Model;

use AutoCare\DAO\VeiculoDAO;

final class Veiculo {
  public $id, $ano, $apelido, $id_usuario, $id_modelo_veiculo;
  
  function getById(int $id) : ?Veiculo {
    return (new VeiculoDAO())->selectById($id);
  }

  function getAllRows() : array {
    return (new VeiculoDAO())->select();
  }

  function save() : Veiculo {
    return (new VeiculoDAO())->save($this);
  }

  function delete(int $id) : bool {
    return (new VeiculoDAO())->delete($id);
  }
}