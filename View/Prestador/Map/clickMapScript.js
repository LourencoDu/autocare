let selectedLat = null;
let selectedLon = null;

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

// Handle map click to set marker
map.on('click', function(event) {
    const coord = ol.proj.toLonLat(event.coordinate);
    selectedLon = coord[0];
    selectedLat = coord[1];

    console.log("Latitude:", selectedLat, "Longitude:", selectedLon);

    // Remove previous marker if exists
    if (window.clickLayer) {
        map.removeLayer(window.clickLayer);
    }

    const marker = new ol.Feature({
        geometry: new ol.geom.Point(event.coordinate)
    });

    marker.setStyle(new ol.style.Style({
        image: new ol.style.Icon({
            anchor: [0.5, 1],
            src: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
            scale: 0.05
        })
    }));

    const vectorSource = new ol.source.Vector({
        features: [marker]
    });

    window.clickLayer = new ol.layer.Vector({
        source: vectorSource
    });

    map.addLayer(window.clickLayer);
});

// Handle Save Button Click
document.addEventListener('DOMContentLoaded', () => {
    const saveButton = document.getElementById('saveLocation');

    if (saveButton) {
        saveButton.addEventListener('click', async () => {
            if (selectedLat === null || selectedLon === null) {
                showSnackbar('Por favor, clique no mapa para selecionar uma localização.');
                return;
            }

    try {
    const response = await fetch('mapaclick/save', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            latitude: selectedLat,
            longitude: selectedLon
        })
    });

    const text = await response.text();
    console.log('Response text:', text); // Debug response

    let data;
    try {
        data = JSON.parse(text);
    } catch (e) {
        console.error('JSON parse error:', e);
        showSnackbar('Resposta inválida do servidor.');
        return;
    }

    if (data.success) {
        showSnackbar("Salvo com sucesso!");
    } else {
        showSnackbar("Erro ao salvar: " + data.message);
    }

} catch (error) {
    console.error("Erro na requisição:", error);
    showSnackbar("Erro na conexão ou no servidor.");
}
        });
    }
});
