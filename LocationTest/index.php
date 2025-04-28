<!DOCTYPE html>
<html lang="en">
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
            height: 100%;
            width: 100%;
        }
    </style>
</head>
<body>

<div id="map"></div>

<script src="https://openlayers.org/en/v6.15.1/build/ol.js"></script>
<script>
// Initialize map
const map = new ol.Map({
    target: 'map',
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM()
        })
    ],
    view: new ol.View({
        center: ol.proj.fromLonLat([-51.9253, -14.2350]), // Center of Brazil
        zoom: 4
    })
});

// Fetch prestadores and add markers
fetch('MapController.php')
    .then(response => {
        // First check the raw response text
        return response.text().then(text => {
            console.log("Raw response:", text);
            return JSON.parse(text); // This will throw the error we're seeing
        });
    })
    .then(data => {
        // Your existing processing code
    })
    .catch(error => {
        console.error('Error details:', error);
    });
fetch('MapController.php')
    .then(response => response.json())
    .then(data => {
        data.forEach(prestador => {
            const marker = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat([parseFloat(prestador.lon), parseFloat(prestador.lat)])),
                name: prestador.nome
            });

            marker.setStyle(new ol.style.Style({
                image: new ol.style.Icon({
                    anchor: [0.5, 1],
                    src: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                    scale: 0.05
                }),
                text: new ol.style.Text({
                    text: prestador.nome,
                    offsetY: -25,
                    fill: new ol.style.Fill({ color: '#000' }),
                    stroke: new ol.style.Stroke({ color: '#fff', width: 2 })
                })
            }));

            const vectorSource = new ol.source.Vector({
                features: [marker]
            });

            const markerLayer = new ol.layer.Vector({
                source: vectorSource
            });

            map.addLayer(markerLayer);
        });
    })
    .catch(error => {
        console.error('Erro ao carregar os prestadores:', error);
    });
</script>

</body>
</html>