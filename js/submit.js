// Store the selected pin type globally
let selectedPinType = null;

// Function to handle pin selection and set report type
function preparePin(pinType) {
    selectedPinType = pinType; // Store the selected pin type
    const pinTypes = {
        cautionPin: "Hazard",
        cleaningPin: "Cleaning",
        electricalPin: "Electrical Hazard",
        itPin: "IT Maintenance",
        repairPin: "Repair",
        requestPin: "Request"
    };

    // Set the Type of Report field based on the selected pin
    const reportTypeInput = document.getElementById("reportTypeInput");
    const reportTypeSpan = document.getElementById("reportTypeSpan");

    if (reportTypeInput && reportTypeSpan) {
        const reportType = pinTypes[pinType] || "Unknown";
        reportTypeSpan.textContent = reportType; // Update the span's text content
        reportTypeInput.value = reportType; // Update the input box value
    } else {
        console.error("Report type input or span not found!");
    }

    alert(`${pinTypes[pinType]} selected!`); // Alert the user with the selected pin type
}

// Wait for the document to load before attaching event listeners
document.addEventListener('DOMContentLoaded', function () {
    // Add event listeners to the pin images
    const pins = document.querySelectorAll('[data-pin-type]'); // Select all pin images with the data-pin-type attribute
    if (pins.length === 0) {
        console.error("No pins found in the DOM! Ensure your pin elements have the data-pin-type attribute.");
    } else {
        pins.forEach(pin => {
            pin.addEventListener('click', function () {
                const pinType = pin.getAttribute('data-pin-type');
                preparePin(pinType); // Call the function to handle the pin type
            });
        });
    }

    // Handle form submission
    const submitButton = document.getElementById('submitButton');
    const form = document.getElementById('reportForm');
    const overlay = document.querySelector('.form-popup');

    if (!submitButton || !form) {
        console.error("Submit button or report form not found in the DOM.");
        return;
    }

    submitButton.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default form submission

        if (!selectedPinType) {
            alert('Please select a pin before submitting the report!');
            return; // Prevent submission if no pin is selected
        }

        // Create FormData object
        const formData = new FormData(form);
        formData.append('reportType', selectedPinType);

        // Send the FormData via fetch
        fetch('php/rep.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success); // Show success message
                form.reset(); // Reset the form after submission
                form.style.display = 'none'; // Hide the form

                // Show the overlay popup
                if (overlay) {
                    overlay.style.display = 'block'; // Show the overlay
                }
                selectedPinType = null; // Reset the selected pin
            } else if (data.error) {
                alert(data.error); // Show error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Populate the input field with the span's initial content
    const reportTypeInput = document.getElementById("reportTypeInput");
    const reportTypeSpan = document.getElementById("reportTypeSpan");
    if (reportTypeInput && reportTypeSpan) {
        reportTypeInput.value = reportTypeSpan.textContent;
    }
});


