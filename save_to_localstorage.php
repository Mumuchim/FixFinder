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

// Get the uid and role of the logged-in user from the session
$uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : null;
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

if ($role) {
    if ($role === 'admin') {
        // SQL query to fetch all data from the local_storage table for admin
        $sql = "SELECT storage_key, storage_value, floor, uid FROM local_storage";
        $stmt = $conn->prepare($sql);
    } else {
        // SQL query to fetch data from the local_storage table based on the uid for regular users
        $sql = "SELECT storage_key, storage_value, floor, uid FROM local_storage WHERE uid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $uid);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Prepare an array to hold the data
    $data = [];

    if ($result->num_rows > 0) {
        // Fetch all rows and store them in the data array
        while ($row = $result->fetch_assoc()) {
            // Decode the value to get back to the original object
            $value = json_decode($row['storage_value'], true); // Decode the value if it's JSON string
            
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
        echo json_encode(["message" => "No data found!"]);
    }

    $stmt->close();
} else {
    echo json_encode(["message" => "User not logged in!"]);
}

$conn->close();
?>
