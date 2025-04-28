<?php

namespace AutoCare\Model;

use AutoCare\DAO\ServicoDAO;

final class Servico {
  public $id, $descricao, $data, $id_usuario, $id_prestador, $id_veiculo;

  public static function getById(int $id) : ?Servico {
    return (new ServicoDAO())->selectById($id);
  }

  public static function getAllRows() : array {
    return (new ServicoDAO())->select();
  }

  public function save() : Servico {
    return (new ServicoDAO())->save($this);
  }

  public static function delete(int $id) : bool {
    return (new ServicoDAO())->delete($id);
  }
}