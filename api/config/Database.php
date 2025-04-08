<?php
class Database {
    private $host = "localhost";
    private $db_name = "autocare";
    private $username = "root";
    private $password = "";
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name",
                                  $this->username, $this->password);
            $this->conn->exec("set names utf8");
            echo "conectou";
        } catch(PDOException $exception) {
            echo "Erro de conexão: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
