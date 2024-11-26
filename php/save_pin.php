<?php
// Include the database connection file
include '../db_conn.php'; // Adjust the path as needed

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON body of the request
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate input data
    if (isset($data['x'], $data['y'], $data['floor'], $data['report_id'])) {
        $x = $data['x'];
        $y = $data['y'];
        $floor = (int)$data['floor'];
        $report_id = (int)$data['report_id'];

        try {
            // Prepare the SQL query to insert the pin
            $stmt = $conn->prepare("INSERT INTO pins (x, y, floor, report_id) VALUES (:x, :y, :floor, :report_id)");
            $stmt->bindParam(':x', $x);
            $stmt->bindParam(':y', $y);
            $stmt->bindParam(':floor', $floor, PDO::PARAM_INT);
            $stmt->bindParam(':report_id', $report_id, PDO::PARAM_INT);

            // Execute the query
            $stmt->execute();

            // Respond with a success message
            echo json_encode(['message' => 'Pin saved successfully']);
        } catch (PDOException $e) {
            // Handle database exceptions
            http_response_code(500);
            echo json_encode(['error' => 'Failed to save pin', 'details' => $e->getMessage()]);
        }
    } else {
        // Respond with a bad request error
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input data']);
    }
} else {
    // Handle invalid request methods
    http_response_code(405);
    header('Allow: POST');
    echo json_encode(['error' => 'Invalid request method']);
}
?>
