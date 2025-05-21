<?php

namespace AutoCare\Model;

use AutoCare\DAO\PrestadorCatalogoDAO;

final class PrestadorCatalogo extends Model {
  public $id, $id_prestador, $id_especialidade;
  public $titulo, $descricao;
  public Especialidade $especialidade;

  public static function getById(int $id) : ?PrestadorCatalogo {
    return (new PrestadorCatalogoDAO())->selectById($id);
  }

  public function getAllRowsByIdPrestador($id_prestador) : array {
    return (new PrestadorCatalogoDAO())->selectByIdPrestador($id_prestador);
  }

  public function save() : PrestadorCatalogo {
    return (new PrestadorCatalogoDAO())->save($this);
  }

  public static function deleteByIdEspecialidade(int $id_especialidade) : bool {
    return (new PrestadorCatalogoDAO())->deleteByIdEspecialidade($id_especialidade);
  }
}