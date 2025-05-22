<?php

namespace AutoCare\Controller;

use AutoCare\Helper\JsonResponse;
use AutoCare\Model\Servico;

final class ServicoController extends Controller
{
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Servico/index.php";
    $this->titulo = "Serviços";

    $this->caminho = [];

    $this->render();
  }

  private function backToIndex(): void
  {
    parent::redirect("servico");
  }

  public function listar(): void
  {
    parent::isProtected();

    $model = new Servico();

    $usuario = $_SESSION["usuario"];
    $tipo = $usuario->tipo;
    $servicos = array();

    if ($tipo == "prestador" || $tipo == "funcionario") {
      $prestador = $usuario->prestador;
      $servicos = $model->getAllRowsByIdPrestador($prestador->id);
    } else {
      $servicos = $model->getAllRows();
    }

    $this->data["servicos"] = $servicos;

    $this->js = "Servico/script.js";

    $this->index();
  }

  public function listarTabela(): void
  {
    parent::isProtected();

    $model = new Servico();

    $usuario = $_SESSION["usuario"];
    $prestador = $usuario->prestador;

    $servicos = $model->getAllRowsByIdPrestador($prestador->id);

    $this->data["servicos"] = $servicos;

    $config = [
      "data" => $this->data
    ];

    extract($config);
    require_once VIEWS . "/Servico/index.php";
  }

  public function cadastrar(): void
  {
    parent::isProtected();

    $descricao = isset($_POST["descricao"]) ? $_POST["descricao"] : null;
    $data_inicio = isset($_POST["data_inicio"]) ? $_POST["data_inicio"] : null;
    $data_fim = isset($_POST["data_fim"]) ? $_POST["data_fim"] : null;
    $id_usuario = isset($_POST["id_usuario"]) ? $_POST["id_usuario"] : null;
    $id_veiculo = isset($_POST["id_veiculo"]) ? $_POST["id_veiculo"] : null;
    $id_especialidade = isset($_POST["id_especialidade"]) ? $_POST["id_especialidade"] : null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      if ($descricao && $data_inicio && $id_usuario && $id_veiculo && $id_especialidade) {
        $usuario = $_SESSION["usuario"];
        $prestador = $usuario->prestador;

        $id_prestador = $prestador->id;

        $response = null;
        try {
          $model = new Servico();

          $model->descricao = $descricao;
          $model->data_inicio = $data_inicio;
          $model->data_fim = $data_fim;
          $model->id_usuario = $id_usuario;
          $model->id_veiculo = $id_veiculo;
          $model->id_especialidade = $id_especialidade;
          $model->id_prestador = $id_prestador;

          $model->save();

          $response = JsonResponse::sucesso("Serviço cadastrada com sucesso!");
        } catch (\Throwable $th) {
          $response = JsonResponse::erro("Falha ao cadastrar serviço!", [$th->getMessage()]);
        }
      } else {
        $response = JsonResponse::erro("Preencha todos os campos!");
      }



      $response->enviar();
    }
  }

  public function alterar(): void
  {
    parent::isProtected();

    $id = isset($_POST["id"]) ? $_POST["id"] : null;
    $descricao = isset($_POST["descricao"]) ? $_POST["descricao"] : null;
    $data_inicio = isset($_POST["data_inicio"]) ? $_POST["data_inicio"] : null;
    $data_fim = isset($_POST["data_fim"]) ? $_POST["data_fim"] : null;
    $id_usuario = isset($_POST["id_usuario"]) ? $_POST["id_usuario"] : null;
    $id_veiculo = isset($_POST["id_veiculo"]) ? $_POST["id_veiculo"] : null;
    $id_especialidade = isset($_POST["id_especialidade"]) ? $_POST["id_especialidade"] : null;

    if ($id && $data_inicio && $id_usuario && $id_veiculo && $id_especialidade) {
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $response = null;
        try {
          $model = new Servico();

          $model->getById((int) $id);
          if ($model) {
            $model->descricao = $descricao;
            $model->data_inicio = $data_inicio;
            $model->data_fim = $data_fim;
            $model->id_usuario = $id_usuario;
            $model->id_veiculo = $id_veiculo;
            $model->id_especialidade = $id_especialidade;

            $model->save();
            $response = JsonResponse::sucesso("Serviço cadastrada com sucesso!");
          } else {
            $response = JsonResponse::erro("Serviço não encontrado!");
          }
        } catch (\Throwable $th) {
          $response = JsonResponse::erro("Falha ao cadastrar serviço!", [$th->getMessage()]);
        }
      } else {
        $response = JsonResponse::erro("Preencha todos os campos!");
      }

      $response->enviar();
    }
  }

  public function deletar(): void
  {
    parent::isProtected();

    $id = isset($_POST["id"]) ? $_POST["id"] : null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $response = null;
      try {
        Servico::delete((int) $id);

        $response = JsonResponse::sucesso("Serviço deletada com sucesso!");
      } catch (\Throwable $th) {
        $response = JsonResponse::erro("Falha ao deletar serviço!", [$th->getMessage()]);
      }

      $response->enviar();
    }
  }
}
