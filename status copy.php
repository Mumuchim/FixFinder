<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start(); // Start session to access stored session data

include "db_conn.php";

// Check if the user's role is set in the session
if (isset($_SESSION['role'])) {
    $userRole = $_SESSION['role']; // Retrieve user role from session
} else {
    $userRole = 'student'; // Default to 'student' if no role is found
}

// Debug session role to ensure it's being set correctly
// if (!isset($_SESSION['role'])) {
//     echo "<p>Debug: Session role is not set, defaulting to 'student'.</p>";
// } else {
//     echo "<p>Debug: Session role is set to '$userRole'.</p>";
// }

// Check if pinId is passed via POST
if (isset($_POST['pinId']) && !empty($_POST['pinId'])) {
    $pinId = $_POST['pinId'];
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
            $status = htmlspecialchars($report['status']);
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
    <link rel="stylesheet" href="css/status.css">
    <title>Status Report</title>
</head>
<body class="<?php echo $userRole === 'admin' ? 'admin' : ''; ?>">
<?php if (isset($error_message)): ?>
    <div class="container">
        <p><?php echo $error_message; ?></p>
        <a href="map.php" class="button">Go to Map</a>
    </div>
<?php else: ?>
    <div class="container">
        <img src="upload/<?php echo $image; ?>" alt="Report Image" class="report-img" id="reportImg" onclick="openModal('upload/<?php echo $image; ?>')">
        <div class="details">
            <h3><strong>Title:</strong> <?php echo $title; ?></h3>
            <p><strong>Details:</strong> <?php echo $details; ?></p>
            <p><strong>Type of Report:</strong> <?php echo $type; ?></p>
            <div class="status">
                <p><strong>Status:</strong> <span id="status-text"><?php echo $status ?: 'Not Available'; ?></span></p>
            </div>
            <p class="reporter-name"><strong>Reporter:</strong> <?php echo $reporter; ?></p>

            <a href="<?php echo $userRole === 'admin' ? 'admin_dashboard.php' : 'map.php'; ?>" class="button">Go to Map</a>

            <?php if ($userRole === 'admin'): ?>
    <a href="#" class="button accept-button admin-only" onclick="updateStatus('In Progress')">Accept</a>
    <a href="#" class="button deny-button admin-only" onclick="updateStatus('Denied')">Deny</a>
    <a href="#" class="button mark-done-button admin-only" style="display: none;" onclick="updateStatus('Done')">Mark as Done</a>
    <a href="#" class="button cancel-button admin-only" style="display: none;" onclick="updateStatus('Cancelled')">Cancel</a>
<?php endif; ?>
<!-- <a href="map.php" class="button go-to-map-button">Go to Map</a> -->


        </div>
    </div>

    <div id="imageModal" class="modal" onclick="closeModal()">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImg">
    </div>
<?php endif; ?>
</body>


<script>

// Check if activePinClicked exists in localStorage
const activePinClicked = localStorage.getItem('activePinClicked');

if (activePinClicked) {
    fetch('status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'pinId=' + encodeURIComponent(activePinClicked)
    })
    .then(response => response.text())
    .then(data => {
        document.body.innerHTML = data;
    })
    .catch(error => {
        console.error('Error:', error);
    });
} else {
    console.error('activePinClicked not found in localStorage.');
}

// Function to update the status
// Function to update the status and remove the pin
function updateStatus(newStatus) {
    const pinId = localStorage.getItem('activePinClicked');

    if (!pinId) {
        alert('No active pin ID found.');
        return;
    }

    fetch('update_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `pinId=${encodeURIComponent(pinId)}&status=${encodeURIComponent(newStatus)}`,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Status updated successfully!');
            document.getElementById('status-text').textContent = newStatus;

            // After status update, remove the pin from localStorage and the database
            removePin(pinId);

            // Hide the action buttons and navigate back to the map or update UI
            if (newStatus === 'Denied' || newStatus === 'Cancelled') {
                document.querySelector('.deny-button').style.display = 'none';
                document.querySelector('.mark-done-button').style.display = 'none';
                document.querySelector('.cancel-button').style.display = 'none';
            }

            if (newStatus === 'Done') {
                document.querySelector('.mark-done-button').style.display = 'none';
                document.querySelector('.cancel-button').style.display = 'none';
                document.querySelector('.go-to-map-button').style.display = 'inline-block';
            }
        } else {
            alert(`Error: ${data.message}`);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the status.');
    });
}

/// Function to remove the pin from the DOM, localStorage, and database
function removePin(pinId) {
    const mapContainer = document.getElementById('mapContainer');

    // Ensure pinId is the same as the storageKey in the database
    const storageKey = pinId;  // Or use the actual key format if it's different

    fetch('php/remove_pin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ storageKey: storageKey })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Remove Pin Response:', data);  // Debugging: log response

        if (data.success) {
            // Remove pin from the DOM (if it's present)
            const pinElement = document.getElementById(pinId);
            if (pinElement) {
                mapContainer.removeChild(pinElement);
            }

            // Remove pin from localStorage
            localStorage.removeItem(pinId);  // Ensure this matches the stored pinId format

            // Optionally remove pin from pinPositions array if used
            pinPositions = pinPositions.filter(p => p.pinId !== pinId);

            // Save the updated pin positions (if needed)
            savePinPositions();

            // Refresh the page or navigate
            location.reload();
        } else {
            alert('Error removing the pin from the database.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


function openModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImg');
    modalImg.src = imageSrc;
    modal.style.display = 'flex';
}

function closeModal() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none';
}

// Show admin-only buttons for admin users
const userRole = '<?php echo $userRole; ?>';
if (userRole === 'admin') {
    document.querySelectorAll('.admin-only').forEach(button => {
        button.style.display = 'inline-block';
    });
} else {
    console.log('User is not admin. Admin-only buttons are hidden.');
}


</script>
</html>
