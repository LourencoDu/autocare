<div class="flex items-center justify-center w-screen h-screen bg-gray-100">
    <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-sm">
        <h2 class="text-3xl font-bold mb-8 text-center text-gray-800">Redefinir Senha</h2>

        <?php if (isset($erro)) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= $erro ?>
            </div>
        <?php endif; ?>

        <form action="autocare/atualizarSenha" method="post" class="space-y-6" id="form">
            <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['email']) ?>">
            <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token']) ?>">

            <div>
                <div class="w-full">
                    <div class="form-control flex-col">
                        <label for="senha">Senha <span class="text-red-500">*</span></label>
                        <input type="password" name="senha" id="senha" data-validate="senha" placeholder="" maxlength="50">
                        <span class="helper-text danger hidden">A senha deve conter pelo menos 8 caracteres, incluindo letras maiúsculas, minúsculas, números e símbolos.</span>
                    </div>
                </div>
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-md transition mt-2">
                Salvar Nova Senha
            </button>
        </form>
    </div>
</div>