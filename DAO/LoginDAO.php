<?php

namespace AutoCare\DAO;

use AutoCare\Model\Login;
use AutoCare\Model\Prestador;

final class LoginDAO extends DAO {
  public function __construct()
  {
    parent::__construct();
  }

  public function autenticar(Login $model) : ?Login
  {
    $sql = "SELECT
    u.id u_id, u.nome u_nome, u.sobrenome u_sobrenome, u.email u_email, u.senha u_senha, u.tipo u_tipo, u.telefone u_telefone, u.numero_sorte u_numero_sorte,
    p.id p_id, p.documento p_documento
    FROM usuario u
    LEFT JOIN prestador p ON (
        (u.tipo = 'prestador' AND p.id_usuario = u.id) OR
        (u.tipo = 'funcionario' AND p.id = (SELECT f.id_prestador FROM funcionario f WHERE f.id_usuario = u.id))
    )
    WHERE u.email = ?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->email);
    $stmt->execute();

    $data = $stmt->fetchObject();
    
    if(is_object($data)) {
      if(password_verify($model->senha, $data->u_senha)) {
        $login = new Login();
        $login->id = $data->u_id;
        $login->nome = $data->u_nome;
        $login->sobrenome = $data->u_sobrenome;
        $login->email = $data->u_email;
        $login->senha = $data->u_senha;
        $login->tipo = $data->u_tipo;
        $login->telefone = $data->u_telefone;
        $login->numero_sorte = $data->u_numero_sorte;

        $login->prestador = null;
        if($data->p_id) {
          $login->prestador = new Prestador();
          $login->prestador->id = $data->p_id;
          $login->prestador->documento = $data->p_documento;
        }

        return $login;
      }
    }

    return null;
  }
}