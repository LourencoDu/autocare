<div class="flex flex-col flex-1 max-h-screen p-5 gap-4">
  <div class="flex flex-row w-full justify-between">
    <div class="flex flex-row h-10 w-12 items-center justify-center gap-1">
      <i class="fa-solid fa-car-side text-3xl"></i>
    </div>

    <div class="flex flex-row items-center gap-2">

      <div class="flex flex-col items-end">
        <span class="text-base/5 font-medium"><?= isset($_SESSION["usuario"]) ? $_SESSION["usuario"]["nome_completo"] : "" ?></span>
        <span class="text-sm/4 text-gray-600"><?= isset($_SESSION["usuario"]) ? $_SESSION["usuario"]["email"] : "" ?></span>
      </div>

      <div class="w-10 h-10 flex items-center justify-center border border-gray-400 rounded-4xl">
        <i class="fa-regular <?= $_SESSION["usuario"]["icone"] ?> text-xl text-gray-700"></i>
      </div>
    </div>
  </div>
  <div class="flex flex-row flex-1 gap-4">
    <div class="flex flex-col flex-1 max-w-12 items-center gap-4">
      <div class="flex flex-1 w-full flex-col justify-start items-center border-y border-y-gray-700/40 py-4 gap-2">
        <a href="/<?= BASE_DIR_NAME; ?>/prestador" class="flex h-12 w-12 border rounded-lg border-gray-700/20 justify-center items-center hover:border-primary/60 hover:text-primary transition duration-300 cursor-pointer">
          <i class="fa-solid fa-screwdriver-wrench"></i>
        </a>

        <a href="/<?= BASE_DIR_NAME; ?>/usuario" class="flex h-12 w-12 border rounded-lg border-gray-700/20 justify-center items-center hover:border-primary/60 hover:text-primary transition duration-300 cursor-pointer">
          <i class="fa-solid fa-user"></i>
        </a>

        <a href="/<?= BASE_DIR_NAME; ?>/veiculo" class="flex h-12 w-12 border rounded-lg border-gray-700/20 justify-center items-center hover:border-primary/60 hover:text-primary transition duration-300 cursor-pointer">
          <i class="fa-solid fa-car"></i>
        </a>

        <a href="/<?= BASE_DIR_NAME; ?>/funcionario" class="flex h-12 w-12 border rounded-lg border-gray-700/20 justify-center items-center hover:border-primary/60 hover:text-primary transition duration-300 cursor-pointer">
          <i class="fa-solid fa-user-group"></i>
        </a>

        <a href="/<?= BASE_DIR_NAME; ?>/servico" class="flex h-12 w-12 border rounded-lg border-gray-700/20 justify-center items-center hover:border-primary/60 hover:text-primary transition duration-300 cursor-pointer">
          <i class="fa-solid fa-gear"></i>
        </a>

        <a href="/<?= BASE_DIR_NAME; ?>/prestador/proximos" class="flex h-12 w-12 border rounded-lg border-gray-700/20 justify-center items-center hover:border-primary/60 hover:text-primary transition duration-300 cursor-pointer">
          <i class="fa-solid fa-map-location-dot"></i>
        </a>

      </div>

      <div class="flex flex-col justify-end items-center">
        <a href="/<?= BASE_DIR_NAME; ?>/logout" class="flex h-12 w-12 border rounded-lg border-gray-700/20 justify-center items-center hover:border-primary/60 hover:text-primary transition duration-300 cursor-pointer">
          <i class="fa-solid fa-arrow-right-from-bracket"></i>
        </a>
      </div>
    </div>
    <div class="flex flex-col flex-1 border border-gray-700/20 rounded-xl p-5 bg-gray-50 gap-2">
      <div class="flex flex-row h-10 items-center">
        <span class="font-medium text-lg">
          <?= isset($titulo) ? $titulo : "Sem Título"; ?>
        </span>
      </div>
      <?php include VIEWS . $view; ?>
    </div>
  </div>
</div>