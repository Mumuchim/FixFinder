<?php
session_start();

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

// Check if the user is logged in and has a valid UID
if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid']; // Get the UID from session
} else {
    echo json_encode(['error' => 'No session found']);
    exit;
}

// SQL query to fetch data from the local_storage table, filtered by UID
$sql = "SELECT storage_key, storage_value, floor, uid FROM local_storage WHERE uid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $uid); // Bind the UID parameter to the query
$stmt->execute();
$result = $stmt->get_result();

// Prepare an array to hold the data
$data = [];

if ($result->num_rows > 0) {
    // Fetch all rows and store them in the data array
    while ($row = $result->fetch_assoc()) {
        // Decode the value to get back to the original object
        $value = json_decode($row['storage_value'], true); // Decode the value if it's a JSON string
        
        $data[] = [
            'key' => $row['storage_key'],
            'value' => $value, // Store the decoded value
            'floor' => $row['floor'],
            'uid' => $row['uid'],
        ];
    }

    // Send the data to the front-end (client-side) as JSON
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'No data found for the user']);
}

$conn->close();
?>
