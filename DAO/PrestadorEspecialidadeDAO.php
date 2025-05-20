<?php

namespace AutoCare\DAO;

use AutoCare\Model\PrestadorEspecialidade;
use AutoCare\Model\Especialidade;
use Exception;

final class PrestadorEspecialidadeDAO extends DAO
{
  public function __construct()
  {
    parent::__construct();
  }

  private function parseRow($data)
  {
    $model = new PrestadorEspecialidade();
    $model->id = $data["pe_id"];
    $model->id_prestador = $data["pe_id_prestador"];
    $model->id_especialidade = $data["pe_id_especialidade"];

    $especialidade = new Especialidade();
    $especialidade->id = $data["e_id"];
    $especialidade->titulo = $data["e_titulo"];
    $especialidade->descricao = $data["e_descricao"];
    $especialidade->id_fabricante_veiculo = $data["e_id_fabricante"] ?? null;

    $model->especialidade = $especialidade;

    return $model;
  }

  public function selectById(int $id): ?PrestadorEspecialidade
  {
    $sql = "SELECT
    pe.id pe_id, pe.id_prestador pe_id_prestador, pe.id_especialidade pe_id_especialidade,
    e.id e_id, e.titulo e_titulo, e.descricao e_descricao, e.id_fabricante e_id_fabricante
    FROM prestador_especialidade pe
    JOIN especialidade e ON e.id = pe.id_especialidade
    WHERE pe.id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    $data = $stmt->fetchObject();

    if (is_object($data)) {
      return $this->parseRow($data);
    }

    return null;
  }

  public function selectByIdPrestador(int $id_prestador): array
  {
    $sql = "SELECT
    pe.id pe_id, pe.id_prestador pe_id_prestador, pe.id_especialidade pe_id_especialidade,
    e.id e_id, e.titulo e_titulo, e.descricao e_descricao, e.id_fabricante_veiculo e_id_fabricante_veiculo
    FROM prestador_especialidade pe
    JOIN especialidade e ON e.id = pe.id_especialidade
    WHERE pe.id_prestador=?;";

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
    pe.id pe_id, pe.id_prestador pe_id_prestador, pe.id_especialidade pe_id_especialidade,
    e.id e_id, e.titulo e_titulo, e.descricao e_descricao, e.id_fabricante_veiculo e_id_fabricante_veiculo
    FROM prestador_especialidade pe
    JOIN especialidade e ON e.id = pe.id_especialidade";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->execute();

    $resultados = $stmt->fetchAll(DAO::FETCH_ASSOC);
    $linhas = [];

    foreach ($resultados as $linha) {
      $linhas[] = $this->parseRow($linha);
    }

    return $linhas;
  }

  public function save(PrestadorEspecialidade $model): PrestadorEspecialidade
  {
    return ($model->id == null) ? $this->insert($model) : $this->update($model);
  }

  private function insert(PrestadorEspecialidade $model): PrestadorEspecialidade
  {
    try {
      // Inicia a transação
      parent::$conexao->beginTransaction();

      $sql_especialidade = "INSERT INTO especialidade (titulo, descricao, id_fabricante_veiculo) VALUES (?, ?, ?);";
      $especialidade = $model->especialidade;

      $stmt_especialidade = parent::$conexao->prepare($sql_especialidade);
      $stmt_especialidade->bindValue(1, $especialidade->titulo);
      $stmt_especialidade->bindValue(2, $especialidade->descricao);
      $stmt_especialidade->bindValue(3, $especialidade->id_fabricante_veiculo ?? null);
      $stmt_especialidade->execute();

      $especialidade->id = parent::$conexao->lastInsertId();
      $model->id_especialidade = $especialidade->id;

      $sql = "INSERT INTO prestador_especialidade (id_prestador, id_especialidade) VALUES (?, ?);";
      $stmt = parent::$conexao->prepare($sql);
      $stmt->bindValue(1, $model->id_prestador);
      $stmt->bindValue(2, $model->id_especialidade);
      $stmt->execute();

      $model->id = parent::$conexao->lastInsertId();

      // Confirma a transação
      parent::$conexao->commit();

      return $model;
    } catch (Exception $e) {
      // Em caso de erro, desfaz a transação
      parent::$conexao->rollBack();
      throw $e; // Repassa a exceção para tratamento externo
    }
  }


  private function update(PrestadorEspecialidade $model): PrestadorEspecialidade
  {
    $sql = "UPDATE especialidade SET
    titulo=?,
    descricao=?,
    id_fabricante_veiculo=?
    WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->especialidade->titulo);
    $stmt->bindValue(2, $model->especialidade->descricao);
    $stmt->bindValue(3, $model->especialidade->id_fabricante_veiculo);
    $stmt->bindValue(4, $model->especialidade->id);
    $stmt->execute();

    return $model;
  }

  public function delete(int $id_prestador_especialidade, int $id_especialidade): bool
  {
    try {
      parent::$conexao->beginTransaction();

      $sql = "DELETE FROM prestador_especialidade WHERE id=?;";
      $stmt = parent::$conexao->prepare($sql);
      $stmt->bindValue(1, $id_prestador_especialidade);
      $stmt->execute();

      $sql_especialidade = "DELETE FROM especialidade WHERE id=?;";
      $stmt_especialidade = parent::$conexao->prepare($sql_especialidade);
      $stmt_especialidade->bindValue(1, $id_especialidade);
      $stmt_especialidade->execute();

      return parent::$conexao->commit();
    } catch (Exception $e) {
      parent::$conexao->rollBack();
      throw $e; // Repassa a exceção para tratamento externo
    }
  }
}
