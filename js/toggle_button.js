const toggleButton = document.getElementById('toggleOpacityButton');

toggleButton.addEventListener('click', () => {
    if (toggleButton.textContent === "Pallete View") {
        toggleButton.textContent = "2D Top View";
    } else {
        toggleButton.textContent = "Pallete View";
    }

    // Example opacity toggle logic
    const allPaths = document.querySelectorAll('.allPaths');
    const mapPhotos = document.querySelectorAll('.map_photo');

    allPaths.forEach(path => {
        path.classList.toggle('hidden');
    });

    mapPhotos.forEach(mapPhoto => {
        mapPhoto.classList.toggle('visible');
    });
});

