<html>
<head>
    <h3>Registration Form</h3>
</head>

<body>
<div class="container">
    <div class="row col-md-6 col-md-offset-3">
        <div class="panel-heading text-center">
            <style>
                /* Global styles */
                body {
                    font-family: Arial, sans-serif;
                }

                h3 {
                    text-align: center;
                }

                /* Center the form */
                .container {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }

                /* Form styles */
                .panel-body {
                    width: 400px;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                }

                .form-group {
                    margin-bottom: 15px;
                }

                label {
                    display: block;
                }

                input[type="text"],
                input[type="email"],
                input[type="password"],
                select {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                }

                select.form-control {
                    width: 100%;
                }

                .btn {
                    background-color: #555;
                    color: white;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }

                .btn:hover {
                    background-color: #333;
                }


                <style>
   
    .btn {
        background-color: #555;
        color: white;
        padding: 12px 24px; /* Increase padding to make the button bigger */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 10px; /* Add margin to separate buttons */
    }

    .btn:hover {
        background-color: #333;
    }
            </style>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
</head>
<body>
    <h2>Parent and Learner Registration</h2>

    <form action="connect.php" method="POST">
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

<!-- Container for additional bus options (1A, 1B, 2A, 2B, 3A, 3B) -->
<div id="additionalOptions">
    <label for="busOption">Select bus option:</label>
    <select name="busOption" id="busOptionSelect">
    <option value="1A">1A</option>
    <option value="1B">1A</option>
    <option value="2A">2A</option>
    <option value="2B">2B</option>
    <option value="3A">3A</option>
    <option value="3B">3B</option>
    </select>
</div>

<div id="busInfo" style="display: none">
    <!-- Information fields go here -->
</div>

<!-- Submit and Cancel Buttons -->
<div>
    <input type="submit" name="submit" class="btn" value="Register">
    <button class="btn" onclick="window.location.href='your-cancel-url';">Cancel</button>
</div>
</form>
</div>

<script>
    // Get references to the select elements and container
    const busSelect = document.getElementById("busSelect");
    const busOptionSelect = document.getElementById("busOptionSelect");
    const additionalOptions = document.getElementById("additionalOptions");
    const busInfo = document.getElementById("busInfo");

    // Bus data for different routes
    const busData = {
        "Bus 1": ["1A", "1B"],
        "Bus 2": ["2A", "2B"],
        "Bus 3": ["3A", "3B"],
    };

    function updateAdditionalOptions() {
        const selectedBus = busSelect.value;
        const busOptions = busData[selectedBus];

        if (busOptions) {
            additionalOptions.style.display = "block";
            busOptionSelect.innerHTML = "";

            // Populate the bus option select element
            busOptions.forEach(option => {
                const optionElement = document.createElement("option");
                optionElement.value = option;
                optionElement.textContent = option;
                busOptionSelect.appendChild(optionElement);
            });
            busOptionSelect.value = busOptions[0];
        } else {
            additionalOptions.style.display = "none";
            busOptionSelect.innerHTML = "";
            busInfo.style.display = "none";
        }
    }
    function displayBusInfo(selectedBus, selectedOption) {
        // Modify this part to fetch information from your data source (e.g., database)

        // Example data for demonstration
        const exampleData = {
            "Bus 1": {
                "1A": {
                    morningPickupNumber: "1A Morning Pickup Number",
                    morningPickupName: "1A Morning Pickup Name",
                    morningPickupTime: "1A Morning Pickup Time",
                    afternoonDropoffNumber: "1A Afternoon Dropoff Number",
                    afternoonDropoffName: "1A Afternoon Dropoff Name",
                    afternoonDropoffTime: "1A Afternoon Dropoff Time",
                },
                "1B": {
                    morningPickupNumber: "1B Morning Pickup Number",
                    morningPickupName: "1B Morning Pickup Name",
                    morningPickupTime: "1B Morning Pickup Time",
                    afternoonDropoffNumber: "1B Afternoon Dropoff Number",
                    afternoonDropoffName: "1B Afternoon Dropoff Name",
                    afternoonDropoffTime: "1B Afternoon Dropoff Time",
                },
                "2A": {
                    morningPickupNumber: "2A Morning Pickup Number",
                    morningPickupName: "2A Morning Pickup Name",
                    morningPickupTime: "2A Morning Pickup Time",
                    afternoonDropoffNumber: "2A Afternoon Dropoff Number",
                    afternoonDropoffName: "2A Afternoon Dropoff Name",
                    afternoonDropoffTime: "2A Afternoon Dropoff Time",
                },
                "2B": {
                    morningPickupNumber: "2B Morning Pickup Number",
                    morningPickupName: "2B Morning Pickup Name",
                    morningPickupTime: "2B Morning Pickup Time",
                    afternoonDropoffNumber: "2B Afternoon Dropoff Number",
                    afternoonDropoffName: "2B Afternoon Dropoff Name",
                    afternoonDropoffTime: "2B Afternoon Dropoff Time",
                },

                "3A": {
                    morningPickupNumber: "3A Morning Pickup Number",
                    morningPickupName: "3A Morning Pickup Name",
                    morningPickupTime: "3A Morning Pickup Time",
                    afternoonDropoffNumber: "3A Afternoon Dropoff Number",
                    afternoonDropoffName: "3A Afternoon Dropoff Name",
                    afternoonDropoffTime: "3A Afternoon Dropoff Time",
                },
                "3B": {
                    morningPickupNumber: "3B Morning Pickup Number",
                    morningPickupName: "3B Morning Pickup Name",
                    morningPickupTime: "3B Morning Pickup Time",
                    afternoonDropoffNumber: "3B Afternoon Dropoff Number",
                    afternoonDropoffName: "3B Afternoon Dropoff Name",
                    afternoonDropoffTime: "3B Afternoon Dropoff Time",
                },
            },
        };

        const busOptionData = exampleData[selectedBus][selectedOption];

if (busOptionData) {
    // Display the information fields
    busInfo.innerHTML = `
        <label for="morningPickupNumber">${busOptionData.morningPickupNumber}:</label>
        <input type="text" name="morningPickupNumber" value="${busOptionData.morningPickupNumber}" required>

        <label for="morningPickupName">Morning Pickup Name:</label>
        <input type="text" name="morningPickupName" value="${busOptionData.morningPickupName}" required>

        <label for="morningPickupTime">Morning Pickup Time:</label>
        <input type="text" name="morningPickupTime" value="${busOptionData.morningPickupTime}" required>

        <label for="afternoonDropoffNumber">Afternoon Dropoff Number:</label>
                <input type="text" name="afternoonDropoffNumber" value="${busOptionData.afternoonDropoffNumber}" required>
    
                <label for="afternoonDropoffName">Afternoon Dropoff Name:</label>
                <input type="text" name="afternoonDropoffName" value="${busOptionData.afternoonDropoffName}" required>
    
                <label for="afternoonDropoffTime">Afternoon Dropoff Time:</label>
                <input type="text" name="afternoonDropoffTime" value="${busOptionData.afternoonDropoffTime}" required>
            `;
            busInfo.style.display = "block";
        } else {
            // Hide the information fields
            busInfo.innerHTML = "";
            busInfo.style.display = "none";
        }
    }
     // Attach change event listeners to the busSelect and busOptionSelect elements
     busSelect.addEventListener("change", function () {
        updateAdditionalOptions();
        displayBusInfo(busSelect.value, busOptionSelect.value);
    });
    busOptionSelect.addEventListener("change", function () {
        displayBusInfo(busSelect.value, busOptionSelect.value);
    });

    // Call the function initially to set the initial state
    updateAdditionalOptions();




    if (busInfoData[selectedBus]) {
            // Display the bus-specific information fields
            const busData = busInfoData[selectedBus];
            busInfo.innerHTML = `
                <label for="morningPickupNumber">1A:</label>
                <input type="text" name="morningPickupNumber" value="${busData.morningPickupNumber}" required>

                <label for="morningPickupName">Morning Pickup Name:</label>
                <input type="text" name="morningPickupName" value="${busData.morningPickupName}" required>

                <label for="morningPickupTime">Morning Pickup Time:</label>
                <input type="text" name="morningPickupTime" value="${busData.morningPickupTime}" required>

                <label for="afternoonDropoffNumber">Afternoon Dropoff Number:</label>
                <input type="text" name="afternoonDropoffNumber" value="${busData.afternoonDropoffNumber}" required>

                <label for="afternoonDropoffName">Afternoon Dropoff Name:</label>
                <input type="text" name="afternoonDropoffName" value="${busData.afternoonDropoffName}" required>

                <label for="afternoonDropoffTime">Afternoon Dropoff Time:</label>
                <input type="text" name="afternoonDropoffTime" value="${busData.afternoonDropoffTime}" required>
            `;
            busInfo.style.display = "block";
        } else {
            // Hide the bus-specific information fields
            busInfo.innerHTML = "";
            busInfo.style.display = "none";
        }

</script>


       
</body>
</html>







