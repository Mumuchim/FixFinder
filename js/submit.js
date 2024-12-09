
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
        fetch('php/test.php', {
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


