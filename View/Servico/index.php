<?php
$servicos = array();
if (isset($data["servicos"])) {
  $servicos = $data["servicos"];
}
$quantidade = count($servicos);
?>

<div class="flex flex-1 flex-col border border-gray-300 rounded-xl justify-between">
  <div class="flex flex-row items-center justify-between h-14 px-5 border-b border-gray-300">
    <span class="text-lg font-semibold">Serviços (<?= $quantidade ?>)</span>
    <button class="button small" onclick="handleActionClick()">
      <i class="fa-solid fa-plus"></i>
      <span class="hidden sm:inline">Novo Serviço</span>
    </button>
  </div>
  <div class="flex flex-1 justify-center">
    <div class="w-full overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-500/10">
          <tr>
            <th scope="col" class="px-5 py-2 font-normal text-center w-[60px] border-r border-gray-300">
              ID
            </th>
            <th scope="col" class="px-5 py-2 font-normal text-left border-r border-gray-300">
              Descricao
            </th>
            <th scope="col" class="px-5 py-2 font-normal text-left border-r border-gray-300">
              Cliente
            </th>
            <th scope="col" class="px-5 py-2 font-normal text-left w-[120px] border-r border-gray-300">
              Data Início
            </th>
            <th scope="col" class="px-5 py-2 font-normal text-left w-[120px] border-r border-gray-300">
              Data Fim
            </th>
            <th scope="col" class="px-5 py-2 font-normal text-left w-[180px] border-r border-gray-300">
              Situação
            </th>
            <th scope="col" class="px-5 py-2 border-r border-gray-300 w-8 sm:w-15"></th>
            <th scope="col" class="px-5 py-2 w-8 sm:w-15"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-300">
          <?php foreach ($servicos as $index => $servico) : ?>
            <tr class="hover:bg-gray-500/5">
              <td class="px-5 py-2 whitespace-nowrap text-sm text-center border-r border-gray-300"><?= $servico->id ?></td>
              <td class="px-5 py-2 whitespace-nowrap text-sm border-r border-gray-300"><?= e($servico->descricao) ?></td>
              <td class="px-5 py-2 whitespace-nowrap text-sm border-r border-gray-300"><?= e($servico->descricao) ?></td>
              <td class="px-5 py-2 whitespace-nowrap text-sm border-r border-gray-300"><?= e($servico->descricao) ?></td>
              <td class="px-5 py-2 whitespace-nowrap text-sm border-r border-gray-300"><?= e($servico->descricao) ?></td>
              <td class="px-5 py-2 whitespace-nowrap text-sm border-r border-gray-300"><?= e($servico->descricao) ?></td>
              <td class="px-2 sm:px-5 py-2 whitespace-nowrap text-sm text-center border-r border-gray-300">
                <button class="button small ghost" onclick="handleActionClick(<?= $servico->id ?>, '<?= e($servico->descricao) ?>')"><i class="fa-solid fa-pen"></i> <span class="hidden sm:inline">Alterar</span></button>
              </td>
              <td class="px-2 sm:px-5 py-2 whitespace-nowrap text-sm text-center">
                <button class="button small ghost danger" onclick="handleDeleteClick(<?= $servico->id ?>, '<?= e($servico->descricao) ?>')"><i class="fa-solid fa-trash"></i> <span class="hidden sm:inline">Deletar</span></button>
              </td>
            </tr>
          <?php endforeach; ?>

        </tbody>
      </table>

      <?php if ($quantidade == 0) : ?>
        <div class="flex flex-col items-center justify-center py-20">
          <i class="text-primary text-6xl fa-solid fa-flag mb-4"></i>
          <span class="text-lg font-semibold mb-4 text-center">Nenhum serviço cadastrado no sistema</span>

          <button class="button" onclick="handleActionClick()">
            <i class="fa-solid fa-plus mt-[2px]"></i>
            <span> Novo Serviço</span>
          </button>
        </div>
      <?php endif; ?>
    </div>

  </div>
</div>