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
    <title>How to create a pop up window using html css</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Zen+Tokyo+Zoo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/rep.css">
</head>

<body>

    <div class="form-popup" id="myForm">
        <a class="button" href="#divOne">Contact US</a>
    </div>

    <div class="overlay" id="divOne">
        <div class="wrapper">
            <h2>Report your concern here.</h2>
            <a class="close" href="#">&times;</a>
            <div class="content">
                <div class="container">
                <div class="form-popup" id="myForm">
                <form id="reportForm" class="form-container" action="php/test.php" method="post" enctype="multipart/form-data">

                        <div class="form-group-inline">
                            <label for="name">Name</label>
                            <input id="name" 
                                   type="text" 
                                   class="form-control"
                                   name="user"
                                   readonly
                                   placeholder="Your name.."
                                   value="<?php 
                                        // Pre-fill with session data or allow user input
                                        if (isset($_SESSION['fname']) && isset($_SESSION['lname'])) {
                                            echo htmlspecialchars($_SESSION['fname'] . ' ' . $_SESSION['lname']);
                                        } elseif (isset($_SESSION['fname'])) {
                                            echo htmlspecialchars($_SESSION['fname']);
                                        } else {
                                            echo '';
                                        }
                                   ?>">
                        </div>
                        
                        <div class="form-group-inline">
    <label for="title">Title</label>
    <input id="title" 
           type="text" 
           class="form-control" 
           name="title" 
           placeholder="Enter the title.."
           value="<?php echo (isset($_GET['title'])) ? $_GET['title'] : ""; ?>">
</div>

<div class="form-group">
    <label for="details">Details</label>
    <textarea id="details" 
              class="form-control" 
              name="details" 
              placeholder="Enter the details.." 
              rows="5">
        <?php echo isset($_GET['details']) ? $_GET['details'] : ""; ?>
    </textarea>
</div>

<div class="form-group-inline">
    <label for="type">Type of Report</label>
    <input id="type" 
           type="text" 
           name="type" 
           class="form-control" 
           value="" 
           readonly>
</div>

<div class="form-group-inline">
    <label for="report-date">Report Date</label>
    <input id="report-date" 
           type="date" 
           name="date" 
           class="date-picker">
</div>

<div class="form-group-inline">
    <label for="file-upload">Upload File</label>
    <input id="file-upload" 
           type="file" 
           class="form-control" 
           name="image">
</div>

<div class="form-group-inline">
    <label for="uid">UID</label>
    <input id="uid" 
           type="text" 
           class="form-control" 
           name="uid"
           value="<?php 
                if (isset($_SESSION['role']) && $_SESSION['role'] === 'student' && isset($_SESSION['uid'])) {
                    echo htmlspecialchars($_SESSION['uid']);
                } else {
                    echo 'Not available';
                }
           ?>">
</div>

<!-- New fields for pin ID, coordinates, and floor -->
<div class="form-group-inline">
    <label for="pinId">Pin ID</label>
    <input type="text" id="pinId" class="form-control" readonly />
</div>

<div class="form-group-inline">
    <label for="coordinates">Coordinates</label>
    <input type="text" id="coordinates" class="form-control" readonly />
</div>

<div class="form-group-inline">
    <label for="floor">Floor</label>
    <input type="text" id="floor" class="form-control" readonly />
</div>

<div class="button-group">
    <input type="submit" value="Submit" class="btn btn-primary" id="submitButton">
    <button type="button" class="cancel-button" id="cancelRequestButton">Cancel</button>
</div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
