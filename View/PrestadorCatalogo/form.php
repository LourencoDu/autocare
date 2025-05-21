<?php
$especialidades = array();
if (isset($data["especialidades"])) {
  $especialidades = $data["especialidades"];
}

$titulo = "";
$descricao = "";
$id_especialidade = "";

$action = $data["action"] ?? "adicionar";

if (isset($data["form"])) {
  $titulo = $data["form"]["titulo"] ?? "";
  $descricao = $data["form"]["descricao"] ?? "";
  $id_especialidade = $data["form"]["id_especialidade"] ?? "";
}
?>

<div class="flex flex-col border border-gray-300 rounded-xl">
  <div class="flex flex-row items-center h-14 px-5 border-b border-gray-300">
    <span class="text-lg font-semibold">Informações do Serviço</span>
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
      <label for="id_especialidade">Especialidade <span class="text-red-500">*</span></label>
      <div class="flex flex-col w-full">
        <div class="grid w-full">
          <select required class="col-start-1 row-start-1" id="select_especialidade" name="id_especialidade" value="<?= $id_especialidade ?>">
            <option <?= $id_especialidade ? "" : "selected" ?> value="">Selecione</option>
            <?php foreach ($especialidades as $index => $fabricante) : ?>
              <option <?= $fabricante->id == $id_especialidade ? "selected" : "" ?> value="<?= $fabricante->id ?>"><?= $fabricante->nome ?></option>
            <?php endforeach; ?>
          </select>
          <i class="fa-solid fa-chevron-down text-gray-400 text-sm pointer-events-none relative right-4 z-10 col-start-1 row-start-1 h-3 w-4 self-center justify-self-end forced-colors:hidden"></i>
        </div>
      </div>
    </div>

    <div class="flex flex-row items-center justify-end pt-2.5 gap-2">
      <a href="/<?= BASE_DIR_NAME ?>/meu-perfil" class="flex flex-row items-center button ghost medium"><?= $action == "adicionar" ? "Voltar" : "Cancelar alterações" ?></a>
      <button class="button medium"><?= $action == "adicionar" ? "Adicionar Serviço ao Catálogo" : "Salvar alterações" ?></button>
    </div>
  </form>
</div>