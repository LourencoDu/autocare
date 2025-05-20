<?php

namespace AutoCare\Model;

final class Especialidade extends Model {
  public $id, $titulo, $descricao;
  public ?int $id_fabricante_veiculo;
}