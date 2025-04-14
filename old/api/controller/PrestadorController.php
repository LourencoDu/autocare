<?php
require_once __DIR__ . '/../model/Prestador.php';
require_once __DIR__ . '/../config/database.php';

class PrestadoController {
    private $prestado;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->prestado = new prestado($db);
    }

    public function create($data) {
        $this->prestado->nome = $data['nome'];
        $this->prestado->apelido = $data['apelido'];
        $this->prestado->endereco_cep = $data['endereco_cep'];
        $this->prestado->endereco_numero = $data['endereco_numero'];
        return $this->prestado->create();
    }

    public function read() {
        return $this->prestado->read();
    }

    public function update($data) {
        $this->prestado->id = $data['id'];
        $this->prestado->ano = $data['ano'];
        $this->prestado->apelido = $data['apelido'];
        $this->prestado->endereco_cep = $data['endereco_cep'];
        $this->prestado->endereco_numero = $data['endereco_numero'];
        return $this->prestado->update();
    }

    public function delete($id) {
        $this->prestado->id = $id;
        return $this->prestado->delete();
    }
}
