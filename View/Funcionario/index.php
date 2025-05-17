<?php

use AutoCare\Helper\Util;

$funcionarios = $data["funcionarios"] ?? [];
$quantidade = count($funcionarios);
?>

<?php if ($quantidade > 0): ?>
  <div class="flex flex-row justify-between items-center gap-2">
    <span class="text font-semibold"><?php
                                      if ($quantidade == 0) {
                                        echo "Nenhum funcionário cadastrado";
                                      } else {
                                        echo "Você tem <span class='text-primary'>" . $quantidade . "</span> " . ($quantidade > 1 ? "funcionários cadastrados" : "funcionário cadastrado");
                                      }
                                      ?></span>

    <div class="flex flex-row items-center justify-between gap-2">
      <a href="/<?= BASE_DIR_NAME ?>/funcionario/cadastrar" class="button small flex flex-row items-center">
        <i class="fa-solid fa-plus mt-[1px]"></i>
        <span class="hidden lg:block ml-1">Novo Funcionário</span>
      </a>
    </div>
  </div>

  <div class="flex flex-row lg:flex-col flex-wrap gap-5 pt-5">
    <?php foreach ($funcionarios as $index => $funcionario) : ?>
      <?php
      $telefone = Util::formatarTelefone($funcionario->usuario->telefone);
      $nome_completo = $funcionario->usuario->nome . " " . $funcionario->usuario->sobrenome;
      ?>

      <div class="relative flex flex-row flex-wrap justify-between p-4 lg:p-8 border border-gray-300 rounded-xl gap-4 max-w-[320px] lg:max-w-full">
        <div class="flex flex-col lg:flex-row items-center lg:items-start w-full lg:w-fit">
          <div class="flex flex-row items-center justify-center h-12 w-12 border border-gray-300 rounded-4xl">
            <i class="fa-solid fa-users-gear"></i>
          </div>
          <div class="flex flex-col lg:pl-3 items-center lg:items-start">
            <span class="text-lg font-semibold"><?= $nome_completo ?></span>
            <span class="hidden sm:block text-sm"><?=  $funcionario->usuario->email. " - " . $telefone ?></span>
          </div>
        </div>

        <div class="flex flex-col lg:flex-row items-center gap-6 lg:gap-14 w-full lg:w-fit">
          <div class="flex flex-row justify-center lg:justify-start gap-2 lg:gap-4 flex-wrap">
            <div class="flex flex-col border border-dashed border-gray-300 rounded-xl px-2.5 py-2 min-w-24 max-w-auto gap-1">
              <span class="text-sm font-semibold"><?= $funcionario->usuario->email ?></span>
              <span class="text-xs text-gray-700">E-mail</span>
            </div>

            <div class="flex flex-col border border-dashed border-gray-300 rounded-xl px-2.5 py-2 min-w-24 max-w-auto gap-1">
              <span class="text-sm font-semibold"><?= $telefone ?></span>
              <span class="text-xs text-gray-700">Telefone</span>
            </div>
          </div>

          <div class="absolute lg:static right-2 top-2 flex flex-row items-center gap-2">
            <a onclick="handleDeleteClick(<?= $funcionario->id ?>, '<?= $nome_completo ?>')" class="flex flex-row items-center justify-center w-8 h-8 rounded-md text-gray-600 hover:text-red-500 hover:bg-red-500/10 transition cursor-pointer">
              <i class="fa-solid fa-trash mt-[2px] transition"></i>
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="flex flex-col items-center justify-center pt-20">
    <i class="text-primary text-6xl fa-solid fa-users-gear mb-4"></i>
    <span class="text-lg font-semibold mb-4 text-center">Você ainda não tem funcionários adicionados</span>

    <a href="/<?= BASE_DIR_NAME ?>/funcionario/cadastrar" class="button flex flex-row items-center gap-1.5">
      <i class="fa-solid fa-plus mt-[2px]"></i>
      <span>Novo Funcionário</span>
    </a>
  </div>
<?php endif; ?>