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
       body {
            font-family: Arial, sans-serif;
            background-image: url('img/bgmap.png'); /* Add this line */
            background-size: cover; /* Ensures the image covers the whole background */
            background-position: center center; /* Centers the image */
            background-repeat: no-repeat; /* Prevents the image from repeating */
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
            position: relative; /* Required for absolute positioning of child elements */
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
    display: inline-block;
    padding: 10px 20px;
    background-color: #007BFF; /* Default blue color */
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    text-align: center;
    font-size: 16px;
    border: none;
    cursor: pointer;
    margin-right: 30px; /* Adds spacing between buttons */
}

.button:hover {
    background-color: #0056b3; /* Darker blue on hover */
}

.accept-button {
    background-color: #28a745; /* Green for Accept */
}

.accept-button:hover {
    background-color: #218838; /* Darker green on hover */
}

.deny-button {
    background-color: #dc3545; /* Red for Deny */
}

.deny-button:hover {
    background-color: #c82333; /* Darker red on hover */
}


        .reporter-name {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }

        .modal {
    display: none; /* Ensure modal is hidden by default */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8); /* Dimmed background */
    justify-content: center;
    align-items: center;
}


.modal-content {
    max-width: 90%;
    max-height: 90%;
    min-width: 300px; /* Ensure the image is at least 300px wide */
    min-height: 300px; /* Ensure the image is at least 300px tall */
    width: auto;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    animation: zoomIn 0.3s ease;
}


@keyframes zoomIn {
    from {
        transform: scale(0.8);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.close {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px;
    font-weight: bold;
    color: white;
    cursor: pointer;
    background: rgba(0, 0, 0, 0.6); /* Dim the background of the close button */
    padding: 5px 10px;
    border-radius: 50%;
    line-height: 1;
}

.admin-only {
    display: none; /* Default to hidden */
}

body.admin .admin-only {
    display: inline-block; /* Show only for admin users */
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
 
        <!-- <img src="upload/<?php echo $image; ?>" alt="Report Image" class="report-img"> -->
        <img src="upload/<?php echo $image; ?>" alt="Report Image" class="report-img" id="reportImg" onclick="openModal('upload/<?php echo $image; ?>')">

        <div class="details">
            <h3><strong>Title:</strong> <?php echo $title; ?></h3>
            <p><strong>Details:</strong> <?php echo $details; ?></p>
            <p><strong>Type of Report:</strong> <?php echo $type; ?></p>
            <div class="status">
                <p><strong>Status:</strong> <?php echo $status ?: 'Not Available'; ?></p>
            </div>
            <p class="reporter-name"><strong>Reporter:</strong> <?php echo $reporter; ?></p>
            <!-- <a href="map.php" class="button">Go to Map</a>
<a href="#" class="button accept-button">Accept</a>
<a href="#" class="button deny-button">Deny</a> -->

<a href="map.php" class="button">Go to Map</a>
<a href="#" class="button accept-button admin-only">Accept</a>
<a href="#" class="button deny-button admin-only">Deny</a>
        </div>
        
    </div>

    <!-- <div id="imageModal" class="modal" onclick="closeModal()">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImg">
</div> -->
<div id="imageModal" class="modal" onclick="closeModal()">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImg">
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

//     function openModal(imageSrc) {
//     const modal = document.getElementById('imageModal');
//     const modalImg = document.getElementById('modalImg');
//     modal.style.display = 'flex'; // Flexbox for proper centering
//     modalImg.src = imageSrc;
// }

// function closeModal() {
//     const modal = document.getElementById('imageModal');
//     modal.style.display = 'none';
// }

function openModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImg');
    
    // Set image source and display modal
    modalImg.src = imageSrc;
    modal.style.display = 'flex';
}

function closeModal() {
    const modal = document.getElementById('imageModal');
    
    // Hide modal
    modal.style.display = 'none';
}

// Hide modal when the page loads
window.onload = function () {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none';
};

// Assume userRole is dynamically set
const userRole = 'student'; // Replace with actual logic to determine role

// Hide admin-only buttons if the user is not an admin
if (userRole === 'student') {
    document.querySelectorAll('.admin-only').forEach(button => {
        button.style.display = 'none';
    });
}


</script>

</body>
</html>
