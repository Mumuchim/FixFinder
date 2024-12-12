const toggleButton = document.getElementById('toggleOpacityButton');

// Function to initialize the view based on localStorage
function initializeView() {
    const activeView = localStorage.getItem('activeView') || "Palette View";
    toggleButton.textContent = activeView;
    updateOpacity(activeView);
}

// Function to update opacity based on the active view
function updateOpacity(view) {
    const allPaths = document.querySelectorAll('.allPaths');
    const mapPhotos = document.querySelectorAll('.map_photo');

    if (view === "Palette View") {
        allPaths.forEach(path => (path.style.opacity = "0.9"));
        mapPhotos.forEach(mapPhoto => (mapPhoto.style.opacity = "0"));
    } else if (view === "2D Top View") {
        allPaths.forEach(path => (path.style.opacity = "0"));
        mapPhotos.forEach(mapPhoto => (mapPhoto.style.opacity = "0.9"));
    }
}

// Event listener for button click
toggleButton.addEventListener('click', () => {
    const currentView = toggleButton.textContent;
    const newView = currentView === "Palette View" ? "2D Top View" : "Palette View";

    toggleButton.textContent = newView;
    localStorage.setItem('activeView', newView); // Save the new view to localStorage
    updateOpacity(newView);
});

// Initialize view on page load
initializeView();
