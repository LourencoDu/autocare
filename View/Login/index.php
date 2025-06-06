<?php
$email = "";
$senha = "";
if (isset($data["form"])) {
  $email = $data["form"]["email"] ?? "";
  $senha = $data["form"]["senha"] ?? "";
}
?>

<div class="flex flex-row flex-1 py-12 px-4 lg:gap-25 lg:px-25 xl:gap-50 xl:px-50 justify-center">
  <div class="hidden lg:flex flex-row flex-1 justify-center items-center">
    <img class="w-full max-w-88" src="public/svg/not-logged.svg" alt="carro sendo levantado por um elevador">
  </div>
  <div class="flex flex-col flex-1 max-w-120 py-12 px-6 gap-8">
    <div class="flex flex-row h-12 items-center gap-1">
      <i class="fa-solid fa-car-side text-3xl"></i>
      <span class="text-2xl font-semibold">AutoCare</span>
    </div>

    <h2 class="text-2xl font-semibold">Acesse sua conta</h2>

    <?php include COMPONENTS . "backend-error.php"; ?>

    <form class="w-full flex flex-col gap-2" method="POST" action="login">
      <div class="form-control flex-col">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="seuemail@exemplo.com" value="<?= $email ?>">
      </div>

      <div  class="form-control flex-col">
        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" placeholder="" value="<?= $senha ?>">
      </div>

      <a href="recuperar" class="hoverable">Esqueci minha senha</a>

      <button class="button mt-4 mb-8" type="submit">Entrar</button>

      <div class="flex flex-row justify-center items-center px-1.5 pt-8 gap-2 border-t border-t-gray-400">
        <span class="">Não tem uma conta?</span>
        <a href="cadastro" class="hoverable font-semibold">Criar uma conta</a>
      </div>
    </form>
  </div>
</div>