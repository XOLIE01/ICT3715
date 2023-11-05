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
}
    ?>