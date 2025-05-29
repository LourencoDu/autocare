<?php

namespace AutoCare\Controller;

use AutoCare\Helper\JsonResponse;
use AutoCare\Model\Servico;
use DateTime;

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
    parent::isProtected(["usuario"]);

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
    parent::isProtected(["usuario"]);

    $model = new Servico();

    $usuario = $_SESSION["usuario"];
    $tipo = $usuario->tipo;

    if ($tipo == "prestador" || $tipo == "funcionario") {
      $prestador = $usuario->prestador;
      $servicos = $model->getAllRowsByIdPrestador($prestador->id);
    } else {
      $servicos = $model->getAllRows();
    }

    $this->data["servicos"] = $servicos;

    $config = [
      "data" => $this->data
    ];

    extract($config);
    require_once VIEWS . "/Servico/index.php";
  }

  public static function getServicoBadgeByIdVeiculo(int $id_veiculo): void
  {
    parent::isProtected();

    $model = new Servico();
    $servicos = $model->getAllRowsByIdVeiculoOnDataFimIsNull($id_veiculo);

    $quantidadeAgendamentos = 0;
    $emServico = false;
    $data_hoje = new DateTime(); // agora

    $classes = "flex items-center h-6 px-2 border rounded-md text-xs font-medium";

    foreach ($servicos as $servico) {
      if((int) $servico->id_status_padrao == 3) {
        $emServico = true;
      }

      if ((int) $servico->id_status_padrao == 1) {
        $quantidadeAgendamentos += 1;
      }
    }

    if ($emServico) {
      echo "<span class='" . $classes . " bg-green-200 border-green-300 text-green-700'>Em serviço</span>";
    } else if ($quantidadeAgendamentos > 0) {
      $label = $quantidadeAgendamentos . " " . ($quantidadeAgendamentos == 1 ? "serviço agendado" : "serviços agendados");
      echo "<span class='" . $classes . " bg-yellow-200 border-yellow-300 text-yellow-700'>" . $label . "</span>";
    } else {
      echo "<span class='" . $classes . " bg-gray-200 border-gray-300 text-gray-700'>Disponível</span>";
    }
  }

  public function cadastrar(): void
  {
    parent::isProtected(["usuario", "administrador"]);

    $descricao = isset($_POST["descricao"]) ? $_POST["descricao"] : null;
    $data_inicio = isset($_POST["data_inicio"]) ? $_POST["data_inicio"] : null;

    $data_fim = isset($_POST["data_fim"]) ? $_POST["data_fim"] : null;
    if ($data_fim == "null") $data_fim = null;

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
          $model->id_status_padrao = 1;

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
    parent::isProtected(["usuario", "administrador"]);

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

          $model = $model->getById((int) $id);
          if ($model->id) {
            $model->descricao = $descricao;
            $model->data_inicio = $data_inicio;
            $model->data_fim = $data_fim;
            $model->id_usuario = $id_usuario;
            $model->id_veiculo = $id_veiculo;
            $model->id_especialidade = $id_especialidade;

            $model->save();
            $response = JsonResponse::sucesso("Serviço alterado com sucesso!");
          } else {
            $response = JsonResponse::erro("Serviço não encontrado!", [$model, $id]);
          }
        } catch (\Throwable $th) {
          $response = JsonResponse::erro("Falha ao alterar serviço!", [$th->getMessage()]);
        }
      } else {
        $response = JsonResponse::erro("Preencha todos os campos!");
      }

      $response->enviar();
    }
  }

  public function deletar(): void
  {
    parent::isProtected(["usuario"]);

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

  public function alterarStatus(): void
  {
    parent::isProtected(["usuario", "administrador"]);

    $id = $_GET["id"] ?? null;
    $id_status_padrao = $_GET["id_status_padrao"] ?? null;

    $arrDados = [];
    array_push($arrDados, $id);
    array_push($arrDados, $id_status_padrao);

    $model = new Servico();
    $model->updateStatus($id, $id_status_padrao);

    $response = JsonResponse::sucesso("enviando dado", $_GET);
    $response->enviar();
  }

  public function avaliarServico(): void
  {
    parent::isProtected(["administrador", "funcionario", "prestador"]);

    $id_servico = $_POST['id'] ?? null;
    $nota = $_POST["avaliacao"] ?? null;
    $comentario = $_POST["comentario"] ?? null;

    $arrDados = [];
    array_push($arrDados, $id_servico);
    array_push($arrDados, $nota);
    array_push($arrDados, $comentario);

    $model = new Servico();
    $model->avaliarServico($id_servico, $nota, $comentario);

    $response = JsonResponse::sucesso("enviando dado", $arrDados);
    $response->enviar();
    return;
  }
}
