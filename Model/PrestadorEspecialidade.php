<?php

namespace AutoCare\Model;

use AutoCare\DAO\PrestadorEspecialidadeDAO;

final class PrestadorEspecialidade extends Model {
  public $id, $id_prestador, $id_especialidade;
  public Especialidade $especialidade;

  public static function getById(int $id) : ?PrestadorEspecialidade {
    return (new PrestadorEspecialidadeDAO())->selectById($id);
  }

  public function getAllRowsByIdPrestador($id_prestador) : array {
    return (new PrestadorEspecialidadeDAO())->selectByIdPrestador($id_prestador);
  }

  public function save() : PrestadorEspecialidade {
    return (new PrestadorEspecialidadeDAO())->save($this);
  }

  public static function deleteByIdEspecialidade(int $id_especialidade) : bool {
    return (new PrestadorEspecialidadeDAO())->deleteByIdEspecialidade($id_especialidade);
  }
}