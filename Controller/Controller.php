<?php

namespace AutoCare\Controller;

use AutoCare\Helper\JsonResponse;

class CaminhoItem
{
  public string $texto, $rota;

  public function __construct(string $texto, string $rota)
  {
    $this->texto = $texto;
    $this->rota = $rota;
  }
}

abstract class Controller
{
  protected $view, $css, $js, $titulo, $data;

  /**
   * @var CaminhoItem[]
   */
  protected ?array $caminho = array();

  public function render()
  {
    $config = [
      "view" => $this->view,
      "css" => $this->css,
      "js" => $this->js,
      "titulo" => $this->titulo,
      "caminho" => $this->caminho,
      "data" => $this->data,
    ];
    extract($config);
    require_once VIEWS . '/Layout/index.php';
  }

  final protected static function isProtected(?array $tiposBloqueados = null, ?array $tiposPermitidos = null, ?bool $json = false)
  {
    if (!isset($_SESSION["usuario"])) {
      if ($json == true) {
        $response = JsonResponse::erro("Para acessar esse recurso é necessário estar logado.", [], 401);
        $response->enviar();
      } else {
        header("Location: login");
      }
      exit;
    }

    $usuario = $_SESSION["usuario"];
    $tipoUsuario = strtolower($usuario->tipo);

    // Prioridade para lista de permitidos, se fornecida
    if ($tiposPermitidos !== null) {
      $tiposPermitidos = array_map('strtolower', $tiposPermitidos);
      if (!in_array($tipoUsuario, $tiposPermitidos)) {
        if ($json == true) {
          $response = JsonResponse::erro("Você não tem permissão para acessar esse recurso.", [], 403);
          $response->enviar();
        } else {
          header("Location: /" . BASE_DIR_NAME . "/home");
        }
        exit;
      }
      return;
    }

    // Verifica lista de bloqueados, se fornecida
    if ($tiposBloqueados !== null) {
      $tiposBloqueados = array_map('strtolower', $tiposBloqueados);
      if (in_array($tipoUsuario, $tiposBloqueados)) {
        if ($json == true) {
          $response = JsonResponse::erro("Você não tem permissão para acessar esse recurso.", [], 403);
          $response->enviar();
        } else {
          header("Location: /" . BASE_DIR_NAME . "/home");
        }
        exit;
      }
    }
  }

  final protected static function isProtectedApi(?array $tiposBloqueados = null, ?array $tiposPermitidos = null) {
    Controller::isProtected($tiposBloqueados, $tiposPermitidos, true);
  }


  final protected static function isPost(): bool
  {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
  }

  final protected static function isGet(): bool
  {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
  }

  final protected static function redirect(string $route)
  {
    Header("Location: /" . BASE_DIR_NAME . "/" . $route);
  }
}
