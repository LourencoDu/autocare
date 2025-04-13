<?php
class Usuario extends Model {
    private $table = "usuario";

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail($email) {
      $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE email = :email");
      $stmt->bindParam(':email', $email);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($usuario) {
        $sql = "INSERT INTO $this->table (nome, sobrenome, email, telefone, senha)
                VALUES (:nome, :sobrenome, :email, :telefone, :senha)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $usuario->nome);
        $stmt->bindParam(':sobrenome', $usuario->sobrenome);
        $stmt->bindParam(':email', $usuario->email);
        $stmt->bindParam(':telefone', $usuario->telefone);
        $stmt->bindParam(':senha', $usuario->senha);
        return $stmt->execute();
    }

        public function update($usuario) {
        $sql = "UPDATE $this->table 
                SET nome=:nome, sobrenome=:sobrenome, email=:email, telefone=:telefone, senha=:senha 
                WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $usuario->nome);
        $stmt->bindParam(':sobrenome', $usuario->sobrenome);
        $stmt->bindParam(':email', $usuario->email);
        $stmt->bindParam(':telefone', $usuario->telefone);
        $stmt->bindParam(':senha', $usuario->senha);
        $stmt->bindParam(':id', $usuario->id);
        return $stmt->execute();
    }

    public function delete($usuario) {
        $sql = "DELETE FROM $this->table WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $usuario->id);
        return $stmt->execute();
    }
}