<?php

namespace AutoCare\Controller;

use AutoCare\Helper\JsonResponse;
use AutoCare\Helper\Util;
use AutoCare\Model\Funcionario;
use AutoCare\Service\FuncionarioService;

final class FuncionarioController extends Controller
{
  public function index(): void
  {
    parent::isProtected(["usuario", "funcionario"]);

    $this->view = "Funcionario/index.php";
    $this->titulo = "Meus Funcionários";
    $this->render();
  }

  private function backToIndex(): void
  {
    parent::redirect("funcionario");
  }

  public function listar(): void
  {
    parent::isProtected(["usuario", "funcionario"]);

    $model = new Funcionario();

    $funcionarios = $model->getAllByLoggedUser();
    $this->data["funcionarios"] = $funcionarios;

    $this->js = "Funcionario/script.js";

    $this->index();
  }

  public function cadastrar(): void
  {
    parent::isProtected(["usuario", "funcionario"]);

    $this->view = "Funcionario/form.php";
    $this->js = "Funcionario/form.js";
    $this->titulo = "Novo Funcionário";


    $this->caminho = [
      new CaminhoItem("Meus Funcionários", "funcionario")
    ];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      try {
        $usuario = $_SESSION["usuario"];
        $id_prestador = $usuario->prestador->id;

        $dadosUsuario['nome'] = $_POST["nome"];
        $dadosUsuario['sobrenome'] = $_POST["sobrenome"];
        $dadosUsuario['telefone'] = Util::removerMascara($_POST["telefone"]);
        $dadosUsuario['email'] = $_POST["email"];
        $dadosUsuario['senha'] = $_POST["senha"];

        $dadosFuncionario["id_prestador"] = $id_prestador;

        $this->data["form"] = [
          "nome" => $dadosUsuario['nome'],
          "sobrenome" => $dadosUsuario['sobrenome'],
          "telefone" => $dadosUsuario['telefone'],
          "email" => $dadosUsuario['email'],
          "senha" => $dadosUsuario['senha'],
        ];

        FuncionarioService::cadastrarFuncionario($dadosUsuario, $dadosFuncionario);

        $this->backToIndex();
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

    $this->render();
  }

  public function desativar(): void
  {
    parent::isProtected(["usuario", "funcionario"]);

    $id = isset($_POST["id"]) ? $_POST["id"] : null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $response = null;
      try {
        Funcionario::delete((int) $id);

        $response = JsonResponse::sucesso("Funcionário deletado com sucesso!");
      } catch (\Throwable $th) {
        $response = JsonResponse::erro("Falha ao deletar veículo!");
      }

      $response->enviar();
    }
  }
}
