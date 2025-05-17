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

    if (parent::isPost()) {
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
      $_SESSION['usuario']->nome_completo = $logado->nome." ".trim($logado->sobrenome);
      if($logado->tipo === "prestador") {
        $_SESSION['usuario']->nome_completo = $logado->nome;
        $_SESSION['usuario']->prestador = $logado->prestador;
      }

      $iconePorTipo = array(
        "prestador" => "fa-building",
        "usuario" => "fa-user",
        "funcionario" => "fa-user-gear",
        "administrador" => "fa-user-tie"
      );

      $_SESSION['usuario']->icone = $iconePorTipo[$logado->tipo];
      
      header("Location: home");
    } else {
      $this->data['erro'] = "E-mail ou senha inválidos.";
      $this->data['form'] = ["email" => $model->email, "senha" => $model->senha];
    }
  }

  public static function logout() : void {
      session_destroy();
      header("Location: login");
  }
}
