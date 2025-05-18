<?php

namespace AutoCare\DAO;

use AutoCare\Model\Chat;

final class ChatDAO extends DAO {
  public function __construct()
  {
    parent::__construct();
  }

  public function selectById(int $id) : ? Chat
  {
    $sql = "SELECT * FROM chat WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    $model = $stmt->fetchObject("AutoCare\Model\Chat");

    return is_object($model) ? $model : null;
  }

  public function getPrestadorByIdUsuario(int $idUsuario): int
  {
    $sql = "SELECT id FROM prestador WHERE id_usuario = ?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $idUsuario);
    $stmt->execute();

    $model = $stmt->fetchObject("AutoCare\Model\Chat");
    
    return $model->id;
  }

  public function selectByIdPrestador(int $idPrestador): array
  {
    $sql = "SELECT * FROM chat WHERE id_prestador = ?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $idPrestador);
    $stmt->execute();

    return $stmt->fetchAll(DAO::FETCH_CLASS, "AutoCare\Model\Chat");
  }

  public function selectByIdUsuario(int $idUsuario): array
  {
    $sql = "SELECT * FROM chat WHERE id_usuario = ?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $idUsuario);
    $stmt->execute();

    return $stmt->fetchAll(DAO::FETCH_CLASS, "AutoCare\Model\Chat");
  }

  public function getMensagensByIdChat(int $idChat): array
  {
    $sql = "SELECT texto, data, visualizado,'funcionario' AS autor
              FROM chat_mensagem_funcionario
              WHERE id_chat = ?

              UNION ALL

            SELECT texto, data, visualizado, 'usuario' AS autor
              FROM chat_mensagem_usuario
              WHERE id_chat = ?

            ORDER BY data ASC;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $idChat);
    $stmt->bindValue(2, $idChat);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
}