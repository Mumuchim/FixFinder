// // Define zone configurations for each floor
// const zoneConfigurations = {
//     floor1: [
//         { id: 'floor1top', top: '0px', left: '356px', width: '566px', height: '65px' },
//         { id: 'floor1left', top: '140px', left: '355px', width: '109px', height: '310px' },
//         { id: 'floor1right', top: '140px', left: '816px', width: '107px', height: '310px' },
//         { id: 'floor1library', top: '140px', left: '540px', width: '200px', height: '306px' },
//         { id: 'floor1botleft', top: '495px', left: '427px', width: '157px', height: '70px' },
//         { id: 'floor1botright', top: '495px', left: '708px', width: '215px', height: '70px' }
//     ],
//     floor2: [
//         { id: 'floor2top', top: '0px', left: '357px', width: '566px', height: '65px' },
//         { id: 'floor2left', top: '140px', left: '355px', width: '109px', height: '310px' },
//         { id: 'floor2right', top: '140px', left: '818px', width: '106px', height: '310px' },
//         { id: 'floor2library', top: '140px', left: '541px', width: '200px', height: '307px' },
//         { id: 'floor2bot', top: '495px', left: '355px', width: '570px', height: '70px' },
//     ]
// };

// Define zone configurations for each floor
const zoneConfigurations = {
    floor1: [
        { id: 'floor1top', top: '0px', left: '447px', width: '706px', height: '81px' },
        { id: 'floor1left', top: '175px', left: '447px', width: '132px', height: '385px' },
        { id: 'floor1right', top: '175px', left: '1021px', width: '132px', height: '387px' },
        { id: 'floor1library', top: '175px', left: '675px', width: '249px', height: '382px' },
        { id: 'floor1botleft', top: '621px', left: '537px', width: '192px', height: '85px' },
        { id: 'floor1botright', top: '621px', left: '886px', width: '268px', height: '85px' }
    ],
    floor2: [
        { id: 'floor2top', top: '0px', left: '448px', width: '706px', height: '81px' },
        { id: 'floor2left', top: '175px', left: '447.5px', width: '132px', height: '385px' },
        { id: 'floor2right', top: '175px', left: '1023px', width: '131px', height: '387px' },
        { id: 'floor2library', top: '175px', left: '677px', width: '249px', height: '382px' },
        { id: 'floor2bot', top: '622px', left: '448px', width: '706px', height: '85px' },
    ]
};

// Subtract 50 from the 'left' property
Object.keys(zoneConfigurations).forEach(floor => {
    zoneConfigurations[floor].forEach(zone => {
        // Parse the 'left' value to a number, subtract 50, and add 'px' back
        zone.left = (parseFloat(zone.left) - 76) + 'px';
    });
});

// Make each zone 10% bigger
// Object.keys(zoneConfigurations).forEach(floor => {
//     zoneConfigurations[floor].forEach(zone => {
//         // Scale width and height by 10%
//         zone.width = (parseFloat(zone.width) * 1.1) + 'px';
//         zone.height = (parseFloat(zone.height) * 1.1) + 'px';
//     });
// });

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
        zone.style.backgroundColor = 'rgba(76, 175, 80, 0.7)'; // Default style
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
