<?php
include '_dbconnect.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
       
        <link rel="icon" type="image/x-icon" href="assets/logo.svg">
        <link rel="stylesheet" href="saved.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


        <title>Saved</title>
        <style>
            nav{
    background: rgb(2, 0, 36);
    background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(3, 45, 8, 1) 32%, rgba(99, 255, 0, 1) 100%);
    z-index: 1000;
    position: fixed;
    transition: 2s linear;
}
#mynavbar .nav-item a {
    color: black;
    cursor: pointer;
    transition: 0.5s ease;
    text-transform: capitalize;
    letter-spacing: 1px;
    font-family: "Platypi", serif;
    font-weight: 500;
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

            .saved a {
            text-decoration: none;
            font-size: 20px;
            color: white;

        }

        .saved a:hover {
            color: green;
        }
        .card-wrapper .slide-title{
    font-family: "Platypi", serif;
    font-weight: 500;
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

@media screen and (max-width: 900px) {
    #mynavbar .nav-item a {
      color:white;
      font-size: 12px;
    }
}



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
                        <a class="nav-link" href="./home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./category.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./calories.php">Calories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link title-small has-state" href="./recipe.php">Recipes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./news.php">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./contact.php">Contact</a>
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
    <div class="home mt-5" style="background-color:black">
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
                        <div class="container">
                            <div class="row justify-content-center">
                                
                           

                        </div>
                        <div class="saved">
                            <?php 
                            $count=0;
                            if(isset($_SESSION['save'])){
                                $count=count($_SESSION['save']);
                            }
                            ?><a href="saved.php" id="saved-button">Saved (<?php echo $count; ?>)</a>
                            </div>
                            </div>


                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="image" data-aos="zoom-in">
                        <img src="https://simplehealthfacts.com/media/2021/07/44-healthy-foods-to-eat-that-you-should-include-in-your-diet.jpg" alt="Healthy Food">
                    </div>
                </div>
            </div>
        </div>
    </div>



<div class="saved" style="background-color:black">
    <div class="container my-5 text-center rounded bg-light">
 
    <div class="row">
        <div class="col-lg-12">
            <h1 style="overflow-y:hidden;  font-family: Platypi, serif;">SAVED RECIPE</h1>
        </div>
        <div class="col-lg-12">
        <div class="table-responsive">
    <table class="table table-striped">
        <thead class="text-center">
            <tr>
                <th scope="col">Serial Number</th>
                <th scope="col">Recipe Name</th>
                <th scope="col">Category</th>
                <th scope="col">Duration</th>
                <th scope="col">Recipe Ingredients</th>
                <th scope="col">Recipe Method</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php 
            if(isset($_SESSION['save']) && !empty($_SESSION['save'])) {
                foreach ($_SESSION['save'] as $key => $recipe) {
                    echo "<tr>";
                    echo "<td>" . ($key + 1) . "</td>";
                    echo "<td>" . $recipe['name'] . "</td>";
                    echo "<td>" . $recipe['category'] . "</td>";
                    echo "<td>" . $recipe['time'] . "</td>";
                    echo "<td>" . $recipe['ingredients'] . "</td>";
                    echo "<td>" . $recipe['recipe'] . "</td>";
                    echo "<td>";
                    echo "<form action='manage_saved.php' method='POST'>";
                    echo "<input type='hidden' name='remove_item_index' value='$key'>";
                    echo "<button type='submit' class='btn btn-sm btn-outline-danger'>Remove</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

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





    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.querySelector('.navbar-nav').classList.toggle('active');
        });
    </script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 200,
            duration: 1000
        });
    </script>

    <script src="home.js"></script>
</body>

</html>
