// Function to render localStorage contents into the table
function renderLocalStorage() {
    const tableBody = document.getElementById('storageTable').getElementsByTagName('tbody')[0];
    tableBody.innerHTML = ''; // Clear existing rows

    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        const value = localStorage.getItem(key);

        let parsedValue = {};
        try {
            parsedValue = JSON.parse(value);
        } catch (e) {
            // Value isn't valid JSON
        }

        const row = tableBody.insertRow();
        const keyCell = row.insertCell(0);
        const valueCell = row.insertCell(1);
        const floorCell = row.insertCell(2);
        const uidCell = row.insertCell(3);
        const actionCell = row.insertCell(4);

        keyCell.textContent = key;
        valueCell.textContent = value;
        floorCell.textContent = parsedValue.floor || 'N/A';
        uidCell.textContent = parsedValue.uid || 'N/A';

        // Make floor cell editable
        floorCell.onclick = function () {
            const currentFloor = floorCell.textContent;
            const inputField = document.createElement('input');
            inputField.type = 'text';
            inputField.value = currentFloor;
            floorCell.innerHTML = ''; // Clear cell and add input field
            floorCell.appendChild(inputField);
            inputField.focus();

            inputField.addEventListener('blur', function () {
                const newFloor = inputField.value;
                if (newFloor !== currentFloor) {
                    parsedValue.floor = newFloor; // Update floor in parsed object
                    localStorage.setItem(key, JSON.stringify(parsedValue)); // Update localStorage
                }
                renderLocalStorage(); // Re-render table
            });

            inputField.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    inputField.blur(); // Trigger blur event
                }
            });
        };

        valueCell.onclick = function () {
            const currentValue = valueCell.textContent;
            const inputField = document.createElement('input');
            inputField.type = 'text';
            inputField.value = currentValue;
            valueCell.innerHTML = ''; // Clear cell and add input field
            valueCell.appendChild(inputField);
            inputField.focus();

            inputField.addEventListener('blur', function () {
                const newValue = inputField.value;
                if (newValue !== currentValue) {
                    localStorage.setItem(key, newValue); // Update localStorage
                }
                renderLocalStorage(); // Re-render table
            });

            inputField.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    inputField.blur(); // Trigger blur event
                }
            });
        };

        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.classList.add('action-btn');
        deleteButton.onclick = function () {
            if (confirm(`Are you sure you want to delete the key "${key}"?`)) {
                localStorage.removeItem(key);
                renderLocalStorage(); // Re-render table
            }
        };
        actionCell.appendChild(deleteButton);
    }
}

// Function to send localStorage data to the server
function saveToDatabase() {
    const storageData = [];

    // Collect all key-value pairs from localStorage, excluding keys starting with "active"
    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (!key.startsWith('active')) {
            const value = localStorage.getItem(key);
            let parsedValue = {};
            try {
                parsedValue = JSON.parse(value);
            } catch (e) {
                // Value isn't valid JSON
            }
            storageData.push({
                key: key.replace(/^\D+/g, ''), // Remove non-numeric characters from the key
                value: value,
                floor: parsedValue.floor || 'N/A',
                uid: parsedValue.uid || 'N/A'
            });
        }
    }

    // Send the data to the server via an AJAX request
    fetch('save_to_db.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(storageData),
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response from server:', data);
        alert('Data saved successfully!');
        localStorage.clear(); // Clear localStorage after saving
        console.log('Local storage cleared');
        renderLocalStorage(); // Re-render the table
        // Redirect to log-out page
        window.location.href = 'logout.php';
    })
    .catch(error => {
        console.error('Error saving data:', error);
    });
}

// Function to delete all items from localStorage
function deleteAll() {
    if (confirm('Are you sure you want to delete all items in localStorage?')) {
        localStorage.clear();
        renderLocalStorage(); // Re-render the table after clearing localStorage
    }
}

// Attach event listeners to the buttons
document.getElementById('saveToDB').addEventListener('click', saveToDatabase);
document.getElementById('deleteAll').addEventListener('click', deleteAll);

// Save data to database when the user logs out
document.getElementById('logoutButton').addEventListener('click', function() {
    saveToDatabase();
});

// Initial rendering of localStorage contents when the page loads
window.onload = function () {
    renderLocalStorage();
};
