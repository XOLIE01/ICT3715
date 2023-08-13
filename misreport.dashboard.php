<!DOCTYPE html>
<html>
<head>
    <title>School Kids MIS Report</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<?php

$servername = "localhost";
$username = "root";
$password = ""; // Leave it empty for no password
$dbname = "school_transport";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$type = $_GET['type'];
$date = $_GET['date'];




if (isset($_GET['type']) && isset($_GET['date'])) {
    $type = $_GET['type'];
    $date = $_GET['date'];
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = [
    "labels" => [],
    "data" => []
];

if ($type === "daily") {
    // Fetch kids data for the selected date
    // Perform necessary database queries and processing
   
    $data["labels"] = ["Morning", "Afternoon"];
    $data["data"] = [30, 40];
} elseif ($type === "weekly") {
    // Fetch kids data for the selected week
    // Perform necessary database queries and processing

    $data["labels"] = ["Week 1", "Week 2", "Week 3"];
    $data["data"] = [100, 120, 90];
} elseif ($type === "monthly") {
    // Fetch kids data for the selected month
    // Perform necessary database queries and processing
    
    $data["labels"] = ["Jan", "Feb", "Mar", "Apr"];
    $data["data"] = [250, 280, 300, 270];
}

$conn->close();

echo json_encode($data);
?>




<body>
    <h1>School Kids MIS Report</h1>
    
    <div class="controls">
        <label for="reportType">Select Report Type:</label>
        <select id="reportType">
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
        </select>
        
        <div id="dateContainer">
            <label for="selectDate">Select Date:</label>
            <input type="date" id="selectDate">
        </div>
        
        <button id="searchBtn">Search</button>
    </div>
    
    <div class="chart-container">
        <canvas id="barChart"></canvas>
    </div>
    
    <script src="Chart.min.js"></script>
    <script src="script.js"></script>
</body>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // ...

    searchBtn.addEventListener("click", function() {
        const selectedReportType = reportType.value;
        const selectedDate = selectDate.value;
        fetchReportData(selectedReportType, selectedDate);
    });
    
    function fetchReportData(reportType, date) {
        const url = `data.php?type=${encodeURIComponent(selectedReportType)}&date=${encodeURIComponent(selectedDate)}`;

        fetch(url)
            .then(response => response.json())
            .then(data => displayChart(data.labels, data.data))
            .catch(error => console.error('Error fetching data:', error));
    }

    // ...
});

</html>
