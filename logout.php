<?php
session_start();

// Ensure the session is active before ending it
if (isset($_SESSION)) {
    session_unset();
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <script>
        // JavaScript function to save localStorage data to the database and clear localStorage
        function saveAndLogout() {
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

            // Save to the database first
            fetch('save_to_db.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(storageData),
            })
            .then(response => response.text())
            .then(data => {
                console.log('Data saved successfully:', data);

                // Clear localStorage after saving
                localStorage.clear();

                // Redirect to login page
                window.location.href = 'login.php';
            })
            .catch(error => {
                console.error('Error saving data:', error);
                alert('Error saving data. Logout process aborted.');
            });
        }

        // Call the function as soon as the page loads
        window.onload = saveAndLogout;
    </script>
</head>
<body>
</body>
</html>
