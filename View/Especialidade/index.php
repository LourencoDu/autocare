<?php
$especialidades = array();
if (isset($data["especialidades"])) {
  $especialidades = $data["especialidades"];
}
$quantidade = count($especialidades);
?>

<div class="flex flex-1 flex-col border border-gray-300 rounded-xl justify-between">
  <div class="flex flex-row items-center justify-between h-14 px-5 border-b border-gray-300">
    <span class="text-lg font-semibold">Especialidades (<?= $quantidade ?>)</span>
    <button class="button small">
      <i class="fa-solid fa-plus"></i>
      Nova Especialidade</button>
  </div>
  <div class="flex flex-1 justify-center overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-300">
      <thead class="bg-gray-500/10">
        <tr>
          <th scope="col" class="px-5 py-2 text-left font-medium w-[60px]">
            ID
          </th>
          <th scope="col" class="px-5 py-2 text-left font-medium">
            Nome
          </th>
          <th scope="col" class="px-5 py-2"></th>
          <th scope="col" class="px-5 py-2"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-300">
        <tr>
          <td class="px-5 py-2 whitespace-nowrap text-sm ">1</td>
          <td class="px-5 py-2 whitespace-nowrap text-sm ">João Silva</td>
          <td class="px-5 py-2 whitespace-nowrap text-sm  w-[60px]">
            <button class="button small ghost"><i class="fa-solid fa-pen"></i></button>
          </td>
          <td class="px-5 py-2 whitespace-nowrap text-sm  w-[60px]">
            <button class="button small ghost"><i class="fa-solid fa-trash"></i></button>
          </td>
        </tr>
        <!-- Repetir tr para outras linhas -->
      </tbody>
    </table>

  </div>
</div>