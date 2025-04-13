<?php
class LoginController extends Controller {
    public function handle() {
        $acao = $_GET['acao'] ?? '';
    
        if ($acao === 'autenticar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->autenticar();
        } else {
            $this->index();
        }
    }

    public function index() {
        $this->config = [
            'name' => 'usuario/login',
            'title' => 'Login',
            'erro' => $this->config['erro'] ?? null,
            'form' => $this->config['form'] ?? null
        ];

        $this->render();
    }

    public function autenticar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            $user = $this->model('Usuario');
            $usuario = $user->findByEmail($email);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                session_start();
                $_SESSION['usuario'] = $usuario;
                header('Location: /home');
                exit;
            } else {
                $this->config['erro'] = "E-mail ou senha inválidos.";
                $this->config['form'] = [ "email" => $email, "senha" => $senha ];
                $this->index(); // renderiza o login novamente com erro
            }
        }
    }
}
