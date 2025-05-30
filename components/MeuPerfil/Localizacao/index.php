<?php
  $usuario = $_SESSION["usuario"];
  $tipo = $usuario->tipo;
?>
<head>
    <meta charset="UTF-8">
    <title>Click Map to Save Coordinates</title>
    <link rel="stylesheet" href="https://openlayers.org/en/v6.15.1/css/ol.css">
    <style>
        #map {
            height: 100%;
            width: 100%;
        }
    </style>
</head>


<div class="flex flex-col pb-4 overflow-x-auto col-span-1 min-h-[200px]">
  <div class="flex flex-1 flex-col border border-gray-300 rounded-xl justify-between">
    <div class="flex flex-row items-center h-14 px-5 border-b border-gray-300">
             

      <span class="text-lg font-semibold">Localização da Empresa</span>
    </div>
    <div class="flex flex-1 items-center justify-center">
     
       <div id="map"></div>
    </div>
    <?php if($tipo == "prestador") : ?>
      <div class="flex flex-row-reverse items-center h-14 px-5 border-t border-gray-300">
        <script src="https://openlayers.org/en/v6.15.1/build/ol.js"></script>
        <script src="View\Prestador\Map\clickMapScript.js"></script>


      <button id="saveLocation" class="button small">Salvar localização</button>
    </div>
    <?php endif; ?>

  </div>
</div>