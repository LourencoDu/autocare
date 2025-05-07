<div class="flex flex-col flex-1 max-h-screen p-5 gap-4">
  <?php include COMPONENTS . "header.php"; ?>

  <div class="flex flex-row flex-1 gap-4">
    <?php include COMPONENTS . "sidemenu.php"; ?>

    <div class="flex flex-col flex-1 border border-gray-700/20 rounded-xl p-5 px-24 bg-gray-50">
      <div class="flex flex-row h-10 items-center gap-4">
        <span class="font-medium text-lg">
          <?= htmlspecialchars($titulo ?? 'Sem Título') ?>
        </span>
        <?php include COMPONENTS . "breadcrumbs.php"; ?>
      </div>

      <?php include VIEWS . $view; ?>
    </div>
  </div>
</div>