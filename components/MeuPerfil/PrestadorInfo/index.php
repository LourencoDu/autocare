<?php

use AutoCare\Helper\Util;
use AutoCare\Model\Prestador;

$usuario = $_SESSION["usuario"];
$tipo = $usuario->tipo;
$prestador = Prestador::getById($usuario->prestador->id);
$usuario_prestador = $prestador->usuario;

$infos = array(
  [
    "label" => "Nome Empresarial",
    "value" => $usuario_prestador->nome
  ],
  [
    "label" => "CNPJ",
    "value" => Util::formatarCnpj($prestador->documento ?? "")
  ]
);
?>

<?php if ($tipo == "funcionario") : ?>
  <div class="flex flex-col pb-4 overflow-x-auto col-span-1">
    <div class="flex flex-col border border-gray-300 rounded-xl">
      <div class="flex flex-row items-center h-14 px-5 border-b border-gray-300">
        <span class="text-lg font-semibold">Informações da Empresa</span>
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
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php endif; ?>