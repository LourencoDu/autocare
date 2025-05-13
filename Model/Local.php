<?php
//Copia do PrestadorDAO por enquanto 
namespace AutoCare\Model;

use AutoCare\DAO\LocalDAO;

final class Local extends Model {
  public $id, $latitude, $longitude;

  public static function getById(int $id) : ?Local {
    return (new LocalDAO())->selectById($id);
  }

  public function getAllRows() : array {
    return (new LocalDAO())->select();
  }

  public function save() : Local {
    return (new LocalDAO())->save($this);
  }

  public static function delete(int $id) : bool {
    return (new LocalDAO())->delete($id);
  }
}