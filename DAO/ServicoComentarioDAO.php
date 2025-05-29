<?php

namespace AutoCare\DAO;

use AutoCare\Model\ServicoAvaliacao;
use AutoCare\Model\ServicoComentario;
use Exception;

final class ServicoComentarioDAO extends DAO
{
  public function __construct()
  {
    parent::__construct();
  }

  private function parseRow($data)
  {
    $model = new ServicoComentario();
    $model->id = $data["c_id"];
    $model->id_servico = $data["c_id_servico"];

    $model->texto = $data["c_texto"];
    $model->data = $data["c_data"];

    $avaliacao = new ServicoAvaliacao();
    $avaliacao->id = $data["a_id"];
    $avaliacao->id_servico = $data["a_id_servico"];
    $avaliacao->nota = (int) $data["a_nota"];

    $model->avaliacao = $avaliacao;

    return $model;
  }

  public function selectById(int $id): ?ServicoComentario
  {
    $sql = "SELECT
    c.id c_id, c.id_servico c_id_servico, c.texto c_texto, c.data c_data,
    a.id a_id, a.id_servico a_id_servico, a.nota a_nota
    FROM comentario c
    JOIN avaliacao a ON c.id_servico =  a.id_servico
    WHERE c.id=?;";

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
    c.id c_id, c.id_servico c_id_servico, c.texto c_texto, c.data c_data,
    a.id a_id, a.id_servico a_id_servico, a.nota a_nota
    FROM comentario c
    JOIN avaliacao a ON c.id_servico = a.id_servico
    JOIN servico s ON s.id = c.id_servico
    JOIN prestador p ON p.id = s.id_prestador
    WHERE p.id=?;";

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
    c.id c_id, c.id_servico c_id_servico, c.texto c_texto, c.data c_data,
    a.id a_id, a.id_servico a_id_servico, a.nota a_nota
    FROM comentario c
    JOIN avaliacao a ON c.id_servico =  a.id_servico";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->execute();

    $resultados = $stmt->fetchAll(DAO::FETCH_ASSOC);
    $linhas = [];

    foreach ($resultados as $linha) {
      $linhas[] = $this->parseRow($linha);
    }

    return $linhas;
  }

  public function deleteAdmin(int $id): bool
  {
    try {
      parent::$conexao->beginTransaction();

      $sql_select = "SELECT
      c.id, c.id_servico,
      s.id s_id
      FROM comentario c
      JOIN servico s ON c.id_servico = s.id
      WHERE c.id = ?";
      $stmt = parent::$conexao->prepare($sql_select);
      $stmt->bindValue(1, $id);
      $stmt->execute();
      $select_data = $stmt->fetch(DAO::FETCH_ASSOC);

      if (is_array($select_data)) {
        $id_servico = $select_data["s_id"];

        $sql_delete_comentario = "DELETE FROM comentario WHERE id_servico = ?";
        $stmt = parent::$conexao->prepare($sql_delete_comentario);
        $stmt->bindValue(1, $id_servico);
        $comentarioDeletado = $stmt->execute();

        $sql_delete_avaliacao = "DELETE FROM avaliacao WHERE id_servico = ?";
        $stmt = parent::$conexao->prepare($sql_delete_avaliacao);
        $stmt->bindValue(1, $id_servico);
        $avaliacaoDeletada = $stmt->execute();

        parent::$conexao->commit();
        return $comentarioDeletado && $avaliacaoDeletada;
      }

      return false;
    } catch (Exception $e) {
      parent::$conexao->rollBack();
      throw $e;
    }
  }

  public function delete(int $id, int $id_usuario): bool
  {
    try {
      $sql_select = "SELECT
      c.id, c.id_servico,
      s.id s_id, s.id_usuario s_id_usuario
      FROM comentario c
      JOIN servico c ON c.id_servico = s.id
      WHERE c.id = ?
      AND s.id_usuario = ?";
      $stmt = parent::$conexao->prepare($sql_select);
      $stmt->bindValue(1, $id);
      $stmt->bindValue(2, $id_usuario);
      $stmt->execute();
      $select_data = $stmt->fetch(DAO::FETCH_ASSOC);

      if (is_array($select_data)) {
        $id_servico = $select_data["s_id"];

        parent::$conexao->beginTransaction();

        $sql_delete_comentario = "DELETE FROM comentario WHERE id_servico = ?";
        $stmt = parent::$conexao->prepare($sql_delete_comentario);
        $stmt->bindValue(1, $id_servico);
        $comentarioDeletado = $stmt->execute();

        $sql_delete_avaliacao = "DELETE FROM avaliacao WHERE id_servico = ?";
        $stmt = parent::$conexao->prepare($sql_delete_avaliacao);
        $stmt->bindValue(1, $id_servico);
        $avaliacaoDeletada = $stmt->execute();

        parent::$conexao->commit();
        return $comentarioDeletado && $avaliacaoDeletada;
      }

      return false;
    } catch (Exception $e) {
      parent::$conexao->rollBack();
      throw $e;
    }
  }
}
