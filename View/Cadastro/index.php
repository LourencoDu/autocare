<?php
$email = "";
$senha = "";
if (isset($data["form"])) {
  $email = $data["form"]["email"] ?? "";
  $senha = $data["form"]["senha"] ?? "";
}
?>

<div class="content">
  <div class="left-side">
    <img src="public/svg/not-logged.svg" alt="carro sendo levantado por um elevador">
  </div>
  <div class="right-side">
    <span>LOGO</span>

    <h2 class="title">Criar uma conta</h2>

    <?php if (!empty($data['erro'])): ?>
      <p style="color:red"><?= $data['erro'] ?></p>
    <?php endif; ?>

    <form class="w-100" method="POST" action="login">
    <div class="type-select">
        <span class="title">Você é...</span>

        <div class="option">
          <span class="label">Dono de veículo</span>
        </div>

        <div class="option">
          <span class="label">Prestador de serviços</span>
        </div>
      </div>

      <button class="btn w-100" type="submit">Próximo</button>

      <div class="nova-conta">
        <span>Já tem uma conta?</span>
        <a href="login" class="hoverable">Entre na plataforma</a>
      </div>
    </form>
  </div>
</div>