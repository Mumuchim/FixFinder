<?php
$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "auth";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['storageKey'])) { 
        $storageKey = $data['storageKey']; 
        
        $stmt = $conn->prepare("DELETE FROM local_storage WHERE storage_key = :storageKey");
        $stmt->bindParam(':storageKey', $storageKey); 
        
        if ($stmt->execute()) { 
            echo json_encode(['success' => true]); 
        } else { 
            error_log("Failed to remove pin."); 
            echo json_encode(['success' => false, 'error' => 'Failed to execute the deletion query.']); 
        } 
    } else { 
        error_log("Missing storageKey in the request."); 
        echo json_encode(['success' => false, 'error' => 'Missing storageKey in the request.']); 
    } 
} catch (PDOException $e) { 
    error_log("Database error: " . $e->getMessage()); 
    echo json_encode(['success' => false, 'error' => $e->getMessage()]); 
} 
?> 
