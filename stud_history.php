<?php
session_start();

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['fname']) || !isset($_SESSION['lname'])) {
    echo "<p><strong>Error:</strong> User is not logged in. Please log in to view history.</p>";
    exit();
}

// Database connection
$con = new mysqli("localhost", "root", "", "auth");

// Check connection
if ($con->connect_error) {
    die("<p><strong>Error:</strong> Database connection failed: " . $con->connect_error . "</p>");
}

// Get the logged-in user's fname and lname from the session
$user_fname = trim($_SESSION['fname']);
$user_lname = trim($_SESSION['lname']);

// Concatenate first name and last name for filtering
$user_fullname = $user_fname . ' ' . $user_lname;

// SQL query to fetch the reports for the logged-in user
$query = "SELECT * FROM report WHERE user = ?";

// Prepare the statement
$stmt = $con->prepare($query);
if (!$stmt) {
    die("<p><strong>Error:</strong> Query preparation failed: " . $con->error . "</p>");
}

// Bind the fname and lname concatenated parameter (the logged-in user's full name) and execute the query
$stmt->bind_param("s", $user_fullname);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any records
if ($result->num_rows == 0) {
    $no_records_message = "No history records found for this user. If you haven't created any reports yet, consider adding one!";
} else {
    $no_records_message = "";
}

// Close resources
$stmt->close();
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <<link rel="stylesheet" href="css/history.css"> 
</head>
<body>
    <div class="container">
    <div id="sidebar-container"></div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4>Student History</h4>
                        <!-- Display Logged-In User's Name -->
                        <p class="text-muted">Logged in as: <strong><?= htmlspecialchars($user_fname . ' ' . $user_lname); ?></strong></p>
                    </div>
                    <div class="card-body">
                        <?php if ($no_records_message): ?>
                            <div class="alert alert-info">
                                <p><strong><?= $no_records_message ?></strong></p>
                            </div>
                        <?php endif; ?>
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Report Title</th>
                                    <th>Report Details</th>
                                    <th>Report Type</th>
                                    <th>Report Image</th>
                                    <th>Report Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Display records if found
                                if ($result->num_rows > 0) {
                                    $counter = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                       <tr>
                                                <td><?= $row['id']; ?></td>
                                                <td><?= $row['title']; ?></td>
                                                <td><?= $row['details']; ?></td>
                                                <td><?= $row['type']; ?></td>
                                                <td><img width="50" height="50" src="upload/<?= $row['image']; ?>"></td>
                                                <td><?= $row['date']; ?></td>                                          
                                            </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/loadSidebar.js"></script>
</body>
</html>
