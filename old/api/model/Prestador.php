<?php
class Prestador {
    private $conn;
    private $table = "prestador";

    public $id, $nome, $apelido, $endereco_cep, $endereco_numero;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $sql = "INSERT INTO $this->table (nome, apelido, endereco_cep, endereco_numero)
                VALUES (:nome, :apelido, :endereco_cep, :endereco_numero)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':apelido', $this->apelido);
        $stmt->bindParam(':endereco_cep', $this->endereco_cep);
        $stmt->bindParam(':endereco_numero', $this->endereco_numero);

        return $stmt->execute();
    }

    public function getById() {
        $sql = "SELECT * FROM $this->table WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        return $stmt->fetch_assoc();
    }

    public function getByEndereco() {
        $sql = "SELECT * FROM $this->table WHERE endereco_cep = :endereco_cep";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':endereco_cep', $this->endereco_cep);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function read() {
        $sql = "SELECT * FROM $this->table";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update() {
        $sql = "UPDATE $this->table 
                SET nome=:nome, apelido=:apelido, endereco_cep=:endereco_cep, endereco_numero=:endereco_numero
                WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':apelido', $this->apelido);
        $stmt->bindParam(':endereco_cep', $this->endereco_cep);
        $stmt->bindParam(':endereco_numero', $this->endereco_numero);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function delete() {
        $sql = "DELETE FROM $this->table WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
