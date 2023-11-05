<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apex School Bus Service</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>

h1 {
  text-align: center;
  font-style: italic
}
body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-image: url('school.png'); 
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-color: rgba(0, 0, 0, 0.5); 
    }


  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
  }
  .container {
    max-width: 400px;
    margin: 0 auto;
    background-color: #ADD8E6;
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
    background-color: #F7D560;
    border-bottom: 1px solid #F7D560
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

/* CSS for the tab container */
.tab-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

/* CSS for the tab container */
.tab-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

/* Styling for the tab */
.tab {
    cursor: pointer;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.tab:hover {
    background-color: #0056b3;
}



        /* Additional CSS styles for this page */
        body {
            font-family: Arial, sans-serif;
        }

        /* MIS Report tab styles */
        .mis-report-tab {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .mis-report-tab:hover {
            background-color: #0056b3;
        }

        /* Tab container styles */
        .tab-container {
            text-align: right;
        }

        /* Main heading styles */
        h1 {
            text-align: center;
            margin-top: 40px;
        }
    </style>

<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=school_transport", "root", '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Define an error message variable
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Perform admin login query
    $admin_sql = "SELECT * FROM administrator WHERE email = :email AND password = :password";
    $admin_stmt = $pdo->prepare($admin_sql);
    $admin_stmt->bindParam(':email', $email);
    $admin_stmt->bindParam(':password', $password);
    $admin_stmt->execute();
    
    // Perform parent login query
    $parent_sql = "SELECT * FROM parent WHERE email = :email AND password = :password";
    $parent_stmt = $pdo->prepare($parent_sql);
    $parent_stmt->bindParam(':email', $email);
    $parent_stmt->bindParam(':password', $password);
    $parent_stmt->execute();


// Check for admin login success
if ($admin_stmt->rowCount() > 0) {
    // Admin login successful, redirect to the admin dashboard
    header("Location: admin_dashboard.php");
    exit;
} 

if ($parent_stmt->rowCount() > 0) {
    echo "Parent login successful!";
} else {
    // Invalid credentials
    $error_message = "Invalid credentials";
}
}

?>
    
</head>
<body>
    <!-- MIS Report tab -->
    <div class="mis-report-tab" onclick="openMISReport()">MIS Report</div>

    <!-- Your existing content -->
    <h1>Apex School Bus Service</h1>

    <div class="container">
        <div class="tabs">
        <div class="tab active" onclick="showTab('admin')">Admin Login</div>
            <div class="tab" onclick="showTab('parent')">Parent Login</div>
        </div>
        <div class="content admin-content active" id="admin-content">
            <?php if (!empty($error_message)) { ?>
                <p><?php echo $error_message; ?></p>
            <?php } ?>
            <form action="administrator_dashboard.php" method="post">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required><br>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required><br>
                <input type="submit" value="Login">
                <div class="forgot-password">
                    <a href="forgot_password.php">Forgot Password?</a>
                </div>
            </form>
        </div>

        
        <div class="content parent-content" id="parent-content">
            <form method="POST" action="parent_dashboard.php">
                <label>Email:</label>
                <input type="email" name="email" required><br>
                <label>Password:</label>
                <input type="password" name="password" required><br>
                <input type="submit" value="Log in">
                <div class="forgot-password">
                    <a href="forgot_password.php">Forgot Password?</a>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for tab switching -->
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

        function openMISReport() {
            // Redirect to the MIS report page (e.g., "mis_report.php")
            window.location.href = "mis_report.php";
        }
    </script>
</body>
</html>
