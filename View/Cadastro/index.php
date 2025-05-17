<?php

$tipoUsuario = "";

if (isset($data["form"])) {
  $tipoUsuario = $data["form"]["tipoUsuario"] ?? "";
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

    <h2 class="text-2xl font-semibold">Criar uma conta</h2>

    <?php if (!empty($data['erro'])): ?>
      <p style="color:red"><?= $data['erro'] ?></p>
    <?php endif; ?>

    <form id="form" class="w-full flex flex-col gap-10" method="GET" action="cadastro">
      <div class="step w-full flex flex-col gap-2">
        <div class="form-control flex-col">
          <span>Você é...</span>

          <div class="flex flex-row gap-3 h-45">
            <label class="group flex flex-col items-center justify-center gap-3 p-4 flex-1 border border-gray-400 rounded-md transition hover:border-primary-hover hover:bg-primary/10 hover:cursor-pointer has-[input:checked]:bg-primary has-[input:checked]:text-white has-[input:checked]:border-primary">
              <input type="radio" name="tipoUsuario" value="usuario" class="hidden person-type-radio">
              <i class="fa-solid fa-user text-6xl group-has-[input:checked]:text-white transition"></i>
              <span class="group-has-[input:checked]:text-white transition">Dono de veículo</span>
            </label>

            <label class="group flex flex-col items-center justify-center gap-3 p-4 flex-1 border border-gray-400 rounded-md transition hover:border-primary-hover hover:bg-primary/10 hover:cursor-pointer has-[input:checked]:bg-primary has-[input:checked]:text-white has-[input:checked]:border-primary">
              <input type="radio" name="tipoUsuario" value="prestador" class="hidden person-type-radio">
              <i class="fa-solid fa-wrench text-6xl group-has-[input:checked]:text-white transition"></i>
              <span class="group-has-[input:checked]:text-white transition">Prestador de serviços</span>
            </label>
          </div>
        </div>

        <button id="step1-submit-button" type="submit" class="button mt-4" disabled>Próximo</button>
      </div>

      <div class="flex flex-row justify-center items-center px-1.5 pt-8 gap-2 border-t border-t-gray-400">
        <span class="">Já tem uma conta?</span>
        <a href="login" class="hoverable font-semibold">Entre na plataforma</a>
      </div>
    </form>
  </div>
</div>