<?php
$fields = isset($data["fields"]) ? $data["fields"] : [];
?>

<form class="flex flex-col gap-2" method="POST" autocomplete="off">
  <?php if (!empty($data['erro'])): ?>
    <p style="color:red"><?= $data['erro'] ?></p>
  <?php endif; ?>

  <?php foreach ($fields as $field) { ?>
    <div class="form-control">
      <label for="<?= $field["name"]; ?>"><?= $field["label"]; ?></label>
      <input autocomplete="off" <?= isset($field["readonly"]) && $field["readonly"] ? "readonly" : ""; ?> <?= $field["required"] ? "required" : ""; ?> type="<?= $field["type"]; ?>" name="<?= $field["name"]; ?>" id="<?= $field["name"]; ?>" placeholder="" value="<?= isset($data["form"][$field["name"]]) ? $data["form"][$field["name"]] : "" ?>">
    </div>
  <?php } ?>

  <div class="flex flex-row gap-4 pt-4">
    <a href="." class="flex flex-row justify-center items-center border border-red-600 hover:border-red-900 rounded-md bg-red-600 hover:bg-red-900 text-white transition duration-300 cursor-pointer px-2 h-12 w-full max-w-40">
      Voltar
    </a>
    <button class="flex flex-row justify-center items-center border border-primary hover:border-primary-hover rounded-md bg-primary hover:bg-primary-hover text-white transition duration-300 cursor-pointer px-2 h-12 w-full max-w-40">
      Enviar
    </button>
  </div>
</form>