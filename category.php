<?php
session_start();
include '_dbconnect.php';

// Check if the connection is valid
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if (!$conn) {
    // Display error message if connection fails
    die('Could not connect: ' . mysqli_connect_error());
}

// Function to sanitize input
function sanitizeInput($conn, $input)
{
    return mysqli_real_escape_string($conn, htmlspecialchars($input));
}

// Fetch all categories from the database
$sql = "SELECT * FROM category ORDER BY RAND()";
$all_category = $conn->query($sql);

if (!$all_category) {
    // Display error message if query fails
    echo "Error fetching category: " . $conn->error;
    exit; // Exit script if query fails
}

// Fetch category items dynamically via AJAX
if (isset($_POST['category'])) {
    // Sanitize category input
    $category = sanitizeInput($conn, $_POST['category']);
    $query = "SELECT * FROM category WHERE category = '$category'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Display category name
        echo "<h1 class='text-center text-light' style='overflow-y:hidden; font-family: Platypi, serif;'>$category</h1>";

        // Initialize counter variable
        $count = 0;

        // Start the card row
        echo '<div class="row row row-cols-1 row-cols-sm-2 row-cols-lg-4 p-2">';

        while ($row = mysqli_fetch_assoc($result)) {
            $pathx = "/loginsys/recipe_images/";
            echo "<div class='col'>
                <div class='card-wrapper'>
                <form action='manage_saved.php' method='POST'>
                    <div class='card'data-aos='zoom-in'>
                        <div class='circle-image-box'>
                            <img src='{$pathx}{$row["image"]}' alt='' class='img-fluid'>
                        </div>
                        <div class='slide-title'>Name-{$row["name"]}</div>";

            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                // User is logged in, display the "Save" button

                echo "<div class='col'>
                          <form action='' method='POST'>
                              <button class='slide-less btn btn-primary' type='submit' name='ADD_TO_SAVED'>SAVED</button>
                              <input type='hidden' name='sno' value='{$row['sno']}'>
                              <input type='hidden' name='name' value='{$row["name"]}'>
                              <input type='hidden' name='category' value='{$row["category"]}'>
                              <input type='hidden' name='time' value='{$row["time"]}'>
                              <input type='hidden' name='ingredients' value='{$row["ingredients"]}'>
                              <input type='hidden' name='recipe' value='{$row["recipe"]}'>
                          </form>
                      </div>";
            } else {
                // User is not logged in, display the login link
                echo "<div class='col'>
                <button class='slide-less btn btn-primary' type='submit'> <a href='/loginsys/login.php' id='login' style='text-decoration:none;color:black'>
                             SAVED</a></button>
                          
                      </div>";
            }
            echo "<div class='col'>
            <div class='slide-more btn btn-primary' style='width: 100px;'>
                <a href='/loginsys/recipe.php?
                    name=" . (isset($row['name']) ? urlencode($row['name']) : '') . "&
                    category=" . (isset($row['category']) ? urlencode($row['category']) : '') . "&
                    image=" . (isset($row['image']) ? urlencode($row['image']) : '') . "&
                    time=" . (isset($row['time']) ? urlencode($row['time']) : '') . "&
                    ingredients=" . (isset($row['ingredients']) ? urlencode($row['ingredients']) : '') . "&
                    recipe=" . (isset($row['recipe']) ? urlencode($row['recipe']) : '') . "
                '>RECIPE</a>
            </div>
        </div>
    </div>
    </div>
    </div>
    ";


            // Increment the counter variable
            $count++;

            // If four images have been displayed, close the current row and start a new one
            if ($count % 4 == 0) {
                echo '</div><div class="row row row-cols-1 row-cols-sm-2 row-cols-lg-4 p-2">';
            }
        }

        // Close the final row if the number of cards is not a multiple of 4
        if ($count % 4 != 0) {
            echo '</div>';
        }
    } else {
        // Handle query error
        echo "Error: " . mysqli_error($conn);
    }
    exit; // Exit after fetching data
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <title>Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="assets/logo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/loginsys/category.css">

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

        @keyframes border-color-change {
            0% {
                box-shadow: 0 0 20px yellowgreen;
            }

            25% {
                box-shadow: 0 0 20px skyblue;
            }

            50% {
                box-shadow: 0 0 20px rgb(170, 123, 219);
            }

            100% {
                box-shadow: 0 0 20px rgb(236, 88, 88);
            }
        }

        .circle-image-box {
            height: 200px;
            /* Adjust the height as needed */
            overflow: hidden;
            width: 100%;
        }

        .circle-image-box img {
            width: 100%;
            height: 100%;
            object-fit: 100% 100%;
            /* This property will make the image cover the entire box */
        }

        .saved a {
            text-decoration: none;
            font-size: 20px;
            color: white;

        }

        .saved a:hover {
            color: green;
        }

        .card-wrapper .slide-title {
            font-family: "Platypi", serif;
            font-weight: 500;
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

        .navbar-toggler:hover {
            background-color: rgb(225, 235, 225);
            margin-bottom: 5px;
        }

        @media screen and (max-width: 900px) {
            #mynavbar .nav-item a {
                color: white;
                font-size: 12px;
            }
        }

        /* @media (min-width: 700px) and (max-width: 1000px) {
    .row-cols-md-3 {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* Change grid-template-columns to display two columns */

        @media (min-width: 768px) and (max-width: 1024px) {
            .category .card-wrapper {
                grid-template-columns: repeat(2, 1fr);
                /* Display two columns */
            }
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
                        <a id="categoriesLink" class="nav-link" href="/loginsys/category.php">Categories</a>
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
                        <a class="nav-link" href="/loginsys/contact.php">Contact</a>
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
                        <h1 class="mt-4" style="color:white">Nourish to <span style="color:yellowgreen">Flourish</span></h1>
                        <p> <?php
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
                        <div class="container">
                            <div class="row justify-content-center">
                                <form action="" method="POST" id="search-form" onsubmit="toggleSearchContainer(event)">

                                    <div class="col-md-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Search for recipe" aria-label="Search for recipe" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>" aria-describedby="search-button" id="search-input" name="search">


                                            <button class="btn btn-outline-secondary" type="submit" name="submit" id="search-button"><img src="./assets/search-icon.svg" alt=""></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="saved">
                            <?php
                            $count = 0;
                            if (isset($_SESSION['save'])) {
                                $count = count($_SESSION['save']);
                            }
                            ?><a href="saved.php" id="saved-button">Saved (<?php echo $count; ?>)</a>
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
    <div class="category">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col">
                    <ul class="list d-flex flex-wrap justify-content-center p-2" data-aos="fade-in">
                        <li class="list-group-item" id="breakfast-category">Breakfast</li>
                        <li class="list-group-item" id="lunch-category">Lunch</li>
                        <li class="list-group-item" id="dinner-category">Dinner</li>
                        <li class="list-group-item" id="snack-category">Snack Time</li>
                        <li class="list-group-item" id="tea-category">Tea Time</li>
                    </ul>

                </div>

            </div>
        </div>
    </div>

    <div class="category-food-container " style="background-color:black"></div>


    <div id="search-food-container" style="background-color:black;">
        <div class="container">
            <h2 class='text-center text-light' style='overflow-y:hidden; font-family: Platypi, serif;'>Searched recipe </h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 p-2">
                <?php
                if (isset($_POST['submit']) && !empty($_POST['search'])) {
                    // Sanitize the search keyword
                    $search = mysqli_real_escape_string($conn, $_POST['search']);
                    $pathx = "/loginsys/recipe_images/";

                    // Query to fetch categories matching the search keyword
                    $query = mysqli_query($conn, "SELECT * FROM `category` WHERE `name` LIKE '%$search%' ORDER BY `name`") or die(mysqli_error($conn));

                    // Check if any matching categories are found
                    if (mysqli_num_rows($query) > 0) {
                        // Loop through the results and display them
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo '<div class="col">                       
    <div class="card-wrapper">
        <form action="manage_saved.php" method="POST">
            <div class="card "data-aos="zoom-in">
                <div class="circle-image-box">
                    <img src="' . $pathx . $row["image"] . '" alt="" class="img-fluid">
                </div>
                <div class="slide-title">Name: ' . $row["name"] . '</div>';
                            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                // User is logged in, display the "Save" button
                                echo '<div class="col">
                                                  <button class="slide-less btn btn-primary" type="submit" name="ADD_TO_SAVED">SAVED</button>
                                                  <input type="hidden" name="sno" value="' . $row['sno'] . '">
                                                  <input type="hidden" name="name" value="' . $row["name"] . '">
                                                  <input type="hidden" name="category" value="' . $row["category"] . '">
                                                  <input type="hidden" name="time" value="' . $row["time"] . '">
                                                  <input type="hidden" name="ingredients" value="' . $row["ingredients"] . '">
                                                  <input type="hidden" name="recipe" value="' . $row["recipe"] . '">
                                              </div>';
                            } else {
                                // User is not logged in, display the login link
                                echo '<div class="col">
                                                  <button class="slide-less btn btn-primary" type="submit">
                                                      <a href="/loginsys/login.php" id="login" style="text-decoration:none;color:black">SAVED</a>
                                                  </button>
                                              </div>';
                            }

                            // Link to view recipe details
                            echo '<div class="col">
                                                <div class="slide-more btn btn-primary" style="width: 100px;">
                                                    <a href="/loginsys/recipe.php?
                                                        name=' . urlencode($row['name']) . '&
                                                        category=' . urlencode($row['category']) . '&
                                                        image=' . urlencode($row['image']) . '&
                                                        time=' . urlencode($row['time']) . '&
                                                        ingredients=' . urlencode($row['ingredients']) . '&
                                                        recipe=' . urlencode($row['recipe']) . '"
                                                    >RECIPE</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>';
                        }
                    }
                } else {
                    // Display a message prompting the user to enter a search query

                }
                ?>
            </div>
        </div>
    </div>


    <div class="category" style="background-color: black;">
        <div class="container">
            <h3>Food Recipes</h3>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 p-2">
                <?php
                $count = 0;
                $pathx = "/loginsys/recipe_images/"; // Initialize $pathx outside the loop
                while ($row = mysqli_fetch_assoc($all_category)) {
                    if ($count % 4 == 0) {
                        echo '</div><div class="row row row-cols-1 row-cols-sm-2 row-cols-lg-4 p-2">'; // Close previous row and start a new one
                    }
                ?>
                    <div class="col">
                        <div class="card-wrapper">
                            <form action="manage_saved.php" method="POST">
                                <div class="card " data-aos="zoom-in">
                                    <div class="circle-image-box">
                                        <img src="<?php echo $pathx . $row["image"]; ?>" alt="" class="img-fluid">
                                    </div>
                                    <div class="slide-title">Name-<?php echo $row["name"]; ?></div>
                                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
                                        <div class="col">
                                            <button class="slide-less btn btn-primary" type="submit" name="ADD_TO_SAVED">Saved</button>
                                            <input type="hidden" name="sno" value="<?php echo $row["sno"]; ?>">
                                            <input type="hidden" name="name" value="<?php echo $row["name"]; ?>">
                                            <input type="hidden" name="category" value="<?php echo $row["category"]; ?>">
                                            <input type="hidden" name="time" value="<?php echo $row["time"]; ?>">
                                            <input type="hidden" name="ingredients" value="<?php echo $row["ingredients"]; ?>">
                                            <input type="hidden" name="recipe" value="<?php echo $row["recipe"]; ?>">
                                        </div>
                                    <?php else : ?>
                                        <div class="col">
                                            <button class="slide-less btn btn-primary" type="submit">
                                                <a href="/loginsys/login.php" id="login" style="text-decoration:none;color:black">SAVED</a>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col">
                                        <div class="slide-more btn btn-primary" style="width: 100px;">
                                            <a href="/loginsys/recipe.php?
    name=<?php echo isset($row["name"]) ? urlencode($row["name"]) : ''; ?>&
    category=<?php echo isset($row["category"]) ? urlencode($row["category"]) : ''; ?>&
    image=<?php echo isset($row["image"]) ? urlencode($row["image"]) : ''; ?>&
    time=<?php echo isset($row["time"]) ? urlencode($row["time"]) : ''; ?>&
    ingredients=<?php echo isset($row["ingredients"]) ? urlencode($row["ingredients"]) : ''; ?>&
    recipe=<?php echo isset($row["recipe"]) ? urlencode($row["recipe"]) : ''; ?>
">Recipe</a>

                                        </div>


                                    </div>
                                </div>
                            </form>
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
                <div class="col-md-4">
                    <h5 style="overflow-y: hidden;">About Us</h5>
                    <p>Savoring a colorful array of nutrient-rich foods not only nourishes the body but also delights the senses, paving the way for a vibrant and fulfilling life.</p>
                </div>
                <div class="col-md-4">
                    <h5 style="overflow-y: hidden; ">Quick Links</h5>

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.querySelector('.navbar-nav').classList.toggle('active');
        });

        $(document).ready(function() {
            $('#breakfast-category').click(function() {
                $.ajax({
                    url: 'category.php',
                    method: 'POST',
                    data: {
                        category: 'Breakfast'
                    },
                    success: function(response) {
                        // Update the container with the fetched data
                        $('.category-food-container').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#lunch-category').click(function() {
                $.ajax({
                    url: 'category.php',
                    method: 'POST',
                    data: {
                        category: 'Lunch'
                    },
                    success: function(response) {
                        // Update the container with the fetched data
                        $('.category-food-container').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
        $(document).ready(function() {
            $('#dinner-category').click(function() {
                $.ajax({
                    url: 'category.php',
                    method: 'POST',
                    data: {
                        category: 'Dinner'
                    },
                    success: function(response) {
                        // Update the container with the fetched data
                        $('.category-food-container').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
        $(document).ready(function() {
            $('#snack-category').click(function() {
                $.ajax({
                    url: 'category.php',
                    method: 'POST',
                    data: {
                        category: 'Snack-time'
                    },
                    success: function(response) {
                        // Update the container with the fetched data
                        $('.category-food-container').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
        $(document).ready(function() {
            $('#tea-category').click(function() {
                $.ajax({
                    url: 'category.php',
                    method: 'POST',
                    data: {
                        category: 'Tea-time'
                    },
                    success: function(response) {
                        // Update the container with the fetched data
                        $('.category-food-container').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });

        function toggleSearchContainer(event) {
            // Prevent the default form submission behavior
            document.getElementById("search-food-container").style.display = "block";
        }

        // Add event listener to the search form
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