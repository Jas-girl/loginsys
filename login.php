<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require '_dbconnect.php';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

// Ensure the connection is successful
if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize input
    $email = mysqli_real_escape_string($conn, $email);

    // Query to check if the email exists in the database
    $email_search = "SELECT * FROM users WHERE email='$email'";
    $query = mysqli_query($conn, $email_search);

    // Check if the query was successful
    if (!$query) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Check if the email exists in the database
    $email_count = mysqli_num_rows($query);
    if ($email_count == 1) {
        // Fetch user data
        $user_data = mysqli_fetch_assoc($query);
        // Verify password
        if (password_verify($password, $user_data['password'])) {
            // Set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user_data['username']; // Assuming username is stored in the 'username' column
            // Redirect to the home page
            header("Location: home.php");
            exit;
        } else {
            echo "<script>alert('Incorrect password');</script>";
        }
    } else {
        echo "<script>alert('Email not found. Redirecting to signup page.'); window.location.href = 'signup.php';</script>";
    }
}

// Close the connection
mysqli_close($conn);

?>

<!Doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="\loginsys\home.css">
    <link rel="stylesheet" href="\loginsys\login.css">
    <link rel="icon" type="image/x-icon" href="assets/logo.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Login</title>
</head>
<style>
    #mynavbar .nav-item a {
    font-size: 18px;
    
   
}
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

        
           
            /* Ensure the background image covers the entire .contact div */
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
        #mynavbar .nav-item a {
            font-size: 16px;
            color:black;
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
        @media screen and (max-width: 900px) {
    #mynavbar .nav-item a {
      color:white;
      font-size: 12px;
    }
}
 
</style>

<body>
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
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                // User is logged in, show logout button
                echo '<a href="\loginsys\logout.php" id="logout"><button>Log out</button></a>';
            } else {
                // User is not logged in, show login button
                echo '<a href="\loginsys\login.php" id="login"><button>Login</button></a>';
            }
            
        ?>
            <button class="navbar-toggler my-2" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="icon"><img src="assets/bar.svg" alt=""></span>
            </button>
        </div>
    </nav>
    <div class="form mt-5">
        <div class="wrapper my-4">
            <div class="form-wrapper sign-in">
                <form action="/loginsys/login.php" method="POST">
                    <h2>LOGIN</h2>
                    <div class="input-group">
                        <input type="text" id="email" name="email" required autocomplete="off">
                        <label for="email">Email</label>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" name="password" style="text-transform:none;" required>
                        <span class="show-hide" onclick="togglePasswordVisibility('password')">Show</span>
                        <label for="password">Password</label>
        </div> 
                    <div class="remember">
                        <label for="remember"><input type="checkbox" id="remember" required>Remember me</label>
                    </div>
                    <button type="submit" name="submit"><a href="home.php"></a>Login</button>
                    <div class="sign-up-link">
                        <p>Don't have an account?<a href="\loginsys\signup.php" class="signup-btn-link">SignUp</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                            <h3 id="good" class="mb-0">Good</h3>
                            <h3 id="health" class="mb-0">Health</h3>
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
