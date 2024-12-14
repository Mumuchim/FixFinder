<?php
$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "auth";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['pinId'])) { 
        $pinId = $data['pinId']; 
        
        // Prepare DELETE query to remove a record from the "report" table
        $stmt = $conn->prepare("DELETE FROM report WHERE pinId = :pinId");
        $stmt->bindParam(':pinId', $pinId);
        
        if ($stmt->execute()) { 
            echo json_encode(['success' => true]); 
        } else { 
            error_log("Failed to remove report with pinId: $pinId."); 
            echo json_encode(['success' => false, 'error' => 'Failed to execute the deletion query.']); 
        } 
    } else { 
        error_log("Missing pinId in the request."); 
        echo json_encode(['success' => false, 'error' => 'Missing pinId in the request.']); 
    } 
} catch (PDOException $e) { 
    error_log("Database error: " . $e->getMessage()); 
    echo json_encode(['success' => false, 'error' => $e->getMessage()]); 
} 
?>
