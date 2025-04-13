<?php
class CadastroController extends Controller {
    public function handle() {
        $acao = $_GET['acao'] ?? '';
    
        if ($acao === 'cadastrar') {
            $this->cadastrar();
        } else {
            $this->index();
        }
    }

    public function index() {
        $this->config = [
            'name' => 'cadastro',
            'title' => 'Cadastro',
            'erro' => $this->config['erro'] ?? null,
            'css' => 'cadastro'
        ];

        $this->render();
    }

    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome = $_POST['nome'] ?? '';
            $sobrenome = $_POST['sobrenome'] ?? '';
            $telefone = $_POST['telefone'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $usuario = [
                "nome" => $nome,
                "sobrenome" => $sobrenome,
                "telefone" => $telefone,
                "email" => $email,
                "senha" => $senhaHash,
            ];

            $usuarioModel = $this->model('Usuario');
            $sucesso = $usuarioModel->create($usuario);
        }
    }
}
