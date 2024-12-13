<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LocalStorage Viewer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .action-btn {
            padding: 5px 10px;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
        }
        #saveToDB, #deleteAll, #loadFromDB {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        #deleteAll {
            background-color: #f44336; /* Red color for Delete All */
        }
        #loadFromDB {
            background-color: #2196F3; /* Blue color for Load from DB */
        }
    </style>
</head>
<body>

    <h1>LocalStorage Viewer</h1>
    <p>Below is a list of all key-value pairs currently stored in <strong>localStorage</strong>.</p>
    
    <table id="storageTable">
        <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
                <th>Floor</th> <!-- New column for Floor -->
                <th>UID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Rows will be populated by JavaScript -->
        </tbody>
    </table>

    <button id="saveToDB">Save to Database</button>
    <button id="deleteAll">Delete All</button> <!-- Delete All button -->
    <button id="loadFromDB">Load from Database</button> <!-- New button to load data from DB -->

    <script>
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

            // Collect all key-value pairs from localStorage
            for (let i = 0; i < localStorage.length; i++) {
                const key = localStorage.key(i);
                const value = localStorage.getItem(key);

                let parsedValue = {};
                try {
                    parsedValue = JSON.parse(value); // Try to parse JSON
                } catch (e) {
                    // If parsing fails, it's a plain string
                }

                storageData.push({
                    key: key,
                    value: value,
                    floor: parsedValue.floor || 'N/A',
                    uid: parsedValue.uid || 'N/A',
                });
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
                alert('Data saved successfully!');
                console.log(data); // For debugging
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

       // Function to load data from the database and render it into the table
function loadFromDatabase() {
    fetch('save_to_localstorage.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(item => {
                // Store data from the DB into localStorage
                localStorage.setItem(item.key, JSON.stringify(item.value)); // item.value is now an object, no extra encoding needed
            });
            renderLocalStorage(); // Re-render the table with new data
        })
        .catch(error => {
            console.error('Error loading data from database:', error);
        });
}

        // Attach event listeners to the buttons
        document.getElementById('saveToDB').addEventListener('click', saveToDatabase);
        document.getElementById('deleteAll').addEventListener('click', deleteAll);
        document.getElementById('loadFromDB').addEventListener('click', loadFromDatabase);

        // Initial rendering of localStorage contents when the page loads
        window.onload = function () {
            renderLocalStorage();
        };
    </script>

</body>
</html>
