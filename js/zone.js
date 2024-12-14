// // Define zone configurations for each floor
const zoneConfigurations = {
    floor1: [
        { id: 'floor1top', top: '0px', left: '446px', width: '667px', height: '76px' },
        { id: 'floor1left', top: '182px', left: '446px', width: '124px', height: '364px' },
        { id: 'floor1right', top: '182px', left: '1043px', width: '125px', height: '365.5px'},
        { id: 'floor1library', top: '182px', left: '683px', width: '235px', height: '361px' },
        { id: 'floor1botleft', top: '647.5px', left: '539px', width: '181.5px', height: '85px' },
        { id: 'floor1botright', top: '647px', left: '903px', width: '251px', height: '85px' },
        { id: 'floor1libraryway', top: '363px', left: '582px', width: '92px', height: '33.3px' },
    ],
    floor2: [
        { id: 'floor2top',top: '0px', left: '446px', width: '667px', height: '76px' },
        { id: 'floor2left',top: '182px', left: '446px', width: '124px', height: '364px' },
        { id: 'floor2right',  top: '182px', left: '1045px', width: '123.3px', height: '364.5px' },
        { id: 'floor2library',top: '183px', left: '686px', width: '234px', height: '360px' },
        { id: 'floor2bot', top: '647px', left: '448px', width: '666px', height: '85px' },
        { id: 'floor2libraryway', top: '363px', left: '584px', width: '92px', height: '33.3px' }
    ]
};
// Subtract 50 from the 'left' property
Object.keys(zoneConfigurations).forEach(floor => {
    zoneConfigurations[floor].forEach(zone => {
        // Parse the 'left' value to a number, subtract 50, and add 'px' back
        zone.left = (parseFloat(zone.left) - 45) + 'px';
    });
});

//Make each zone 10% bigger
Object.keys(zoneConfigurations).forEach(floor => {
    zoneConfigurations[floor].forEach(zone => {
        // Scale width and height by 10%
        zone.width = (parseFloat(zone.width) * 1.1) + 'px';
        zone.height = (parseFloat(zone.height) * 1.1) + 'px';
    });
});

console.log(zoneConfigurations);

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
            zone.style.backgroundColor = 'rgba(215, 124, 252, 0.1)';
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
