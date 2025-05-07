<?php
$lista = isset($data["lista"]) ? $data["lista"] : [];
$keys = [];

if (count($lista)) {
  $keys = array_keys(get_object_vars(reset($lista)));;
}
?>

<div class="overflow-x-auto">
  <?php if (count($lista)) { ?>
    <table class="min-w-full divide-y divide-gray-700/40 bg-white  border border-gray-200">
      <thead class="bg-gray-100">
        <tr>
          <?php
          foreach ($keys as $key) {
            echo "<th class='px-6 py-3 text-start text-xs font-medium uppercase tracking-wider'>$key</th>";
          }
          ?>
          <th class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider">Ações</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        <?php foreach ($lista as $item) { ?>
          <tr>
            <?php
            $values = get_object_vars($item);

            foreach ($values as $value) {
              echo "<td class='px-6 py-4 whitespace-nowrap text-ellipsis'>$value</td>";
            }
            ?>
            <td class="flex flex-row px-6 py-4 whitespace-nowrap text-center gap-2">
              <a href="<?= isset($data["editLink"]) ? $data["editLink"] . "?id=" . $item->id : "#" ?>" class="flex justify-center items-center text-black hover:text-primary transition duration-300 cursor-pointer border border-gray-300 hover:border-primary/60 rounded-sm w-10 h-10" title="Editar">
                <i class="fa-solid fa-pen"></i>
              </a>
              <a href="<?= isset($data["deleteLink"]) ? $data["deleteLink"] . "?id=" . $item->id : "#" ?>" class="flex justify-center items-center text-black hover:text-red-500 transition duration-300 cursor-pointer border border-gray-300 hover:border-red-500/60 rounded-sm w-10 h-10" title="Deletar">
                <i class="fa-solid fa-trash"></i>
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php } else { ?>
    <span>Nenhum registro encontrado...</span>
  <?php } ?>
</div>

<a href="<?= isset($data["addLink"]) ? $data["addLink"] : "#" ?>" class="flex flex-row justify-center items-center border border-primary hover:border-primary-hover rounded-md bg-primary hover:bg-primary-hover text-white transition duration-300 cursor-pointer px-2 h-12 w-full max-w-40 mt-4">
  Adicionar
</a>