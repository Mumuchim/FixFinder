<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$required_fields = ['user', 'title', 'details', 'type', 'date', 'uid', 'pinId', 'coordinates', 'floor'];
$missing_fields = [];

foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        $missing_fields[] = $field;
    }
}

if (!empty($missing_fields)) {
    echo json_encode(["error" => "Missing required fields: " . implode(", ", $missing_fields)]);
    exit;
}

include "../db_conn.php";

// Form data
$user = $_POST['user'];
$title = $_POST['title'];
$details = $_POST['details'];
$type = $_POST['type'];
$date = $_POST['date'];
$uid = $_POST['uid'];
$pinId = $_POST['pinId'];
$coordinates = $_POST['coordinates'];
$floor = $_POST['floor'];

try {
    $new_img_name = 'default.png';
    if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
        $img_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $error = $_FILES['image']['error'];

        if ($error === 0) {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_to_lc = strtolower($img_ex);
            $allowed_exs = ['jpg', 'jpeg', 'png'];

            if (in_array($img_ex_to_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_to_lc;
                $img_upload_path = '../upload/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
            } else {
                echo json_encode(["error" => "You can't upload files of this type"]);
                exit;
            }
        } else {
            echo json_encode(["error" => "Unknown error occurred during file upload!"]);
            exit;
        }
    }

    $sql = "INSERT INTO report (user, title, details, type, image, date, uid, pinId, coordinates, floor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user, $title, $details, $type, $new_img_name, $date, $uid, $pinId, $coordinates, $floor]);

    echo json_encode(["success" => "Report submitted successfully!"]);
    exit;
} catch (Exception $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    exit;
}
?>
