<?php
include '_dbconnect.php';

if(isset($_POST['add_news'])) {
    // Establish MySQL connection
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

    if (!$conn) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    $news_name = $_POST['news_name'];
    $desc = $_POST['desc'];
    $news_image = $_FILES['news_image']['name'];
    $news_image_tmp_name = $_FILES['news_image']['tmp_name'];
    $news_image_folder = 'news_images/' . $news_image;

    if(empty($news_name) || empty($desc) || empty($news_image)){
        $message[] = 'Please fill out all fields.';
    }
    else{
        $insert = "INSERT INTO health_news(name, image, description) VALUES ('$news_name', '$news_image', '$desc')";
        $upload = mysqli_query($conn, $insert);

        if($upload){
            move_uploaded_file($news_image_tmp_name, $news_image_folder);
            $message[] = 'New product added successfully.';
        }
        else{
            $message[] = 'Could not add the product.';
        }
    }

    // Close MySQL connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/logo.svg">
    <title>Admin Panel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;
            text-transform: capitalize;
        }
        html {
            font-size: 62.5%;
            overflow-x: hidden;
        }
        .container {
            max-width: 1200px;
            padding: 2rem;
            margin: 0 auto;
        }
        .admin-news-form-container {
            max-width: 50rem;
            margin: 0 auto;
            padding: 2rem;
            border-radius: .5rem;
            background-color: lightgrey;
        }
        .admin-news-form-container h3{
            text-transform: uppercase;
            margin-bottom: 1rem;
            text-align: center;
            font-size: 2.5rem;
        }
        .box {
            width: 100%;
            margin-bottom: 1rem;
            padding: 1.2rem 1.5rem;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
            box-sizing: border-box;
            font-size: 1.7rem;
            background-color: #fff;
            text-transform: none;
        }
        .btn {
            display:block;
            width: 100%;
            margin-top: 1rem;
            cursor: pointer;
            border-radius: .5rem;
            font-size: 1.7rem;
            padding:1rem 3rem;
            background-color: green;
            color:white;
        }
        .btn:hover {
            background-color: black;
        }
        .message{
            display:block;
            background: lightgray;
            padding:1.5rem 1rem;
            font-size: 2rem;
            margin-bottom: 2rem;
           
        }
        @media (max-width:991px){
            html{
                font-size: 55%;
            }
        }
        @media (max-width:450px){
            html{
                font-size: 50%;
            }
        }
    </style>
</head>
<body>
    <?php 
      if(isset($message)){
        foreach($message as $message){
            echo '<span class="message">'.$message.'</span>';
        }
      }
    ?>
    <div class="container">
        <div class="admin-news-form-container">
            <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                <h3>Add news</h3>
                <input type="text" placeholder="Enter news name" name="news_name" class="box">

                <textarea name="desc" id="" rows="6" placeholder="Enter the description" class="box"></textarea>
              
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="news_image" class="box">
                <input type="submit" class="btn" name="add_news" value="Add a news">
            </form>
        </div>
    </div>
</body>
</html>
