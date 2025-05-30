<?php

$tipoUsuario = "usuario";

$nome = "";
$sobrenome = "";
$telefone = "";
$email = "";
$senha = "";
$numero_sorte = "";

if (isset($data["form"])) {
  $nome = $data["form"]["nome"] ?? "";
  $sobrenome = $data["form"]["sobrenome"] ?? "";
  $telefone = $data["form"]["telefone"] ?? "";
  $email = $data["form"]["email"] ?? "";
  $senha = $data["form"]["senha"] ?? "";
  $numero_sorte = $data["form"]["numero_sorte"] ?? "";
}

?>

<div class="flex flex-row flex-1 px-4 lg:gap-25 lg:px-25 xl:gap-50 xl:px-50 justify-center">
  <div class="hidden lg:flex flex-row flex-1 justify-center items-center">
    <img class="w-full max-w-88" src="public/svg/not-logged.svg" alt="carro sendo levantado por um elevador">
  </div>
  <div class="flex flex-col flex-1 max-w-120 py-12 px-6 gap-8">
    <div class="flex flex-row h-12 items-center gap-1">
      <i class="fa-solid fa-car-side text-3xl"></i>
      <span class="text-2xl font-semibold">AutoCare</span>
    </div>

    <h2 class="text-2xl font-semibold">Criar uma conta</h2>

    <form id="form" class="w-full flex flex-col gap-10" method="POST" action="cadastro" novalidate>
      <div class="step w-full flex flex-col gap-2">
        <div class="form-control flex-col">
          <label for="nome">Nome <span class="text-red-500">*</span></label>
          <input type="text" name="nome" id="nome" data-validate="nome" value="<?= $nome ?>" maxlength="50">
          <span class="helper-text danger hidden">O nome deve conter pelo menos 2 caracteres.</span>
        </div>

        <div class="form-control flex-col">
          <label for="sobrenome">Sobrenome <span class="text-red-500">*</span></label>
          <input type="text" name="sobrenome" id="sobrenome" data-validate="nome" value="<?= $sobrenome ?>" maxlength="45">
          <span class="helper-text danger hidden">O sobrenome deve conter pelo menos 2 caracteres.</span>
        </div>

                <div class="form-control flex-col">
          <label for="numero_sorte">Número da Sorte <span class="text-red-500">*</span></label>
          <input type="number" name="numero_sorte" id="numero_sorte" value="<?= $numero_sorte ?>" max="99999999">
          <span class="helper-text danger hidden"></span>
        </div>

        <div class="form-control flex-col">
          <label for="telefone">Telefone <span class="text-red-500">*</span></label>
          <input type="text" name="telefone" id="telefone" data-validate="telefone" value="<?= $telefone ?>">
          <span class="helper-text danger hidden">Digite um telefone válido no formato (99) 99999-9999.</span>
        </div>

        <div class="form-control flex-col">
          <label for="email">E-mail <span class="text-red-500">*</span></label>
          <input type="email" name="email" id="email" data-validate="email" placeholder="seuemail@exemplo.com" value="<?= $email ?>" maxlength="45">
          <span class="helper-text danger hidden">Digite um e-mail válido.</span>
        </div>

        <div class="w-full">
          <div class="form-control flex-col">
            <label for="senha">Senha <span class="text-red-500">*</span></label>
            <input type="password" name="senha" id="senha" data-validate="senha" placeholder="" value="<?= $senha ?>" maxlength="50">
            <span class="helper-text danger hidden">A senha deve conter pelo menos 8 caracteres, incluindo letras maiúsculas, minúsculas, números e símbolos.</span>
          </div>
        </div>

        <input name="tipoUsuario" value="<?= $_GET["tipoUsuario"] ?>" hidden/>

        <button type="submit" class="button mt-6">Confirmar</button>
      </div>

      <div class="flex flex-row justify-center items-center px-1.5 pt-8 gap-2 border-t border-t-gray-400">
        <span class="">Já tem uma conta?</span>
        <a href="login" class="hoverable font-semibold">Entre na plataforma</a>
      </div>
    </form>
  </div>
</div>