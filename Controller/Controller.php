<?php

namespace AutoCare\Controller;

abstract class Controller {
  protected $view, $css, $titulo, $data;

  public function render() {
    $config = [
      "view" => $this->view,
      "css" => $this->css,
      "titulo" => $this->titulo,
      "data" => $this->data,
    ];
    extract($config);
    require_once VIEWS.'/Layout/index.php';
  }
}