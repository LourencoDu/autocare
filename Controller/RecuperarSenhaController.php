<?php

namespace AutoCare\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use AutoCare\Model\Usuario;

require_once __DIR__ . '/../phpmailer/PHPMailer.php';
require_once __DIR__ . '/../phpmailer/SMTP.php';
require_once __DIR__ . '/../phpmailer/Exception.php';

final class RecuperarSenhaController extends Controller
{
  public function index(): void
  {
    $this->view = "Login/recuperarSenha.php";
    $this->titulo = "Recuperar Senha";

    $this->render();
  }

  public function recuperarSenha(): void
  {
    $email = $_POST['email'];
    $token_hash = hash("sha256", bin2hex(random_bytes(16)));

    $model = new Usuario();

    if ($model->recuperarSenha($email, $token_hash)) {
      $link = "http://localhost/autocare/novaSenha?token=" . $token_hash . "&email=" . urlencode($email);

      $mail = new PHPMailer(true);

      try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'c7769144@gmail.com';
        $mail->Password = 'uilg uqzt pmvj lwmk';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('c7769144@gmail.com', 'AutoCare');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Recuperação de Senha - AutoCare';
        $mail->Body = "
                <h1>Recuperação de Senha</h1>
                <p>Olá, recebemos uma solicitação para redefinir sua senha.</p>
                <p><a href='{$link}'>Clique aqui para redefinir sua senha</a></p>
                <p>Se você não solicitou isso, ignore este e-mail.</p>
            ";
        $mail->AltBody = "Acesse este link para redefinir sua senha: {$link}";

        $mail->send();
        $this->view = "Login/enviarEmailRecuperacao.php";
        $this->titulo = "Enviar Email";

        $this->render();
      } catch (Exception $e) {
        echo "O e-mail não pôde ser enviado. Erro: {$mail->ErrorInfo}";
      }
    };
  }

  public function novaSenha(): void
  {
    $token = $_GET['token'] ?? '';
    $email = $_GET['email'] ?? '';


    $this->view = "Login/novaSenha.php";
    $this->js = "login/script.js";
    $this->titulo = "Nova Senha";

    $this->render(compact('token', 'email'));
  }

  public function salvarNovaSenha(): void
  {
    $email = $_POST['email'];
    $token = $_POST['token'];

    $model = new Usuario();

    if ($model->validarToken($email, $token)) {
      $novaSenha = $_POST['senha'];
      $model->atualizarSenha($email, $novaSenha);
      Header("Location: /" . BASE_DIR_NAME . "/login");
    } else {
      echo "Token inválido ou expirado";
    }
  }
}
