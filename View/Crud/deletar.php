<?php
$infos = isset($data["infos"]) ? $data["infos"] : [];
?>

<form class="flex flex-col gap-10" method="POST">
  <div class="w-full max-w-150">
    <table class="min-w-full divide-y divide-zinc-700/40 bg-white dark:bg-zinc-900 dark:text-white border border-zinc-700/40">
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        <?php foreach ($infos as $key => $value) { ?>
          <tr>
            <td class="px-6 py-4 whitespace-nowrap"><?= $key ?></td>
            <td class="px-6 py-4 whitespace-nowrap"><?= $value ?></td>
          </tr>
        <?php } ?>
      </tbody>

    </table>
  </div>

  <div class="flex flex-col gap-2">
    <span class="font-medium">
      Deseja realmente deletar o registro acima?
    </span>

    <div class="flex flex-row gap-4 mt-4">
      <a href="." class="flex flex-row justify-center items-center border border-primary hover:border-primary-hover rounded-md bg-primary hover:bg-primary-hover transition duration-300 cursor-pointer px-2 h-12 w-full max-w-40">
        Voltar
      </a>
      <button class="flex flex-row justify-center items-center border border-red-600 hover:border-red-900 rounded-md bg-red-600 hover:bg-red-900 transition duration-300 cursor-pointer px-2 h-12 w-full max-w-40">
        Confirmar
      </button>
    </div>
  </div>
</form>