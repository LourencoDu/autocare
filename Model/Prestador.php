<?php

namespace AutoCare\Model;

use AutoCare\DAO\PrestadorDAO;

final class Prestador extends Model {
  public $id, $documento, $id_usuario, $id_localizacao;
  public Usuario $usuario;
  public ?Local $localizacao = null;
  public ?PrestadorContato $prestador_contato;

  public static function getById(int $id) : ?Prestador {
    return (new PrestadorDAO())->selectById($id);
  }

  public function getAllRows() : array {
    return (new PrestadorDAO())->select();
  }

  public function save() : Prestador {
    return (new PrestadorDAO())->save($this);
  }

  public static function delete(int $id) : bool {
    return (new PrestadorDAO())->delete($id);
  }
}