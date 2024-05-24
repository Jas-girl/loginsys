<?php
include '_dbconnect.php';

// Establish database connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

// Check if the connection was successful
if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['add_plan'])) {
    // Retrieve form data
    $duration = $_POST['duration'];
    $price = $_POST['price'];
    $plan = $_POST['plan'];
    $meetings = $_POST['meetings'];

    // Check if various plans are selected
    if (isset($_POST['variousplan']) && is_array($_POST['variousplan'])) {
        // Convert the array of selected plans into a comma-separated string
        $variousplan = implode(', ', $_POST['variousplan']);
    } else {
        // If no plans are selected, set $variousplan to an empty string
        $variousplan = '';
    }

    // Check if any required field is empty
    if (empty($duration) || empty($price) || empty($plan) || empty($variousplan) || empty($meetings)) {
        $message[] = 'Please fill out all fields.';
    } else {
        // Perform database insertion
        $insert = "INSERT INTO payment (duration, price, category, plans, meetings) VALUES ('$duration', '$price', '$plan', '$variousplan', '$meetings')";
        
        // Execute the query
        $result = mysqli_query($conn, $insert);

        // Check if insertion was successful
        if ($result) {
            $message[] = 'Plan added successfully.';
        } else {
            $message[] = 'Failed to add plan: ' . mysqli_error($conn); // Provide detailed error message
        }
    }
}

// Perform select query
$select_result = mysqli_query($conn, "SELECT * FROM payment");

// Check if the select query was successful
if ($select_result) {
    // Display table rows
    while ($row = mysqli_fetch_assoc($select_result)) {
        // Process each row
    }
} else {
    $message[] = 'Failed to retrieve payment data: ' . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/logo.svg">
    <title>Payment</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;
            text-transform: capitalize;
        }

        html {
            font-size: 62.5%;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            padding: 2rem;
            margin: 0 auto;
        }

        .admin-plans {
            max-width: 50rem;
            margin: 0 auto;
            padding: 2rem;
            border-radius: .5rem;
            background-color: lightgrey;
            font-size: 18px;
        }

        .admin-plans h3 {
            text-transform: uppercase;
            margin-bottom: 1rem;
            text-align: center;
            font-size: 2.5rem;
        }

        .btn {
            display: block;
            width: 100%;
            margin-top: 1rem;
            cursor: pointer;
            border-radius: .5rem;
            font-size: 1.7rem;
            padding: 1rem 3rem;
            background-color: green;
            color: white;
        }

        .btn:hover {
            background-color: black;
        }

        .message {
            display: block;
            background: lightgray;
            padding: 1.5rem 1rem;
            font-size: 2rem;
            margin-bottom: 2rem;

        }

        .payment-display {
            margin: 2rem 0;
            
        }

        .payment-display .payment-display-table {
            width: 100%;
        }

        .payment-display .payment-display-table thead {
            padding: 1rem;
            font-size: 2rem;
            background-color: grey;
        }

        .payment-display .payment-display-table td {
            padding: 1rem;
            font-size: 2rem;
        }
        .payment-display .payment-display-table th {
            padding: 1rem;
            font-size: 2rem;
        }

        @media (max-width:991px) {
            html {
                font-size: 55%;
            }

        }

        @media (max-width:768px) {
            .payment-display{
                overflow: scroll;
            }
            .payment-display .payment-display-table {
                width: 80rem;
            }
        }

        @media (max-width:450px) {
            html {
                font-size: 50%;
            }
        }
    </style>
</head>

<body>
<?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<span class="message">' . $message . '</span>';
        }
    }
    ?>
    <div class="container">
        <div class="admin-plans">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <h3>Services of food plans</h3>

                <div class="form-group">
                    <label for="duration">Choose a duration:</label>
                    <select class="form-control" id="duration" name="duration">
                        <option value="3 months">3 months</option>
                        <option value="6 months">6 months</option>
                        <option value="9 months">9 months</option>
                        <option value="1 year">1 year</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">Enter a price:</label>
                    <input type="number" class="form-control" id="price" placeholder="Enter the price" name="price">
                </div>
                <div class="form-group">
                    <label for="plan">Category of plan:</label>
                    <select class="form-control" id="plan" name="plan">
                        <option value="basic">Basic</option>
                        <option value="standard">Standard</option>
                        <option value="premium">Premium</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="plans">Various plans:</label><br>
                    <div class="form-check">
                        <input type="checkbox" name="variousplan[]" id="dietPlan" value="dietPlan">
                        <label class="form-check-label" for="dietPlan">Diet plan</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="variousplan[]" id="bodyMeasurement" value="bodyMeasurement">
                        <label class="form-check-label" for="bodyMeasurement">Body measurement</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="variousplan[]" id="healthyFood" value="healthyFood">
                        <label class="form-check-label" for="healthyFood">Healthy food</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="meetings">Choose a number of meetings:</label>
                    <input type="number" class="form-control" id="meetings" name="meetings">
                </div>
                <button type="submit" class="btn btn-primary" name="add_plan">Add a plan</button>
            </form>
        </div>
       
        
        </div>
    </div>

</body>

</html>