<?php
class Veiculo {
    private $conn;
    private $table = "veiculo";

    public $id, $ano, $apelido, $id_usuario, $id_modelo;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $sql = "INSERT INTO $this->table (ano, apelido, id_usuario, id_modelo)
                VALUES (:ano, :apelido, :id_usuario, :id_modelo)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ano', $this->ano);
        $stmt->bindParam(':apelido', $this->apelido);
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->bindParam(':id_modelo', $this->id_modelo);
        
        return $stmt->execute();
    }

    public function read() {
        $sql = "SELECT * FROM $this->table";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update() {
        $sql = "UPDATE $this->table 
                SET ano=:ano, apelido=:apelido, id_usuario=:id_usuario, id_modelo=:id_modelo 
                WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ano', $this->ano);
        $stmt->bindParam(':apelido', $this->apelido);
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->bindParam(':id_modelo', $this->id_modelo);
        return $stmt->execute();
    }

    public function delete() {
        $sql = "DELETE FROM $this->table WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
