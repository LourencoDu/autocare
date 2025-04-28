<div class="flex flex-row flex-1 max-h-screen p-5 gap-4">
  <div class="flex flex-col flex-1 max-w-12 items-center gap-4">
    <div class="flex h-10 w-10 border rounded-lg border-zinc-700/40 justify-center items-center">
      <span class="font-medium text-sm">AC</span>
    </div>

    <div class="flex flex-1 w-full flex-col justify-start items-center border-y border-y-zinc-700/20 py-4 gap-2">
      <a href="/<?= BASE_DIR_NAME; ?>/prestador" class="flex h-12 w-12 border rounded-lg border-zinc-700/40 justify-center items-center hover:border-primary/40 hover:text-primary transition duration-300 cursor-pointer">
        <i class="fa-solid fa-screwdriver-wrench"></i>
      </a>

      <a href="/<?= BASE_DIR_NAME; ?>/usuario" class="flex h-12 w-12 border rounded-lg border-zinc-700/40 justify-center items-center hover:border-primary/40 hover:text-primary transition duration-300 cursor-pointer">
        <i class="fa-solid fa-user"></i>
      </a>

      <a href="/<?= BASE_DIR_NAME; ?>/veiculo" class="flex h-12 w-12 border rounded-lg border-zinc-700/40 justify-center items-center hover:border-primary/40 hover:text-primary transition duration-300 cursor-pointer">
        <i class="fa-solid fa-car"></i>
      </a>

      <a href="/<?= BASE_DIR_NAME; ?>/funcionario" class="flex h-12 w-12 border rounded-lg border-zinc-700/40 justify-center items-center hover:border-primary/40 hover:text-primary transition duration-300 cursor-pointer">
        <i class="fa-solid fa-user-group"></i>
      </a>

      <a href="/<?= BASE_DIR_NAME; ?>/servico" class="flex h-12 w-12 border rounded-lg border-zinc-700/40 justify-center items-center hover:border-primary/40 hover:text-primary transition duration-300 cursor-pointer">
        <i class="fa-solid fa-gear"></i>
      </a>
      
      <a href="/<?= BASE_DIR_NAME; ?>/prestador/proximos" class="flex h-12 w-12 border rounded-lg border-zinc-700/40 justify-center items-center hover:border-primary/40 hover:text-primary transition duration-300 cursor-pointer">
        <i class="fa-solid fa-map-location-dot"></i>
      </a>

    </div>

    <div class="flex flex-col justify-end items-center">
      <a href="/<?= BASE_DIR_NAME; ?>/logout" class="flex h-12 w-12 border rounded-lg border-zinc-700/40 justify-center items-center hover:border-primary/40 hover:text-primary transition duration-300 cursor-pointer">
        <i class="fa-solid fa-arrow-right-from-bracket"></i>
      </a>
    </div>
  </div>
  <div class="flex flex-col flex-1 border border-zinc-700/40 rounded-xl p-5 bg-zinc-900 gap-2">
    <div class="flex flex-row h-10 items-center">
      <span class="font-medium text-lg">
        <?= isset($titulo) ? $titulo : "Sem Título"; ?>
      </span>
    </div>
    <?php include VIEWS . $view; ?>
  </div>
</div>