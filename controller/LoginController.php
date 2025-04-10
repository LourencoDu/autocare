<?php
class LoginController extends Controller {
    public function index() {
      ob_start();
      require_once 'view/login.php';
      $content = ob_get_clean();
      $this->config = ['name' => 'login', 'title' => 'Login', 'content' => $content];
      $this->render();
    }

    public function autenticar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $user = $this->model('User');
            $usuario = $user->findByEmail($email);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                session_start();
                $_SESSION['usuario'] = $usuario['nome'];
                header('Location: /home/index');
            } else {
                $this->config['erro'] = "Email ou senha inválidos.";
                $this->render();
            }
        }
    }

    public function sair() {
        session_start();
        session_destroy();
        header('Location: /login/index');
    }
}
