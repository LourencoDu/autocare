<?php if (isset($caminho)): ?>
  <div class="flex flex-row items-center gap-1">
    <a class="font-normal transition text-gray-600 hover:text-primary" href="/<?= BASE_DIR_NAME ?>/">Início</a>
    <span class="text-gray-600">/</span>

    <?php foreach ($caminho as $index => $item): ?>
      <a class="font-normal transition text-gray-600 hover:text-primary" href="/<?= BASE_DIR_NAME ?>/<?= $item->rota ?>">
        <?= htmlspecialchars($item->texto) ?>
      </a>
      <span class="text-gray-600">/</span>
    <?php endforeach; ?>

    <?php if($titulo != "Início"): ?>
    <span><?= htmlspecialchars($titulo) ?></span>
    <?php endif; ?>
  </div>
<?php endif; ?>