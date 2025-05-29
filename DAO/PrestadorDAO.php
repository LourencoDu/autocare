<?php

namespace AutoCare\DAO;

use AutoCare\Model\Prestador;
use AutoCare\Model\Usuario;
use AutoCare\Model\Local;
use AutoCare\Model\PrestadorContato;

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
    $sql = "INSERT INTO prestador (documento, id_usuario, id_localizacao) VALUES (?, ?, ?);";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->documento);
    $stmt->bindValue(2, $model->id_usuario);
    $stmt->bindValue(3, $model->localizacao?->id); // null-safe in case it's not set

    $stmt->execute();

    $model->id = parent::$conexao->lastInsertId();

    return $model;
  }


  private function update(Prestador $model): Prestador
  {
    $sql = "UPDATE prestador SET documento=?, id_localizacao=? WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->documento);
    $stmt->bindValue(2, $model->localizacao?->id);
    $stmt->bindValue(3, $model->id);

    $stmt->execute();

    return $model;
  }


  public function selectById(int $id)
  {
    $sql = "SELECT 
      p.id, 
      p.documento,
      p.id_usuario,
      p.id_localizacao,
      p.id_prestador_contato,
      u.id AS u_id,
      u.nome AS u_nome, 
      u.email AS u_email, 
      u.senha AS u_senha,
      u.telefone as u_telefone,   
      u.tipo as u_tipo,   
      l.id AS l_id, 
      l.latitude AS l_latitude, 
      l.longitude AS l_longitude,
      pc.id AS pc_id,
      pc.whatsapp AS pc_whatsapp,
      pc.telefone AS pc_telefone,
      pc.email AS pc_email,
      (
      SELECT AVG(a.nota)
      FROM avaliacao a
      JOIN servico s ON a.id_servico = s.id
      WHERE s.id_prestador = p.id
      ) AS p_nota
    FROM prestador p
    JOIN usuario u ON u.id = p.id_usuario
    LEFT JOIN prestador_contato pc ON p.id_prestador_contato = pc.id
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

    $model = new Prestador();
    $model->id = $data->id;
    $model->documento = $data->documento;
    $model->id_usuario = $data->id_usuario;
    $model->usuario = $usuario;
    $model->nota = $data->p_nota != null ? number_format($data->p_nota, 2) : null;

    if ($data->pc_id != null) {
      $prestador_contato = new PrestadorContato();
      $prestador_contato->id = $data->pc_id;
      $prestador_contato->whatsapp = $data->pc_whatsapp;
      $prestador_contato->telefone = $data->pc_telefone;
      $prestador_contato->email = $data->pc_email;
      $model->prestador_contato = $prestador_contato;
    } else {
      $model->prestador_contato = null;
    }

    if ($data->l_id != null) {
      $localizacao = new Local();
      $localizacao->id = $data->l_id;
      $localizacao->latitude = $data->l_latitude;
      $localizacao->longitude = $data->l_longitude;
      $model->localizacao = $localizacao;
    } else {
      $model->localizacao = null;
    }

    return $model;
  }

  public function select(): array
  {
    $sql = "SELECT 
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
      l.longitude AS l_longitude,
      pc.id AS pc_id,
      pc.whatsapp AS pc_whatsapp,
      pc.telefone AS pc_telefone,
      pc.email AS pc_email,
            (
      SELECT AVG(a.nota)
      FROM avaliacao a
      JOIN servico s ON a.id_servico = s.id
      WHERE s.id_prestador = p.id
      ) AS p_nota
    FROM prestador p
    JOIN usuario u ON u.id = p.id_usuario
    LEFT JOIN prestador_contato pc ON p.id_prestador_contato = pc.id
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
      $nota = $data["p_nota"] ?? null;
      $model->nota = $nota != null ? number_format($nota, 2) : null;


      if ($data['pc_id'] !== null) {
        $prestador_contato = new PrestadorContato();
        $prestador_contato->id = ['pc_id'];
        $prestador_contato->whatsapp = ['pc_whatsapp'];
        $prestador_contato->telefone = ['pc_telefone'];
        $prestador_contato->email = ['pc_email'];
        $model->prestador_contato = $prestador_contato;
      } else {
        $model->prestador_contato = null;
      }

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
