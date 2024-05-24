<?php
session_start();

// Database connection
require '_dbconnect.php';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $first_name = mysqli_real_escape_string($conn, $_POST['firstname']);
    $last_name = mysqli_real_escape_string($conn, $_POST['lastname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert data into database
    $sql = "INSERT INTO contact_form (first_name, last_name, phone, email, message) VALUES ('$first_name', '$last_name', '$phone', '$email', '$message')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Message sent successfully!";
    } else {
        $_SESSION['message'] = "There was an error sending your message. Please try again later.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <title>Contact</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="\loginsys\contact.css">
    <link rel="stylesheet" href="\loginsys\signup.css">
    <link rel="stylesheet" href="\loginsys\home.css">
    <style>
        #mynavbar .nav-item a {
    font-size: 18px;
   
   
}
        .home .image img {
            width: 100%;
            height: 90%;
            object-fit: cover;
            box-shadow: 0 0 100px yellowgreen;
            margin-top: 10px;
            margin-bottom: 10px;
            animation: border-color-change 5s infinite;

        }
        @keyframes border-color-change {
    0% { box-shadow: 0 0 20px yellowgreen; } 
    25% { box-shadow: 0 0 20px skyblue; } 
    50% { box-shadow: 0 0 20px rgb(170, 123, 219); } 
    100% {box-shadow: 0 0 20px rgb(236, 88, 88); } 
}
.navbar-toggler:hover{
    background-color: rgb(225, 235, 225);
    margin-bottom: 5px;
}
@media screen and (max-width: 900px) {
    #mynavbar .nav-item a {
      color:white;
      font-size: 12px;
    }
}
@media (max-width: 550px) {
    .home {
        height: 110vh; 
    }

}
        
       

footer h5{
    color:#00ff2a;
}
footer a{
    text-decoration: none;
    color:white;
}
footer .nav-link{
    color:white;
}
.contact {
   
    background: url("https://media.gray.com/wp-content/uploads/2020/04/02070702/iStock-1133157200_NEW-WEB.jpg");
    background-size: 100% 100%; /* Ensure the background image covers the entire .contact div */
}




        /* Adjust the height as needed */
    </style>
</head>
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
                        <a class="nav-link " href="/loginsys/home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link" href="/loginsys/category.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/loginsys/calories.php">Calories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link title-small has-state" href="/loginsys/recipe.php">Recipes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/loginsys/news.php">News</a>
                    </li>
                    <li class="nav-item">
                        <a id="contactLink" class="nav-link" href="/loginsys/contact.php">Contact</a>
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
            echo '<a href="\loginsys\login.php" id="login"><button>Login</button></a>';
        }
        ?>
            <button class="navbar-toggler my-2" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="icon"><img src="assets/bar.svg" alt=""></span>
            </button>
        </div>
    </nav>

    <div class="home mt-5">
    <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="text" data-aos="slide-left">
                        <h1 class="mb-4" style="color:white">Nourish to <span style="color:yellowgreen">Flourish</span></h1>
                        <p> <?php
                      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                        // User is logged in
                        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                            // $_SESSION['email'] is set and not empty, get the first letter
                            $username = $_SESSION['username']; // Get the email from the session
                            // Get the first letter and convert it to uppercase
                            echo "<p style='text-transform:none'>Welcome, " . $username. "!</p>"; // Display the welcome message
                        } else {
                            // $_SESSION['email'] is either not set or empty
                            echo "Welcome!"; // Display a generic welcome message
                        }
                    } else {
                        // User is not logged in, display a login link
                        echo '';
                    }
?></p>
                        <p class="mb-4">To keep the body in good health is a duty... otherwise, we shall not be able to keep our mind strong and clear</p>
                        
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mt-5">
                    <div class="image" data-aos="zoom-in">
                        <img src="https://simplehealthfacts.com/media/2021/07/44-healthy-foods-to-eat-that-you-should-include-in-your-diet.jpg" alt="Healthy Food">
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <div class="contact">
    <div id="message-box" class="alert alert-success" style="display: <?php echo isset($_SESSION['message']) ? 'block' : 'none'; ?>;">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']); // Clear the message after displaying it
                        }
                        ?>
                    </div>
        <div class="form ">
            <div class="wrapper my-5">
                <div class="form-wrapper contactid">
                    <!-- Placeholder for the success message -->
                    
                    <form action="" method="POST">
                        <h2 class="mb-5">CONTACT FORM</h2>
                        <div class="input-group">
                            <input type="text" required id="firstname" name="firstname" style="text-transform:none;">
                            <label for="firstname">FIRST NAME</label>
                        </div>
                        <div class="input-group">
                            <input type="text" required id="lastname" name="lastname" style="text-transform:none;">
                            <label for="lastname">LAST NAME</label>
                        </div>
                        <div class="input-group">
                            <input type="text" required id="phone" name="phone" style="text-transform:none;">
                            <label for="phone">PHONE NUMBER</label>
                        </div>
                        <div class="input-group">
                            <input type="email" required id="email" name="email" style="text-transform: lowercase;">
                            <label for="email">EMAIL ADDRESS</label>
                        </div>
                        <div class="form-group">
                            <label for="message" class="text-light">MESSAGE</label>
                            <textarea id="message" name="message" rows="5" cols="60" placeholder="Enter your message" autocomplete="off" required></textarea>
                        </div>
                        <button type="submit" name="submit" class="my-3">Send a message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <footer class="footer bg-dark text-light">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://smtpjs.com/v3/smtp.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.querySelector('.navbar-nav').classList.toggle('active');
        });

        AOS.init({
            offset: 200,
            duration: 1000
        });
    </script>
</body>
</html>
