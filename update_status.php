<?php
include "db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pinId = $_POST['pinId'] ?? null;
    $newStatus = $_POST['status'] ?? null;

    if ($pinId && $newStatus) {
        try {
            $sql = "UPDATE report SET status = ? WHERE pinId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$newStatus, $pinId]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Status updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
