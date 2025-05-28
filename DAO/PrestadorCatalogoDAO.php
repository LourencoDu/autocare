<?php

namespace AutoCare\DAO;

use AutoCare\Model\Especialidade;
use AutoCare\Model\PrestadorCatalogo;
use Exception;

final class PrestadorCatalogoDAO extends DAO
{
  public function __construct()
  {
    parent::__construct();
  }

  private function parseRow($data)
  {
    $model = new PrestadorCatalogo();
    $model->id = $data["pc_id"];
    $model->id_prestador = $data["pc_id_prestador"];
    $model->id_especialidade = $data["pc_id_especialidade"];

    $model->titulo = $data["pc_titulo"];
    $model->descricao = $data["pc_descricao"];

    $especialidade = new Especialidade();
    $especialidade->id = $data["e_id"];
    $especialidade->nome = $data["e_nome"];

    $model->especialidade = $especialidade;

    return $model;
  }

  public function selectById(int $id): ?PrestadorCatalogo
  {
    $sql = "SELECT
    pc.id pc_id, pc.id_prestador pc_id_prestador, pc.id_especialidade pc_id_especialidade,
    pc.titulo pc_titulo, pc.descricao pc_descricao,
    e.id e_id, e.nome e_nome
    FROM prestador_catalogo pc
    JOIN especialidade e ON e.id = pc.id_especialidade
    WHERE pc.id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    $data = $stmt->fetch(DAO::FETCH_ASSOC);

    if (is_array($data)) {
      return $this->parseRow($data);
    }

    return null;
  }

  public function selectByIdPrestador(int $id_prestador): array
  {
    $sql = "SELECT
    pc.id pc_id, pc.id_prestador pc_id_prestador, pc.id_especialidade pc_id_especialidade,
    pc.titulo pc_titulo, pc.descricao pc_descricao,
    e.id e_id, e.nome e_nome
    FROM prestador_catalogo pc
    JOIN especialidade e ON e.id = pc.id_especialidade
    WHERE pc.id_prestador=?;";

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

  public function select(): array
  {
    $sql = "SELECT
    pc.id pc_id, pc.id_prestador pc_id_prestador, pc.id_especialidade pc_id_especialidade,
    pc.titulo pc_titulo, pc.descricao pc_descricao,
    e.id e_id, e.nome e_nome
    FROM prestador_catalogo pc
    JOIN especialidade e ON e.id = pc.id_especialidade";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->execute();

    $resultados = $stmt->fetchAll(DAO::FETCH_ASSOC);
    $linhas = [];

    foreach ($resultados as $linha) {
      $linhas[] = $this->parseRow($linha);
    }

    return $linhas;
  }

  public function save(PrestadorCatalogo $model): PrestadorCatalogo
  {
    return ($model->id == null) ? $this->insert($model) : $this->update($model);
  }

  private function insert(PrestadorCatalogo $model): PrestadorCatalogo
  {
      $sql = "INSERT INTO prestador_catalogo (titulo, descricao, id_especialidade, id_prestador) VALUES (?, ?, ?, ?);";
      $stmt_especialidade = parent::$conexao->prepare($sql);
      $stmt_especialidade->bindValue(1, $model->titulo);
      $stmt_especialidade->bindValue(2, $model->descricao);
      $stmt_especialidade->bindValue(3, $model->id_especialidade);
      $stmt_especialidade->bindValue(4, $model->id_prestador);
      $stmt_especialidade->execute();

      return $model;
  }


  private function update(PrestadorCatalogo $model): PrestadorCatalogo
  {
    $sql = "UPDATE prestador_catalogo SET
    titulo=?,
    descricao=?,
    id_especialidade=?
    WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->titulo);
    $stmt->bindValue(2, $model->descricao);
    $stmt->bindValue(3, $model->id_especialidade);
    $stmt->bindValue(4, $model->id);
    $stmt->execute();

    return $model;
  }

  public function deleteByIdEspecialidade(int $id_especialidade): bool
  {
    try {
      $sql = "DELETE FROM prestador_catalogo WHERE id=?;";
      $stmt = parent::$conexao->prepare($sql);
      $stmt->bindValue(1, $id_especialidade);

      return $stmt->execute();
    } catch (Exception $e) {
      parent::$conexao->rollBack();
      throw $e; // Repassa a exceção para tratamento externo
    }
  }

public function selectByEspecialidade(int $id_especialidade): array
{
    $sql = "
      SELECT
        pc.id           AS pc_id,
        pc.id_prestador AS pc_id_prestador,
        pc.id_especialidade AS pc_id_especialidade,
        pc.titulo       AS pc_titulo,
        pc.descricao    AS pc_descricao,
        e.id            AS e_id,
        e.nome          AS e_nome
      FROM prestador_catalogo pc
      JOIN especialidade e ON e.id = pc.id_especialidade
      WHERE pc.id_especialidade = ?
    ";
    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id_especialidade, \PDO::PARAM_INT);
    $stmt->execute();

    $rows = $stmt->fetchAll(DAO::FETCH_ASSOC);
    return array_map(fn($r) => $this->parseRow($r), $rows);
}
}
