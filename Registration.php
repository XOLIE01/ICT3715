<!DOCTYPE html>
<html lang="en">
<head>

<?php
// Establish a database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=school_transport", "root", '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

if (isset($_POST['bus'])) {
    $bus = $_POST['bus'];

    // Query the database for pickup details based on the selected bus
    $query = "SELECT pickup_number, pickup_name, pickup_time FROM bus1 WHERE bus1 = :bus";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':bus', $bus);
    $stmt->execute();

    $pickupDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the pickup details as JSON
    echo json_encode($pickupDetails);
} else {
    // Handle the case when 'bus' is not in the POST request
    echo json_encode(["pickupNumber" => "N/A", "pickupName" => "N/A", "pickupTime" => "N/A"]);
}

?>
</head>
<body>
    <h1>School Transport Application</h1>

    <h2>Parent Information</h2>
    <form action="process_application.php" method="post">
        <label for="name">Name and Surname:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="email">Password:</label>
        <input type="password" name="email" id="password" required><br>

        <label for="phone">Phone:</label>
        <input type="tel" name="phone" id="phone" required><br>

    <h2>Learners Information</h2>
    <label for="name">Name and Surname :</label>
        <input type="text" name="name" id="name" required><br>

        <label for="phone">Phone:</label>
        <input type="tel" name="phone" id="phone" required><br>

        <label for="grade">Select Grade:</label>
        <select name="grade" id="grade" required>
            <option value="Grade 8">Grade 8</option>
            <option value="Grade 9">Grade 9</option>
            <option value="Grade 10">Grade 10</option>
            <option value="Grade 11">Grade 11</option>
            <option value="Grade 12">Grade 12</option>
        </select><br>

    <label for="bus">Select Bus:</label>
    <select name="bus" id="bus" required onchange="showPickupDetails()">
        <option value="Bus 1">Bus1</option>
        <option value="Bus 2">Bus2</option>
        <option value="Bus 3">Bus3</option>
    </select><br>

    <h3>Morning Pick up</h3>

  

<div id="pickupDetails" style="display: none;">
    <label for="pickupNumber">Pickup Number:</label>
    <span id="pickupNumber"></span><br>

    <label for="pickupName">Pickup Name:</label>
    <span id="pickupName"></span><br>

    <label for="pickupTime">Pickup Time:</label>
    <span id="pickupTime"></span><br>
</div>




    <h3>Afternoon Drop off</h3>
    <div id="afternoonDropoffDetails" style="display: none;">
        <label for="dropoffNumber">Dropoff Number:</label>
        <span id="afternoonDropoffNumber"></span><br>

        <label for="dropoffName">Dropoff Name:</label>
        <span id="afternoonDropoffName"></span><br>

        <label for="dropoffTime">Dropoff Time:</label>
        <span id="afternoonDropoffTime"></span><br>
    </div>

    <input type="submit" value="Submit Application">

    <script>
        function showPickupDetails() {
            const busSelect = document.getElementById('bus');
            const morningPickupDetails = document.getElementById('morningPickupDetails');
            const afternoonDropoffDetails = document.getElementById('afternoonDropoffDetails');
            const selectedBus = busSelect.value;

            if (selectedBus) {
                // Use AJAX to fetch pickup details from the server
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'get_pickup_details.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const data = JSON.parse(xhr.responseText);

                        if (data.isMorning) {
                            document.getElementById('morningPickupNumber').textContent = data.pickupNumber;
                            document.getElementById('morningPickupName').textContent = data.pickupName;
                            document.getElementById('morningPickupTime').textContent = data.pickupTime;
                            morningPickupDetails.style.display = 'block';
                            afternoonDropoffDetails.style.display = 'none';
                        } else {
                            document.getElementById('afternoonDropoffNumber').textContent = data.pickupNumber;
                            document.getElementById('afternoonDropoffName').textContent = data.pickupName;
                            document.getElementById('afternoonDropoffTime').textContent = data.pickupTime;
                            afternoonDropoffDetails.style.display = 'block';
                            morningPickupDetails.style.display = 'none';
                        }
                    }
                };
                xhr.send('bus=' + selectedBus);
            } else {
                morningPickupDetails.style.display = 'none';
                afternoonDropoffDetails.style.display = 'none';
            }
        }
    </script>
</body>
</html>