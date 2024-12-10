<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "db_conn.php";

// Check if pinId is passed via POST
if (isset($_POST['pinId']) && !empty($_POST['pinId'])) {
    $pinId = $_POST['pinId'];
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
            $status = htmlspecialchars($report['status']); // Assuming a 'status' column exists
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
        /* Your existing CSS */
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

<script>
    // Check if activePinClicked exists in localStorage
    const activePinClicked = localStorage.getItem('activePinClicked');

    if (activePinClicked) {
        // Send the activePinClicked value to the PHP script via AJAX (POST)
        fetch('status.php', { // Replace with the actual PHP script name
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'pinId=' + encodeURIComponent(activePinClicked)  // Send pinId as POST data
        })
        .then(response => response.text())
        .then(data => {
            // The data from PHP will be included in the response.
            // This part assumes PHP directly outputs the report's HTML content, 
            // which could be dynamically updated based on the response.
            document.body.innerHTML = data;  // Replace page content with the new data
        })
        .catch(error => {
            console.error('Error:', error);
        });
    } else {
        console.error('activePinClicked not found in localStorage.');
    }
</script>

</body>
</html>
