<?php
$nome = "";
$sobrenome = "";
$telefone = "";
$email = "";
$senha = "";

$action = $data["action"] ?? "adicionar";

if (isset($data["form"])) {
  $nome = $data["form"]["nome"] ?? "";
  $sobrenome = $data["form"]["sobrenome"] ?? "";
  $telefone = $data["form"]["telefone"] ?? "";
  $email = $data["form"]["email"] ?? "";
  $senha = $data["form"]["senha"] ?? "";
}
?>

<div class="flex flex-col border border-gray-300 rounded-xl">
  <div class="flex flex-row items-center h-14 px-5 border-b border-gray-300">
    <span class="text-lg font-semibold">Informações do Funcionário</span>
  </div>
  <form id="form" action="" method="post" class="flex flex-col p-5 gap-5" novalidate>
    <div class="form-control row medium flex-col sm:flex-row">
      <label for="nome">Nome <span class="text-red-500">*</span></label>
      <input required type="text" name="nome" data-validate="nome" placeholder="" maxlength="50" value="<?= $nome ?>" />
    </div>

    <div class="form-control row medium flex-col sm:flex-row">
      <label for="sobrenome">Sobrenome <span class="text-red-500">*</span></label>
      <input required type="text" name="sobrenome" data-validate="nome" placeholder="" maxlength="45" value="<?= $sobrenome ?>" />
    </div>

    <div class="form-control row medium flex-col sm:flex-row">
      <label for="telefone">Telefone <span class="text-red-500">*</span></label>
      <input required type="text" name="telefone" data-validate="telefone" placeholder="" maxlength="45" value="<?= $telefone ?>" />
    </div>

    <div class="form-control row medium flex-col sm:flex-row">
      <label for="email">E-mail <span class="text-red-500">*</span></label>
      <input required type="email" name="email" data-validate="email" placeholder="seuemail@exemplo.com" maxlength="45" value="<?= $email ?>" maxlength="45" />
    </div>

    <div class="form-control row medium flex-col sm:flex-row">
      <label for="senha">Senha <span class="text-red-500">*</span></label>
      <input required type="password" name="senha" data-validate="senha" placeholder="" maxlength="50" value="<?= $senha ?>" maxlength="45" />
    </div>

    <div class="flex flex-row items-center justify-end pt-2.5 gap-2">
      <a href="." class="flex flex-row items-center button ghost medium"><?= $action == "adicionar" ? "Voltar" : "Cancelar alterações" ?></a>
      <button class="button medium"><?= $action == "adicionar" ? "Adicionar Funcionário" : "Salvar alterações" ?></button>
    </div>
  </form>
</div>