<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <title>Calories</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <link rel="stylesheet" href="/loginsys/calories.css">
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
    0% { box-shadow: 0 0 20px yellowgreen; } 
    25% { box-shadow: 0 0 20px skyblue; } 
    50% { box-shadow: 0 0 20px rgb(170, 123, 219); } 
    100% {box-shadow: 0 0 20px rgb(236, 88, 88); } 
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
                        <a  id="Calorieslink" class="nav-link" href="/loginsys/calories.php">Calories</a>
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
                        <div class="container">
                            <div class="row justify-content-center">
                                <form action="" method="POST" id="search-form" onsubmit="toggleSearchContainer(event)">

                                    <div class="col-md-12">
                                        <div class="input-group mb-3">
                                           <!-- HTML structure -->
<!-- Updated HTML -->
<input type="text" class="form-control" placeholder="Search for calories" aria-label="Search for calories" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>" aria-describedby="search-button" id="input-box" name="search">




                                            <button class="btn btn-outline-secondary" type="submit" name="submit" id="search-button"><img src="./assets/search-icon.svg" alt=""></button>
                                        </div>
                                    </div>
                                </form>
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

    <div class="col ">
        <div class="col text-center">
            <h1><span id="name">Food</span> has a total of <strong><span id="cal">100</span> Calories</strong></h1>
            <div id="imageContainer"></div>
            <div id="alertContainer" class="mt-3"></div>
            <div class="sugarContainer mt-3"></div>
        </div>
        
           
            <div class="row justify-content-center mt-5 mb-5">
                <div class="col-md-10 caloriescont shadow rounded">
                    <div class="row">

                        <div class="col-md-6">
                            <h2 class="mt-3 mb-4">Nutritional Values </h2><span></span>
                            <ul>
                                <li class="servingsize">Serving Size per 100/Grams or 0.1/liter <span class="float-end"></span></li>
                                <li>Carbohydrates: <span class="float-end carb">0.00</span>
                                </li>
                                <li>Cholesterol: <span class="float-end chol">0.00</span></li>
                                <li>Saturated fat: <span class="float-end fat">0.00</span></li>
                                <li>Total Fat: <span class="float-end totfat">0.00</span></li>
                                <li>Fiber Content: <span class="float-end fiber">0.00</span></li>
                                <li>Potassium <span class="float-end k">0.00</span></li>
                                <li>Protein: <span class="float-end protein">0.00<span></li>
                                <li>Sodium:<span class="float-end na">0.00</span></li>
                                <li>Sugar: <span class="float-end sweet">0.00</span></li>
                            </ul>
                        </div>
                        <div class="col-md-6 mb-5">
                            <h4 class="mt-3 mb-4" style="overflow-y: hidden;">To burn <strong>Calories</strong> you will have to</h4>

                            <div class="d-flex align-items-center mb-5">
                                <div class="flex-shrink-0" >
                                    <img src="assets/running.png" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 style="overflow-y: hidden;"> Jog </h5>
                                    <p>you will have to jog for <strong>
                                        <span id="jog">20</span></strong> Minutes</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-5">
                                <div class="flex-shrink-0">
                                    <img src="assets/yoga.png" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-4">
                                    <h5 style="overflow-y: hidden;"> Do Power Yoga </h5>
                                    <p>you will have to Power Yoga for <strong>
                                            <span id="yoga">20</span> </strong> Minutes</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-5">
                                <div class="flex-shrink-0">
                                    <img src="assets/weightlifter.png" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-4">
                                    <h5 style="overflow-y: hidden;">Get a Gym Workout </h5>
                                    <p>you will have to lift weight for <strong>
                                        <span id="gym">20</span> </strong> Minutes </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="assets/walking.png" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-1">
                                    <h5 style="overflow-y: hidden;"> Go for a Brisk Walk </h5>
                                    <p>you will have to brisk walk for <strong>
                                        <span id="walk">20</span> </strong> Minutes</p>
                                </div>
                            </div>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.querySelector('.navbar-nav').classList.toggle('active');
        });
        document.addEventListener('DOMContentLoaded', function() {
    // Event listener for search button click
    document.getElementById("search-button").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent form submission
        searchNutrition();
    });

    // Event listener for Enter key press in search box
    document.getElementById("search-box").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent form submission
            searchNutrition();
        }
    });
});
        function searchNutrition() {
            const food = document.getElementById("input-box").value;
    const food_name = document.getElementById("name");
    const calories = document.querySelector("#cal");
    const carbo = document.querySelector(".carb");
    const choles = document.querySelector(".chol");
    const satfat = document.querySelector(".fat");
    const totalfat = document.querySelector(".totfat");
    const fib = document.querySelector(".fiber");
    const pots = document.querySelector(".k");
    const pro = document.querySelector(".protein");
    const sodium = document.querySelector(".na");
    const sugar = document.querySelector(".sweet");
    const jogg = document.getElementById("jog");
    const power = document.getElementById("yoga");
    const workout = document.getElementById("gym");
    const brisk = document.getElementById("walk");
    const imageContainer = document.getElementById("imageContainer");
    const alertContainer = document.getElementById("alertContainer");
    const sugarContainer=document.getElementById("sugarContainer");

    const apiKey = 'hnkXlqLKUPbPVTjLxz+HSQ==ElYJCn9iRNCQMzHL';
    const apiUrl = 'https://api.api-ninjas.com/v1/nutrition?query=' + food;

    $.ajax({
        method: 'GET',
        url: apiUrl,
        headers: { 'X-Api-Key': apiKey },
        contentType: 'application/json',
        success: function(result) {
            console.log(result);
            const foodName = result[0].name;
            food_name.innerHTML = foodName;

            const Calories = result[0].calories;
            calories.innerHTML = Calories;
           if (result[0].calories> 200) {
                const img = document.createElement("img");
        img.src = "assets/shocked.png";
        img.className = "img-responsive";
        img.alt = "Shocked emoji";
        imageContainer.appendChild(img);
        calories.style.color = "red";
         }
            else{
                calories.style.color = "green";
            }
            

            const carbValue = result[0].carbohydrates_total_g;
            carbo.innerHTML = carbValue;

            const cholest = result[0].cholesterol_mg;
            choles.innerHTML = cholest;

            const satFat = result[0].fat_saturated_g;
            satfat.innerHTML = satFat;

            const totalFat = result[0].fat_total_g;
            totalfat.innerHTML = totalFat;

            const Fiber = result[0].fiber_g;
            fib.innerHTML = Fiber;

            const Potas = result[0].potassium_mg;
            pots.innerHTML = Potas;

            const Protein = result[0].protein_g;
            pro.innerHTML = Protein;

            const Sodium = result[0].sodium_mg;
            sodium.innerHTML = Sodium;
            if (result[0].sodium_mg > 100) {
               
                const alertDiv = document.createElement("div");
                alertDiv.className = "alert alert-danger align-items-center mt-3 ";
                alertDiv.setAttribute("role", "alert");
                alertDiv.innerHTML = `
                    <div>
                        This food contains a high amount of sodium. High sodium causes severe dehydration and water retention.
                    </div>
                `;
                alertContainer.appendChild(alertDiv);
            }
            

            const Sugar = result[0].sugar_g;
            sugar.innerHTML = Sugar;
            if (result[0].sugar_g > 50) {
               
                const alertDiv = document.createElement("div");
                alertDiv.className = "alert alert-danger  align-items-center mt-3 ";
                alertDiv.setAttribute("role", "alert");
                alertDiv.innerHTML = `
                    <div>
                        This food contains a high amount of sugar. Sugar causes insulin spikes and is a no. 1 cause of obesity 
                    </div>
                `;
                alertContainer.appendChild(alertDiv);
            }

            const jogging = Math.round(result[0].calories / 229 * 60);
            jogg.innerHTML = jogging;
            const Yoga = Math.round(result[0].calories / 223 * 60);
            power.innerHTML = Yoga;
            const Gym = Math.round(result[0].calories / 483 * 60);
            workout.innerHTML = Gym;
            const Walk = Math.round(result[0].calories / 294 * 60);
            brisk.innerHTML = Walk;

            
        },
        error: function ajaxError(jqXHR) {
            console.error('Error: ', jqXHR.responseText);
        }
    });
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