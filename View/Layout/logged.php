<div class="flex flex-1 grow">
  <div class="flex flex-col flex-1 max-h-screen max-w-screen p-5 gap-4">
    <div class="flex flex-row grow flex-1 gap-4 overflow-y-auto">
      <?php include COMPONENTS . "sidemenu.php"; ?>

      <div class="flex flex-col grow border border-gray-700/20 rounded-xl px-[0.15rem] py-[0.15rem] bg-gray-50">
        <div class="flex flex-col grow p-5 px-24 overflow-y-auto">
          <div class="flex flex-row pb-5">
            <div class="flex flex-row items-center gap-4 h-10">
              <span class="font-medium text-lg">
                <?= htmlspecialchars($titulo ?? 'Sem Título') ?>
              </span>
              <?php include COMPONENTS . "breadcrumbs.php"; ?>
            </div>
          </div>

          <?php include VIEWS . $view; ?>
        </div>
      </div>
    </div>
  </div>
</div>