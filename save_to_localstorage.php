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

// SQL query to fetch data from the local_storage table
$sql = "SELECT storage_key, storage_value, floor, uid FROM local_storage";
$result = $conn->query($sql);

// Assuming $value is the object you're trying to store
$value = ['top' => '306px', 'left' => '598px', 'imgSrc' => 'img/Cleaning_shadow.png', 'floor' => 1, 'uid' => '15177060'];

// Store $value as JSON
$encodedValue = json_encode($value);  // Encode it only when saving to the database


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
    echo "No data found!";
}

$conn->close();
?>
