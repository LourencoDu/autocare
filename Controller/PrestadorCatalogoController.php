<?php

namespace AutoCare\Controller;

use AutoCare\Helper\JsonResponse;
use AutoCare\Model\Especialidade;
use AutoCare\Model\FabricanteVeiculo;
use AutoCare\Model\PrestadorCatalogo;

final class PrestadorCatalogoController extends Controller
{
  private function backToIndex(): void
  {
    Header("Location: /" . BASE_DIR_NAME . "/meu-perfil");
  }

  public function listar($id_prestador): array
  {
    parent::isProtected();

    $model = new PrestadorCatalogo();

    return $model->getAllRowsByIdPrestador($id_prestador);
  }

  public function cadastrar(): void
  {
    parent::isProtected(["usuario"]);

    $this->view = "PrestadorCatalogo/form.php";
    $this->js = "PrestadorCatalogo/form.js";
    $this->titulo = "Novo Serviço";


    $this->caminho = [
      new CaminhoItem("Meu Perfil", "meu-perfil"),
      new CaminhoItem("Catálogo de Serviço", "meu-perfil")
    ];

    $this->data = [
      "especialidades" => Especialidade::getAllRows()
    ];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $usuario = $_SESSION["usuario"];
      $id_prestador = $usuario->prestador->id;
      
      try {
        $model = new PrestadorCatalogo();

        $model->titulo = $_POST["titulo"];
        $model->descricao = $_POST["descricao"];
        $model->id_especialidade = $_POST["id_especialidade"];
        $model->id_prestador = $id_prestador;

        $this->data["form"] = [
          "titulo" => $model->titulo,
          "descricao" => $model->descricao,
          "id_especialidade" => $model->id_especialidade
        ];

        $model->save();

        $this->backToIndex();
      } catch (\Throwable $th) {
        $this->data = array_merge($this->data, [
          "erro" => "Falha ao adicionar registro. Erro: " . $th->getMessage(),
          "exception" => $th->getMessage()
        ]);
      }
    }

    $this->render();
  }

  public function alterar(): void
  {
    parent::isProtected(["usuario"]);

    $this->view = "PrestadorCatalogo/form.php";
    $this->js = "PrestadorCatalogo/form.js";

    $model = new PrestadorCatalogo();
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    $usuario = $_SESSION["usuario"];
    $id_prestador = $usuario->prestador->id;

    if ($id != null) {
      $model = $model->getById((int) $id);

      if ($model != null && $model->id_prestador == $id_prestador) {
        $this->titulo = 'Alterar "' . $model->titulo . '"';

        $this->caminho = [
          new CaminhoItem("Meu Perfil", "meu-perfil"),
          new CaminhoItem("Catálogo de Serviço", "meu-perfil")
        ];

        $this->data = [
          "especialidades" => Especialidade::getAllRows(),
          "action" => "alterar"
        ];

        $this->data["form"] = [
          "titulo" => $model->titulo,
          "descricao" => $model->descricao,
          "id_especialidade" => $model->id_especialidade
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
          try {
            $model->titulo = $_POST["titulo"];
            $model->descricao = $_POST["descricao"];
            $model->id_especialidade = $_POST["id_especialidade"];


            $model->save();

            $this->backToIndex();
          } catch (\Throwable $th) {
            $this->data = array_merge($this->data, [
              "erro" => "Falha ao alterar registro. Erro: " . $th->getMessage(),
              "exception" => $th->getMessage()
            ]);
          }
        }

        $this->render();
      } else {
        $this->backToIndex();
      }
    } else {
      $this->backToIndex();
    }
  }

  public function deletar(): void
  {
    parent::isProtected(["usuario"]);

    $id_especialidade = isset($_POST["id_especialidade"]) ? $_POST["id_especialidade"] : null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $response = null;
      try {
        PrestadorCatalogo::deleteByIdEspecialidade((int) $id_especialidade);

        $response = JsonResponse::sucesso("Especialidade deletada com sucesso!");
      } catch (\Throwable $th) {
        $response = JsonResponse::erro("Falha ao deletar especialidade!");
      }

      $response->enviar();
    }
  }
}
