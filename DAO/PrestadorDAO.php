<?php

namespace AutoCare\DAO;

use AutoCare\Model\Prestador;
use AutoCare\Model\Usuario;
use AutoCare\Model\Local;

final class PrestadorDAO extends DAO
{
  public function __construct()
  {
    parent::__construct();
  }

  public function save(Prestador $model): Prestador
  {
    return ($model->id == null) ? $this->insert($model) : $this->update($model);
  }

  private function insert(Prestador $model): Prestador
  {
    $sql = "INSERT INTO prestador (documento, id_usuario) VALUES (?, ?);";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->documento);
    $stmt->bindValue(2, $model->id_usuario);
    $stmt->execute();

    $model->id = parent::$conexao->lastInsertId();

    return $model;
  }

  private function update(Prestador $model)
  {
    $sql = "UPDATE prestador SET documento=? WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->documento);
    $stmt->bindValue(2, $model->id);
    $stmt->execute();

    return $model;
  }

  public function selectById(int $id)
  {
    $sql = "
    SELECT 
      p.id, 
      p.documento,
      p.id_usuario,
      p.id_localizacao,
      u.id AS u_id, 
      u.nome AS u_nome, 
      u.email AS u_email, 
      u.senha AS u_senha,
      u.telefone as u_telefone,   
      u.tipo as u_tipo,   
      l.id AS l_id, 
      l.latitude AS l_latitude, 
      l.longitude AS l_longitude
    FROM prestador p
    JOIN usuario u ON u.id = p.id_usuario
    LEFT JOIN localizacao l ON l.id = p.id_localizacao
    WHERE p.id = ?
  ";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    $data = $stmt->fetchObject();

    if (!$data) {
      return null;
    }

    $usuario = new Usuario();
    $usuario->id = $data->u_id;
    $usuario->nome = $data->u_nome;
    $usuario->email = $data->u_email;
    $usuario->senha = $data->u_senha;
    $usuario->telefone = $data->u_telefone;
    $usuario->tipo = $data->u_tipo;

    $localizacao = new Local();
    $localizacao->id = $data->l_id;
    $localizacao->latitude = $data->l_latitude;
    $localizacao->longitude = $data->l_longitude;

    $model = new Prestador();
    $model->id = $data->id;
    $model->documento = $data->documento;
    $model->id_usuario = $data->id_usuario;
    $model->usuario = $usuario;
    $model->localizacao = $localizacao;
    
    return $model;
  }

  public function select(): array
  {
    $sql = "
    SELECT 
      p.id, 
      p.id_usuario,
      p.documento,
      u.id AS u_id, 
      u.nome AS u_nome, 
      u.email AS u_email, 
      u.senha AS u_senha,
      u.telefone as u_telefone,   
      u.tipo as u_tipo,   
      l.id AS l_id, 
      l.latitude AS l_latitude, 
      l.longitude AS l_longitude
    FROM prestador p
    JOIN usuario u ON u.id = p.id_usuario
    LEFT JOIN localizacao l ON l.id = p.id_localizacao
  ";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->execute();
    $resultados = $stmt->fetchAll(DAO::FETCH_ASSOC);
    $prestadores = [];

    foreach ($resultados as $data) {
      $usuario = new Usuario();
      $usuario->id = $data['u_id'];
      $usuario->nome = $data['u_nome'];
      $usuario->email = $data['u_email'];
      $usuario->senha = $data['u_senha'];
      $usuario->telefone = $data['u_telefone'];
      $usuario->tipo = $data['u_tipo'];

      $model = new Prestador();
      $model->id = $data['id'];
      $model->documento = $data['documento'];
      $model->id_usuario = $data['id_usuario'];
      $model->usuario = $usuario;

      if ($data['l_id'] !== null) {
        $localizacao = new Local();
        $localizacao->id = $data['l_id'];
        $localizacao->latitude = $data['l_latitude'];
        $localizacao->longitude = $data['l_longitude'];
        $model->localizacao = $localizacao;
      } else {
        $model->localizacao = null;
      }

      $prestadores[] = $model;
    }


    return $prestadores;
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM prestador WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    return $stmt->execute();
  }
}
