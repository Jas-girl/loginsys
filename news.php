<?php
session_start();
include '_dbconnect.php';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM health_news ORDER BY RAND()";

$all_news = $conn->query($sql);

if (!$all_news) {
    echo "Error fetching health news: " . $conn->error;
}
$name = isset($_GET['name']) ? $_GET['name'] : '';
$image = isset($_GET['image']) ? $_GET['image'] : '';
$description = isset($_GET['description']) ? $_GET['description'] : '';
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <title>News</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="\loginsys\news.css">
</head>
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
        0% {
            border-color: yellowgreen;
            box-shadow: 0 0 20px yellowgreen;
        }

        25% {
            border-color: skyblue;
            box-shadow: 0 0 20px skyblue;
        }

        50% {
            border-color: rgb(170, 123, 219);
            box-shadow: 0 0 20px rgb(170, 123, 219);
        }

        100% {
            border-color: rgb(236, 88, 88);
            box-shadow: 0 0 20px rgb(236, 88, 88);
        }
    }

    footer h5 {
        color: #00ff2a;
    }

    footer a {
        text-decoration: none;
        color: white;
    }

    footer .nav-link {
        color: white;
    }

    strong {
        color: #00ff2a
    }

    .home #addRecipeBtn {
        font-weight: bold;
        border-radius: .5rem;
        transition-property: width;
        transition-duration: 2s;
        transition-timing-function: linear;
        transition-delay: 1s;
        width: 200px;
        height: 50px;

    }

    .home #addRecipeBtn:hover {
        background: linear-gradient(35deg, green, rgb(191, 233, 6));

        color: white;
        box-shadow: 0 0 7px yellowgreen;
    }


    .text p:hover {
        color: yellowgreen;
    }

    .navbar-toggler:hover {
        background-color: rgb(225, 235, 225);
        margin-bottom: 5px;
    }

    .card-title {
        font-family: "Platypi", serif;
        font-weight: 500;
    }

    .card-img-top {
        height: 200px;
        /* Adjust the height as needed */
        overflow: hidden;
        width: 100%;
    }

    .news .btn1 {
        font-weight: bold;
        border-radius: .5rem;
        transition-property: width;
        transition-duration: 2s;
        transition-timing-function: linear;
        transition-delay: 1s;
        width: 100px;
        height: 50px;
        display: flex;
        /* Added */
        justify-content: center;
        /* Added */
        align-items: center;
        /* Added */
    }

    .news .btn1:hover {
        background: linear-gradient(35deg, green, rgb(191, 233, 6));
        color: white;
        box-shadow: 0 0 7px yellowgreen;
    }


    @media screen and (max-width: 900px) {
        #mynavbar .nav-item a {
            color: white;
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
                        <a class="nav-link " href="./home.php">Home</a>
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
                        <a class="nav-link" href="./news.php" id="newsLink">News</a>
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
    <div class="home ">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="text text-center" data-aos="slide-left">
                        <h1 class="mb-4" style="color:white">Nourish to <span style="color:yellowgreen">Flourish</span></h1>
                        <p><?php
                            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                // User is logged in
                                if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                                    // $_SESSION['email'] is set and not empty, get the first letter
                                    $username = $_SESSION['username']; // Get the email from the session
                                    // Get the first letter and convert it to uppercase
                                    echo "<p style='text-transform:none'>Welcome, " . $username . "!</p>"; // Display the welcome message
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
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="image" data-aos="zoom-in">
                        <img src="https://simplehealthfacts.com/media/2021/07/44-healthy-foods-to-eat-that-you-should-include-in-your-diet.jpg" alt="Healthy Food">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="news-details" style=" background-color:black;display: <?php echo isset($_POST['submit']) ? 'block' : 'none'; ?> ">
        <div class="container"  id="news-section">
            <h1 class="text-center text-light" style="overflow-y:hidden">NEWS DETAILS</h1>
            <div class="detail text-center text-light">
                <p><strong>TITLE:</strong> <?php echo isset($_POST['news_name']) ? htmlspecialchars($_POST['news_name']) : ''; ?></p>
            </div>
            <div class="detail text-center">
                <?php $pathx = "/loginsys/news_images/"; ?>
                <p><strong>IMAGE:</strong> <img src="<?php echo isset($_POST['news_image']) ? htmlspecialchars($pathx . $_POST['news_image']) : ''; ?>" width="300" height="300"></p>
            </div>
            <div class="detail text-center text-light">
                <p><strong>DESCRIPTION:</strong> <?php echo isset($_POST['news_description']) ? htmlspecialchars($_POST['news_description']) : ''; ?></p>
            </div>
        </div>
    </div>

    <div class="news" style="background-color:black">
    <div class="container">
        <h1 class="p-3 text-center" style="font-family: Platypi, serif;" data-aos="fade-in">HEALTH NEWS</h1>
        <div class="row row row-cols-1 row-cols-sm-2 row-cols-lg-4 p-2">
            <?php
            // Assuming $all_news is the result of a database query fetching health news articles
            $count = 0;
            $pathx = "/loginsys/news_images/";

            // Loop through each news article
            while ($row = mysqli_fetch_assoc($all_news)) {
                if ($count % 4 == 0) {
                    // Start a new row after every 4 articles
                    echo '</div><div class="row row row-cols-1 row-cols-sm-2 row-cols-lg-4 p-2">';
                }
            ?>
                <div class="col mb-4">
                    <div class="card my-3" data-aos="zoom-in">
                        <img class="card-img-top" src="<?php echo $pathx . $row["image"]; ?>" alt="<?php echo $row["name"]; ?>">
                        <div class="card-body">
                            <p class="card-title"><?php echo $row["name"]; ?></p>
                            <p class="card-text"><?php echo substr($row["description"], 0, 50) . '...'; ?></p>
                            <form action="" method="POST">
                                <input type="hidden" name="news_name" value="<?php echo $row["name"]; ?>">
                                <input type="hidden" name="news_image" value="<?php echo $row["image"]; ?>">
                                <input type="hidden" name="news_description" value="<?php echo $row["description"]; ?>">
                                <button type="submit" class="btn1 justify-content-center align-items-center" name="submit" id="newsbtn">NEWS</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
                $count++;
            }
            ?>
        </div>
    </div>
</div>



    <footer class="footer bg-dark text-light">
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
                </div>
                <div class="col-md-4 mt-5">
                    <h5 style="overflow-y: hidden;">Contact Info</h5>
                    <p>1064 Phase2, Dugri, Ludhiana, Punjab</p>
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
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.querySelector('.navbar-nav').classList.toggle('active');
        });
        var newsbtn = document.getElementById("newsbtn");
if (newsbtn) {
    newsbtn.addEventListener("click", function() {
        var newsSection = document.getElementById("news-section");
        if (newsSection) {
            // Scroll to the news section smoothly
            newsSection.scrollIntoView({ behavior: "smooth" });
        } else {
            console.error("Error: Element with id 'news-section' not found.");
        }
    });
} else {
    console.error("Error: Element with id 'newsbtn' not found.");
}




    </script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 200,
            duration: 1000
        });
    </script>


</body>

</html>