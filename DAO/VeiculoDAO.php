<?php

namespace AutoCare\DAO;

use AutoCare\Model\Veiculo;
use PDO;

final class VeiculoDAO extends DAO {
  public function __construct()
  {
    parent::__construct();
  }

  public function save(Veiculo $model) : Veiculo
  {
    return ($model->id == null) ? $this->insert($model) : $this->update($model);
  }

  private function insert(Veiculo $model) : Veiculo
  {
    $sql = "INSERT INTO veiculo (ano, apelido, id_usuario, id_modelo_veiculo) VALUES (?, ?, ?, ?);";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->ano);
    $stmt->bindValue(2, $model->apelido);
    $stmt->bindValue(3, $_SESSION["usuario"]->id);
    $stmt->bindValue(4, $model->id_modelo_veiculo);
    $stmt->execute();

    $model->id = parent::$conexao->lastInsertId();

    return $model;
  }

  private function update(Veiculo $model) : Veiculo
  {
    $sql = "UPDATE veiculo SET ano=?, apelido=?, id_modelo_veiculo=? WHERE id=? AND id_usuario = ?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->ano);
    $stmt->bindValue(2, $model->apelido);
    $stmt->bindValue(3, $model->id_modelo_veiculo);
    $stmt->bindValue(4, $model->id);
    $stmt->bindValue(5, $_SESSION["usuario"]->id);
    $stmt->execute();

    return $model;
  }

  public function selectById(int $id) : ?Veiculo
  {
    $sql = "SELECT * FROM veiculo WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    $model = $stmt->fetchObject("AutoCare\Model\Veiculo");

    return is_object($model) ? $model : null;
  }

  public function select(): array
  {
    $sql = "SELECT * FROM veiculo;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(DAO::FETCH_CLASS, "AutoCare\Model\Veiculo");
  }

  public function selectByUser(int $id_usuario): array
  {
    $sql = "SELECT v.id id, v.apelido apelido, v.ano ano, mv.nome as modelo, fv.nome as fabricante FROM veiculo as v JOIN modelo_veiculo as mv ON mv.id = v.id_modelo_veiculo JOIN fabricante_veiculo as fv ON fv.id = mv.id_fabricante_veiculo WHERE id_usuario = ?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id_usuario);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $lista = array();

    foreach ($data as $key => $row) {
      $model = new \AutoCare\Model\Veiculo();

      $model->id = $row["id"]; 
      $model->apelido = $row["apelido"];
      $model->ano = $row["ano"];
      $model->modelo = $row["modelo"];
      $model->fabricante = $row["fabricante"];

      array_push($lista, $model);
    }

    return $lista;
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM veiculo WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    return $stmt->execute();
  }
}