<!DOCTYPE html>
<html>
<head>
    <title>Administrator Registration</title>
    <style>
        /* Global styles (unchanged) */
    </style>
</head>
<body>
    <div class="container">
        <div class="row col-md-6 col-md-offset-3">
            <div class="panel-heading text-center">
                <h2>Administrator Registration</h2>
                <form action="connect1.php" method="POST" id="registration">
                    <!-- Parent Information -->
                    <h3>Parent Information</h3>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                    <br>
                    <label for="surname">Surname:</label>
                    <input type="text" id="surname" name="surname" required>
                    <br>
                    <label for="cell_number">Cell Number:</label>
                    <input type="text" id="cell_number" name="cell_number" required>
                    <br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <br>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <br>

                    <!-- Learner Information -->
                    <h3>Learner Information</h3>
                    <label for="learnerFirstName">First Name:</label>
                    <input type="text" id="learnerFirstName" name="learnerFirstName" required>
                    <br>
                    <label for="learnerLastName">Last Name:</label>
                    <input type="text" id="learnerLastName" name="learnerLastName" required>
                    <br>
                    <label for="learnerNumber">Cell Number:</label>
                    <input type="text" id="learnerNumber" name="learnerNumber" required>
                    <br>
                    <label for="grade">Grade:</label>
                    <select name="grade">
                        <option value="Grade 8">Grade 8</option>
                        <option value="Grade 9">Grade 9</option>
                        <option value="Grade 10">Grade 10</option>
                        <option value="Grade 11">Grade 11</option>
                        <option value="Grade 12">Grade 12</option>
                    </select>

                    <!-- Bus Information -->
                    <label for="bus">Bus route:</label>
                    <select name="bus" id="busSelect">
                        <option value="Bus 1">Bus 1</option>
                        <option value="Bus 2">Bus 2</option>
                        <option value="Bus 3">Bus 3</option>
                    </select>

                    <!-- Container for additional bus options (1A, 1B, etc.) -->
                    <div id="additionalOptions">
                        <label for="busOption">Select bus option:</label>
                        <select name="busOption" id="busOptionSelect">
                            <!-- This will be populated dynamically using JavaScript -->
                        </select>
                    </div>

                    <div id="busInfo" style="display: none">
                        <!-- Information fields for bus route will be displayed here using JavaScript -->
                    </div>

                    <input type="submit" name="submit" class="btn" value="Register">
                    <button class="btn" onclick="window.location.href='your-cancel-url';">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const busSelect = document.getElementById("busSelect");
        const busOptionSelect = document.getElementById("busOptionSelect");
        const busInfo = document.getElementById("busInfo");

        // Bus information object for each bus route
        const busInformation = {
            "Bus 1": {
                "1A": {
                    morningPickupNumber: "1A",
                    morningPickupName: "Corner of Panorama and Marabou Road",
                    morningPickupTime: "06:22 AM",
                    afternoonDropoffNumber: "A1",
                    afternoonDropoffName: "Corner of Panorama and Marabou Road",
                    afternoonDropoffTime: "14:30 PM"
                },
                "1B": {
                    morningPickupNumber: "1B",
                    morningPickupName: "Corner of Kolgansstraat and Skimmerstraat",
                    morningPickupTime: "06:30 AM",
                    afternoonDropoffNumber: "1B",
                    afternoonDropoffName: "Corner of Kolgansstraat and Skimmerstraat",
                    afternoonDropoffTime: "14:39 PM"
                }
            },
            "Bus 2": {
                "2A": {
                    morningPickupNumber: "2A",
                    morningPickupName: "Corner of Reddersburg Street and Mafeking Drive",
                    morningPickupTime: "06:25 AM",
                    afternoonDropoffNumber: "2A",
                    afternoonDropoffName: "Corner of Reddersburg Street and Mafeking Drive",
                    afternoonDropoffTime: "14:25 PM"
                },
                "2B": {
                    morningPickupNumber: "2B",
                    morningPickupName: "Corner of Theuns van Niekerkstraat and Roosmarynstraat",
                    morningPickupTime: "06:35 AM",
                    afternoonDropoffNumber: "2B",
                    afternoonDropoffName: "Corner of Theuns van Niekerkstraat and Roosmarynstraat",
                    afternoonDropoffTime: "14:30 PM"
                }
            },
            "Bus 3": {
                "3A": {
                    morningPickupNumber: "3A",
                    morningPickupName: "Corner of Jasper Drive and Tieroog Street",
                    morningPickupTime: "06:20 AM",
                    afternoonDropoffNumber: "3A",
                    afternoonDropoffName: "Corner of Jasper Drive and Tieroog Street",
                    afternoonDropoffTime: "14:30 PM"
                },
                "3B": {
                    morningPickupNumber: "3B",
                    morningPickupName: "Corner of Louise Street and Von Willich Drive",
                    morningPickupTime: "06:40 AM",
                    afternoonDropoffNumber: "3B",
                    afternoonDropoffName: "Corner of Louise Street and Von Willich Drive",
                    afternoonDropoffTime: "14:40 PM"
                }
            }
        };

        busSelect.addEventListener("change", function () {
            const selectedBus = this.value;
            const busOptions = busInformation[selectedBus];

            // Clear previous bus info
            busInfo.innerHTML = "";

            // Clear and populate the bus option dropdown based on the selected bus route
            busOptionSelect.innerHTML = '';
            for (const option in busOptions) {
                const optionElement = document.createElement("option");
                optionElement.value = option;
                optionElement.textContent = option;
                busOptionSelect.appendChild(optionElement);
            }

            // Show the additional options
            document.getElementById("additionalOptions").style.display = "block";
        });

        busOptionSelect.addEventListener("change", function () {
            const selectedBus = busSelect.value;
            const selectedOption = this.value;
            const busData = busInformation[selectedBus][selectedOption];

            busInfo.innerHTML = `
                <h3>${selectedBus} Information</h3>
                <label for="morningPickupNumber">Morning Pickup Number:</label>
                <input type="text" name="morningPickupNumber" value="${busData.morningPickupNumber}" required>
                <br>
                <label for="morningPickupName">Morning Pickup Name:</label>
                <input type="text" name="morningPickupName" value="${busData.morningPickupName}" required>
                <br>
                <label for="morningPickupTime">Morning Pickup Time:</label>
                <input type="text" name="morningPickupTime" value="${busData.morningPickupTime}" required>
                <br>
                <label for="afternoonDropoffNumber">Afternoon Dropoff Number:</label>
                <input type="text" name="afternoonDropoffNumber" value="${busData.afternoonDropoffNumber}" required>
                <br>
                <label for="afternoonDropoffName">Afternoon Dropoff Name:</label>
                <input type="text" name="afternoonDropoffName" value="${busData.afternoonDropoffName}" required>
                <br>
                <label for="afternoonDropoffTime">Afternoon Dropoff Time:</label>
                <input type="text" name="afternoonDropoffTime" value="${busData.afternoonDropoffTime}" required>
            `;

            // Show the bus info
            busInfo.style.display = "block";
        });
    </script>
</body>
</html>
