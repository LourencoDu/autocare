<?php

$tipoUsuario = "";

$nome = "";
$sobrenome = "";
$telefone = "";
$email = "";
$senha = "";

if (isset($data["form"])) {
  $tipoUsuario = $data["form"]["tipoUsuario"] ?? "";

  $nome = $data["form"]["nome"] ?? "";
  $sobrenome = $data["form"]["sobrenome"] ?? "";
  $telefone = $data["form"]["telefone"] ?? "";
  $email = $data["form"]["email"] ?? "";
  $senha = $data["form"]["senha"] ?? "";
}

?>

<div class="flex flex-row flex-1 py-12 px-4 lg:gap-25 lg:px-25 xl:gap-50 xl:px-50 justify-center">
  <div class="hidden lg:flex flex-row flex-1 justify-center items-center">
    <img class="w-full max-w-88" src="public/svg/not-logged.svg" alt="carro sendo levantado por um elevador">
  </div>
  <div class="flex flex-col flex-1 max-w-120 py-12 px-6 gap-8">
    <span>LOGO</span>

    <h2 class="text-2xl font-semibold">Criar uma conta</h2>

    <?php if (!empty($data['erro'])): ?>
      <p style="color:red"><?= $data['erro'] ?></p>
    <?php endif; ?>

    <form id="form" class="w-full flex flex-col gap-10" method="POST" action="cadastro">
      <div id="step-1" class="step w-full flex flex-col gap-2 <?= $tipoUsuario != "" ? "hidden" : "" ?>">
        <div class="form-control">
          <span>Você é...</span>

          <div class="flex flex-row gap-3 h-45">
            <label class="flex flex-col items-center justify-center gap-3 p-4 flex-1 border border-gray-700 rounded-md transition hover:border-primary-hover hover:text-primary hover:cursor-pointer has-[input:checked]:bg-primary has-[input:checked]:text-white has-[input:checked]:border-primary">
              <input <?= $tipoUsuario === "usuario" ? 'checked' : '' ?> type="radio" name="tipoUsuario" value="usuario" class="hidden person-type-radio">
              <i class="fa-solid fa-user text-6xl"></i>
              <span>Dono de veículo</span>
            </label>

            <label class="flex flex-col items-center justify-center gap-3 p-4 flex-1 border border-gray-700 rounded-md transition hover:border-primary-hover hover:text-primary hover:cursor-pointer has-[input:checked]:bg-primary has-[input:checked]:text-white has-[input:checked]:border-primary">
              <input <?= $tipoUsuario === "prestador" ? 'checked' : '' ?> type="radio" name="tipoUsuario" value="prestador" class="hidden person-type-radio">
              <i class="fa-solid fa-wrench text-6xl"></i>
              <span>Prestador de serviços</span>
            </label>
          </div>
        </div>

        <button id="step1-submit-button" type="button" class="button mt-4" onclick="nextStep(1)" disabled>Próximo</button>
      </div>

      <div id="step-2" class="step w-full flex flex-col gap-2 <?= $tipoUsuario != "" ? "" : "hidden" ?>">
        <div class="form-control">
          <label for="nome">Nome <span class="text-red-500">*</span></label>
          <input type="text" name="nome" id="nome" value="<?= $nome ?>" required>
        </div>

        <div class="form-control">
          <label for="sobrenome">Sobrenome <span class="text-red-500">*</span></label>
          <input type="text" name="sobrenome" id="sobrenome" value="<?= $sobrenome ?>" required>
        </div>

        <div class="form-control">
          <label for="telefone">Telefone <span class="text-red-500">*</span></label>
          <input type="text" name="telefone" id="telefone" value="<?= $telefone ?>" required>
        </div>

        <div class="form-control">
          <label for="email">E-mail <span class="text-red-500">*</span></label>
          <input type="email" name="email" id="email" placeholder="seuemail@exemplo.com" value="<?= $email ?>" required>
        </div>

        <div class="w-full">
          <div class="form-control">
            <label for="senha">Senha <span class="text-red-500">*</span></label>
            <input type="password" name="senha" id="new-senha" placeholder="" value="<?= $senha ?>" required>
          </div>
        </div>

        <button id="step2-submit-button" type="button" class="button mt-6" onclick="nextStep(2)">Confirmar</button>
      </div>

      <div class="flex flex-row justify-center items-center px-1.5 pt-8 gap-2 border-t border-t-gray-700">
        <span class="">Já tem uma conta?</span>
        <a href="login" class="hoverable font-semibold">Entre na plataforma</a>
      </div>
    </form>
  </div>
</div>