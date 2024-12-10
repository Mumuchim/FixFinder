// Define zone configurations for each floor
const zoneConfigurations = {
    floor1: [
        { id: 'floor1top', top: '0px', left: '356px', width: '566px', height: '65px' },
        { id: 'floor1left', top: '140px', left: '355px', width: '109px', height: '310px' },
        { id: 'floor1right', top: '140px', left: '816px', width: '107px', height: '310px' },
        { id: 'floor1library', top: '140px', left: '540px', width: '200px', height: '306px' },
        { id: 'floor1botleft', top: '495px', left: '427px', width: '157px', height: '70px' },
        { id: 'floor1botright', top: '495px', left: '708px', width: '215px', height: '70px' }
    ],
    floor2: [
        { id: 'floor2top', top: '0px', left: '357px', width: '566px', height: '65px' },
        { id: 'floor2left', top: '140px', left: '355px', width: '109px', height: '310px' },
        { id: 'floor2right', top: '140px', left: '818px', width: '106px', height: '310px' },
        { id: 'floor2library', top: '140px', left: '541px', width: '200px', height: '307px' },
        { id: 'floor2bot', top: '495px', left: '355px', width: '570px', height: '70px' },
    ]
};

// Function to update zones based on the active floor
function updateZones(floor) {
    const mapContainer = document.getElementById('mapContainer');

    // Remove existing zones
    const existingZones = mapContainer.querySelectorAll('.confirm-zone');
    existingZones.forEach(zone => mapContainer.removeChild(zone));

    // Add zones for the active floor
    const zones = zoneConfigurations[floor] || [];
    zones.forEach(config => {
        const zone = document.createElement('div');
        zone.classList.add('confirm-zone');
        zone.id = config.id;
        zone.style.position = 'absolute';
        zone.style.top = config.top;
        zone.style.left = config.left;
        zone.style.width = config.width;
        zone.style.height = config.height;
        zone.style.backgroundColor = 'rgba(76, 175, 80, 0.1)'; // Default style
        mapContainer.appendChild(zone);
    });
}

function highlightZone(pin) {
    const zones = document.querySelectorAll('.confirm-zone');
    zones.forEach(zone => {
        if (isInsideZone(pin, zone)) {
            zone.style.backgroundColor = 'rgba(215, 124, 252, 0.3)';
        } else {
            zone.style.backgroundColor = 'rgba(76, 175, 80, 0.1)';
        }
    });
}

function isInsideZone(pin, zone) {
    const pinRect = pin.getBoundingClientRect();
    const zoneRect = zone.getBoundingClientRect();

    return (
        pinRect.left >= zoneRect.left &&
        pinRect.right <= zoneRect.right &&
        pinRect.top >= zoneRect.top &&
        pinRect.bottom <= zoneRect.bottom
    );
}
