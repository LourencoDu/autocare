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
    $sql = "SELECT c.id, c.id_usuario, c.id_prestador, u.nome,
    GREATEST(
        COALESCE(cmu.data_envio, '0000-00-00 00:00:00'),
        COALESCE(cmf.data_envio, '0000-00-00 00:00:00')
    ) AS ultima_data,
    COALESCE(cmu.visualizado, 1) as visualizado FROM chat c
    LEFT JOIN (
      SELECT id_chat, MAX(data) AS data_envio, visualizado
      FROM chat_mensagem_usuario
      GROUP BY id_chat
    ) AS cmu ON c.id = cmu.id_chat
    LEFT JOIN (
      SELECT m1.id_chat, m1.data AS data_envio
      FROM chat_mensagem_funcionario m1
        INNER JOIN (
          SELECT id_chat, MAX(data) AS max_data FROM chat_mensagem_funcionario
          GROUP BY id_chat
    ) m2 ON m1.id_chat = m2.id_chat AND m1.data = m2.max_data) AS cmf ON c.id = cmf.id_chat
    LEFT JOIN usuario u ON c.id_usuario = u.id
    WHERE c.id_prestador = ?
    ORDER BY ultima_data DESC";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $idPrestador);
    $stmt->execute();

    return $stmt->fetchAll(DAO::FETCH_CLASS, "AutoCare\Model\Chat");
  }

  public function selectByIdUsuario(int $idUsuario): array
  {
    $sql = "SELECT c.id, c.id_usuario, c.id_prestador, u.nome,
    GREATEST(
        COALESCE(cmu.data_envio, '0000-00-00 00:00:00'),
        COALESCE(cmf.data_envio, '0000-00-00 00:00:00')
    ) AS ultima_data,
    COALESCE(cmf.visualizado, 1) as visualizado FROM chat c
    LEFT JOIN (
      SELECT id_chat, MAX(data) AS data_envio
      FROM chat_mensagem_usuario
      GROUP BY id_chat
    ) AS cmu ON c.id = cmu.id_chat
    LEFT JOIN (
      SELECT m1.id_chat, m1.data AS data_envio,m1.visualizado
      FROM chat_mensagem_funcionario m1
        INNER JOIN (
          SELECT id_chat, MAX(data) AS max_data FROM chat_mensagem_funcionario
          GROUP BY id_chat
    ) m2 ON m1.id_chat = m2.id_chat AND m1.data = m2.max_data) AS cmf ON c.id = cmf.id_chat
    LEFT JOIN autocare.prestador p ON c.id_prestador = p.id
    LEFT JOIN usuario u ON p.id_usuario = u.id
    WHERE c.id_usuario = ?
    ORDER BY ultima_data DESC";

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

  public function criaNovaConversa(int $idUsuario, int $idPrestador): int
  {
    $sql = "insert into chat (id_usuario, id_prestador)
            values (?, ?);";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $idUsuario);
    $stmt->bindValue(2, $idPrestador);

    $stmt->execute();

    return (int)parent::$conexao->lastInsertId();
  }

  public function getChatbyIDs(int $idUsuario, int $idPrestador): int
  {
    $sql = "SELECT id FROM chat WHERE id_usuario = ? and id_prestador = ?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $idUsuario);
    $stmt->bindValue(2, $idPrestador);
    $stmt->execute();

    $id = $stmt->fetchColumn();

    return (int) $id;
  }
}
