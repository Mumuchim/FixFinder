<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "../db_conn.php";

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if (empty($data)) {
    echo "No data received.";
    exit;
}

try {
    foreach ($data as $item) {
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
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage();
}

$conn->close();
?>
