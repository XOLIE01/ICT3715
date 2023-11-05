<!DOCTYPE html>
<html>
<head>
    <title>MIS REPORTS</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<style>
        body {
            background-image: url('capture.png');
            background-size: auto; /* Use "auto" to keep the original size */
            background-repeat: no-repeat; /
        }
    </style>


<body>
    <h2>MIS REPORTS</h2>

    <form action="mis_report.php" method="POST">
        <select id="dropdown" name="reportType">
            <option value="dailyreport">Daily Report</option>
            <option value="weeklyreport">Weekly Report</option>
            <option value="monthlyreport">Monthly Report</option>
        </select>
        <input type="submit" value="Generate Report">
    </form>

    <?php
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=school_transport", "root", '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully!";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    function fetchAllLearners($pdo, $query) {
        $result = $pdo->query($query);
        $learnerData = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $learnerData[] = $row;
        }
        return $learnerData;
    }

    if (isset($_POST['reportType'])) {
        $reportType = $_POST['reportType'];

        if ($reportType === 'dailyreport') {
            $query = "SELECT `Learner_ID`, `First_Name`, `Last_Name`, `GRADE` FROM learners";
            $allLearnersData = fetchAllLearners($pdo, $query);

            echo '<h3>Daily Report</h3>';
            echo '<table>';
            echo '<thead><tr><th>Learner ID</th><th>First Name</th><th>Last Name</th><th>Grade</th></tr></thead>';
            echo '<tbody>';
            foreach ($allLearnersData as $learner) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($learner['Learner_ID']) . '</td>';
                echo '<td>' . htmlspecialchars($learner['First_Name']) . '</td>';
                echo '<td>' . htmlspecialchars($learner['Last_Name']) . '</td>';
                echo '<td>' . htmlspecialchars($learner['GRADE']) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } elseif ($reportType === 'weeklyreport') {
            $query = "SELECT COUNT(*) as `TotalLearners` FROM learners";
            $result = $pdo->query($query);
            $totalLearners = $result->fetchColumn();

            echo '<h3>Weekly Report</h3>';
            echo '<p>Total Learners in the Database: ' . $totalLearners . '</p>';
            echo '<canvas id="learnerGraph" width="400" height="200"></canvas>';
            echo '<script>
                var ctx = document.getElementById("learnerGraph").getContext("2d");
                var learnerData = {
                    labels: ["Total Learners"],
                    datasets: [{
                        label: "Learner Statistics",
                        data: [' . $totalLearners . '],
                        borderColor: "red", // Red line color
                        borderWidth: 2, // Line width
                        fill: false, // No fill under the line
                    }]
                };
                var myChart = new Chart(ctx, {
                    type: "line",
                    data: learnerData,
                });
            </script>';
        } elseif ($reportType === 'monthlyreport') {
            $query = "SELECT `GRADE`, COUNT(*) as `Count` FROM learners GROUP BY `GRADE`";
            $allLearnersData = fetchAllLearners($pdo, $query);

            echo '<h3>Monthly Report</h3>';
            echo '<table>';
            echo '<thead><tr><th>Grade</th><th>Count</th></tr></thead>';
            echo '<tbody>';
            foreach ($allLearnersData as $gradeData) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($gradeData['GRADE']) . '</td>';
                echo '<td>' . htmlspecialchars($gradeData['Count']) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            
            echo '<canvas id="gradeChart" width="400" height="400"></canvas>';
            echo '<script>
                var ctx = document.getElementById("gradeChart").getContext("2d");
                var labels = ' . json_encode(array_column($allLearnersData, 'GRADE')) . ';
                var data = ' . json_encode(array_column($allLearnersData, 'Count')) . ';
                var gradeData = {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            "rgba(75, 192, 192, 1)", // Stronger color
                            "rgba(255, 40, 120, 1)", // Stronger color
                            "rgba(54, 162, 200, 1)", // Stronger color
                            "rgba(255, 206, 86, 1)", // Stronger color
                            "rgba(75, 192, 192, 1)", // Stronger color
                            "rgba(255, 99, 132, 1)", // Stronger color
                            // Add more colors as needed
                        ],
                        borderColor: [
                            "rgba(60, 180, 150, 1)",
                            "rgba(255, 99, 132, 1)",
                            "rgba(54, 162, 200, 1)",
                            "rgba(255, 206, 86, 1)",
                            "rgba(75, 192, 192, 1)",
                            "rgba(220, 55, 120, 1)",
                            // Add more colors as needed
                        ],
                        borderWidth: 1
                    }]
                };

                var myPieChart = new Chart(ctx, {
                    type: "pie",
                    data: gradeData,
                });
            </script>';
        }
    }
    ?>
</body>
</html>
