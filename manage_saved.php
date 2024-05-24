<?php
session_start();

// Destroy session (for testing purposes)
// session_destroy();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['ADD_TO_SAVED'])) {
        // Check if the form contains the necessary data
        if (isset($_POST['sno']) && isset($_POST['name']) && isset($_POST['category']) && isset($_POST['time']) && isset($_POST['ingredients']) && isset($_POST['recipe'])) {
            // Retrieve the recipe data from the form
            $recipe_id = $_POST['sno'];
            $recipe_name = $_POST['name'];
            $category = $_POST['category'];
            $time = $_POST['time'];
            $ingredients = $_POST['ingredients'];
            $recipe = $_POST['recipe'];

            // Check if the recipe ID already exists in the session
            if (isset($_SESSION['save'])) {
                $existing_ids = array_column($_SESSION['save'], 'sno');
                if (in_array($recipe_id, $existing_ids)) {
                    echo "<script>alert('Recipe with ID $recipe_id and Name $recipe_name already exists in session.'); window.location.href = '/loginsys/category.php';</script>";
                } else {
                    // Add the new recipe to the session
                    $_SESSION['save'][] = array(
                        'sno' => $recipe_id,
                        'name' => $recipe_name,
                        'category' => $category,
                        'time' => $time,
                        'ingredients' => $ingredients,
                        'recipe' => $recipe
                    );
                    echo "<script>alert('Recipe with ID $recipe_id and Name $recipe_name added to session.'); window.location.href = '/loginsys/saved.php';</script>";
                }
            } else {
                // If 'save' session variable doesn't exist, initialize it with the new recipe
                $_SESSION['save'][] = array(
                    'sno' => $recipe_id,
                    'name' => $recipe_name,
                    'category' => $category,
                    'time' => $time,
                    'ingredients' => $ingredients,
                    'recipe' => $recipe
                );
                echo "<script>alert('Recipe with ID $recipe_id and Name $recipe_name added to session.'); window.location.href = '/loginsys/saved.php';</script>";
            }
        } else {
            // If the necessary data is not found in the form data
            echo "<script>alert('Error: Recipe data missing.'); window.location.href = '/loginsys/category.php';</script>";
        }
    } elseif (isset($_POST['remove_item_index'])) {
        // Check if the item to remove is set
        if (isset($_POST['remove_item_index'])) {
            $index = $_POST['remove_item_index'];
            
            // Check if the index is valid and exists in the session
            if (isset($_SESSION['save'][$index])) {
                // Remove the item from the session array
                unset($_SESSION['save'][$index]);
                // Reset array keys to maintain continuity
                $_SESSION['save'] = array_values($_SESSION['save']);
                // Redirect to the same page or wherever needed
                header("Location: saved.php");
                exit(); // Ensure script execution stops after redirection
            } else {
                // Handle the case where the index is not valid
                echo "<script>alert('Invalid index.');</script>";
                // Redirect to the same page or wherever needed
                header("Location: saved.php");
                exit(); // Ensure script execution stops after redirection
            }
        } else {
            // Handle the case where the remove_item_index is not set
            echo "<script>alert('No index provided.');</script>";
            // Redirect to the same page or wherever needed
            header("Location: saved.php");
            exit(); // Ensure script execution stops after redirection
        }
    }
} else {
    // If the form was not submitted via POST method
    echo "<script>alert('Invalid request.'); window.location.href = '/loginsys/saved.php';</script>";
}
?>
