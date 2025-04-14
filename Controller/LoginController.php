<?php

namespace AutoCare\Controller;

use AutoCare\Model\Login;

final class LoginController extends Controller
{
  public function index(): void
  {
    $this->view = "Login/index.php";
    $this->css = "Login/style.css";
    $this->titulo = "Login";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->logar();
    }

    $this->render();
  }

  public function logar(): void
  {
    $model = new Login();
    $model->email = $_POST['email'] ?? '';
    $model->senha = $_POST['senha'] ?? '';
    $logado = $model->logar($model);

    if ($logado != null) {
      $_SESSION['usuario'] = $logado;
      $this->data = [];
      header("Location: home");
    } else {
      $this->data['erro'] = "E-mail ou senha inválidos.";
      $this->data['form'] = ["email" => $model->email, "senha" => $model->senha];
    }
  }

  public static function logout() : void {
      session_destroy();
  }
}
