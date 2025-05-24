<?php

use AutoCare\Helper\Util;

$usuario = $_SESSION["usuario"];
$tipo = $usuario->tipo;

$infos = array();

array_push($infos, [
  "label" => $tipo == "prestador" ? "Nome Empresarial" : "Nome",
  "value" => $usuario->nome
]);

if ($tipo != "prestador") {
  array_push($infos, [
    "label" => "Sobrenome",
    "value" => $usuario->sobrenome
  ]);
} else {
  array_push($infos, [
    "label" => "CNPJ",
    "value" => Util::formatarCnpj($usuario->prestador->documento ?? "")
  ]);
}

array_push(
  $infos,
  [
    "label" => "Telefone",
    "value" => Util::formatarTelefone($usuario->telefone ?? "")
  ],
  [
    "label" => "E-mail",
    "value" => $usuario->email
  ],
  [
    "label" => "Senha",
    "value" => "********"
  ]
);

?>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
  <div class="flex flex-col col-span-1">
    <div class="flex flex-col pb-4 overflow-x-auto col-span-1">
      <div class="flex flex-col border border-gray-300 rounded-xl">
        <div class="flex flex-row items-center h-14 px-5 border-b border-gray-300">
          <span class="text-lg font-semibold">Informações da Conta</span>
        </div>
        <div class="overflow-x-auto">
          <table class="border-collapse w-full">
            <tbody>
              <?php foreach ($infos as $index => $info) : ?>
                <tr class="<?= count($infos) - 1 == $index ? "" : "border-b"; ?> border-gray-300">
                  <td class="min-w-10 sm:min-w-20 px-5 py-2 text-gray-600 text-base/10 whitespace-nowrap"><?= $info["label"] ?></td>

                  <td class="min-w-40 sm:min-w-80 px-5 py-2 text-gray-700 text-base/10 flex items-center justify-between">
                    <span><?= $info["value"] ?></span>
                  </td>

                  <td class="min-w-10 sm:min-w-20 px-5 py-2 text-end">
                    <?php if ($info["label"] === "Senha") : ?>
                      <button id="button-alterar-senha" class="button small text-nowrap">
                        Alterar Senha
                      </button>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php
    if ($tipo == "funcionario") {
      require COMPONENTS . "/MeuPerfil/PrestadorInfo/index.php";
    }
    ?>
  </div>

  <?php
  if ($tipo == "prestador" || $tipo == "funcionario") {
    require COMPONENTS . "/MeuPerfil/Localizacao/index.php";
  }
  ?>

  <?php
  if ($tipo == "prestador" || $tipo == "funcionario") {
    require COMPONENTS . "/MeuPerfil/Catalogo/index.php";
  }
  ?>


</div>