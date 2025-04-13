<div class="content">
  <div class="left-side">
    <div>IMAGEM</div>
  </div>
  <div class="right-side">
    <span>LOGO</span>

    <h2 class="title">Acesse sua conta</h2>

    <?php if (!empty($data['erro'])): ?>
        <p style="color:red"><?= $data['erro'] ?></p>
    <?php endif; ?>

    <form class="w-100" method="POST" action="<?= BASE_URL ?>/login?acao=autenticar">
      <div class="form-control w-100">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="seuemail@exemplo.com">
      </div>
  
      <div class="form-control w-100">
        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" placeholder="">
      </div>

      <a href="#" class="hoverable">Esqueci minha senha</a>
  
      <button class="w-100" type="submit">Entrar</button>

      <div class="nova-conta">
        <span>Não tem uma conta?</span>
        <a href="#" class="hoverable">Criar uma conta</a>
      </div>
    </form>
  </div>
</div>