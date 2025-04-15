<?php

namespace AutoCare\Controller;

final class CadastroController extends Controller
{
  public function index(): void
  {
    $this->view = "Cadastro/index.php";
    $this->css = "Cadastro/style.css";
    $this->titulo = "Cadastro";
    $this->render();
  }
}