<?php
class Veiculo {
    private $conn;
    private $table = "veiculo";

    public $id, $nome, $sobrenome, $email, $telefone, $senha;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $sql = "INSERT INTO $this->table (nome, sobrenome, email, telefone, senha)
                VALUES (:nome, :sobrenome, :email, :telefone, :senha)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':sobrenome', $this->sobrenome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':senha', $this->senha);
        return $stmt->execute();
    }

    public function read() {
        $sql = "SELECT * FROM $this->table";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update() {
        $sql = "UPDATE $this->table 
                SET nome=:nome, sobrenome=:sobrenome, email=:email, telefone=:telefone, senha=:senha 
                WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':sobrenome', $this->sobrenome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':senha', $this->senha);
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
