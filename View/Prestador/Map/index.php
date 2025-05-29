<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Mapa de Prestadores</title>
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
        #especialidadeDropdown {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            background: white;
            min-width: 200px;
        }
    </style>
</head>
<body>
    <div>
    <select id="especialidadeDropdown">
        <option value="">Selecione uma especialidade</option>
    </select>
    </div>
    <div id="map"></div>

    <script src="https://openlayers.org/en/v6.15.1/build/ol.js"></script>
    <script>
        // Configurações iniciais
        const especialidades = [
            { id: 33, nome: 'Mecânica Geral' },
            { id: 34, nome: 'Troca de Óleo' },
            { id: 35, nome: 'Alinhamento e Balanceamento' },
            { id: 36, nome: 'Revisão Preventiva' },
            { id: 37, nome: 'Freios e Suspensão' },
            { id: 38, nome: 'Injeção Eletrônica' },
            { id: 39, nome: 'Ar-condicionado' },
            { id: 40, nome: 'Elétrica Automotiva' },
            { id: 41, nome: 'Funilaria e Pintura' },
            { id: 42, nome: 'Inspeção Veicular' },
            { id: 43, nome: 'Higienização Interna' },
            { id: 44, nome: 'Instalação de Acessórios' },
            { id: 45, nome: 'Diagnóstico Eletrônico' },
            { id: 46, nome: 'Polimento e Estética' },
            { id: 47, nome: 'Troca de Pneus' },
            { id: 48, nome: 'Outra' }
        ];

        // Inicialização do mapa
        const map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([-51.9253, -14.2350]),
                zoom: 4
            })
        });

        // Variáveis globais
        let prestadoresData = [];
        let markerLayer = null;
        let circleLayer = null;
        const dropdown = document.getElementById('especialidadeDropdown');

        // Preenche dropdown de especialidades
        especialidades.forEach(especialidade => {
            const option = document.createElement('option');
            option.value = especialidade.id;
            option.textContent = especialidade.nome;
            dropdown.appendChild(option);
        });

        // Carrega dados dos prestadores
        fetch('/autocare/mapa/json')
            .then(response => {
                if (!response.ok) throw new Error('Erro na rede');
                return response.json();
            })
            .then(data => {
                prestadoresData = data;
                plotPrestadores(data);
            })
            .catch(error => {
                console.error('Erro ao carregar prestadores:', error);
                alert('Erro ao carregar dados. Verifique o console.');
            });

        // Função para plotar prestadores no mapa
        function plotPrestadores(data, centerCoord = null, especialidadeId = "") {
            if (markerLayer) map.removeLayer(markerLayer);

            const features = [];
            
            data.forEach(prestador => {
                // Filtro por especialidade
                if (especialidadeId && prestador.especialidades) {
                    if (!prestador.especialidades.includes(parseInt(especialidadeId))) {
                        return;
                    }
                }

                const lon = parseFloat(prestador.lon);
                const lat = parseFloat(prestador.lat);
                const coord = ol.proj.fromLonLat([lon, lat]);

                let distanceLabel = prestador.nome || '';
                let showMarker = true;

                // Filtro por distância
                if (centerCoord) {
                    const clickLonLat = ol.proj.toLonLat(centerCoord);
                    const prestadorLonLat = [lon, lat];
                    const distance = ol.sphere.getDistance(clickLonLat, prestadorLonLat);
                    
                    if (distance > 100000) { // 100km
                        showMarker = false;
                    } else {
                        distanceLabel += `\n${(distance / 1000).toFixed(2)} km`;
                    }
                }

                if (showMarker) {
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
                            stroke: new ol.style.Stroke({ color: '#fff', width: 2 })
                        })
                    }));

                    features.push(marker);
                }
            });

            markerLayer = new ol.layer.Vector({
                source: new ol.source.Vector({ features })
            });
            map.addLayer(markerLayer);
        }

        // Evento de clique no mapa
        map.on('click', function(evt) {
            // Remove círculo anterior
            if (circleLayer) map.removeLayer(circleLayer);

            // Cria novo círculo
            const circleFeature = new ol.Feature(
                new ol.geom.Circle(evt.coordinate, 100000)
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

            circleLayer = new ol.layer.Vector({
                source: new ol.source.Vector({ features: [circleFeature] })
            });
            map.addLayer(circleLayer);

            // Filtra prestadores
            plotPrestadores(
                prestadoresData,
                evt.coordinate,
                dropdown.value
            );
        });

        // Evento de mudança no dropdown
        dropdown.addEventListener('change', () => {
            if (circleLayer) {
                map.removeLayer(circleLayer);
                circleLayer = null;
            }
            plotPrestadores(prestadoresData, null, dropdown.value);
        });
    </script>
</body>
</html>