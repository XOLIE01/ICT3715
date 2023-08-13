<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<h1>Apex School Bus Service</h1>
<body>

<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
  }
  .container {
    max-width: 400px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  .tabs {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
  }
  .tab {
    padding: 10px 20px;
    cursor: pointer;
    background-color: #f4f4f4;
    border: 1px solid #ddd;
    border-radius: 5px 5px 0 0;
  }
  .tab.active {
    background-color: #fff;
    border-bottom: 1px solid #fff;
  }
  .content {
    display: none;
    padding: 20px 0;
  }
  .content.active {
    display: block;
  }
  form {
    margin-top: 20px;
}
  label {
    display: block;
    margin-bottom: 5px;
  }
  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 3px;

  }

  input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
  }
</style>

<div class="container">
  <div class="tabs">
    <div class="tab active" onclick="showTab('admin')">Admin Login</div>
    <div class="tab" onclick="showTab('parent')">Parent Login</div>
  </div>
  <div class="content admin-content active" id="admin-content">
    
  <?php if (isset($error_message)) { ?>
                <p><?php echo $error_message; ?></p>
            <?php } ?>
            
            <form method="POST" action="login.php">
                <label>Email:</label>
                <input type="email" name="email" required>
                <br>
                <label>Password:</label>
                <input type="password" name="password" required>
                <br>
                <input type="submit" value="Log in">
                <div class="forgot-password">
      <a href="forgot_password.php">Forgot Password?</a>
    </div>
  
    
      

    </form>
  </div>
  <div class="content parent-content" id="parent-content">
  <form method="POST" action="login.php">
                <label>Email:</label>
                <input type="email" name="email" required>
                <br>
                <label>Password:</label>
                <input type="password" name="password" required>
                <br>
                <input type="submit" value="Log in">
                <div class="forgot-password">
      <a href="forgot_password.php">Forgot Password?</a>
  </div>
</div>

<script>
  function showTab(tabName) {
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => tab.classList.remove('active'));

    const contents = document.querySelectorAll('.content');
    contents.forEach(content => content.classList.remove('active'));

    const selectedTab = document.querySelector(`.${tabName}-content`);
    selectedTab.classList.add('active');

    const activeTab = document.querySelector(`[onclick="showTab('${tabName}')"]`);
    activeTab.classList.add('active');
  }
</script>

<?php

// PHP code for handling administrator and parent logins
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "school_transport";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user input
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare and execute the query for parent
    $stmt = $conn->prepare("SELECT email, password, role FROM parent WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists and verify the password
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            // Successful login
            session_start();
            $_SESSION["user_id"] = $user["email"];

            // Redirect based on user's role
            if ($user["role"] === "parent") {
                header("Location: parent_dashboard.php");
                exit;
            }
        } else {
            $error_message = "Invalid email or password.";
        }
    } else {
        // No parent found, check administrator table
        $stmt_admin = $conn->prepare("SELECT email, password FROM administration WHERE email = ?");
        $stmt_admin->bind_param("s", $email);
        $stmt_admin->execute();
        $result_admin = $stmt_admin->get_result();

        if ($result_admin->num_rows === 1) {
            $admin = $result_admin->fetch_assoc();
            if (password_verify($password, $admin["password"])) {
                // Successful login as administrator
                session_start();
                $_SESSION["user_id"] = $admin["email"];
                header("Location: admin_dashboard.php");
                exit;
            } else {
                $error_message = "Invalid email or password.";
            }
        } else {
            $error_message = "User not found.";
        }
    }

    // Close the database connections
    $stmt->close();
    $stmt_admin->close();
    $conn->close();
}
?>



 
</body>
</html>