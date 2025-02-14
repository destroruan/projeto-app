mapboxgl.accessToken = 'pk.eyJ1IjoicnVhbmRlc3RybyIsImEiOiJjbTc0b2twZzEwM2doMmpwamFiZmM3b3YwIn0.1NbR8n9KE2q33Dl56F0voA';
const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [-43.2859, -22.5848],
    zoom: 15
});

let geojsonData = null;
let markers = [];

function getUserLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            position => {
                console.log(position);
                const { latitude, longitude } = position.coords;
                document.getElementById('start').value = `${latitude},${longitude}`;
            },
            error => {
                console.warn('Erro ao obter localização:', error);
                if (error.code === error.PERMISSION_DENIED) {
                    alert("Permissão de localização negada. Ative a localização nas configurações.");
                }
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    } else {
        alert('Geolocalização não suportada pelo navegador.');
    }
}

getUserLocation();

async function loadGeoJSON() {
    const response = await fetch('controller/gjson/locais.geojson');
    geojsonData = await response.json();
    console.log('GeoJSON Carregado:', geojsonData);
    document.getElementById('traceButton').disabled = false;
}
loadGeoJSON();

function findLocation() {
    const startValue = document.getElementById('start').value.trim();
    const endValue = document.getElementById('end').value.trim();

    if (!startValue || !endValue) {
        alert("Por favor, preencha ambos os campos.");
        return;
    }

    removeMarkers();

    let startCoords = parseCoordinates(startValue);
    if (!startCoords) {
        startCoords = findInGeoJSON(startValue);
        if (!startCoords) {
            alert('Local de origem não encontrado.');
            return;
        }
    }

    let endCoords = findInGeoJSON(endValue);
    if (!endCoords) {
        alert('Local de destino não encontrado.');
        return;
    }

    placeMarker(startCoords, 'blue');
    placeMarker(endCoords, 'red');
    getRoute(startCoords, endCoords);
}

function findInGeoJSON(address) {
    for (const feature of geojsonData.features) {
        if (feature.properties.title.toLowerCase() === address.toLowerCase()) {
            return feature.geometry.coordinates;
        }
    }
    return null;
}

function parseCoordinates(value) {
    const coordPattern = /^-?\d+\.\d+,-?\d+\.\d+$/;
    if (coordPattern.test(value)) {
        return value.split(',').map(Number).reverse();
    }
    return null;
}

function placeMarker(coords, color) {
    const marker = new mapboxgl.Marker({ color: color })
        .setLngLat(coords)
        .addTo(map);
    markers.push(marker);
}

function removeMarkers() {
    markers.forEach(marker => marker.remove());
    markers = [];
}

async function getRoute(startCoords, endCoords) {
    const url = `https://api.mapbox.com/directions/v5/mapbox/driving/${startCoords[0]},${startCoords[1]};${endCoords[0]},${endCoords[1]}?geometries=geojson&access_token=${mapboxgl.accessToken}`;
    
    try {
        const response = await axios.get(url);
        console.log('Resposta da API:', response.data);

        if (!response.data.routes.length) {
            alert("Nenhuma rota encontrada.");
            return;
        }

        const route = response.data.routes[0].geometry;
        const distanceInKm = (response.data.routes[0].distance / 1000).toFixed(2);
        const durationInMinutes = (response.data.routes[0].duration / 60).toFixed(0);

        const routeInfoDiv = document.createElement('div');
        routeInfoDiv.classList.add('route-info');
        routeInfoDiv.innerHTML = `
            <p><strong>Distância:</strong> ${distanceInKm} km</p>
            <p><strong>Tempo estimado:</strong> ${durationInMinutes} minutos</p>
        `;

        const existingInfoDiv = document.querySelector('.route-info');
        if (existingInfoDiv) {
            existingInfoDiv.remove();
        }

        document.getElementById('map').appendChild(routeInfoDiv);

        if (map.getLayer('route')) map.removeLayer('route');
        if (map.getSource('route')) map.removeSource('route');

        map.addSource('route', {
            type: 'geojson',
            data: { type: 'Feature', geometry: route }
        });

        map.addLayer({
            id: 'route',
            type: 'line',
            source: 'route',
            layout: { 'line-join': 'round', 'line-cap': 'round' },
            paint: {
                'line-color': '#ff0000',
                'line-width': 6,
            }
        });

        map.fitBounds([startCoords, endCoords], { padding: 50 });

    } catch (error) {
        console.error('Erro ao buscar rota:', error);
        alert("Erro ao obter rota. Verifique sua conexão e tente novamente.");
    }
}