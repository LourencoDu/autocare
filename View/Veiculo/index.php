<?php
$veiculos = $data["veiculos"] ?? [];
$quantidade = count($veiculos);
?>

<?php if ($quantidade > 0): ?>
  <div class="flex flex-row justify-between items-center gap-2">
    <span class="text-xl font-semibold"><?php
                                        if ($quantidade == 0) {
                                          echo "Nenhum veículo cadastrado";
                                        } else {
                                          echo $quantidade . " " . ($quantidade > 1 ? "Veículos" : "Veículo");
                                        }
                                        ?></span>

    <div class="flex flex-row items-center justify-between gap-2">
      <a href="/<?= BASE_DIR_NAME ?>/veiculo/cadastrar" class="button small flex flex-row items-center">
        <i class="fa-solid fa-plus mt-[1px]"></i>
        <span>Novo Veículo</span>
      </a>
    </div>
  </div>

  <div class="flex flex-col gap-5 pt-5">
    <?php foreach ($veiculos as $index => $veiculo) : ?>
      <div class="flex flex-row flex-wrap justify-between p-8 border border-gray-300 rounded-xl gap-4">
        <div class="flex flex-row">
          <div class="flex flex-row items-center justify-center h-12 w-12 border border-gray-300 rounded-4xl">
            <i class="fa-solid fa-car"></i>
          </div>
          <div class="flex flex-col pl-3">
            <span class="text-lg font-semibold"><?= $veiculo->apelido ?></span>
            <span class="text-sm"><?= $veiculo->fabricante . " - " . $veiculo->modelo . " - " . $veiculo->ano ?></span>
          </div>
        </div>

        <div class="flex flex-row">
          <div class="flex flex-row gap-4">
            <div class="flex flex-col border border-dashed border-gray-300 rounded-xl px-2 py-1 min-w-24 max-w-auto gap-1">
              <span class="text-sm font-semibold"><?= $veiculo->fabricante ?></span>
              <span class="text-xs text-gray-700">Fabricante</span>
            </div>

            <div class="flex flex-col border border-dashed border-gray-300 rounded-xl px-2 py-1 min-w-24 max-w-auto gap-1">
              <span class="text-sm font-semibold"><?= $veiculo->modelo ?></span>
              <span class="text-xs text-gray-700">Modelo</span>
            </div>

            <div class="flex flex-col border border-dashed border-gray-300 rounded-xl px-2 py-1 min-w-24 max-w-auto gap-1">
              <span class="text-sm font-semibold"><?= $veiculo->ano ?></span>
              <span class="text-xs text-gray-700">Ano</span>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="flex flex-col items-center justify-center pt-20">
    <i class="text-primary text-6xl fa-solid fa-car mb-4"></i>
    <span class="text-lg font-semibold mb-4">Você ainda não tem veículos adicionados ao seu perfil</span>

    <a href="/<?= BASE_DIR_NAME ?>/veiculo/cadastrar" class="button flex flex-row items-center gap-1.5">
      <i class="fa-solid fa-plus mt-[2px]"></i>
      <span>Novo Veículo</span>
    </a>
  </div>
<?php endif; ?>