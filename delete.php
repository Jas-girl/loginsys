<?php
include '_dbconnect.php';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['name'])) {
    $recipe_name = $_GET['name'];
    $sql = "DELETE FROM category WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $recipe_name);

    if ($stmt->execute()) {
        $message = 'Recipe deleted successfully.';
    } else {
        $message = 'Could not delete the recipe.';
    }

    $stmt->close();
}

$conn->close();
header("Location: recipe.php?message=" . urlencode($message));
exit();
?>
