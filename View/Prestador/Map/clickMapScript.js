// map.js

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
        center: ol.proj.fromLonLat([-51.9253, -14.2350]), 
        zoom: 4
    })
});

map.on('click', function(event) {
    const coord = ol.proj.toLonLat(event.coordinate);
    selectedLon = coord[0];
    selectedLat = coord[1];

    console.log("Latitude:", selectedLat, "Longitude:", selectedLon);

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
