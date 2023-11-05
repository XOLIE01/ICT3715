<?php
if (isset($_POST['submit'])) {
    // Get user data from the form
    $parent_name = $_POST['name'];
    $parent_surname = $_POST['surname'];
    $parent_email = $_POST['email'];
    $parent_password = $_POST['password'];
    $parent_phone_number = $_POST['cell_number'];

    $learner_first_name = $_POST['learnerFirstName'];
    $learner_last_name = $_POST['learnerLastName'];
    $cellnumber = $_POST['learnerNumber'];
    $grade = $_POST['grade'];
    $bus_route = $_POST['bus'];

    // Database connection
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=school_transport", "root", '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully!";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit; // Exit script on database connection failure
    }

    // Insert parent data into the parent table using prepared statements
    $parentSql = "INSERT INTO parent (`name`, `surname`, `password`, `cell_number`, `email`) VALUES (?, ?, ?, ?, ?)";

    $parentStmt = $pdo->prepare($parentSql);
    $parentStmt->execute([$parent_name, $parent_surname, $parent_password, $parent_phone_number, $parent_email]);

    // Check if the parent insert was successful
    if ($parentStmt->rowCount() > 0) {
        // Parent registered successfully

        // Check the number of registered learners for the parent
        $learnerCountSql = "SELECT COUNT(*) FROM learners l INNER JOIN parent p ON l.parent_id = p.parent_id WHERE p.email = ?";
        $learnerCountStmt = $pdo->prepare($learnerCountSql);
        $learnerCountStmt->execute([$parent_email]);
        $learnerCount = $learnerCountStmt->fetchColumn();

        // Limit the number of learners to 15
        if ($learnerCount >= 15) {
            $registrationStatus = 'Waiting';
        } else {
            $registrationStatus = 'Registered';
        }

        // Get the parent's ID
        $parentIDSql = "SELECT parent_id FROM parent WHERE email = ?";
        $parentIDStmt = $pdo->prepare($parentIDSql);
        $parentIDStmt->execute([$parent_email]);
        $parentID = $parentIDStmt->fetchColumn();

        // Insert learner data into the learner table using prepared statements
        $learnerSql = "INSERT INTO learners (Parent_id, `First_Name`, `Last_Name`, `Cell_Number`, `Grade`) VALUES (?, ?, ?, ?, ?)";

        $learnerStmt = $pdo->prepare($learnerSql);
        $learnerStmt->execute([$parentID, $learner_first_name, $learner_last_name, $cellnumber, $grade]);

        // Check if the learner insert was successful
        if ($learnerStmt->rowCount() > 0) {
            // User and learner registered successfully
            echo "Learner registration successful!";
        } else {
            echo "Error: Learner registration failed";
        }
    } else {
        echo "Error: Parent registration failed";
    }

    // Fetch bus data from the bus_route_information table
    $busDataSql = "SELECT `morning_Pickup_Number`, `morning_Pickup_Name`, `morning_Pickup_Time`, `afternoon_Dropoff_Number`, `afternoon_Dropoff_Name`, `afternoon_Dropoff_Time` FROM bus_route_information WHERE bus_route = :bus_route";
    $busDataStmt = $pdo->prepare($busDataSql);
    $busDataStmt->bindParam(':bus_route', $bus_route, PDO::PARAM_STR);
    $busDataStmt->execute();
    
    $busInfo = $busDataStmt->fetch(PDO::FETCH_ASSOC);
    

    if ($busInfo) {
        // Insert bus-specific information into the bus_info table
        $busSql = "INSERT INTO bus_info (`morningPickupNumber`, `morningPickupName`, `morningPickupTime`, `afternoonDropoffNumber`, `afternoonDropoffName`, `afternoon_Drop_off_Time`) VALUES (?, ?, ?, ?, ?, ?)";

        $busStmt = $pdo->prepare($busSql);
        $busStmt->execute([
            $busInfo['morningPickupNumber'],
            $busInfo['morningPickupName'],
            $busInfo['morningPickupTime'],
            $busInfo['afternoonDropoffNumber'],
            $busInfo['afternoonDropoffName'],
            $busInfo['afternoonDropoffTime']
        ]);

        if ($busStmt->rowCount() > 0) {
            echo "Bus information registered successfully!";
        } else {
            echo "Error: Bus information registration failed";
        }
    } else {
        echo "Error: Bus information not found for the selected route";
    }

    // Sending acknowledgment email
    $to = $parent_email; // Use parent's email for acknowledgment
    $subject = "Registration Acknowledgment";
    $message = "Thank you for registering!";
    $headers = "From: your_email@gmail.com"; // Replace with your Gmail email address
    
    // Send email using a secure connection (TLS)
    if (mail($to, $subject, $message, $headers)) {
        echo "Acknowledgment email sent successfully!";
    } else {
        echo "Error: Email sending failed.";
    }
}
