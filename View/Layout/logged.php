<div class="flex flex-1 grow">
  <div class="flex flex-col flex-1 max-h-screen max-w-screen p-2 sm:p-5 gap-2 sm:gap-4">
    <div class="flex sm:hidden items-center justify-between w-full h-10">
      <div class="flex items-center gap-1">
        <i class="fa-solid fa-car-side text-3xl"></i>
        <span class="text-xl font-semibold">AutoCare</span>
      </div>

      <button id="toggle-sidemenu-button" class="flex items-center justify-center border w-10 h-10 border-gray-300 rounded-lg hover:border-primary hover:text-primary hover:bg-gray-200">
        <i class="fa-solid fa-bars"></i>
      </button>
    </div>
    <div class="flex flex-row grow flex-1 gap-2 sm:gap-4 overflow-y-auto">
      <?php include COMPONENTS . "sidemenu.php"; ?>

      <div class="flex flex-col items-center grow border border-gray-700/20 rounded-xl px-[0.15rem] py-[0.15rem] bg-gray-50 overflow-auto">
        <div class="flex flex-col grow p-5 sm:p-5 px-5 sm:px-24 overflow-y-auto w-full max-w-[1600px]">
          <div class="flex flex-row pb-5">
            <div class="flex flex-row items-center gap-4 h-10">
              <span class="font-medium text-lg">
                <?= htmlspecialchars($titulo ?? 'Sem Título') ?>
              </span>
              <?php include COMPONENTS . "breadcrumbs.php"; ?>
            </div>
          </div>

          <?php include COMPONENTS . "backend-error.php"; ?>

          <div id="view-content">
            <?php include VIEWS . $view; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>