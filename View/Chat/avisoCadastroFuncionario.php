<div class="flex flex-col col-span-1 lg:col-span-2">
  <div class="flex w-full h-full flex-col border border-gray-300 rounded-xl px-6 py-16 items-center justify-center gap-4">
    <img class="w-full max-w-60" src="/<?= PUBLIC_DIR ?>/svg/chat_prestador.svg" alt="ilustração de funcionários conversando">
    <span class="text-xl font-semibold text-center">Acesse o Chat com seu Perfil de Funcionário</span>
    <span class="font-medium text-gray-700 text-center max-w-[480px]">
      Para utilizar as funcionalidades de chat, é necessário cadastrar funcionários.<br>
      O acesso ao chat é exclusivo para perfis de funcionários cadastrados no sistema.
    </span>
    <a href="/<?= BASE_DIR_NAME ?>/funcionario" class="button medium flex items-center justify-center">
      Cadastrar Funcionário
    </a>
  </div>
</div>