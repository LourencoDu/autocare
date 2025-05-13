<?php

namespace AutoCare\Controller;

final class HomeController extends Controller
{
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Home/index.php";
    $this->css = "Home/style.css";
    $this->titulo = "Início";

    $this->caminho = null;

    $this->render();
  }
}
