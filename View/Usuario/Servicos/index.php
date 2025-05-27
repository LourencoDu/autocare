<?php

use AutoCare\Helper\Util;

$servicos = $data["servicos"];
$quantidade = count($servicos);
?>

<?php if ($quantidade > 0): ?>
  <div class="flex flex-row justify-between items-center gap-2">
    <span class="text font-semibold">
      <?php
      if ($quantidade == 0) {
        echo "Nenhum serviço cadastrado";
      } else {
        echo "Você tem <span class='text-primary'>" . $quantidade . "</span> " . ($quantidade > 1 ? "serviços cadastrados" : "serviço cadastrado");
      }
      ?>
    </span>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 pt-5 gap-5">
    <?php foreach ($servicos as $index => $servico) : ?>
      <?php
      $prestador = $servico->prestador;

      $veiculo = $servico->veiculo;
      $veiculo_modelo = $veiculo->modelo;
      $veiculo_fabricante = $veiculo->fabricante;
      $veiculo_label = $veiculo_fabricante->nome." ".$veiculo_modelo->nome." (".$veiculo->apelido.")";

      $infos = array();
      array_push($infos, ["label" => "Prestador:", "value" => "<a class='hover:text-primary transition' href='/" . BASE_DIR_NAME . "/prestador?id=" . $prestador->id . "'>" . $prestador->usuario->nome . "</a>"]);
      array_push($infos, ["label" => "Veículo:", "value" => $veiculo_label]);
      array_push($infos, ["label" => "Início:", "value" => Util::formatarDataHora($servico->data_inicio)]);
      array_push($infos, ["label" => "Finalização:", "value" => $servico->data_fim ? Util::formatarDataHora($servico->data_fim) : "<span class='text-orange-700'>Não finalizado</span>"]);
      ?>
      <div class="flex flex-col flex-1 col-span-1 border border-gray-300 rounded-xl gap-4">
        <div class="flex items-center justify-between border-b border-gray-300 h-14 px-5">
          <span class="text-lg font-semibold">Serviço #<?= $servico->id; ?></span>

          <?php 
              $situacao = "EM_ANDAMENTO";
              $situacao_cores = [
                "AGENDADA" => "gray",
                "EM_ANDAMENTO" => "yellow",
                "CANCELADO" => "red",
                "FINALIZADO" => "green"
              ];
              $situacao_cor = $situacao_cores[$situacao];
          ?>
          <div class="<?= "flex items-center justify-center px-2 bg-".$situacao_cor."-200 border border-".$situacao_cor."-300 rounded-md" ?>">
            <span class="<?= "text-sm font-medium text-".$situacao_cor."-700" ?>">Em andamento</span>
          </div>
        </div>

        <?php foreach ($infos as $info_index => $info) : ?>
          <div class="flex items-center px-5">
            <span class="text-gray-700 w-full max-w-[96px]"><?= $info["label"] ?></span>
            <span class=""><?= $info["value"] ?></span>
          </div>
        <?php endforeach; ?>

        <div class="flex flex-1 px-5">
          <p><?= nl2br($servico->descricao); ?></p>
        </div>

        <div class="flex justify-between items-center border-t border-gray-300 h-14 px-5">
          <div></div>
          <button class="button small">Avaliar Serviço</button>
        </div>
      </div>


    <?php endforeach; ?>
  </div>
<?php endif; ?>