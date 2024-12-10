const activePinClicked = localStorage.getItem('activePinClicked');

if (activePinClicked) {
    // Send the activePinClicked value to the PHP script
    fetch('your_php_script.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'pinId=' + encodeURIComponent(activePinClicked)  // Send pinId as POST data
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response from PHP
        if (data.error) {
            alert(data.error); // Handle error if no report found or database issue
        } else {
            // Process the response (populate report details, etc.)
            console.log(data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
} else {
    console.error('activePinClicked not found in localStorage.');
}