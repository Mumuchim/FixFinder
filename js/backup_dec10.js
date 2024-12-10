document.getElementById('secondFloor').style.display = 'none';

let cloningInProgress = false; // Track if a pin is being placed
let lastClonedPin = null; // Track the most recently cloned pin
let pinPlacedManually = false; // Flag to track if a pin was placed manually


// Function to show the specified floor
function showFloor(floor) {
    const firstFloor = document.getElementById('firstFloor');
    const secondFloor = document.getElementById('secondFloor');
    
    // Show or hide floors based on the floor number
    if (floor === 1) {
        firstFloor.style.display = 'block';
        secondFloor.style.display = 'none';
        updateZones('floor1'); // Update zones for Floor 1
    } else if (floor === 2) {
        firstFloor.style.display = 'none';
        secondFloor.style.display = 'block';
        updateZones('floor2'); // Update zones for Floor 2
    }

    // Save the active floor and load pin positions
    saveActiveFloor(floor); // Save the active floor to localStorage
    loadPinPositions(); // Load pins for the active floor
    
    // Show the floor change message
    showFloorChangeMessage(floor);
}

// Function to display the floor change message in a modal
function showFloorChangeMessage(floor) {
    const message = (floor === 1) ? "You are now viewing \n Floor 1" : "You are now viewing \n Floor 2";
    
    // Set the message text
    document.getElementById("floorMessage").innerText = message;
    
    // Show the modal
    document.getElementById("floorChangeModal").style.display = "flex";
    
    // Auto-close the modal after 1 second (1000 ms)
    setTimeout(closeModal, 1000);
}

// Function to close the modal
function closeModal() {
    document.getElementById("floorChangeModal").style.display = "none";
}


// Initialize zones and set the active floor on page load
document.addEventListener('DOMContentLoaded', () => {
    const savedFloor = localStorage.getItem('activeFloor'); // Get the saved floor from localStorage
    const activeFloor = getCurrentActiveFloor(); // Get the saved floor value (1 or 2)
    showFloor(activeFloor); // Set the active floor
    
});




function addPathListeners(paths, svgId) {
    const nameLabel = document.getElementById('name');
    const slidingColumn = document.getElementById('slidingColumn');

    paths.forEach(path => {
        path.addEventListener('mouseover', () => {
            nameLabel.style.opacity = '1';
            nameLabel.querySelector('#namep').innerText = `${svgId} - ${path.id}`;
        });

        path.addEventListener('mousemove', (e) => {
            nameLabel.style.left = `${e.pageX + 10}px`;
            nameLabel.style.top = `${e.pageY - 20}px`;
        });

        path.addEventListener('mouseout', () => {
            nameLabel.style.opacity = '0';
        });

        path.addEventListener('click', () => {
            slidingColumn.classList.add('show');
        //    document.getElementById('pins').innerHTML = `<div class="pin">You clicked on: ${svgId} - ${path.id}</div>`;
        });
    });
}

addPathListeners(document.querySelectorAll('#firstFloor .allPaths'), 'First Floor');
addPathListeners(document.querySelectorAll('#secondFloor .allPaths'), 'Second Floor');

document.getElementById("closeButton").addEventListener("click", function () {
    document.getElementById("slidingColumn").classList.remove("show");
});

function saveActiveFloor(floor) {
    // Ensure the floor value is valid (1 or 2)
    if (floor !== 1 && floor !== 2) {
        console.error("Invalid floor value. Only 1 or 2 are allowed.");
        return;
    }

    // Save the active floor as a simple object
    const floorData = { floor }; // Only store the floor number
    localStorage.setItem('activeFloor', JSON.stringify(floorData));
}

function getCurrentActiveFloor() {
    try {
        // Retrieve the active floor from localStorage
        const savedData = localStorage.getItem('activeFloor');

        if (savedData) {
            const parsedData = JSON.parse(savedData);

            // Ensure it's an object with a valid 'floor' property
            if (parsedData && (parsedData.floor === 1 || parsedData.floor === 2)) {
                return parsedData.floor;
            }
        }
    } catch (e) {
        console.error("Error parsing active floor from localStorage", e);
    }

    // Default to Floor 1 if no valid data is found
    return 1;
}

let pinPositions = [];

function savePinPositions() {
    try {
        const uidInput = document.querySelector('input[name="uid"]');
        const uid = uidInput ? uidInput.value : 'Unknown';

        // Get all keys in localStorage (ignoring activeFloor key)
        const allKeys = Object.keys(localStorage).filter(key => key !== 'activeFloor' && /^\d+$/.test(key));

        // Limit the number of pins in localStorage to 5
        if (allKeys.length >= 5) {
            alert("You have reached the maximum number of pins. Please remove a pin before adding a new one.");
            return;  // Don't save any new pins if the limit is reached
        }

        pinPositions.forEach(position => {
            const pinElement = document.getElementById(position.pinId);
            const img = pinElement.querySelector('img');
            const imgSrc = img ? img.src : null;

            const relativeImgSrc = imgSrc ? imgSrc.replace(/^http:\/\/localhost:3000\//, '') : null;

            const pinData = {
                top: position.top,
                left: position.left,
                imgSrc: relativeImgSrc,
                floor: position.floor || getCurrentActiveFloor(), // Use current active floor if not set
                uid: uid // Save the current session UID
            };

            const pinIdWithoutPrefix = position.pinId.replace(/^pin-/, '');
            localStorage.setItem(pinIdWithoutPrefix, JSON.stringify(pinData));
        });
    } catch (e) {
        console.error("Error saving pin positions to localStorage", e);
    }
}

function loadPinPositions() {
    try {
        const activeFloor = getCurrentActiveFloor(); // Fetch the correct active floor

        // Clear existing pins from the map container
        const mapContainer = document.getElementById("mapContainer");
        const existingPins = mapContainer.querySelectorAll('.pin');
        existingPins.forEach(pin => mapContainer.removeChild(pin)); // Remove all pins before loading new ones

        // Load pins from localStorage based on the active floor
        Object.keys(localStorage).forEach(key => {
            // Only process numeric keys (pin IDs)
            if (/^\d+$/.test(key)) {
                const pinData = JSON.parse(localStorage.getItem(key));

                // Match pins with the current active floor
                if (pinData && pinData.floor === activeFloor) {
                    createPinOnMap(pinData, key); // Create and display the pin
                }
            }
        });
    } catch (e) {
        console.error("Error loading pin positions from localStorage", e);
    }
}


function createPinOnMap(pinData, key) {
    const pinElement = document.createElement('div');
    pinElement.classList.add('pin');
    pinElement.style.position = 'absolute';
    pinElement.style.top = pinData.top;
    pinElement.style.left = pinData.left;
    pinElement.id = `pin-${key}`;

    // Add the pin image if available
    if (pinData.imgSrc) {
        const img = document.createElement('img');
        img.src = pinData.imgSrc;
        pinElement.appendChild(img);
    }

    // Append the pin to the map container
    document.getElementById("mapContainer").appendChild(pinElement);

    // Add click event listener for pin options
    pinElement.addEventListener('click', () => {
        showPinOptions(pinElement, key);
    });

    // Track the pin position in memory
    pinPositions.push({
        pinId: `pin-${key}`,
        top: pinData.top,
        left: pinData.left,
        imgSrc: pinData.imgSrc,
        floor: pinData.floor,
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const mapContainer = document.getElementById('mapContainer');

    let cloningInProgress = false; // Track if a pin is being placed

    function clonePin(pin, x, y) {
        const allKeys = Object.keys(localStorage).filter(key => key !== 'activeFloor' && /^\d+$/.test(key));
    
        if (allKeys.length >= 5) {
            alert("You have reached the maximum number of pins. Please remove a pin before adding a new one.");
            return;  // Prevent cloning if there are already 5 pins in localStorage
        }
    
        if (cloningInProgress) {
            alert("Please confirm the current pin's position before cloning a new one.");
            return;
        }
    
        const pinType = pin.dataset.pinType; // Get the pin type from the data-pin-type attribute
        const imgSrc = getFixedImagePath(pinType); // Get the fixed image path based on pin type
    
        const clone = pin.cloneNode(true);
        const pinId = `pin-${Date.now()}`;
        clone.id = pinId;
        clone.style.position = 'absolute';
        clone.style.left = `${x}px`;
        clone.style.top = `${y}px`;
    
        // Add pin to positions but don't save it yet
        pinPositions.push({
            pinId: pinId,
            top: clone.style.top,
            left: clone.style.left,
            imgSrc: imgSrc, // Save the fixed image path
        });
    
        mapContainer.appendChild(clone);
    
        // Create image element with the fixed image path
        const img = document.createElement('img');
        img.src = imgSrc;
        clone.appendChild(img);
    
        lastClonedPin = clone;
        cloningInProgress = true; // Block additional cloning until confirmed
    
        makeDraggable(clone);
    
        clone.addEventListener('click', () => {
            if (!pinPlacedManually) {
                showPinOptions(clone, pinId);
            }
        });
    }    

    function makeDraggable(pin) {
        let isDragging = false;
        let offsetX, offsetY;
    
        function onMouseMove(e) {
            if (isDragging) {
                pin.style.position = 'absolute';
                pin.style.left = `${e.clientX - offsetX}px`;
                pin.style.top = `${e.clientY - offsetY}px`;
    
                // Highlight the zones as the pin moves
                highlightZone(pin);
            }
        }
    
        function onMouseUp() {
            isDragging = false;
        
            // Check if the pin is within any confirmable zone
            const zones = document.querySelectorAll('.confirm-zone');
            let isInZone = false;
        
            zones.forEach(zone => {
                if (isInsideZone(pin, zone)) {
                    isInZone = true;
                }
            });
        
            if (isInZone) {
                const confirmPosition = confirm("Do you want to confirm the pin's position?");
                if (confirmPosition) {
                    pin.style.position = 'absolute';
                    const pinId = pin.id;
        
                    // Save the confirmed position
                    pinPositions = pinPositions.filter(p => p.pinId !== pinId);
                    pinPositions.push({
                        pinId: pinId,
                        top: pin.style.top,
                        left: pin.style.left,
                    });
                    savePinPositions(); // Save to localStorage after confirmation
        
                    cloningInProgress = false; // Allow new pins to be cloned
        
                    // Finalize the pin and remove drag listeners
                    pin.removeEventListener('mousedown', onMouseDown);
                    pin.removeEventListener('mousemove', onMouseMove);
                    pin.removeEventListener('mouseup', onMouseUp);
        
                    // Populate the form with the pin's information
                    document.getElementById('pinId').value = pinId;  // Pin ID
                    document.getElementById('coordinates').value = JSON.stringify({
                        top: pin.style.top,
                        left: pin.style.left,
                        imgSrc: pin.querySelector('img') ? pin.querySelector('img').src : null,
                        floor: getCurrentActiveFloor()
                    });  // Coordinates (JSON stringified)
                    document.getElementById('floor').value = getCurrentActiveFloor();  // Floor (1 or 2)
        
                    openForm();  // Show the form
        
                    pinPlacedManually = true;
                } else {
                    cancelPinPlacement(); // Use updated cancel function
                }
            } else {
                alert("Pin must be placed within a designated confirmable zone.");
                cancelPinPlacement(); // Use updated cancel function
            }
        
            // Remove drag event listeners after mouseup
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
        }
               
    
        function onMouseDown(e) {
            isDragging = true;
            offsetX = e.clientX - pin.getBoundingClientRect().left;
            offsetY = e.clientY - pin.getBoundingClientRect().top;
    
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        }
    
        pin.addEventListener('mousedown', onMouseDown);
    }
    
    function getFixedImagePath(pinType) {
        const imagePaths = {
            'cleaningIcon': 'img/Cleaning_shadow.png',
            'repairIcon': 'img/Repair_shadow.png',
            'itIcon': 'img/IT Maintenance_shadow.png',
            'electricalIcon': 'img/Electrical Hazard_shadow.png',
            'cautionIcon': 'img/Caution_shadow.png',
            'requestIcon': 'img/Request_shadow.png',
        };
    
        return imagePaths[pinType] || 'error';  // Return a default image if pinType is unknown
    }
    

// Store the selected pin type globally
let selectedPinType = null;

// Function to handle pin selection and set report type
function preparePin(pinType) {
    if (selectedPinType === pinType) {
        return; // Don't do anything if the same pin type was already selected
    }

    console.log("Pin clicked:", pinType); // Debugging: check which pin is clicked
    selectedPinType = pinType; // Store the selected pin type
    
    const pinTypes = {
        cautionIcon: "Hazard",
        cleaningIcon: "Cleaning",
        electricalIcon: "Electrical Hazard",
        itIcon: "IT Maintenance",
        repairIcon: "Repair",
        requestIcon: "Request"
    };

    // Set the Type of Report field based on the selected pin
    const reportTypeInput = document.getElementById("reportTypeInput");
    const reportTypeSpan = document.getElementById("reportTypeSpan");

    if (reportTypeInput && reportTypeSpan) {
        const reportType = pinTypes[pinType] || "Unknown";
        reportTypeSpan.textContent = reportType; // Update the span's text content
        reportTypeInput.value = reportType; // Update the input box value

        // Alert after DOM update
        alert(`${reportType} selected!`); // Should show the alert now
    } else {
        console.error("Report type input or span not found!");
    }
}


// Modified enablePinPlacement function
function enablePinPlacement(icon) {
    icon.addEventListener('click', function (e) {
        const mapRect = mapContainer.getBoundingClientRect();
        const x = e.clientX - mapRect.left;
        const y = e.clientY - mapRect.top;

        // Get the pin type from the icon's data-pin-type attribute
        const pinType = icon.dataset.pinType;

        // Prepare the pin by setting the report type
        preparePin(pinType);

        // Clone the pin after preparing the report type
        clonePin(icon, x, y);
    });
}

    enablePinPlacement(cautionIcon);
    enablePinPlacement(cleaningIcon);
    enablePinPlacement(electricalIcon);
    enablePinPlacement(itIcon);
    enablePinPlacement(repairIcon);
    enablePinPlacement(requestIcon);
});

function showPinOptions(pinElement, pinId) {
    if (document.querySelector('.custom-modal')) {
        return;
    }

    const modal = document.createElement('div');
    modal.classList.add('custom-modal');
    modal.style.position = 'absolute';
    modal.style.width = '200px';
    modal.style.height = '140px'; // Default height
    modal.style.backgroundColor = '#042331';
    modal.style.border = '1px solid #ccc';
    modal.style.borderRadius = '8px';
    modal.style.padding = '10px';
    modal.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';

    const heightLimit = 40;
    const pinRect = pinElement.getBoundingClientRect();
    const modalTop = pinRect.top - 100;
    const modalLeft = pinRect.left;
    const viewportHeight = window.innerHeight;

    if (modalTop < heightLimit) {
        // Position below the pin
        const availableSpaceBelow = viewportHeight - pinRect.bottom - 10; // Space below the pin
        modal.style.top = `${pinRect.bottom + 100   }px`;
        modal.style.height = `${Math.min(140, availableSpaceBelow)}px`; // Adjust modal height to fit the space below
    } else {
        // Position above the pin
        modal.style.top = `${modalTop}px`;
    }
    modal.style.left = `${modalLeft}px`;

    const statusButton = document.createElement('button');
    statusButton.textContent = 'Status';
    const removeButton = document.createElement('button');
    removeButton.textContent = 'Remove Pin';
    const closeButton = document.createElement('button');
    closeButton.textContent = 'Close';

    modal.appendChild(statusButton);
    modal.appendChild(removeButton);
    modal.appendChild(closeButton);

    document.body.appendChild(modal);

    // Show pin ID from localStorage based on coordinates
    const pinPosition = {
        top: pinElement.style.top,
        left: pinElement.style.left
    };

    // Function to get the pin key from localStorage based on coordinates
    function getPinKeyByCoordinates(position) {
        for (let key in localStorage) {
            if (/^\d+$/.test(key)) {
                const pinData = JSON.parse(localStorage.getItem(key));

                // Check if the pin's coordinates match
                if (pinData.top === position.top && pinData.left === position.left) {
                    return key;  // Return the matching pin ID from localStorage
                }
            }
        }
        return null;  // Return null if no match is found
    }

    // Fetch and display the pin ID
    const pinKey = getPinKeyByCoordinates(pinPosition);
    const pinIdElement = document.getElementById("pinIDClicked");
    if (pinKey) {
        pinIdElement.textContent = pinKey;  // Show the pin ID in the span
    } else {
        pinIdElement.textContent = "Not Found";  // If no key is found
    }

    statusButton.addEventListener('click', () => {
        window.location.href = 'status.html';
        document.body.removeChild(modal);
    });

    removeButton.addEventListener('click', () => {
        if (confirm('Are you sure you want to remove this pin?')) {
            const mapContainer = document.getElementById('mapContainer');
            mapContainer.removeChild(pinElement);
    
            // Remove pin from pinPositions array
            pinPositions = pinPositions.filter(p => p.pinId !== pinId);
    
            // Also remove the corresponding pin data from localStorage
            const pinIdWithoutPrefix = pinId.replace(/^pin-/, ''); // Remove 'pin-' prefix
            localStorage.removeItem(pinIdWithoutPrefix); // Remove the pin data from localStorage
    
            // Save the updated pin positions
            savePinPositions();
    
            // Refresh the page after removing the pin
            location.reload(); // This will reload the page and reset everything
        }
        document.body.removeChild(modal);
    });
    
    closeButton.addEventListener('click', () => {
        document.body.removeChild(modal);
    });
}

window.onload = function() {
    loadPinPositions();
};

function openForm() {
    document.getElementById("myForm").style.display = "block";
}

function closeForm() {
    document.getElementById("myForm").style.display = "none";

    if (lastClonedPin) {
        // Remove the last cloned pin from the map
        const mapContainer = document.getElementById("mapContainer");
        mapContainer.removeChild(lastClonedPin);

        // Remove the last cloned pin from pinPositions
        pinPositions = pinPositions.filter(pin => pin.pinId !== lastClonedPin.id);

        // Save the updated pin positions to localStorage
        savePinPositions();

        // Reset the lastClonedPin
        lastClonedPin = null;
    }
}

document.getElementById("cancelRequestButton").addEventListener('click', closeForm);

function cancelPinPlacement() {
    // Reload the page to reset all pin placements
    location.reload();
}


document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('reportDate');
    try {
        // Get the current date in YYYY-MM-DD format
        const today = new Date().toISOString().split('T')[0];

        // Check if the input type is supported
        if (dateInput.type === "date") {
            dateInput.value = today;
        } else {
            throw new Error("Input type 'date' is not supported by this browser.");
        }
    } catch (error) {
        console.error("Error setting the current date:", error.message);

        // Fallback for unsupported browsers
        dateInput.placeholder = "YYYY-MM-DD";
        dateInput.type = "text";
    }
});

