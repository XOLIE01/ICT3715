<form id="waitingListForm" method="POST">
    <label for="firstName">First Name:</label>
    <input type="text" id="firstName" name="firstName" required><br>
    
    <label for="lastName">Last Name:</label>
    <input type="text" id="lastName" name="lastName" required><br>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>
    
    <label for="cellNumber">Cell Number:</label>
    <input type="text" id="cellNumber" name="cellNumber" required><br>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>
    
    <button type="submit" name="submit">Add to Waiting List</button>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $cellNumber = $_POST['cellNumber'];
    $email = $_POST['email'];

    $insertQuery = "INSERT INTO waitinglist (FirstName, LastName, Password, CellNumber, Email) VALUES (:firstName, :lastName, :password, :cellNumber, :email)";
    $insertStatement = $pdo->prepare($insertQuery);
    $insertStatement->bindParam(':firstName', $firstName);
    $insertStatement->bindParam(':lastName', $lastName);
    $insertStatement->bindParam(':password', $password);
    $insertStatement->bindParam(':cellNumber', $cellNumber);
    $insertStatement->bindParam(':email', $email);
    
    if ($insertStatement->execute()) {
        echo "New waiting list entry added successfully.";
    } else {
        echo "Error adding waiting list entry.";
    }
}


?>