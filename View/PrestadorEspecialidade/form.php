<?php
$fabricantes = array();
if (isset($data["fabricantes"])) {
  $fabricantes = $data["fabricantes"];
}

$titulo = "";
$descricao = "";
$id_fabricante_veiculo = "";

$action = $data["action"] ?? "adicionar";

if (isset($data["form"])) {
  $titulo = $data["form"]["titulo"] ?? "";
  $descricao = $data["form"]["descricao"] ?? "";
  $id_fabricante_veiculo = $data["form"]["id_fabricante_veiculo"] ?? "";
}
?>

<div class="flex flex-col border border-gray-300 rounded-xl">
  <div class="flex flex-row items-center h-14 px-5 border-b border-gray-300">
    <span class="text-lg font-semibold">Informações da Especialidade</span>
  </div>
  <form action="" method="post" class="flex flex-col p-5 gap-5">
    <div class="form-control row medium flex-col sm:flex-row">
      <label for="titulo">Título <span class="text-red-500">*</span></label>
      <input required type="text" name="titulo" placeholder="ex.: Pintura" maxlength="40" value="<?= $titulo ?>" />
    </div>

    <div class="form-control row medium flex-col sm:flex-row">
      <label for="descricao">Descrição <span class="text-red-500">*</span></label>
      <textarea required type="text" name="descricao" placeholder="ex.: Pintura profissional em carros de luxo" maxlength="200" rows="5" cols="20"><?= e($descricao) ?></textarea>
    </div>

    <div class="form-control row medium flex-col sm:flex-row">
      <label for="id_fabricante_veiculo">Fabricante <span class="text-gray-500 font-normal">(Opcional)</span></label>
      <div class="flex flex-col w-full">
        <div class="grid w-full">
          <select class="col-start-1 row-start-1" id="select_fabricante_veiculo" name="id_fabricante_veiculo" value="<?= $id_fabricante_veiculo ?>">
            <option <?= $id_fabricante_veiculo ? "" : "selected" ?> value="">Selecione</option>
            <?php foreach ($fabricantes as $index => $fabricante) : ?>
              <option <?= $fabricante->id == $id_fabricante_veiculo ? "selected" : "" ?> value="<?= $fabricante->id ?>"><?= $fabricante->nome ?></option>
            <?php endforeach; ?>
          </select>
          <i class="fa-solid fa-chevron-down text-gray-400 text-sm pointer-events-none relative right-4 z-10 col-start-1 row-start-1 h-3 w-4 self-center justify-self-end forced-colors:hidden"></i>
        </div>
        <span class="helper-text">Escolha caso a especialidade seja referente a um fabricante de veículos em específico.</span>
      </div>
    </div>

    <div class="flex flex-row items-center justify-end pt-2.5 gap-2">
      <a href="/<?= BASE_DIR_NAME ?>/meu-perfil" class="flex flex-row items-center button ghost medium"><?= $action == "adicionar" ? "Voltar" : "Cancelar alterações" ?></a>
      <button class="button medium"><?= $action == "adicionar" ? "Adicionar Especialidade" : "Salvar alterações" ?></button>
    </div>
  </form>
</div>