document.addEventListener('DOMContentLoaded', function () {
    if (!document.getElementById('dci-map')) return;

    const map = L.map('dci-map').setView([3.139, 101.6869], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

const datacenters = dci_vars.datacenters || [];
console.log('Datacenters:', datacenters);

    let previousMarker = null;

    datacenters.forEach(dc => {
        const marker = L.marker([dc.lat, dc.lng]).addTo(map).bindPopup(dc.name);
        if (previousMarker) {
            const line = L.polyline([previousMarker.getLatLng(), marker.getLatLng()], {
                color: '#00ffea',
                weight: 4,
                opacity: 0.7
            }).addTo(map);
        }
        previousMarker = marker;
    });
});
