<?php
  session_start();
include '_dbconnect.php'; // Include database connection file
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db); // Establish database connection

if ($_SERVER['REQUEST_METHOD'] == "POST") { // Check if form is submitted via POST

    if (isset($_POST['submit'])) { // Check if the form is submitted with the 'submit' button
        // Sanitize form input data
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $cpassword = mysqli_real_escape_string($conn, $_POST["cpassword"]);
        $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
        $state = mysqli_real_escape_string($conn, $_POST["state"]);
        $city = mysqli_real_escape_string($conn, $_POST["city"]);

        // Hash passwords
        $pass = password_hash($password, PASSWORD_BCRYPT);
        $cpass = password_hash($cpassword, PASSWORD_BCRYPT);

        // Check if email already exists in the database

        $emailquery = "SELECT * FROM users WHERE email='$email'";
        $query = mysqli_query($conn, $emailquery);
        $emailcount = mysqli_num_rows($query);
        if (!$query) {
            die("Query failed: " . mysqli_error($conn)); // Exit if query fails
        }

        if ($emailcount > 0) {
            echo "<script>document.querySelector('.message').innerHTML = 'Email already exists';</script>";
        } else {
            // If passwords match, insert user data into database
            if ($password === $cpassword) {
                $insertquery = "INSERT INTO users (username, email, password, cpassword, phone, state, city) VALUES ('$username', '$email', '$pass', '$cpass', '$phone', '$state', '$city')";
                $iquery = mysqli_query($conn, $insertquery);

                // If registration successful, redirect to login page
                if ($iquery) {
                    echo "<script>window.location.href = '/loginsys/login.php';</script>";
                } else {
                    // If registration fails, display alert
                    echo "<script>document.querySelector('.message').innerHTML = 'Registration Failed';</script>";
                }
            } else {
                // If passwords don't match, display alert
                echo "<script>var passwordsMatch = false;</script>";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="\loginsys\home.css">
    <link rel="stylesheet" href="\loginsys\signup.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="assets/logo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Signup</title>
</head>

<body>
    <style>
        nav {
            background: rgb(2, 0, 36);
            background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(3, 45, 8, 1) 32%, rgba(99, 255, 0, 1) 100%);
            width: 100%;
            z-index: 1000;
            position: fixed;
            transition: 2s linear;
        }

        .form {

            background: url("assets/login.webp");
            background-size: 100% 100%;
            height:auto;
            margin-top: 50px;

        
        }

        .input-group {
    position: relative;
    margin: 30px 0;
    border-bottom: 2px solid white;
}

.input-group input {
    width: 320px;
    height: 20px;
    font-size: 12px;
    color: white;
    padding: 0 5px;
    background-color: transparent;
    border: none;
    outline: none;
}

.input-group label {
    position: absolute;
    left: 5px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 12px;
    color: white;
    pointer-events: none;
    transition: all 0.3s ease;
}

.input-group input:focus ~ label,
.input-group input:valid ~ label {
    top: 0; /* Keep it vertically centered or adjust as necessary */
    transform:  translateX(10px); /* Adjust the translateX value as needed */
    font-size: 10px;
    color: white;
}

        #mynavbar .nav-item a {
            font-size: 18px;
            color:black;
        }
        @media screen and (max-width: 900px) {
    #mynavbar .nav-item a {
      color:white;
      font-size: 12px;
    }
    #login{
        width:70px;
    }
    #logout{
        width:70px;
    }
   
}
.message{
    width:100%;
    height:50px;
    overflow-y: hidden;
    font-size: 12px;
   
}
.show-hide {
            cursor: pointer;
            user-select: none;
            position: absolute;
            right: 5px;
            font-size: 12px;
            
            color: white;
            overflow-y: hidden;
        }
#password-strength {
            margin-top: 10px;
            font-size: 12px;
            background-color: lightblue;
            
            
        }
    </style>

    <nav class="navbar navbar-expand-sm navbar-dark  fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="assets/logo.svg" alt="Logo">
                <h3 id="good">Good</h3>
                <h3 id="health">Health</h3>
            </a>

            <div class="collapse navbar-collapse flex-grow-0" id="mynavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-auto">
                    <li class="nav-item">
                        <a class="nav-link "  href="./home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="./category.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="./calories.php">Calories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link title-small has-state " href="./recipe.php">Recipes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="./news.php">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="./contact.php">Contact</a>
                    </li>
                </ul>
            </div>
            <?php
       // Start session to access session variables

        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            // User is logged in, show logout button
            echo '<a href="\loginsys\logout.php" id="logout"><button>Log out</button></a>';
        } else {
            // User is not logged in, show login button
            echo '<a href="\loginsys\login.php" id="login" ><button>Login</button></a>';
        }
        ?>
            <button class="navbar-toggler my-2" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="icon"><img src="assets/bar.svg" alt=""></span>
            </button>
        </div>
    </nav>
   

    <div class="form mt-5">
        <div class="wrapper my-5">
            <div class="form-wrapper sign-in">
                <form action="/loginsys/signup.php" method="POST" autocomplete="off" onsubmit="return validateForm()">
                    <h2 class="mb-5">SIGN-UP</h2>
                    <div class="input-group">
                        <input type="text" required id="username" name="username" style=" text-transform:none;">
                        <label for="username">Username</label>
                    </div>
                    <div class="input-group">
                        <input type="email" required id="email" name="email" style=" text-transform: lowercase;">
                        <label for="email">Email</label>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" name="password" style="text-transform:none;" required oninput="checkPasswordStrength()">
                        <span class="show-hide" onclick="togglePasswordVisibility('password')">Show</span>
                        <label for="password">Password</label>
                    </div>
                    <div class="input-group">
                        <input type="password" id="cpassword" name="cpassword" style="text-transform:none;" required>
                        <span class="show-hide" onclick="togglePasswordVisibility('cpassword')">Show</span>
                        <label for="cpassword">Confirm Password</label>
                    </div>
                    
                    <div class="input-group">
                        <input type="tel" id="phone" name="phone" required minlength="12">
                        <label for="phone">Phone Number</label>
                    </div>
                    <div class="input-group">
                        <input type="text" id="state" name="state" style=" text-transform:none;" required>
                        <label for="state">State</label>
                    </div>
                    <div class="input-group">
                        <input type="text" id="city" name="city" style=" text-transform:none;" required>
                        <label for="city">City</label>
                    </div>
                   
                    <div class="remember">
                        <label><input type="checkbox" required>I agree to the terms & conditions</label>
                    </div>
                    <div id="password-strength"></div>
                    <button type="submit" name="submit" class="my-3">Sign Up</button>
                    <div class="sign-up-link">
                        <p>Already have an account? <a href="/loginsys/login.php" class="signup-btn-link">Sign In</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

<div class="message  text-dark bg-danger" style="display: none;"></div>
<footer class="footer bg-dark text-light p-2 ">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 style="overflow-y: hidden;">About Us</h5>
                    <p>Savoring a colorful array of nutrient-rich foods not only nourishes the body but also delights the senses, paving the way for a vibrant and fulfilling life.</p>
                </div>
                <div class="col-md-4">
                    <h5 style="overflow-y: hidden;">Quick Links</h5>

                    <a class="nav-link title-small has-state active" href="/loginsys/home.php">Home</a>
                    <a class="nav-link" href="/loginsys/category.php">Categories</a>
                    <a class="nav-link" href="/loginsys/calories.php">Calories</a>
                    <a class="nav-link title-small has-state" href="/loginsys/recipe.php">Recipes</a>
                    <a class="nav-link" href="/loginsys/news.php">News</a>
                    <a class="nav-link" href="/loginsys/contact.php">Contact</a>

                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 style="overflow-y: hidden;">Contact Info</h5>
                    <p>1064 Phase2, Dugri,Ludhiana,Punjab</p>
                    <p>Email: healthgood124@gmail.com</p>
                    <p>Phone: +91-6239476478</p>
                </div>
            </div>
            <hr>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 d-flex align-items-center">
                        <p class="m-0">© 2024</p>
                        <a class="navbar-brand ml-2" href="#">
                            <img src="assets/logo.svg" alt="Logo">
                            <h3 id="good" class="mb-0 fs-5">Good</h3>
                            <h3 id="health" class="mb-0 fs-5">Health</h3>
                        </a>
                        <p class="m-0">. All rights reserved</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-md-right text-muted">Designed by Jasleen</p>
                    </div>
                </div>
            </div>

    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    document.querySelector('.navbar-toggler').addEventListener('click', function() {
        document.querySelector('.navbar-nav').classList.toggle('active');
    });

    document.querySelector('.navbar-toggler').addEventListener('click', function() {
        document.querySelector('.navbar-nav').classList.toggle('active');
    });
    if (typeof passwordsMatch !== 'undefined' && !passwordsMatch) {
        // Display error message
        document.querySelector('.message').innerHTML = 'Passwords do not match';
    }
    function validateForm(event) {
    event.preventDefault(); // Prevent default form submission behavior

    var password = document.getElementById("password").value;
    var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/;

    if (!passwordRegex.test(password)) {
        updateMessage("Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, and one number");
        return false;
    }

    var password2 = document.getElementById("cpassword").value;
    if (password !== password2) {
        updateMessage("Passwords do not match");
        return false;
    }

    // If validation passes, submit the form programmatically
    document.getElementById("signupForm").submit();
}

function updateMessage(message) {
    document.querySelector('.message').innerHTML = message;
    document.querySelector('.message').style.display = 'block';
}

function checkPasswordStrength() {
            var password = document.getElementById("password").value;
            var strengthMeter = document.getElementById("password-strength");

            var lowercaseRegex = /[a-z]/;
            var uppercaseRegex = /[A-Z]/;
            var numberRegex = /\d/;

            var isLowercase = lowercaseRegex.test(password);
            var isUppercase = uppercaseRegex.test(password);
            var isNumber = numberRegex.test(password);

            var strength = 0;
            if (isLowercase) strength++;
            if (isUppercase) strength++;
            if (isNumber) strength++;

            var strengthMessage = "Password strength: ";
            var missing = [];

            if (!isLowercase) missing.push("lowercase letter");
            if (!isUppercase) missing.push("uppercase letter");
            if (!isNumber) missing.push("number");

            switch (strength) {
                case 0:
                    strengthMessage += "Weak";
                    break;
                case 1:
                    strengthMessage += "Medium";
                    break;
                case 2:
                    strengthMessage += "Strong";
                    break;
                case 3:
                    strengthMessage += "Very Strong";
                    break;
                default:
                    strengthMessage = "Password strength: Unknown";
            }

            if (missing.length > 0) {
                strengthMessage += " - Missing: " + missing.join(", ");
            }

            strengthMeter.innerHTML = strengthMessage;
        }
        function togglePasswordVisibility(fieldId) {
            var field = document.getElementById(fieldId);
            var showHideSpan = field.nextElementSibling;

            if (field.type === "password") {
                field.type = "text";
                showHideSpan.textContent = "Hide";
            } else {
                field.type = "password";
                showHideSpan.textContent = "Show";
            }
        }
</script>
</body>

</html>
