<?php

namespace AutoCare\DAO;

use AutoCare\Model\Prestador;
use AutoCare\Model\Servico;

final class ServicoDAO extends DAO {
  public function __construct()
  {
    parent::__construct();
  }

  private function parseRow($data) : Servico {
    $model = new Servico();

    $model->id = $data["s_id"];
    $model->descricao = $data["s_descricao"];
    $model->data_inicio = $data["s_data_inicio"];
    $model->data_fim = $data["s_data_fim"];

    $model->id_usuario = $data["s_id_usuario"];
    $model->id_prestador = $data["s_id_prestador"];
    $model->id_veiculo = $data["s_id_veiculo"];
    $model->id_especialidade = $data["s_id_especialidade"];

    //Usuario
    $model_usuario = UsuarioDAO::parseRow($data, "u_");
    $model->usuario = $model_usuario;

    //Prestador
    $model_prestador = new Prestador();
    $model_prestador->id = $data["p_id"];
    $model_prestador->documento = $data["p_documento"];
    $model_prestador->usuario = UsuarioDAO::parseRow($data, "pu_");
    $model->prestador = $model_prestador;

    //Veiculo

    //Especialidade

    return $model;
  }

    public function selectById(int $id) : ?Servico
  {
    $sql = "SELECT 
    s.id s_id, s.descricao s_descricao, s.data_inicio s_data_inicio, s.data_fim s_data_fim,
    s.id_prestador s_id_prestador, s.id_usuario s_id_usuario, s.id_veiculo s_id_veiculo, s.id_especialidade s_id_especialidade,
    p.id p_id_prestador, p.documento p_documento,
    pu.id pu_id, pu.nome pu_nome,
    u.id u_id, u.nome u_nome, u.sobrenome u_sobrenome, u.email u_email, u.telefone u_telefone,
    v.id v_id, v.apelido v_apelido, v.ano v_ano, v.id_modelo_veiculo v_id_modelo_veiculo,
    mv.id mv_id, mv.nome mv_nome, mv.id_fabricante_veiculo,
    fv.id fv_id, fv.nome fv_nome,
    e.id e_id, e.nome e_nome
    FROM servico s
    JOIN prestador p ON p.id = s.id_prestador
    JOIN usuario pu ON p.id_usuario = pu.id
    JOIN usuario u ON u.id = s.id_usuario
    JOIN veiculo v ON v.id = s.id_veiculo
    JOIN modelo_veiculo mv ON mv.id = v.id_modelo_veiculo
    JOIN fabricante_veiculo fv ON fv.id = mv.id_fabricante_veiculo
    JOIN especialidade e ON e.id = s.id_especialidade
    WHERE s.id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    $data = $stmt->fetch(DAO::FETCH_ASSOC);

    if (is_array($data)) {
      return $this->parseRow($data);
    }

    return null;
  }

  public function select(): array
  {
    $sql = "SELECT 
    s.id s_id, s.descricao s_descricao, s.data_inicio s_data_inicio, s.data_fim s_data_fim,
    s.id_prestador s_id_prestador, s.id_usuario s_id_usuario, s.id_veiculo s_id_veiculo, s.id_especialidade s_id_especialidade,
    p.id p_id_prestador, p.documento p_documento,
    pu.id pu_id, pu.nome pu_nome,
    u.id u_id, u.nome u_nome, u.sobrenome u_sobrenome, u.email u_email, u.telefone u_telefone,
    v.id v_id, v.apelido v_apelido, v.ano v_ano, v.id_modelo_veiculo v_id_modelo_veiculo,
    mv.id mv_id, mv.nome mv_nome, mv.id_fabricante_veiculo,
    fv.id fv_id, fv.nome fv_nome,
    e.id e_id, e.nome e_nome
    FROM servico s
    JOIN prestador p ON p.id = s.id_prestador
    JOIN usuario pu ON p.id_usuario = pu.id
    JOIN usuario u ON u.id = s.id_usuario
    JOIN veiculo v ON v.id = s.id_veiculo
    JOIN modelo_veiculo mv ON mv.id = v.id_modelo_veiculo
    JOIN fabricante_veiculo fv ON fv.id = mv.id_fabricante_veiculo
    JOIN especialidade e ON e.id = s.id_especialidade;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->execute();

    $resultados = $stmt->fetchAll(DAO::FETCH_ASSOC);
    $linhas = [];

    foreach ($resultados as $linha) {
      $linhas[] = $this->parseRow($linha);
    }

    return $linhas;
  }

  public function selectByIdPrestador($id_prestador): array
  {
    $sql = "SELECT 
    s.id s_id, s.descricao s_descricao, s.data_inicio s_data_inicio, s.data_fim s_data_fim,
    s.id_prestador s_id_prestador, s.id_usuario s_id_usuario, s.id_veiculo s_id_veiculo, s.id_especialidade s_id_especialidade,
    p.id p_id_prestador, p.documento p_documento,
    pu.id pu_id, pu.nome pu_nome,
    u.id u_id, u.nome u_nome, u.sobrenome u_sobrenome, u.email u_email, u.telefone u_telefone,
    v.id v_id, v.apelido v_apelido, v.ano v_ano, v.id_modelo_veiculo v_id_modelo_veiculo,
    mv.id mv_id, mv.nome mv_nome, mv.id_fabricante_veiculo,
    fv.id fv_id, fv.nome fv_nome,
    e.id e_id, e.nome e_nome
    FROM servico s
    JOIN prestador p ON p.id = s.id_prestador
    JOIN usuario pu ON p.id_usuario = pu.id
    JOIN usuario u ON u.id = s.id_usuario
    JOIN veiculo v ON v.id = s.id_veiculo
    JOIN modelo_veiculo mv ON mv.id = v.id_modelo_veiculo
    JOIN fabricante_veiculo fv ON fv.id = mv.id_fabricante_veiculo
    JOIN especialidade e ON e.id = s.id_especialidade
    WHERE s.id_prestador = ?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id_prestador);
    $stmt->execute();

    $resultados = $stmt->fetchAll(DAO::FETCH_ASSOC);
    $linhas = [];

    foreach ($resultados as $linha) {
      $linhas[] = $this->parseRow($linha);
    }

    return $linhas;
  }

  public function save(Servico $model) : Servico
  {
    return ($model->id == null) ? $this->insert($model) : $this->update($model);
  }

  private function insert(Servico $model) : Servico
  {
    $sql = "INSERT INTO servico
    (descricao, data_inicio, data_fim, id_usuario, id_prestador, id_veiculo, id_especialidade)
    VALUES (?, ?, ?, ?, ?, ?, ?);";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->descricao);
    $stmt->bindValue(2, $model->data_inicio);
    $stmt->bindValue(3, $model->data_fim);
    $stmt->bindValue(4, $model->id_usuario);
    $stmt->bindValue(5, $model->id_prestador);
    $stmt->bindValue(6, $model->id_veiculo);
    $stmt->bindValue(7, $model->id_especialidade);
    $stmt->execute();

    $model->id = parent::$conexao->lastInsertId();

    return $model;
  }

  private function update(Servico $model) : Servico
  {
    $sql = "UPDATE servico SET descricao=?, `data_inicio`=?, `data_fim`=?, id_usuario=?,  id_veiculo=?, id_especialidade=? WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->descricao);
    $stmt->bindValue(2, $model->data_inicio);
    $stmt->bindValue(3, $model->data_fim);
    $stmt->bindValue(4, $model->id_usuario);
    $stmt->bindValue(5, $model->id_veiculo);
    $stmt->bindValue(6, $model->id_especialidade);
    $stmt->bindValue(7, $model->id);
    $stmt->execute();

    return $model;
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM servico WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    return $stmt->execute();
  }
}