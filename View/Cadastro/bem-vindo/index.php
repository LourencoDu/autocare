<?php
$tipoUsuario = isset($data["tipoUsuario"]) ? $data["tipoUsuario"] : "usuario";
?>

<div class="flex flex-col flex-1 items-center pt-24">
  <div class="flex flex-col flex-1 max-w-[336px] gap-8">
    <div class="flex flex-row h-12 items-center gap-1">
      <i class="fa-solid fa-car-side text-3xl"></i>
      <span class="text-2xl font-semibold">AutoCare</span>
    </div>

    <h2 class="text-2xl font-semibold">Sua conta foi criada!</h2>

    <?php if ($tipoUsuario == "usuario"): ?>
      <p class="text-gray-700">
        Agora você pode encontrar oficinas, estéticas automotiva e muitos outros prestadores de serviços para o seu veículo.
      </p>
    <?php else: ?>
      <p class="text-gray-700">
        O próximo passo é cadastrar os serviços oferecidos pela sua empresa e atrair novos clientes.
      </p>
    <?php endif; ?>

    <a href="/<?= BASE_DIR_NAME ?>" class="button flex flex-row items-center justify-center font-medium">Acessar minha conta</a>
  </div>
</div>