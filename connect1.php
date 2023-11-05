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
    $learner_cell_number = $_POST['learnerNumber'];
    $grade = $_POST['grade'];
    $bus_route = $_POST['bus'];
    $bus_option = $_POST['busOption'];
    $morningPickupNumber = $_POST['morningPickupNumber'];
    $morningPickupName = $_POST['morningPickupName'];
    $morningPickupTime = $_POST['morningPickupTime'];
    $afternoonDropoffNumber = $_POST['afternoonDropoffNumber'];
    $afternoondropoffName = $_POST['afternoonDropoffName'];
    $afternoondropofftime = $_POST['afternoonDropoffTime'];
    


    try {
        $pdo = new PDO("mysql:host=localhost;dbname=school_transport", "root", '');
     
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully!";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit; // Exit script on database connection failure
    }


        // Insert parent details into the 'parent' table
        $parent_insert_sql = "INSERT INTO parent (Name, Surname, Email, Password, Cell_Number)
                             VALUES (?, ?, ?, ?, ?)";
        $parent_insert_stmt = $pdo->prepare($parent_insert_sql);
        $parent_insert_stmt->execute([$parent_name, $parent_surname, $parent_email, $parent_password, $parent_phone_number]);

        // Get the parent ID of the newly inserted parent
        $parent_id = $pdo->lastInsertId();

        // Insert learner details into the 'learners' table with relevant columns
        $learner_insert_sql = "INSERT INTO learners (First_Name, Last_Name, Cell_Number, Grade, morningPickupNumber, morningPickupName, morningPickupTime, afternoonDropoffNumber, afternoondropoffName, afternoondropofftime, parent_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $learner_insert_stmt = $pdo->prepare($learner_insert_sql);
        $learner_insert_stmt->execute([$learner_first_name, $learner_last_name, $learner_cell_number, $grade, $morningPickupNumber, $morningPickupName, $morningPickupTime, $afternoonDropoffNumber, $afternoondropoffName, $afternoondropofftime, $parent_id]);

        echo "Registration successful!";


if (isset($_POST['submit'])) {
    // ... (previous code to insert data into the database)

    // Email configuration
    $to = $_POST['email']; // Parent's email address
    $subject = "Registration Successful";
    $message = "Thank you for registering. Your registration was successful.";
    $headers = "From: your-email@gmail.com"; // Your Gmail address
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Send the email using Gmail's SMTP server
    if (mail($to, $subject, $message, $headers)) {
        echo "Registration successful! An email has been sent to confirm your registration.";
    } else {
        echo "Email could not be sent. Please check your email settings.";
    }

    // Close the database connection
    $pdo =
     null;
}
}
?>
