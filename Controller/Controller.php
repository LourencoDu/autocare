<?php

namespace AutoCare\Controller;

abstract class Controller {
  protected $view, $css, $js, $titulo, $data;

  public function render() {
    $config = [
      "view" => $this->view,
      "css" => $this->css,
      "js" => $this->js,
      "titulo" => $this->titulo,
      "data" => $this->data,
    ];
    extract($config);
    require_once VIEWS.'/Layout/index.php';    
  }

  protected static function isProtected() {
    if(!isset($_SESSION["usuario"]))
      header("Location: login");
  }
}