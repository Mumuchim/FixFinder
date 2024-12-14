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
            $specific_place = htmlspecialchars($report['specific_place']);
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
            <p><strong>Specific Place of Report:</strong> <?php echo $specific_place; ?></p>
            <p><strong>Type of Report:</strong> <?php echo $type; ?></p>
            <div class="status">
                <p><strong>Status:</strong> <span id="status-text"><?php echo $status ?: 'Not Available'; ?></span></p>
            </div>
            <p class="reporter-name"><strong>Reporter:</strong> <?php echo $reporter; ?></p>

            <a href="<?php echo $userRole === 'admin' ? 'admin_dashboard.php' : 'map.php'; ?>" class="button">Go to Map</a>

            <?php if ($userRole === 'admin'): ?>
                <a href="#" class="button accept-button admin-only" style="<?php echo $status === 'Pending' ? 'display: inline-block;' : 'display: none;'; ?>" onclick="updateStatus('In Progress')">Accept</a>
                <a href="#" class="button deny-button admin-only" style="<?php echo $status === 'Pending' ? 'display: inline-block;' : 'display: none;'; ?>" onclick="updateStatus('Denied')">Deny</a>
                <a href="#" class="button mark-done-button admin-only" style="<?php echo $status === 'In Progress' ? 'display: inline-block;' : 'display: none;'; ?>" onclick="updateStatus('Done')">Mark as Done</a>
                <a href="#" class="button cancel-button admin-only" style="<?php echo $status === 'In Progress' ? 'display: inline-block;' : 'display: none;'; ?>" onclick="updateStatus('Cancelled')">Cancel</a>
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

function updateStatus(newStatus) {
    const pinId = localStorage.getItem('activePinClicked');

    if (!pinId) {
        alert('No active pin ID found.');
        return;
    }

    // Exempt 'Accept' status from deletion process
    if (newStatus === 'In Progress') {
        // Update the status to 'In Progress' without deleting the pin
        fetch('update_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `pinId=${encodeURIComponent(pinId)}&status=${encodeURIComponent(newStatus)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
    alert('Status updated to "In Progress"');
    document.querySelector('.accept-button').style.display = 'none';
    document.querySelector('.deny-button').style.display = 'none';
    document.querySelector('.mark-done-button').style.display = 'inline-block';
    document.querySelector('.cancel-button').style.display = 'inline-block';
    location.reload();
} else if (data.error) { // Assuming you are checking for a different condition
    alert(`Error: ${data.message}`);
} else {
    document.querySelector('.mark-done-button').style.display = 'none';
    document.querySelector('.cancel-button').style.display = 'none';
}

        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the status.');
        });
        return; // Exit the function without deleting the pin
    }

    // If status is not 'In Progress', continue with deletion process
    fetch('update_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `pinId=${encodeURIComponent(pinId)}&status=${encodeURIComponent(newStatus)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Status updated successfully!');
            document.getElementById('status-text').textContent = newStatus;

            // Delete the pin from localStorage if it's not 'In Progress'
            if (newStatus !== 'In Progress') {
                const pinData = localStorage.getItem(pinId); // Fetch the pin data based on pinId
                if (pinData && localStorage.getItem('activePinClicked') === pinId) {
                    localStorage.removeItem(pinId); // Remove the pin data
                    localStorage.removeItem('activePinClicked'); // Remove the active pin clicked reference
                    console.log(`Pin with ID ${pinId} removed from localStorage.`);
                }

                // Call remove_pin.php to remove the pin from the database
                fetch('php/remove_pin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ storageKey: pinId }) // Send the pin's storageKey (pinId) to be removed
                })
                .then(response => response.json())
                .then(dbData => {
                    if (dbData.success) {
                        console.log(`Pin with ID ${pinId} removed from the database.`);
                    } else {
                        console.error('Failed to remove pin from the database:', dbData.error);
                    }
                })
                .catch(error => {
                    console.error('Error removing pin from the database:', error);
                });
            }

            // Redirect to map.php after a brief delay
            setTimeout(() => {
                console.log('Redirecting to map.php...');
                window.location.href = 'admin_dashboard.php'; // This will immediately redirect to map.php
            }, 500); // 0.5 second delay
        } else {
            alert(`Error: ${data.message}`);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the status.');
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
