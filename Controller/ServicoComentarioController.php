<?php

namespace AutoCare\Controller;

use AutoCare\Helper\JsonResponse;
use AutoCare\Model\ServicoComentario;

final class ServicoComentarioController extends Controller
{
  public function listar($id_prestador): array
  {
    parent::isProtected();

    $model = new ServicoComentario();

    return $model->getAllRowsByIdPrestador($id_prestador);
  }

  public function deletar(): void
  {
    parent::isProtectedApi(null, ["administrador"]);

    $id_comentario = isset($_POST["id_comentario"]) ? $_POST["id_comentario"] : null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $response = null;
      try {
        ServicoComentario::delete((int) $id_comentario);

        $response = JsonResponse::sucesso("Comentário deletada com sucesso!");
      } catch (\Throwable $th) {
        $response = JsonResponse::erro("Falha ao deletar comentário!");
      }

      $response->enviar();
    }
  }
}
