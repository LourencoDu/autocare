<?php
require_once '../Controller/PrestadorController.php';


$prestadorController = new PrestadorController();
$prestadores = $prestadorController->listar(); // Busca todos os prestadores

// Função para converter CEP em coordenadas usando Nominatim
function getCoordinatesFromCEP($cep) {
    $cep = urlencode($cep);
    $url = "https://nominatim.openstreetmap.org/search?postalcode={$cep}&country=Brazil&format=json";

    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: MyOpenLayersApp/1.0\r\n"
        ]
    ];
    $context = stream_context_create($opts);

    $response = file_get_contents($url, false, $context);
    if ($response === FALSE) {
        return null;
    }

    $data = json_decode($response, true);
    if (!empty($data)) {
        return [
            'lat' => $data[0]['lat'],
            'lon' => $data[0]['lon']
        ];
    }

    return null;
}

// Montar array de marcadores
$marcadores = [];

foreach ($prestadores as $prestador) {
    $cep = $prestador['endereco_cep'];
    $nome = $prestador['nome'];

    $coords = getCoordinatesFromCEP($cep);

    if ($coords) {
        $marcadores[] = [
            'nome' => $nome,
            'lat' => $coords['lat'],
            'lon' => $coords['lon']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Mapa de Prestadores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@6.15.1/ol.css">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
        }
        #map {
            height: 100%;
            width: 100%;
        }
    </style>
</head>
<body>

<div id="map"></div>

<script src="https://cdn.jsdelivr.net/npm/ol@6.15.1/ol.js"></script>
<script>
const marcadores = <?php echo json_encode($marcadores); ?>;

const map = new ol.Map({
    target: 'map',
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM()
        })
    ],
    view: new ol.View({
        center: ol.proj.fromLonLat([-51.9253, -14.2350]), // Centro aproximado do Brasil
        zoom: 4
    })
});

marcadores.forEach(marcador => {
    const feature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat([parseFloat(marcador.lon), parseFloat(marcador.lat)])),
        name: marcador.nome
    });

    const layer = new ol.layer.Vector({
        source: new ol.source.Vector({
            features: [feature]
        }),
        style: new ol.style.Style({
            image: new ol.style.Circle({
                radius: 6,
                fill: new ol.style.Fill({color: 'blue'}),
                stroke: new ol.style.Stroke({color: 'white', width: 2})
            }),
            text: new ol.style.Text({
                text: marcador.nome,
                offsetY: -15,
                fill: new ol.style.Fill({ color: '#000' }),
                stroke: new ol.style.Stroke({ color: '#fff', width: 2 })
            })
        })
    });

    map.addLayer(layer);
});
</script>

</body>
</html>
