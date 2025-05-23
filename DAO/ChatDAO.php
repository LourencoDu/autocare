<?php

namespace AutoCare\DAO;

use AutoCare\Model\Chat;

final class ChatDAO extends DAO
{
  public function __construct()
  {
    parent::__construct();
  }

  public function selectById(int $id): ?Chat
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
    $sql = "SELECT id_prestador FROM funcionario WHERE id_usuario = ?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $idUsuario);
    $stmt->execute();

    $id = $stmt->fetchColumn();

    return (int) $id;
  }

  public function selectByIdPrestador(int $idPrestador): array
  {
    $sql = "SELECT c.id, c.id_usuario, c.id_prestador, u.nome 
            FROM autocare.chat as c
            left join autocare.usuario as u
            on c.id_usuario = u.id
            where id_prestador = ?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $idPrestador);
    $stmt->execute();

    return $stmt->fetchAll(DAO::FETCH_CLASS, "AutoCare\Model\Chat");
  }

  public function selectByIdUsuario(int $idUsuario): array
  {
    $sql = "SELECT c.id, c.id_usuario, c.id_prestador, u.nome 
              FROM autocare.chat as c
              left join autocare.prestador as p
              on c.id_prestador = p.id
              left join autocare.usuario as u
              on p.id_usuario = u.id
              where c.id_usuario = ?;";

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

  public function incluirMensagem($chatID, $mensagem, $id_funcionario = null): void
  {
    if ($_SESSION['usuario']->tipo == 'usuario') {
      $sql = "INSERT INTO chat_mensagem_usuario (id_chat, texto, data, visualizado, id_usuario) VALUES (?, ?, ?, ?, ?);";
    } else {
      $sql = "INSERT INTO chat_mensagem_funcionario (id_chat, texto, data, visualizado, id_funcionario) VALUES (?, ?, ?, ?, ?);";
    }

    date_default_timezone_set('America/Sao_Paulo');
    $dataHoraAtual = date('Y-m-d H:i:s');

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $chatID);
    $stmt->bindValue(2, $mensagem);
    $stmt->bindValue(3, $dataHoraAtual);
    $stmt->bindValue(4, 0);

    $_SESSION['usuario']->tipo == 'usuario' ? $stmt->bindValue(5, $_SESSION['usuario']->id) : $stmt->bindValue(5, $id_funcionario);

    $stmt->execute();

    return;
  }

  public function visualizarMensagensChat(int $idChat): void
  {
    if ($_SESSION['usuario']->tipo == 'usuario') {
      $sql = "update chat_mensagem_funcionario
              set visualizado = 1
              where id_chat = ?;";
    } else {
      $sql = "update chat_mensagem_usuario
              set visualizado = 1
              where id_chat = ?;";
    }

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $idChat);

    $stmt->execute();

    return;
  }
}
