<?php

namespace AutoCare\Controller;

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

  final protected static function isProtected(?array $tiposBloqueados = null, ?array $tiposPermitidos = null)
  {
    if (!isset($_SESSION["usuario"])) {
      header("Location: login");
      exit;
    }

    $usuario = $_SESSION["usuario"];
    $tipoUsuario = strtolower($usuario->tipo);

    // Prioridade para lista de permitidos, se fornecida
    if ($tiposPermitidos !== null) {
      $tiposPermitidos = array_map('strtolower', $tiposPermitidos);
      if (!in_array($tipoUsuario, $tiposPermitidos)) {
        header("Location: /" . BASE_DIR_NAME . "/home");
        exit;
      }
      return;
    }

    // Verifica lista de bloqueados, se fornecida
    if ($tiposBloqueados !== null) {
      $tiposBloqueados = array_map('strtolower', $tiposBloqueados);
      if (in_array($tipoUsuario, $tiposBloqueados)) {
        header("Location: /" . BASE_DIR_NAME . "/home");
        exit;
      }
    }
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
