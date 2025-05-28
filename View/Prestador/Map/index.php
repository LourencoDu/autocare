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

<select id="especialidadeDropdown">
  <option value="">Selecione uma especialidade</option>
</select>

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

// Função que plota os prestadores, filtrando por especialidade e opcionalmente por centro e raio
function plotPrestadores(data, centerCoord = null, especialidadeId = "") {
    if (markerLayer) {
        map.removeLayer(markerLayer);
    }

    const features = [];

    data.forEach(prestador => {
        // Filtra por especialidade, se selecionada
        if (especialidadeId && prestador.id_especialidade != especialidadeId) {
            return;
        }

        const lon = parseFloat(prestador.lon);
        const lat = parseFloat(prestador.lat);
        const coord = ol.proj.fromLonLat([lon, lat]);

        let distanceLabel = prestador.nome || '';

        if (centerCoord) {
            const clickLonLat = ol.proj.toLonLat(centerCoord);
            const prestadorLonLat = [lon, lat];

            const distance = ol.sphere.getDistance(clickLonLat, prestadorLonLat);

            if (distance > 100000) {
                return; // Fora do raio de 100 km
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

// Clique no mapa: desenha círculo e filtra prestadores no raio
map.on('click', function (evt) {
    const clickCoord = evt.coordinate;

    // Remove camada de círculo anterior
    if (circleLayer) {
        map.removeLayer(circleLayer);
    }

    // Cria o círculo de 100 km
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

    // Pega o valor selecionado no dropdown para filtrar por especialidade
    const selectedEspecialidade = dropdown.value;

    // Plota prestadores filtrando pelo círculo e especialidade
    plotPrestadores(prestadoresData, clickCoord, selectedEspecialidade);
});

const especialidades = [
  { id: 17, nome: 'Mecânica Geral' },
  { id: 18, nome: 'Troca de Óleo' },
  { id: 19, nome: 'Alinhamento e Balanceamento' },
  { id: 20, nome: 'Revisão Preventiva' },
  { id: 21, nome: 'Freios e Suspensão' },
  { id: 22, nome: 'Injeção Eletrônica' },
  { id: 23, nome: 'Ar-condicionado' },
  { id: 24, nome: 'Elétrica Automotiva' },
  { id: 25, nome: 'Funilaria e Pintura' },
  { id: 26, nome: 'Inspeção Veicular' },
  { id: 27, nome: 'Higienização Interna' },
  { id: 28, nome: 'Instalação de Acessórios' },
  { id: 29, nome: 'Diagnóstico Eletrônico' },
  { id: 30, nome: 'Polimento e Estética' },
  { id: 31, nome: 'Troca de Pneus' },
  { id: 32, nome: 'Outra' }
];

const dropdown = document.getElementById('especialidadeDropdown');

especialidades.forEach(especialidade => {
  const option = document.createElement('option');
  option.value = especialidade.id;
  option.textContent = especialidade.nome;
  dropdown.appendChild(option);
});

// Quando muda a especialidade: remove filtro de raio e plota só pela especialidade
dropdown.addEventListener('change', () => {
    const selectedEspecialidade = dropdown.value;

    // Remove o círculo, se existir
    if (circleLayer) {
        map.removeLayer(circleLayer);
        circleLayer = null;
    }

    // Plota sem filtro de raio, apenas por especialidade
    plotPrestadores(prestadoresData, null, selectedEspecialidade);
});
</script>
