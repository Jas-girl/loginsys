<?php
session_start();


require '_dbconnect.php';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

$sql = "SELECT * FROM health_news ORDER BY RAND()";

$all_news = $conn->query($sql);

if (!$all_news) {
    echo "Error fetching health news: " . $conn->error;
}

$sql1 = "SELECT * FROM payment";
$all_services = $conn->query($sql1);

if (!$all_services) {
    echo "Error fetching services data: " . $conn->error;
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#317EFB"/>
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        <link rel="icon" type="image/x-icon" href="assets/logo.svg">
        <link rel="stylesheet" href="\loginsys\home.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
       


        <title>Home</title>
        <style>
            #mynavbar .nav-item a {
                font-size: 18px;
                color: black;
                cursor: pointer;
                transition: 0.5s ease;
                text-transform: capitalize;
                letter-spacing: 1px;
                font-family: "Platypi", serif;
                font-weight: 500;

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

            .about .heading h1,
            .eating h1,
            .news h1,
            .services h1 {
                overflow-y: hidden;

                cursor: pointer;

                color: white;

                text-transform: uppercase;

                font-family: "Platypi", serif;
            }

            .about .heading h1:hover,
            .eating h1:hover,
            .news h1:hover {
                width: 100%;
                border-bottom: 2px solid yellow;
                color: yellow;
                border-radius: 15px;
                height: 15%;

            }

            .navbar-toggler:hover {
                background-color: rgb(225, 235, 225);
                margin-bottom: 5px;
            }

            .services .service-box {
                background: radial-gradient(circle, #f7faf6, #c7e908);
                height: 520px;
                padding: 20px;
                border-radius: 100px;
                transition: 0.5s;
            }

            @media screen and (max-width: 900px) {
                #mynavbar .nav-item a {
                    color: white;
                    font-size: 12px;
                }
            }

            @media (min-width: 1000px) and (max-width: 1200px) {
                .eating .col-md-4 {
                    flex: 0 0 33.333333%;
                    max-height: 33.333333%;
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
                        <a class="nav-link " id="HomeLink" href="./home.php">Home</a>
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

                echo '<a href="\loginsys\logout.php" id="logout"><button>Log out</button></a>';
            } else {
                
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
                    <div class="text" >
                        <h1 class="mt-4">Nourish to <span style="color:yellowgreen">Flourish</span></h1>
                        <p> <?php
                            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                               
                                if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                                   
                                    $username = $_SESSION['username']; 
                                    echo "<p style='text-transform:none'>Welcome, " . $username . "!</p>"; 
                                } else {
                                    echo "Welcome!"; 
                                }
                            } else {
                                echo '';
                            }
                            ?></p>
                        <p class="mb-4">To keep the body in good health is a duty... otherwise, we shall not be able to keep our mind strong and clear</p>
                        <?php
                       

                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                          
                            echo '';
                        } else {
                           
                            echo '<a href="\loginsys\signup.php" id="login"><button class="btn1">SignIn</button></a>';
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mt-5 ">
                    <div class="image " >
                    <img src="\loginsys\assets\rect.webp" alt="Healthy Food" class=" my-5 " style="overflow-y:hidden;">

                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="about">
        <div class="heading text-center p-3" data-aos="fade-in">
            <h1>About</h1>
        </div>
        <div class="container">

            <div class="col">
                <h4 class="text-center  text-light p-3  " data-aos="fade-in">Savoring a colorful array of nutrient-rich foods not only nourishes the body but also delights the senses, paving the way for a vibrant and fulfilling life</h4>

            </div>

        </div>

        <div class="container">
            <div class="row p-4">
                <div class="col-lg-6" data-aos="zoom-in">
                    <img src="https://sites.psu.edu/siowfa15/wp-content/uploads/sites/29639/2015/09/o-HEALTHY-EATING-facebook.jpg" class=" p-2" alt="aboutimage">
                </div>
                <div class="col-lg-6  d-flex " style=" font-family: Platypi, serif;font-size: 20px;color:lightgreen;" data-aos="zoom-in">
                    <p>Eating good food is fundamental to maintaining optimal health and well-being. A balanced diet rich in nutrient-dense foods such as fruits, vegetables, whole grains, lean proteins, and healthy fats provides our bodies with the essential vitamins, minerals, and antioxidants needed to thrive. By focusing on whole, minimally processed foods and minimizing consumption of added sugars, unhealthy fats, and artificial ingredients, we fuel our bodies with the energy and nutrients necessary for optimal functioning. Making mindful food choices, practicing portion control, and savoring each meal not only nourishes our bodies but also promotes a positive relationship with food and enhances overall quality of life.</p>
                </div>
            </div>
        </div>
    </div>


    <div class="eating">
        <h1 class="p-3 text-center" style="font-family: Platypi, serif;" data-aos="fade-in">Healthy eating</h1>
        <p class="text-center" style="font-family: Platypi, serif; font-size: 20px; color: white" data-aos="fade-out">Learn about the basics of healthy eating including the food groups, portion size, and making food choices</p>
        <div class="container p-3">
            <div class="row">
                <div class="col-md-4 mb-4 text-center">
                    <div class="card-container" data-aos="zoom-in">
                        <article class="card-article">
                            <img src="\loginsys\assets\nutrition.webp" alt="categoryimage" class="card-img">
                            <div class="card_data">
                                <h2 class="card_title mt-2">CATEGORIES</h2>
                                <?php
                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                    
                                    echo '<a href="\loginsys\category.php" id="category"><button class=" btn1  fs-6">CLICK</button></a>';
                                } else {
                                    // User is not logged in, show login button
                                    echo '<a href="\loginsys\login.php" id="login"><button  class=" btn1  fs-6">CLICK</button></a>';
                                }
                                ?>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="col-md-4 mb-4 text-center">
                    <div class="card-container" data-aos="zoom-in">
                        <article class="card-article">
                            <img src="\loginsys\assets\recipe.webp" alt="recipeimage" class="card-img">
                            <div class="card_data">
                                <h2 class="card_title">RECIPES</h2>
                                <?php
                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                  
                                    echo '<a href="\loginsys\recipe.php" id="recipe"><button class=" btn1  fs-6">CLICK</button></a>';
                                } else {
                                    // User is not logged in, show login button
                                    echo '<a href="\loginsys\login.php" id="login"><button  class=" btn1  fs-6">CLICK</button></a>';
                                }
                                ?>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="col-md-4 mb-4 text-center">
                    <div class="card-container" data-aos="zoom-in">
                        <article class="card-article">
                            <img src="\loginsys\assets\calories.webp" alt="calorieimage" class="card-img">
                            <div class="card_data">
                                <h2 class="card_title">CALORIES</h2>
                                <?php
                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                    // User is logged in, show logout button
                                    echo '<a href="\loginsys\calories.php" id="calories"><button class=" btn1  fs-6">CLICK</button></a>';
                                } else {
                                    // User is not logged in, show login button
                                    echo '<a href="\loginsys\login.php" id="login"><button  class=" btn1  fs-6">CLICK</button></a>';
                                }
                                ?>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="news">
        <h1 class="p-3 text-center" style="font-family:Platypi, serif;" data-aos="fade-in">Health News</h1>
        <div class="container p-3">
            <div class="row">
                <?php
                $count = 0;

                while ($row = mysqli_fetch_assoc($all_news)) {
                    if ($count < 3) {
                        $pathx = "/loginsys/news_images/";
                ?>
                        <div class="col-md-4 mb-4">
                            <div class="card my-5" data-aos="zoom-in">
                                <img class="card-img-top" src="<?php echo $pathx . $row["image"]; ?>" alt="newsimage">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $row["name"]; ?></h4>
                                    <p class="card-text"><?php echo substr($row["description"], 0, 50) . '...'; ?></p>

                                    <?php
                                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                        // User is logged in, show logout button
                                        echo '<a href="\loginsys\news.php" id="news"><button class=" btn1  fs-6 bg-danger">CLICK</button></a>';
                                    } else {
                                        // User is not logged in, show login button
                                        echo '<a href="\loginsys\login.php" id="login"><button  class=" btn1  fs-6 bg-danger">CLICK</button></a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                <?php
                        $count++;
                    }
                }
                ?>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="services">
        <div class="container p-3">
            <h1 class="text-center" style="overflow-y: hidden;" data-aos="fade-in">Our Services</h1>
            <div class="container">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php
                    $count = 0;
                    while ($row = mysqli_fetch_assoc($all_services)) {
                        if ($count < 3) {
                    ?>
                            <div class="col">
                                <div class="service-box my-5" data-aos="zoom-in">
                                    <div class="service-content">
                                        <p class="plan text-danger" style="text-transform:uppercase;font-weight:bold"><?php echo $row["category"]; ?></p><br>
                                        <h2 class="price-and-duration">Rs-<?php echo $row["price"]; ?>/<?php echo $row["duration"]; ?></h2>
                                        <p class="various-plans">Various Plans: <?php echo $row["plans"]; ?></p>
                                        <p class="meetings">Personal-Meetings: <?php echo $row["meetings"]; ?></p>

                                        <?php
                                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                            
                                            echo '<a href="payment-details.php?category=' . $row["category"] . '&price=' . $row["price"] . '&duration=' . $row["duration"] . '&plans=' . $row["plans"] . '&meetings=' . $row["meetings"] . '"><button class="btn1 fs-6 bg-danger">PAY</button></a>';
                                        } else {
                                            // User is not logged in, show login button
                                            echo '<a href="\loginsys\login.php" id="login"><button class="btn1 fs-6 bg-danger">PAY</button></a>';
                                        }
                                        ?>


                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                        $count++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


    <footer class=" bg-dark text-light p-2">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mt-5">
                    <h5 style="overflow-y: hidden;">About Us</h5>
                    <p>Savoring a colorful array of nutrient-rich foods not only nourishes the body but also delights the senses, paving the way for a vibrant and fulfilling life.</p>
                </div>
                <div class="col-md-4 mt-5">
                    <h5 style="overflow-y: hidden;">Quick Links</h5>

                    <a class="nav-link title-small has-state active" href="/loginsys/home.php">Home</a>
                    <a class="nav-link" href="/loginsys/category.php">Categories</a>
                    <a class="nav-link" href="/loginsys/calories.php">Calories</a>
                    <a class="nav-link title-small has-state" href="/loginsys/recipe.php">Recipes</a>
                    <a class="nav-link" href="/loginsys/news.php">News</a>
                    <a class="nav-link" href="/loginsys/contact.php">Contact</a>

                    </ul>
                </div>
                <div class="col-md-4 mt-5">
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