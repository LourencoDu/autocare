<?php
$email = "";
if (isset($data["form"])) {
  $email = $data["form"]["email"] ?? "";
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

    <h2 class="text-2xl font-semibold">Recuperar senha</h2>
    <p class="text-base text-gray-600">
      Informe seu e-mail cadastrado e enviaremos as instruções para redefinir sua senha.
    </p>

    <?php include COMPONENTS . "backend-error.php"; ?>

    <form class="w-full flex flex-col gap-2" method="POST" action="recuperarSenha">
      <div class="form-control flex-col">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="seuemail@exemplo.com" value="<?= $email ?>" required>
      </div>

      <button class="button mt-4 mb-8" type="submit">Enviar instruções</button>

      <div class="flex flex-row justify-center items-center px-1.5 pt-8 gap-2 border-t border-t-gray-400">
        <a href="login" class="hoverable font-semibold">Voltar para login</a>
      </div>
    </form>
  </div>
</div>