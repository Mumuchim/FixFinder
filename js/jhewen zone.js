// Define zone configurations for each floor
const zoneConfigurations = {
    floor1: [
        { id: 'floor1top', top: '0px', left: '447px', width: '706px', height: '81px' },
        { id: 'floor1left', top: '175px', left: '447px', width: '132px', height: '385px' },
        { id: 'floor1right', top: '175px', left: '1021px', width: '132px', height: '387px'},
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

// // Subtract 50 from the 'left' property
// Object.keys(zoneConfigurations).forEach(floor => {
//     zoneConfigurations[floor].forEach(zone => {
//         // Parse the 'left' value to a number, subtract 50, and add 'px' back
//         zone.left = (parseFloat(zone.left) - 76) + 'px';
//     });
// });

// Make each zone 10% bigger
// Object.keys(zoneConfigurations).forEach(floor => {
//     zoneConfigurations[floor].forEach(zone => {
//         // Scale width and height by 10%
//         zone.width = (parseFloat(zone.width) * 1.1) + 'px';
//         zone.height = (parseFloat(zone.height) * 1.1) + 'px';
//     });
// });
