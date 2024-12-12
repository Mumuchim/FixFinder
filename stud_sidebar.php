<?php
session_start();

// Assuming that 'fname' and 'role' are stored in the session after login
// Example: $_SESSION['fname'] for full name, $_SESSION['role'] for role
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
            if (isset($_SESSION['fname'])) {
                echo "Hello, " . htmlspecialchars($_SESSION['fname']);
                
                // Display the role below the name
                if (isset($_SESSION['role'])) {
                    echo "<br><small>(" . htmlspecialchars(ucfirst($_SESSION['role'])) . ")</small>";
                }
            } else {
                echo "Welcome, Guest";  // Default if no user is logged in
            }
            ?>
        </header>
        <ul>
            <!-- Adjust dashboard links based on the user's role -->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li><a href="admin_dashboard.php"><i class="fa fa-tachometer-alt"></i> Admin Dashboard</a></li>
            <?php else: ?>
                <li><a href="map.php"><i class="fa fa-qrcode"></i> Student Dashboard</a></li>
            <?php endif; ?>
            <li><a href="stud_history.php"><i class="fas fa-history"></i>History</a></li>
            <li><a href="edit.php"><i class="fas fa-edit"></i>Edit Profile</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out"></i>Logout</a></li>
        </ul>   
    </div>
</body>
</html>
