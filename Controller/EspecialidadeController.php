<?php

namespace AutoCare\Controller;

use AutoCare\Helper\JsonResponse;
use AutoCare\Model\Especialidade;

final class EspecialidadeController extends Controller
{
  public function index(): void
  {
    parent::isProtected(null, ["administrador"]);

    $this->view = "Especialidade/index.php";
    $this->titulo = "Especialidades";

    $this->caminho = [
      new CaminhoItem("Administração", "")
    ];

    $this->render();
  }

  private function backToIndex(): void
  {
    parent::redirect("especialidade");
  }

  public function listar(): void
  {
    parent::isProtected(null, ["administrador"]);

    $model = new Especialidade();

    $especialidades = $model->getAllRows();
    $this->data["especialidades"] = $especialidades;

    $this->js = "Especialidade/script.js";

    $this->index();
  }

  public function listarJson(): void
  {
    parent::isProtectedApi();

    $model = new Especialidade();
    
    try {
      $lista = $model->getAllRows();

      $response = JsonResponse::sucesso("Registros carregados com sucesso.", $lista);
    } catch (\Throwable $th) {
      $response = JsonResponse::erro("Falha ao carregar registros.", [$th->getMessage()]);
    }

    $response->enviar();
  }

  public function listarTabela(): void
  {
    parent::isProtected(null, ["administrador"]);

    $model = new Especialidade();
    $especialidades = $model->getAllRows();

    $this->data["especialidades"] = $especialidades;

    $config = [
      "data" => $this->data
    ];

    extract($config);
    require_once VIEWS . "/Especialidade/index.php";
  }

  public function cadastrar(): void
  {
    parent::isProtected(null, ["administrador"]);

    $nome = isset($_POST["nome"]) ? $_POST["nome"] : null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $response = null;
      try {
        $model = new Especialidade();
        $model->nome = $nome;

        $model->save();

        $response = JsonResponse::sucesso("Especialidade cadastrada com sucesso!");
      } catch (\Throwable $th) {
        $response = JsonResponse::erro("Falha ao cadastrar especialidade!");
      }

      $response->enviar();
    }
  }

  public function alterar(): void
  {
    parent::isProtected(null, ["administrador"]);

    $id = isset($_POST["id"]) ? $_POST["id"] : null;
    $nome = isset($_POST["nome"]) ? $_POST["nome"] : null;

    if ($id && $nome) {
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $response = null;
        try {
          $model = new Especialidade();
          $model->id = $id;
          $model->nome = $nome;

          $model->save();

          $response = JsonResponse::sucesso("Especialidade cadastrada com sucesso!");
        } catch (\Throwable $th) {
          $response = JsonResponse::erro("Falha ao cadastrar especialidade!");
        }
      } else {
        $response = JsonResponse::erro("Preencha todos os campos!");
      }

      $response->enviar();
    }
  }

  public function deletar(): void
  {
    parent::isProtected(null, ["administrador"]);

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
