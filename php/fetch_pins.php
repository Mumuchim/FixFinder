<?php
// Include the database connection file
include '../db_conn.php'; // Adjust the path as needed

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the floor number from the query parameters, default to 1 if not provided
    $floor = isset($_GET['floor']) ? (int)$_GET['floor'] : 1;

    try {
        // Prepare the SQL query to fetch pins for the specified floor
        $stmt = $conn->prepare("SELECT id, x, y, report_id FROM pins WHERE floor = :floor");
        $stmt->bindParam(':floor', $floor, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch all pins as an associative array
        $pins = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Set the Content-Type header to application/json
        header('Content-Type: application/json');

        // Respond with the pins
        echo json_encode($pins);
    } catch (PDOException $e) {
        // Handle database exceptions
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch pins', 'details' => $e->getMessage()]);
    }
} else {
    // Handle invalid request methods
    http_response_code(405);
    header('Allow: GET');
    echo json_encode(['error' => 'Invalid request method']);
}
?>
