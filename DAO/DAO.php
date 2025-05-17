<?php

namespace AutoCare\DAO;

use PDO;

abstract class DAO extends PDO
{
  protected static $conexao = null;

  public function __construct()
  {
    self::criarConexao();
  }

  private static function criarConexao()
  {
    $host = $_ENV["db"]["host"];
    $dbname = $_ENV["db"]["database"];
    $username = $_ENV["db"]["user"];
    $password = $_ENV["db"]["pass"];

    $dsn = "mysql:host=$host;dbname=$dbname";

    if (self::$conexao == null) {
      self::$conexao = new PDO(
        $dsn,
        $username,
        $password,
        [
          PDO::ATTR_PERSISTENT => true,
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
      );
    }
  }

  public static function getConexao()
  {
    if (self::$conexao === null) {
      self::criarConexao();
    }
    return self::$conexao;
  }
}
