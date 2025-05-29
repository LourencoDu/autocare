<?php

namespace AutoCare\Model;

use AutoCare\DAO\ServicoComentarioDAO;

final class ServicoComentario extends Model {
  public $id, $id_servico;
  public $texto, $data;
  public ServicoAvaliacao $avaliacao;

  public static function getById(int $id) : ?ServicoComentario {
    return (new ServicoComentarioDAO())->selectById($id);
  }

  public function getAllRowsByIdPrestador($id_prestador) : array {
    return (new ServicoComentarioDAO())->selectByIdPrestador($id_prestador);
  }

  public static function delete(int $id) : bool {
    return (new ServicoComentarioDAO())->delete($id);
  }
}