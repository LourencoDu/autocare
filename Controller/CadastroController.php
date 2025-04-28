<?php

namespace AutoCare\Controller;

use AutoCare\Model\Usuario;
use AutoCare\Model\Prestador;

final class CadastroController extends Controller
{
  public function index(): void
  {
    $this->view = "Cadastro/index.php";
    $this->css = "Cadastro/style.css";
    $this->js = "Cadastro/script.js";
    $this->titulo = "Cadastro";
    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $this->cadastrar();
    }
    $this->render();
  }

  private function cadastrar(): void
  {
    $tipoUsuario = $_POST["tipoUsuario"];

    if($tipoUsuario === "usuario") {
      $this->cadastrarUsuario();
    } else {
      $this->cadastrarPrestador();
    }
  }

  private function cadastrarUsuario(): void
  {
    $tipoUsuario = "usuario";

    $nome = $_POST["nome"];
    $sobrenome = $_POST["sobrenome"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    if(!$nome || !$sobrenome || !$telefone || !$email || !$senha) {
      $this->data['erro'] = "Preencha todos os campos obrigatórios (*).";
      $this->data['form'] = [
        "tipoUsuario" => $tipoUsuario,
        "nome" => $nome,
        "sobrenome" => $sobrenome,
        "telefone" => $telefone,
        "email" => $email,
        "senha" => $senha,
      ];
      return;
    }

    try {
      $model = new Usuario();

      $model->nome = $nome;
      $model->sobrenome = $sobrenome;
      $model->telefone = $telefone;
      $model->email = $email;
      $model->senha = $senha;

      $model->save();

      Header("Location: /".BASE_DIR_NAME."");
    } catch (\Throwable $th) {
      $this->data = array_merge($this->data ?? [], [
        "erro" => "Falha ao adicionar registro. Erro: ".$th->getMessage(),
        "exception" => $th->getMessage()
      ]);
    }
  }

  private function cadastrarPrestador(): void
  {
    $tipoUsuario = "prestador";

    $nome = $_POST["prestadorNome"];
    $sobrenome = $nome;
    $telefone = "";
    $email = $_POST["prestadorEmail"];
    $senha = $_POST["prestadorSenha"];

    $apelido = $_POST["prestadorApelido"];
    $cep = $_POST["prestadorCEP"];

    if(!$nome || !$email || !$senha || !$apelido || !$cep) {
      $this->data['erro'] = "Preencha todos os campos obrigatórios (*).";
      $this->data['form'] = [
        "tipoUsuario" => $tipoUsuario,
        "nome" => $nome,
        "sobrenome" => $sobrenome,
        "telefone" => $telefone,
        "email" => $email,
        "senha" => $senha,
      ];
      return;
    }

    try {
      $modelPrestador = new Prestador();

      $modelPrestador->nome = $nome;
      $modelPrestador->apelido = $apelido;

      $modelPrestador->endereco_cep = $cep;
      $modelPrestador->endereco_numero = "";

      $prestador = $modelPrestador->save();

      $model = new Usuario();

      $model->nome = $nome;
      $model->sobrenome = $sobrenome;
      $model->telefone = $telefone;
      $model->email = $email;
      $model->senha = $senha;
      $model->tipo = "prestador";
      $model->id_prestador = $prestador->id;

      $model->save();

      Header("Location: /".BASE_DIR_NAME."");
    } catch (\Throwable $th) {
      $this->data = array_merge($this->data ?? [], [
        "erro" => "Falha ao adicionar registro. Erro: ".$th->getMessage(),
        "exception" => $th->getMessage()
      ]);
    }
  }
}