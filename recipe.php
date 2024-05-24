<?php
session_start();

// Include database connection file
include '_dbconnect.php';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

// Check if the form is submitted
if (isset($_POST['add_recipe'])) {
    // Get form data
    $recipe_name = $_POST['recipe_name'];
    $category = $_POST['category'];
    $recipe_time = $_POST['recipe_time'];
    $ingredients = $_POST['ingredients'];
    $method = $_POST['method'];

    // File upload handling
    $recipe_image = $_FILES['recipe_image']['name'];
    $recipe_image_tmp_name = $_FILES['recipe_image']['tmp_name'];
    $recipe_image_folder = 'recipe_images/' . $recipe_image;

    // Validate form inputs
    if (empty($recipe_name) || empty($category) || empty($recipe_image) || empty($recipe_time) || empty($ingredients) || empty($method)) {
        $message = 'Please fill out all fields.';
    } else {
        // Prepare and bind the SQL statement
        $insert = $conn->prepare("INSERT INTO category (name, category, image, time, ingredients, recipe) VALUES (?, ?, ?, ?, ?, ?)");
        $insert->bind_param("ssssss", $recipe_name, $category, $recipe_image, $recipe_time, $ingredients, $method);

        // Check if the query executed successfully
        if ($insert->execute()) {
            // Move uploaded file to destination folder
            move_uploaded_file($recipe_image_tmp_name, $recipe_image_folder);
            $message = 'New recipe added successfully.';
        } else {
            $message = 'Could not add the recipe.';
        }
    }
}



// Check if the connection is established
if ($conn) {
    // Execute the query
    $sql = "SELECT sno, name, category, image, time, ingredients, recipe FROM category";
    $result = $conn->query($sql);
    // Check if the query executed successfully
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
} else {
    // Handle connection error
    die("Connection failed: " . mysqli_connect_error());
}
?>



<?php


// Initialize variables to avoid errors
$name = isset($_GET['name']) ? $_GET['name'] : '';
$image = isset($_GET['image']) ? $_GET['image'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$time = isset($_GET['time']) ? $_GET['time'] : '';
$ingredients = isset($_GET['ingredients']) ? $_GET['ingredients'] : '';
$method = isset($_GET['method']) ? $_GET['method'] : '';
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="icon" type="image/x-icon" href="assets/logo.svg">
    <title>Recipe</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="\loginsys\recipe.css">
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
    0% { border-color: yellowgreen;box-shadow: 0 0 20px yellowgreen; } 
    25% { border-color: skyblue;box-shadow: 0 0 20px skyblue; } 
    50% { border-color: rgb(170, 123, 219);box-shadow: 0 0 20px rgb(170, 123, 219); } 
    100% { border-color: rgb(236, 88, 88);box-shadow: 0 0 20px rgb(236, 88, 88); } 
}

      

        .recipe {
            display: none;
            /* Hide the recipe section by default */
            box-shadow: 2px 4px 6px white, 0px 6px 20px white;
            padding: 20px;
            background: linear-gradient(35deg, green, white);
            margin-bottom: 20px;
            border-radius: 10px;


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
strong{
    color:#00ff2a
}
.home #addRecipeBtn {
    font-weight: bold;
    border-radius: .5rem;
    transition-property: width;
  transition-duration: 2s;
  transition-timing-function: linear;
  transition-delay: 1s;
  width:200px;
  height:50px;

}
.home #addRecipeBtn:hover {
    background: linear-gradient(35deg, green, rgb(191, 233, 6));

    color:white;
    box-shadow: 0 0 7px yellowgreen;
}


.text p:hover {
    color: yellowgreen;
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
                        <a class="nav-link " href="./home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./category.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./calories.php">Calories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link title-small has-state" id="recipeLink" href="./recipe.php">Recipes</a>
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
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

                        <button id="addRecipeBtn" class="btn1 justify-content-center align-items-center">ADD A RECIPE</button>

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
    <div class="showrecipe " style="background-color:black;color:white;">
    <div class="container">
    <h1 class="text-center" style="overflow-y:hidden;color:yellow">RECIPE</h1>

    <div class="row">
    <div class="detail text-center">
            <p><strong>Name:</strong> <?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?></p>
        </div>
    <!-- First column for name, category, and image -->
    <div class="col-md-6">
        
        
        <div class="detail text-center">
            <?php $pathx = "/loginsys/recipe_images/"; ?>
            <p><strong></strong> <img src="<?php echo isset($_GET['image']) ? htmlspecialchars($pathx . $_GET['image']) : ''; ?>" width=300 height=300></p>
        </div>
        <div class="detail text-center">
            <p><strong>Ingredients:</strong> <?php echo isset($_GET['ingredients']) ? htmlspecialchars($_GET['ingredients']) : ''; ?></p>
        </div>
    </div>
    

    <!-- Second column for time, ingredients, and recipe -->
    <div class="col-md-6">
        <div class="detail text-center">
            <p><strong>Time:</strong> <?php echo isset($_GET['time']) ? htmlspecialchars($_GET['time']) : ''; ?> Minutes</p>
        </div>
        <div class="detail text-center">
            <p><strong>Category:</strong> <?php echo isset($_GET['category']) ? htmlspecialchars($_GET['category']) : ''; ?></p>
        </div>
       
        <div class="detail text-center">
            <p><strong>Recipe:</strong> <?php echo isset($_GET['recipe']) ? htmlspecialchars($_GET['recipe']) : ''; ?></p>
        </div>
    </div>
</div>
</div>
</div>

<div class="addrecipe"  id="addrecipe-section" style="background-color:black;color:white">
    <div class="container" style="max-width: 600px;">
    <?php if (isset($message)) : ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <h2 class="text-center mb-4" style="overflow-y:hidden;color:yellow">ADD A RECIPE</h2>
        <div class="recipe-name mb-3">
            <label for="recipe_name">Enter a recipe name:</label>
            <input type="text" placeholder="Enter a recipe name" id="recipe_name" name="recipe_name" class="form-control" required>
        </div>
        <div class="recipe-category mb-3">
            <label for="category">Choose a category:</label>
            <select class="form-control" id="category" name="category" required>
                <option value="Category">Category</option>
                <option value="Breakfast">Breakfast</option>
                <option value="Lunch">Lunch</option>
                <option value="Dinner">Dinner</option>
                <option value="Snack-time">Snack-time</option>
                <option value="Tea-time">Tea-time</option>
            </select>
        </div>
        <div class="recipe-image mb-3">
            <label for="recipe_image">Choose an image:</label>
            <input type="file" accept="image/png, image/jpeg, image/jpg" id="recipe_image" name="recipe_image" class="form-control" required>
        </div>
        <div class="recipe-time mb-3">
            <label for="recipe_time">Duration:(In minutes)</label>
            <input type="number" placeholder="Enter a recipe duration" id="recipe_time" name="recipe_time" class="form-control" required>
        </div>
        <div class="recipe-ingredients mb-3">
            <label for="ingredients">Enter ingredients:</label>
            <textarea id="ingredients" class="form-control" rows="10" name="ingredients" required></textarea>
        </div>
        <div class="recipe-method mb-3">
            <label for="method">Enter method:</label>
            <textarea id="method" class="form-control" rows="10" name="method" required></textarea>
        </div>
        <?php 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // Display the upload button
    echo '<button type="submit" class="btn btn-warning" name="add_recipe" style="text-decoration:none">Upload</button>';
} else {
    // Display a button that links to the login page
    echo '<a href="/loginsys/login.php" id="login" style="text-decoration:none"><button class="btn btn-warning">Upload</button></a>';
}
?>


    </form>
   
</div>
</div>
<div class="management" style="background-color:black">
<div class="container mt-5">
<h1 class="text-center mb-4" style="overflow-y:hidden;color:yellow">RECIPE MANAGEMENT</h1>
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="input-group mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search for recipes...">
                <button class="btn btn-outline-secondary" type="button" id="search-button" style="background: linear-gradient(135deg, green, yellow); color: white;" onclick="searchRecipe()">
    <img src="./assets/search-icon.svg" alt="">
</button>

            </div>
        </div>
    </div>

        
        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="table-responsive">
    <table class="table table-bordered" id="recipeTable">
        <thead>
            <tr>
                <th><strong>ID</strong></th>
                <th><strong>Name</strong></th>
                <th><strong>Category</strong></th>
                <th><strong>Image</strong></th>
                <th><strong>Time (minutes)</strong></th>
                <th><strong>Ingredients</strong></th>
                <th><strong>Method</strong></th>
                <th><strong>Actions</strong></th>
            </tr>
        </thead>
        <tbody style="color:white">
        <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['sno']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><img src="recipe_images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" width="100"></td>
                        <td><?php echo $row['time']; ?></td>
                        <td><?php echo $row['ingredients']; ?></td>
                        <td><?php echo $row['recipe']; ?></td>
                        <td>
                        <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        // User is logged in, provide the update link
        echo '<a href="update.php?name=' . $row['name'] . '" class="btn btn-success btn-sm" name="update_recipe">Update</a>';
    } else {
        // User is not logged in, provide the login link
        echo '<a href="\loginsys\login.php" class="btn btn-success btn-sm">Update</a>';
    }
?><br> <?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo '<a href="delete.php?name=' . $row['name'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this recipe?\');">Delete</a>';
} else {
    // User is not logged in, provide the login link
    echo '<a href="\loginsys\login.php" class="btn btn-danger btn-sm">Delete</a>';
}
?>

                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No recipes found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

        <?php $conn->close(); ?>
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




    </div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.querySelector('.navbar-nav').classList.toggle('active');
        });
       
        document.addEventListener("DOMContentLoaded", function() {
    // Get the button and add an event listener for click event
    var addRecipeBtn = document.getElementById("addRecipeBtn");
    addRecipeBtn.addEventListener("click", function() {
        // Scroll to the addrecipe section smoothly
        document.getElementById("addrecipe-section").scrollIntoView({ behavior: "smooth" });
    });
});
function searchRecipe() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("recipeTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those that don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1]; // Change index to match the column containing recipe names
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
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