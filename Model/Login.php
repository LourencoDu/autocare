<?php

namespace AutoCare\Model;

use AutoCare\DAO\LoginDAO;

final class Login {
  public $id, $nome, $sobrenome, $email, $senha, $tipo, $telefone;
  public $nome_completo, $icone;
  public ?Prestador $prestador;

  function logar() : ?Login {
    return (new LoginDAO())->autenticar($this);
  }
}