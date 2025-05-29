<?php

namespace AutoCare\Controller;

use AutoCare\Model\Prestador;

final class PrestadorController extends Controller
{
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Prestador/lista/index.php";
    $this->js = "Prestador/lista/script.js";
    $this->titulo = "Prestadores";
    $this->render();
  }

  public function listar(): void
  {
    parent::isProtected();

    $model = new Prestador();

    $lista = $model->getAllRows();
    $this->data["lista"] = $lista;

    $this->index();
  }

  public function ver(): void
  {
    parent::isProtected();

    $id = $_GET["id"];

    if (!isset($id)) {
      $this->backToIndex();
      return;
    }

    $model = new Prestador();
    $prestador = $model->getById((int) $id);

    if (!isset($prestador)) {
      $this->backToIndex();
      return;
    }

    $this->view = "Prestador/ver/index.php";
    $this->js = "Prestador/ver/script.js";
    $this->titulo = $prestador->usuario->nome;

    $this->caminho = [
      new CaminhoItem("Prestadores", "prestador")
    ];

    $this->data["prestador"] = $prestador;

    $this->render();
  }

  private function backToIndex(): void
  {
    Header("Location: /" . BASE_DIR_NAME . "/prestador");
  }
}
