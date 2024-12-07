<?php
session_start();

// Assuming that the username or full name is stored in the session after login
// Example: $_SESSION['username'] or $_SESSION['fname'] 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>        
<body>     
    <input type="checkbox" id="check">
    <label for="check">
        <i class="fas fa-bars" id="btn"></i>
        <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="sidebar">
        <!-- Displaying the logged-in user's name in the header -->
        <header>
            <?php 
            // Check if the session variable for the user's name is set
            if(isset($_SESSION['fname'])) {
                echo "Hello, " . htmlspecialchars($_SESSION['fname']);  // Display full name or username
            } else {
                echo "Welcome, Guest";  // Default if no user is logged in
            }
            ?>
        </header>
        <ul>
            <li><a href="map.php"><i class="fa fa-qrcode"></i> Student Dashboard</a></li>
            <li><a href="stud_history.php"><i class="fas fa-history"></i>History</a></li>
            <li><a href="edit.php"><i class="fas fa-edit"></i>Edit Profile</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out"></i>Logout</a></li>
        </ul>   

        <!-- Displaying the UID for students at the bottom -->
        
    </div>
</body>
</html>
