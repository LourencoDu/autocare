<?php

namespace AutoCare\Model;

use AutoCare\DAO\EspecialidadeDAO;

final class Especialidade extends Model
{
  public $id, $nome;

  public static function getById(int $id): ?Especialidade
  {
    return (new EspecialidadeDAO())->selectById($id);
  }

  public static function getAllRows(): array
  {
    return (new EspecialidadeDAO())->select();
  }

  public function save(): Especialidade
  {
    return (new EspecialidadeDAO())->save($this);
  }

  public static function delete(int $id): bool
  {
    return (new EspecialidadeDAO())->delete($id);
  }
}
