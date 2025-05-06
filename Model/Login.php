<?php

namespace AutoCare\Model;

use AutoCare\DAO\LoginDAO;

final class Login {
  public $id, $nome, $email, $senha;

  function logar() : ?Login {
    return (new LoginDAO())->autenticar($this);
  }
}