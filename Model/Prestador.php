<?php

namespace AutoCare\Model;

use AutoCare\DAO\PrestadorDAO;

final class Prestador {
  public $id, $nome, $apelido, $endereco_cep, $endereco_numero;

  function getById(int $id) : ?Prestador {
    return (new PrestadorDAO())->selectById($id);
  }

  function getAllRows() : array {
    return (new PrestadorDAO())->select();
  }

  function save() : Prestador {
    return (new PrestadorDAO())->save($this);
  }

  function delete(int $id) : bool {
    return (new PrestadorDAO())->delete($id);
  }
}