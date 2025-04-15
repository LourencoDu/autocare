<?php
  $email = "";
  $senha = "";
  if(isset($data["form"])) {
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

    <h2 class="title">Acesse sua conta</h2>

    <?php if (!empty($data['erro'])): ?>
        <p style="color:red"><?= $data['erro'] ?></p>
    <?php endif; ?>

    <form class="w-100" method="POST" action="login">
      <div class="form-control w-100">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="seuemail@exemplo.com" value="<?= $email ?>">
      </div>
  
      <div class="form-control w-100">
        <label for="senha">Senha</label>
        
        <input type="password" name="senha" id="senha" placeholder="" value="<?= $senha ?>">
      </div>

      <a href="#" class="hoverable">Esqueci minha senha</a>
  
      <button class="w-100" type="submit">Entrar</button>

      <div class="nova-conta">
        <span>Não tem uma conta?</span>
        <a href="cadastro" class="hoverable">Criar uma conta</a>
      </div>
    </form>
  </div>
</div>