<?php
$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "auth";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the JSON input from JavaScript
    $data = json_decode(file_get_contents('php://input'), true);

    // Debugging: Log incoming request
    file_put_contents('php://stderr', "Received data: " . json_encode($data) . "\n");

    if (isset($data['storageKey'])) {
        $storageKey = $data['storageKey'];

        // Debugging: Log the storage key
        file_put_contents('php://stderr', "Removing pin with storageKey: $storageKey\n");

        // Prepare a SQL statement to delete the row with the matching storage_key
        $stmt = $conn->prepare("DELETE FROM local_storage WHERE storage_key = :storageKey");
        $stmt->bindParam(':storageKey', $storageKey);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to execute the deletion']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing storageKey']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
