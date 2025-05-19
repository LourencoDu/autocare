<?php

namespace AutoCare\Controller;

use AutoCare\Model\Prestador;

final class MeuPerfilController extends Controller
{
  public function index(): void
  {
    parent::isProtected();

    $this->view = "MeuPerfil/index.php";
    $this->js = "MeuPerfil/script.js";
    $this->titulo = "Meu Perfil";
    $this->render();
  }

  private function backToIndex(): void
  {
    Header("Location: /" . BASE_DIR_NAME . "/meu-perfil");
  }
}
