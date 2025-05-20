<?php

namespace AutoCare\Controller;

use AutoCare\Helper\JsonResponse;
use AutoCare\Model\Especialidade;
use AutoCare\Model\FabricanteVeiculo;
use AutoCare\Model\PrestadorEspecialidade;

final class PrestadorEspecialidadeController extends Controller {
  private function backToIndex(): void {
    Header("Location: /".BASE_DIR_NAME."/meu-perfil");
  }

  public function listar($id_prestador): array
  {
    parent::isProtected();

    $model = new PrestadorEspecialidade();

    return $model->getAllRowsByIdPrestador($id_prestador);
  }

  public function cadastrar(): void
  {
    parent::isProtected(["usuario"]);

    $this->view = "PrestadorEspecialidade/form.php";
    $this->js = "PrestadorEspecialidade/form.js";
    $this->titulo = "Nova Especialidade";


    $this->caminho = [
      new CaminhoItem("Meu Perfil", "meu-perfil")
    ];

    $this->data = [
      "fabricantes" => FabricanteVeiculo::getAllRows()
    ];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      try {
        $especialidade = new Especialidade();

        $especialidade->titulo = $_POST["titulo"];
        $especialidade->descricao = $_POST["descricao"];
        $especialidade->id_fabricante_veiculo = $_POST["id_fabricante_veiculo"] ? (int) $_POST["id_fabricante_veiculo"] : null;

        $model = new PrestadorEspecialidade();
        $model->especialidade = $especialidade;
        $model->id_prestador = $_SESSION["usuario"]->prestador->id;

        $this->data["form"] = [
          "titulo" => $especialidade->titulo,
          "descricao" => $especialidade->descricao,
          "id_fabricante_veiculo" => $especialidade->id_fabricante_veiculo
        ];

        $model->save();

        $this->backToIndex();
      } catch (\Throwable $th) {
        $this->data = array_merge($this->data, [
          "erro" => "Falha ao adicionar registro. Erro: ".$th->getMessage(),
          "exception" => $th->getMessage()
        ]);
      }
    }

    $this->render();
  }

  public function alterar(): void
  {
    parent::isProtected(["prestador", "funcionario"]);

    $this->view = "PrestadorEspecialidade/form.php";
    $this->js = "PrestadorEspecialidade/form.js";

    $model = new PrestadorEspecialidade();
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if($id != null) {
      $model = $model->getById((int) $id);

      if($model != null) {
        $modeloModel = ModeloPrestadorEspecialidade::getById($model->id_modelo_veiculo);
        $id_fabricante_veiculo = $modeloModel->id_fabricante_veiculo;

        $this->titulo = 'Alterar "'.$model->apelido.'"';

        $this->caminho = [
          new CaminhoItem("Meus Veículos", "veiculo"),
        ];

        $this->data = [
          "fabricantes" => FabricantePrestadorEspecialidade::getAllRows(),
          "modelos" => ModeloPrestadorEspecialidade::getRowsByIdFabricante($id_fabricante_veiculo),
          "action" => "alterar"
        ];

        $this->data["form"] = [
          "ano" => $model->ano,
          "apelido" => $model->apelido,
          "id_modelo_veiculo" => $model->id_modelo_veiculo,
          "id_fabricante_veiculo" => $id_fabricante_veiculo
        ];
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
          try {           
            $model->ano = $_POST["ano"];
            $model->apelido = $_POST["apelido"];
            $model->id_modelo_veiculo = $_POST["id_modelo_veiculo"];
    
            $model->save();
    
            $this->backToIndex();
          } catch (\Throwable $th) {
            $this->data = array_merge($this->data, [
              "erro" => "Falha ao alterar registro. Erro: ".$th->getMessage(),
              "exception" => $th->getMessage()
            ]);
          }
        }
    
        $this->render();
      }  else {
        $this->backToIndex();
      }    
    } else {
      $this->backToIndex();
    }
  }

  public function deletar(): void
  {
    parent::isProtected(["prestador", "funcionario"]);

    $id = isset($_POST["id"]) ? $_POST["id"] : null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $response = null;
      try {           
        PrestadorEspecialidade::delete((int) $id);

        $response = JsonResponse::sucesso("Veículo deletado com sucesso!");
      } catch (\Throwable $th) {
        $response = JsonResponse::erro("Falha ao deletar veículo!");
      }

      $response->enviar();
    }
  }
}