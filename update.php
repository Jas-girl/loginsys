<?php
include '_dbconnect.php';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';
$recipe = null;

// Check if an sno is provsnoed in the URL
if (isset($_GET['name'])) {
    $recipe_name = $_GET['name'];

    // Fetch the recipe details from the database based on the name
    $sql = "SELECT * FROM category WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $recipe_name);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the recipe was found
    if ($result->num_rows > 0) {
        $recipe = $result->fetch_assoc();
    } else {
        $message = "Recipe not found.";
    }
}
// Check if the form is submitted
if (isset($_POST['update_recipe'])) {
    $sno = $_POST['sno'];
    $recipe_name = $_POST['recipe_name'];
    $category = $_POST['category'];
    $recipe_image = $_FILES['recipe_image']['name'];
    $recipe_image_tmp_name = $_FILES['recipe_image']['tmp_name'];
    $recipe_image_folder = 'recipe_images/' . $recipe_image;
    $recipe_time = $_POST['recipe_time'];
    $ingredients = $_POST['ingredients'];
    $method = $_POST['method'];

    // Valsnoate inputs
    if (empty($recipe_name) || empty($category) || empty($recipe_time) || empty($ingredients) || empty($method)) {
        $message = 'Please fill out all fields.';
    } else {
        // Prepare the SQL statement
        if (!empty($recipe_image)) {
            // If a new image is uploaded, update the image as well
            $sql = "UPDATE category SET name = ?, category = ?, image = ?, time = ?, ingredients = ?, recipe = ? WHERE sno = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $recipe_name, $category, $recipe_image, $recipe_time, $ingredients, $method, $sno);
        } else {
            // If no new image is uploaded, keep the existing image
            $sql = "UPDATE category SET name = ?, category = ?, time = ?, ingredients = ?, recipe = ? WHERE sno = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $recipe_name, $category, $recipe_time, $ingredients, $method, $sno);
        }

        // Execute the query and check if it was successful
        if ($stmt->execute()) {
            // Move uploaded file to destination folder if a new image is uploaded
            if (!empty($recipe_image)) {
                move_uploaded_file($recipe_image_tmp_name, $recipe_image_folder);
            }
            $message = 'Recipe updated successfully.';
        } else {
            $message = 'Could not update the recipe.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/logo.svg">
    <title>Update Recipe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="\loginsys\home.css">
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

            background: url("https://media.gray.com/wp-content/uploads/2020/04/02070702/iStock-1133157200_NEW-WEB.jpg");
            background-size: 100% 100%;
            height:auto;
            margin-top: 50px;

        
           
            /* Ensure the background image covers the entire .contact div */
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="icon"><img src="assets/bar.svg" alt=""></span>
            </button>
        </div>
    </nav>
    <div class="form mt-5">
    <div class="container bg-dark py-4 my-5" style="max-width: 600px; border-radius: 20px; box-shadow: 0 0 50px yellowgreen;color:white">
        <h1 class="mb-4" style="color:yellow;overflow-y:hidden">Update Recipe</h1>

        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if ($recipe): ?>
            <form action="update.php?name=<?php echo $recipe['name']; ?>" method="post" enctype="multipart/form-data">

        <input type="hidden" name="sno" value="<?php echo $recipe['sno']; ?>">
        <div class="mb-3">
            <label for="recipe_name" class="form-label">Recipe Name</label>
            <input type="text" class="form-control" name="recipe_name" value="<?php echo $recipe['name']; ?>">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" class="form-control" name="category" value="<?php echo $recipe['category']; ?>">
        </div>
        <div class="mb-3">
            <label for="recipe_image" class="form-label">Recipe Image</label>
            <input type="file" class="form-control" name="recipe_image">
            <?php if (!empty($recipe['image'])): ?>
                <img src="recipe_images/<?php echo $recipe['image']; ?>" alt="<?php echo $recipe['name']; ?>" width="100" class="mt-2">
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="recipe_time" class="form-label">Recipe Time(in minutes)</label>
            <input type="text" class="form-control" name="recipe_time" value="<?php echo $recipe['time']; ?>">
        </div>
        <div class="mb-3">
            <label for="ingredients" class="form-label">Ingredients</label>
            <textarea class="form-control" name="ingredients" rows="4"><?php echo $recipe['ingredients']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="method" class="form-label">Method</label>
            <textarea class="form-control" name="method" rows="4"><?php echo $recipe['recipe']; ?></textarea>
        </div>
        <button type="submit" name="update_recipe" class="btn btn-primary">Update Recipe</button>
    </form>
<?php else: ?>
    <div class="alert alert-warning">No recipe found to update.</div>
<?php endif; ?>

</div>
</div>
</body>
</html>


<?php
$conn->close();
?>
