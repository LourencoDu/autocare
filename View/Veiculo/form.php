<?php
  $fabricantes = array();
  if(isset($data["fabricantes"])) {
    $fabricantes = $data["fabricantes"];
  }

  $modelos = array();
  if(isset($data["modelos"])) {
    $modelos = $data["modelos"];
  }

  $ano = "";
  $apelido = "";

  $id_modelo_veiculo = "";
  $id_fabricante_veiculo = "";

  $action = $data["action"] ?? "adicionar";

  if (isset($data["form"])) {
    $ano = $data["form"]["ano"] ?? "";
    $apelido = $data["form"]["apelido"] ?? "";
    $id_modelo_veiculo = $data["form"]["id_modelo_veiculo"] ?? "";
    $id_fabricante_veiculo = $data["form"]["id_fabricante_veiculo"] ?? "";
  }
?>

<div class="flex flex-col border border-gray-300 rounded-xl">
  <div class="flex flex-row items-center h-14 px-5 border-b border-gray-300">
    <span class="text-lg font-semibold">Informações do Veículo</span>
  </div>
  <form action="" method="post" class="flex flex-col p-5 gap-5">
    <div class="form-control row medium">
      <label for="apelido">Apelido <span class="text-red-500">*</span></label>
      <input required type="text" name="apelido" placeholder="ex.: Meu Corsa Azul" maxlength="60" value="<?= $apelido ?>"/>
    </div>

    <div class="form-control row medium">
      <label for="ano">Ano de Fabricação <span class="text-red-500">*</span></label>
      <input required type="number" name="ano" placeholder="ex.: 2009" min="1900" max="2099" oninput="limitarDigitos(this, 4)" value="<?= $ano ?>"/>
    </div>

    <div class="form-control row medium">
      <label for="id_fabricante_veiculo">Fabricante <span class="text-red-500">*</span></label>
      <div class="grid w-full">
        <select required class="col-start-1 row-start-1" id="select_fabricante_veiculo" name="id_fabricante_veiculo" value="<?= $id_fabricante_veiculo ?>">
          <option disabled <?= $id_fabricante_veiculo ? "" : "selected" ?> value="">Selecione</option>  
        <?php foreach ($fabricantes as $index => $fabricante) : ?>
            <option <?= $fabricante->id == $id_fabricante_veiculo ? "selected" : "" ?> value="<?= $fabricante->id ?>"><?= $fabricante->nome ?></option>
          <?php endforeach; ?>
        </select>
        <i class="fa-solid fa-chevron-down text-gray-400 text-sm pointer-events-none relative right-4 z-10 col-start-1 row-start-1 h-3 w-4 self-center justify-self-end forced-colors:hidden"></i>
      </div>
    </div>

    <div class="form-control row medium">
      <label for="id_modelo_veiculo">Modelo <span class="text-red-500">*</span></label>
      <div class="grid w-full">
        <select <?= $id_modelo_veiculo ? "" : "disabled" ?> required class="col-start-1 row-start-1 disabled:opacity-40" id="select_modelo_veiculo" name="id_modelo_veiculo" value="<?= $id_modelo_veiculo ?>">
        <option disabled <?= $id_modelo_veiculo ? "" : "selected" ?> value="">Selecione</option> 
        <?php foreach ($modelos as $index => $modelo) : ?>
            <option <?= $modelo->id == $id_modelo_veiculo ? "selected" : "" ?> value="<?= $modelo->id ?>"><?= $modelo->nome ?></option>
          <?php endforeach; ?>
        </select>
        <i class="fa-solid fa-chevron-down text-gray-400 text-sm pointer-events-none relative right-4 z-10 col-start-1 row-start-1 h-3 w-4 self-center justify-self-end forced-colors:hidden"></i>
      </div>
    </div>

    <div class="flex flex-row items-center justify-end pt-2.5 gap-2">
      <a href="." class="flex flex-row items-center button ghost medium"><?= $action == "adicionar" ? "Voltar" : "Cancelar alterações" ?></a>
      <button class="button medium"><?= $action == "adicionar" ? "Adicionar Veículo" : "Salvar alterações" ?></button>
    </div>
  </form>
</div>