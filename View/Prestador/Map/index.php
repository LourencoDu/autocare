<link rel="stylesheet" href="https://openlayers.org/en/v6.15.1/css/ol.css">

<style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
        }
        #map {
            height: 100vh;
            width: 100%;
        }
    </style>

<div id="map"></div>

<script src="https://openlayers.org/en/v6.15.1/build/ol.js"></script>
<script>
// Inicializa o mapa
const map = new ol.Map({
    target: 'map',
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM()
        })
    ],
    view: new ol.View({
        center: ol.proj.fromLonLat([-51.9253, -14.2350]), // Centro do Brasil
        zoom: 4
    })
});

let prestadoresData = [];
let markerLayer = null;
let circleLayer = null;

// Carrega os prestadores do backend
fetch('/autocare/mapa/json')
    .then(response => response.json())
    .then(data => {
        prestadoresData = data;
        plotPrestadores(data);
    })
    .catch(error => {
        console.error('Erro ao carregar os prestadores:', error);
    });

// Função que plota os prestadores, filtrando se for passado centro e raio
function plotPrestadores(data, centerCoord = null) {
    if (markerLayer) {
        map.removeLayer(markerLayer);
    }

    const features = [];

    data.forEach(prestador => {
        const lon = parseFloat(prestador.lon);
        const lat = parseFloat(prestador.lat);
        const coord = ol.proj.fromLonLat([lon, lat]);

        let distanceLabel = prestador.nome || '';

        if (centerCoord) {
            // Converte as coordenadas para lon/lat WGS84
            const clickLonLat = ol.proj.toLonLat(centerCoord);
            const prestadorLonLat = [lon, lat];

            // Calcula a distância em metros usando ol.sphere.getDistance
            const distance = ol.sphere.getDistance(clickLonLat, prestadorLonLat);

            if (distance > 100000) {
                // Se estiver fora do raio de 100km, pula esse prestador
                return;
            }

            distanceLabel += `\n${(distance / 1000).toFixed(2)} km`;
        }

        const marker = new ol.Feature({
            geometry: new ol.geom.Point(coord),
            name: distanceLabel
        });

        marker.setStyle(new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                src: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                scale: 0.05
            }),
            text: new ol.style.Text({
                text: distanceLabel,
                offsetY: -25,
                fill: new ol.style.Fill({ color: '#000' }),
                stroke: new ol.style.Stroke({ color: '#fff', width: 2 }),
                overflow: true
            })
        }));

        features.push(marker);
    });

    const vectorSource = new ol.source.Vector({
        features: features
    });

    markerLayer = new ol.layer.Vector({
        source: vectorSource
    });

    map.addLayer(markerLayer);
}

// Evento de clique: desenha o círculo e filtra prestadores dentro dele
map.on('click', function (evt) {
    const clickCoord = evt.coordinate;

    // Remove camada de círculo anterior se existir
    if (circleLayer) {
        map.removeLayer(circleLayer);
    }

    // Cria e estiliza o círculo de 100 km (100000 metros)
    const circleFeature = new ol.Feature(
        new ol.geom.Circle(clickCoord, 100000)
    );

    circleFeature.setStyle(new ol.style.Style({
        stroke: new ol.style.Stroke({
            color: 'rgba(0, 0, 255, 0.8)',
            width: 2
        }),
        fill: new ol.style.Fill({
            color: 'rgba(0, 0, 255, 0.1)'
        })
    }));

    const circleSource = new ol.source.Vector({
        features: [circleFeature]
    });

    circleLayer = new ol.layer.Vector({
        source: circleSource
    });

    map.addLayer(circleLayer);

    // Re-plota os prestadores filtrando pelo círculo
    plotPrestadores(prestadoresData, clickCoord);
});
</script>

</body>
</html>