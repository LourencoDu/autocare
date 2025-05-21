<?php

namespace AutoCare\Controller;

use AutoCare\Helper\JsonResponse;
use AutoCare\Model\Especialidade;

final class EspecialidadeController extends Controller {
  public function index(): void
  {
    parent::isProtected(["prestador", "funcionario", "usuario"]);

    $this->view = "Especialidade/index.php";
    $this->titulo = "Especialidades";
    $this->render();
  }

  private function backToIndex(): void {
    parent::redirect("especialidade");
  }

  public function listar(): void
  {
    parent::isProtected(["prestador", "funcionario", "usuario"]);

    $model = new Especialidade();

    $especialidades = $model->getAllRows();
    $this->data["especialidades"] = $especialidades;

    $this->js = "Especialidade/script.js";

    $this->index();
  }

  public function deletar(): void
  {
    parent::isProtected(["prestador", "funcionario", "usuario"]);

    $id = isset($_POST["id"]) ? $_POST["id"] : null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $response = null;
      try {           
        Especialidade::delete((int) $id);

        $response = JsonResponse::sucesso("Especialidade deletada com sucesso!");
      } catch (\Throwable $th) {
        $response = JsonResponse::erro("Falha ao deletar especialidade!");
      }

      $response->enviar();
    }
  }
}