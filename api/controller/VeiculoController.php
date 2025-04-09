<?php
require_once __DIR__ . '/../model/Veiculo.php';
require_once __DIR__ . '/../config/database.php';

class VeiculoController {
    private $veiculo;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->veiculo = new veiculo($db);
    }

    public function create($data) {
        $this->veiculo->ano = $data['ano'];
        $this->veiculo->apelido = $data['apelido'];
        $this->veiculo->id_usuario = $data['id_usuario'];
        $this->veiculo->id_modelo = $data['id_modelo'];
        return $this->veiculo->create();
    }

    public function read() {
        return $this->veiculo->read();
    }

    public function update($data) {
        $this->veiculo->id = $data['id'];
        $this->veiculo->ano = $data['ano'];
        $this->veiculo->apelido = $data['apelido'];
        $this->veiculo->id_usuario = $data['id_usuario'];
        $this->veiculo->id_modelo = $data['id_modelo'];
        return $this->veiculo->update();
    }

    public function delete($id) {
        $this->veiculo->id = $id;
        return $this->veiculo->delete();
    }
}
