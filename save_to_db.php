<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your MySQL password
$dbname = "auth"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    foreach ($data as $item) {
        // Extract only numeric values from the key
        $key = preg_replace('/\D/', '', $conn->real_escape_string($item['key']));

        // Check if the key is numeric
        if (is_numeric($key)) {
            $value = $conn->real_escape_string($item['value']);
            $floor = isset($item['floor']) ? $conn->real_escape_string($item['floor']) : 'N/A';
            $uid = isset($item['uid']) ? $conn->real_escape_string($item['uid']) : 'N/A';

            // Insert into the database
            $sql = "INSERT INTO local_storage (storage_key, storage_value, floor, uid) 
                    VALUES ('$key', '$value', '$floor', '$uid')";

            if (!$conn->query($sql)) {
                echo "Error: " . $conn->error;
            }
        }
    }
    echo "Data saved successfully!";
} else {
    echo "No data received!";
}

$conn->close();
?>