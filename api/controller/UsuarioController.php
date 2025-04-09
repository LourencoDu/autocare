<?php
require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../config/database.php';

class UsuarioController {
    private $usuario;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->usuario = new Usuario($db);
    }

    public function create($data) {
        $this->usuario->nome = $data['nome'];
        $this->usuario->sobrenome = $data['sobrenome'];
        $this->usuario->email = $data['email'];
        $this->usuario->telefone = $data['telefone'];
        $this->usuario->senha = password_hash($data['senha'], PASSWORD_DEFAULT);
        return $this->usuario->create();
    }

    public function read() {
        return $this->usuario->read();
    }

    public function update($data) {
        $this->usuario->id = $data['id'];
        $this->usuario->nome = $data['nome'];
        $this->usuario->sobrenome = $data['sobrenome'];
        $this->usuario->email = $data['email'];
        $this->usuario->telefone = $data['telefone'];
        $this->usuario->senha = password_hash($data['senha'], PASSWORD_DEFAULT);
        return $this->usuario->update();
    }

    public function delete($id) {
        $this->usuario->id = $id;
        return $this->usuario->delete();
    }

    public function login($data) {
        $this->usuario->email = $data['email'];

        $usuario = $this->usuario->getByEmail();

        if(isset($usuario)) {
            $senha = $data['senha'];            

            if(password_verify($senha, $usuario["senha"])) {
                return true;
            }
        }       
        
        return false;
    }
}
