<?php

namespace AutoCare\Controller;

use AutoCare\Helper\JsonResponse;
use AutoCare\Model\FabricanteVeiculo;
use AutoCare\Model\ModeloVeiculo;
use AutoCare\Model\Servico;
use AutoCare\Model\Veiculo;

final class UsuarioServicoController extends Controller
{
  public function index(): void
  {
    parent::isProtected(["prestador", "funcionario"]);

    $this->view = "Usuario/Servicos/index.php";
    $this->js = "Usuario/Servicos/script.js";
    $this->titulo = "Serviços";

    $this->render();
  }

  private function backToIndex(): void
  {
    parent::redirect("servico");
  }

  public function listar(): void
  {
    parent::isProtected(["prestador", "funcionario"]);

    $id_veiculo = $_GET["id_veiculo"] ?? null;
    $usuario = $_SESSION["usuario"];
    $id_usuario = $usuario->id;

    if (isset($id_usuario)) {
        $servicos = array();

        $servico_model = new Servico();
        $servicos = $servico_model->getAllRowsByIdUsuario($id_usuario);

        $this->data["servicos"] = $servicos;

        $this->index();
    } else {
      parent::redirect("");
    }
  }

}
