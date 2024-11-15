<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['title']) && isset($_POST['details']) && isset($_POST['type']) && isset($_POST['date'])) {
    include "../db_conn.php";

    // Form data
    $title = $_POST['title'];
    $details = $_POST['details'];
    $type = $_POST['type'];
    $date = $_POST['date'];

    // Form validation
    if (empty($title) || empty($details) || empty($type) || empty($date)) {
        echo json_encode(['error' => 'All fields are required']);
        exit;
    }

    try {
        // Handle image upload if provided
        $new_img_name = 'default-pp.png'; // Default image

        if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
            $img_name = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];
            $error = $_FILES['image']['error'];

            if ($error === 0) {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_to_lc = strtolower($img_ex);

                $allowed_exs = array('jpg', 'jpeg', 'png');
                if (in_array($img_ex_to_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_to_lc;
                    $img_upload_path = '../upload/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
                } else {
                    echo json_encode(['error' => "You can't upload files of this type"]);
                    exit;
                }
            } else {
                echo json_encode(['error' => "Unknown error occurred during file upload!"]);
                exit;
            }
        }

        // Insert into the `report` table
        $sql = "INSERT INTO report (title, details, type, image, date) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$title, $details, $type, $new_img_name, $date]);
        echo json_encode(['success' => 'Report submitted successfully']);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Missing required fields']);
}
?>
