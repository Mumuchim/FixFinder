<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "db_conn.php";

// Check if pinId is set and not empty
if (isset($_GET['pinId']) && !empty($_GET['pinId'])) {
    $pinId = $_GET['pinId'];
    // Rest of your code to fetch data from the database

    try {
        // Prepare SQL query to fetch report by pinId
        $sql = "SELECT * FROM report WHERE pinId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$pinId]);

        $report = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($report) {
            $title = htmlspecialchars($report['title']);
            $details = htmlspecialchars($report['details']);
            $type = htmlspecialchars($report['type']);
            // $status = htmlspecialchars($report['status']); // Assuming a 'status' column exists
            $reporter = htmlspecialchars($report['user']);
            $image = htmlspecialchars($report['image']);
        } else {
            $error_message = "No report found for the given pin ID.";
        }
    } catch (Exception $e) {
        $error_message = "Database error: " . $e->getMessage();
    }
} else {
    $error_message = "Invalid or missing pin ID.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Report</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            background-image: url('img/bgmap.png');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            width: 500px;
            text-align: center;
            position: relative;
        }
        .report-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .details {
            padding: 20px;
            font-size: 16px;
            line-height: 1.6;
        }
        .details h3 {
            color: #333;
        }
        .details p {
            color: #555;
        }
        .status {
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            color: #e74c3c;
            margin-top: 10px;
        }
        .button {
            background-color: #0245c1;
            color: white;
            padding: 8px 8px;
            text-decoration: none;
            border-radius: 5px;
            position: absolute;
            top: 280px;
            left: 30px;
            font-size: 14px;
        }
        .button:hover {
            background-color: #218838;
        }
        .reporter-name {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php if (isset($error_message)): ?>
    <div class="container">
        <p><?php echo $error_message; ?></p>
        <a href="map.php" class="button">Go to Map</a>
    </div>
<?php else: ?>
    <div class="container">
        <img src="img/<?php echo $image; ?>" alt="Report Image" class="report-img">
        <div class="details">
            <h3><strong>Title:</strong> <?php echo $title; ?></h3>
            <p><strong>Details:</strong> <?php echo $details; ?></p>
            <p><strong>Type of Report:</strong> <?php echo $type; ?></p>
            <div class="status">
                <p><strong>Status:</strong> <?php echo $status ?: 'Not Available'; ?></p>
            </div>
            <p class="reporter-name"><strong>Reporter:</strong> <?php echo $reporter; ?></p>
        </div>
        <a href="map.php" class="button">Go to Map</a>
    </div>
<?php endif; ?>

<script src="js/app.js"></script>

</body>
</html>
