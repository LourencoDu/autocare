<?php

namespace AutoCare\Controller;

use AutoCare\Model\Usuario;
use AutoCare\Model\Prestador;

use AutoCare\Helper\Util;
use AutoCare\Service\CadastroService;

final class CadastroController extends Controller
{
  public function index(): void
  {
    $this->view = "Cadastro/index.php";
    $this->js = "Cadastro/script.js";

    $this->titulo = "Cadastro";
    if (parent::isPost()) {
      $this->cadastrar();
    } else if (isset($_GET["tipoUsuario"])) {
      if ($_GET["tipoUsuario"] == "usuario") {
        $this->exibirCadastroUsuario();
      } else if ($_GET["tipoUsuario"] == "prestador") {
        $this->exibirCadastroPrestador();
      }
    }
    $this->render();
  }

  private function exibirCadastroUsuario()
  {
    $this->view = "Cadastro/usuario/index.php";
    $this->js = "Cadastro/usuario/script.js";
  }

  private function exibirCadastroPrestador()
  {
    $this->view = "Cadastro/prestador/index.php";
    $this->js = "Cadastro/prestador/script.js";
  }

  public function exibirBemVindo()
  {
    $this->titulo = "Bem-vindo";
    $this->view = "Cadastro/bem-vindo/index.php";

    $this->data["tipoUsuario"] = $_GET["tipoUsuario"] ?? "usuario";

    $this->render();
  }

  private function cadastrar(): void
  {
    $tipoUsuario = $_POST["tipoUsuario"];

    if ($tipoUsuario === "usuario") {
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

    if (!$nome || !$sobrenome || !$telefone || !$email || !$senha) {
      $this->data['erro'] = "Preencha todos os campos obrigatórios (*).";
      $this->data['form'] = [
        "tipoUsuario" => $tipoUsuario,
        "nome" => $nome,
        "sobrenome" => $sobrenome,
        "telefone" => $telefone,
        "email" => $email,
        "senha" => $senha
      ];
      return;
    }

    try {
      $model = new Usuario();

      $model->nome = $nome;
      $model->sobrenome = $sobrenome;
      $model->telefone = Util::removerMascara($telefone);
      $model->email = $email;
      $model->senha = $senha;

      $model->save();

      Header("Location: /" . BASE_DIR_NAME . "/cadastro/bem-vindo?tipoUsuario=" . $tipoUsuario);
    } catch (\Throwable $th) {
      $mensagem = "Falha ao adicionar registro. Por favor, tente novamente.";

      // Se for PDOException (ou similar), pode melhorar a mensagem
      if ($th instanceof \PDOException) {
        // Exemplo: detectar erro de duplicidade pelo código SQLSTATE
        if ($th->getCode() === '23000') {
          $mensagem = "Já existe um usuário cadastrado com o e-mail informado.";
        } else {
          $mensagem = "Erro no banco de dados. Tente novamente mais tarde. Error: ".$th->getMessage();
        }
      }

      $this->data = array_merge($this->data ?? [], [
        "erro" => $mensagem,
        "exception" => $th->getMessage()
      ]);
    }
  }

  private function cadastrarPrestador(): void
  {
    $tipoUsuario = "prestador";

    $nome = $_POST["nome"];
    $documento = $_POST["documento"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    if (!$nome || !$documento || !$telefone || !$email || !$senha) {
      $this->data['erro'] = "Preencha todos os campos obrigatórios (*).";
      $this->data['form'] = [
        "tipoUsuario" => $tipoUsuario,
        "nome" => $nome,
        "documento" => $documento,
        "telefone" => $telefone,
        "email" => $email,
        "senha" => $senha,
      ];
      return;
    }

    try {
      $dadosUsuario['nome'] = $nome;
      $dadosUsuario['telefone'] = Util::removerMascara($telefone);
      $dadosUsuario['email'] = $email;
      $dadosUsuario['senha'] = $senha;
      $dadosUsuario['tipo'] = $tipoUsuario;

      $dadosPrestador['documento'] = Util::removerMascara($documento);

      CadastroService::cadastrarPrestador($dadosUsuario, $dadosPrestador);

      Header("Location: /" . BASE_DIR_NAME . "/cadastro/bem-vindo?tipoUsuario=" . $tipoUsuario);
    } catch (\Throwable $th) {
      $mensagem = "Falha ao adicionar registro. Error: ".$th->getMessage();

      // Se for PDOException (ou similar), pode melhorar a mensagem
      if ($th instanceof \PDOException) {
        // Exemplo: detectar erro de duplicidade pelo código SQLSTATE
        if ($th->getCode() === '23000') {
          $mensagemError = $th->getMessage();
          
          if (stripos($mensagemError, 'prestador.documento') !== false) {
            $mensagem = "Já existe um prestador cadastrado com o CNPJ informado.";
          } else {
            $mensagem = "Já existe um usuário cadastrado com o e-mail informado.";
          }
        } else {
          $mensagem = "Erro no banco de dados. Tente novamente mais tarde. Error: ".$th->getMessage();
        }
      }

      $this->data = array_merge($this->data ?? [], [
        "erro" => $mensagem,
        "exception" => $th->getMessage()
      ]);
    }
  }
}
