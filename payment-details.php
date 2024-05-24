<?php
session_start();

// Initialize variables to avoid errors
$category = isset($_GET['category']) ? $_GET['category'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
$duration = isset($_GET['duration']) ? $_GET['duration'] : '';
$plans = isset($_GET['plans']) ? $_GET['plans'] : '';
$meetings = isset($_GET['meetings']) ? $_GET['meetings'] : '';
$receipt = null;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="payment-details.css">
    <link rel="icon" type="image/x-icon" href="assets/logo.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Payment </title>
</head>
<style>
    #mynavbar .nav-item a {
    font-size: 18px;
  
   
}
    .navbar-toggler:hover{
    background-color: rgb(225, 235, 225);
    margin-bottom: 5px;
}
.container .card-container .front{
    /* position: absolute; */
    height:100%;
    width:100%;
    top:0;
    left:0;
    background: linear-gradient(45deg, green,rgb(20, 20, 20));
    border-radius: 5px;
    backface-visibility: hidden;
    box-shadow: 0 15px 25px rgba(0,0,0,0.2);
    padding:20px;
    text-transform: uppercase; 
    color:white
   
}
.container .product form input[type="submit"] {
    width:100%;
    margin-top:20px;
    background: linear-gradient(45deg, green,rgb(14, 14, 14));
    padding:10px;
    font-size: 20px;
    color: white;
    border: none;
    cursor: pointer;
    transition: 0.3s linear; 
    border-radius: 10px;
}

    @media screen and (max-width: 900px) {
    #mynavbar .nav-item a {
      color:white;
      font-size: 12px;
    }
}
@media screen and (max-width:400px) {
    .container .card-container {
        width:300px;
    }
    .cvv{
        margin-top: 20px;
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
                        <a class="nav-link" id="HomeLink" href="./home.php">Home</a>
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
            <a href="\loginsys\logout.php" id=logout><button>Log out</button></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="icon"><img src="assets/bar.svg" alt=""></span>
            </button>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="product">
                    <h1 class="text-center">Payment Details</h1>

                    <div class="detail text-center">
                        <p><strong>Category:</strong> <?php echo $category; ?></p>
                    </div>
                    <div class="detail text-center">
                        <p><strong>Price:</strong> <?php echo $price; ?></p>
                    </div>
                    <div class="detail text-center">
                        <p><strong>Duration:</strong> <?php echo $duration; ?></p>
                    </div>
                    <div class="detail text-center">
                        <p><strong>Plans:</strong> <?php echo $plans; ?></p>
                    </div>
                    <div class="detail text-center">
                        <p><strong>Meetings:</strong> <?php echo $meetings; ?></p>
                    </div>
                    <div class="card-container">
                        <div class="front">
                            <div class="image"><img src="assets/chip.png" alt="">
                                <img src="assets/visa.png" alt="">
                            </div>
                            <div class="card-number-box">################</div>
                            <div class="flexbox">
                                <div class="box">
                                    <span>CARD HOLDER</span>
                                    <div class="card-holder-name">FULL NAME</div>
                                </div>
                               
                                <div class="box">
                                    <span>EXPIRES CVV</span>
                                    <div class="expiration"><span class="exp-month">MM</span>
                                       / <span class="exp-year">YY</span>
                                       &nbsp;&nbsp;<span class="cvv-box">&nbsp;&nbsp;***</span>
                                    </div>
                                   


                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="paymentForm" action="home.php" method="post">
                        <div class="inputbox">
                            <span>Card Number</span>
                            <input type="text" maxlength="16" class="card-number-input">
                        </div>
                        <div class="inputbox">
                            <span>Card Holder</span>
                            <input type="text" class="card-holder-input">
                        </div>
                        <div class="flexbox">
                            <div class="inputbox">
                                <span>expiration mm</span>
                                <select name="" id="" class="month-input">
                                    <option value="month" selected disabled>month</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <div class="inputbox">
                                <span>expiration yy</span>
                                <select name="" id="" class="year-input">
                                    <option value="year" selected disabled>year</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>

                                </select>
                            </div>
                            <div class="inputbox cvv">
                                <span>cvv</span>
                                <input type="text" maxlength="3" class="cvv-input">
                            </div>
                        </div>
                        <input type="submit" name="submit" value="PAY: <?php echo $price; ?>" class="submit-btn">

                    </form>
                    <?php
                    // Display receipt if available
                    if ($receipt) {
                        echo $receipt;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


    <a href="https://dribbble.com/myacode" class="dribbble" target="_blank"><ion-icon name="logo-dribbble"></ion-icon></a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        document.querySelector('.card-number-input').oninput = () => {
            document.querySelector('.card-number-box').innerText = document.querySelector('.card-number-input').value;
        }
        document.querySelector('.card-holder-input').oninput = () => {
            document.querySelector('.card-holder-name').innerText = document.querySelector('.card-holder-input').value;
        }
        document.querySelector('.month-input').oninput = () => {
            document.querySelector('.exp-month').innerText = document.querySelector('.month-input').value;
        }
        document.querySelector('.year-input').oninput = () => {
            document.querySelector('.exp-year').innerText =document.querySelector('.year-input').value;
        }
        document.querySelector('.cvv-input').oninput = () => {
            document.querySelector('.cvv-box').innerText = document.querySelector('.cvv-input').value;
        }
        
        document.getElementById('paymentForm').addEventListener('submit', function(event) {
    // Prevent the default form submission
    event.preventDefault();

    // Initialize an array to store empty fields information
    var emptyFieldsInfo = [];

    // Check if any field is empty
    var formFields = document.querySelectorAll('#paymentForm input[type="text"], #paymentForm select');
    formFields.forEach(function(field) {
        if (!field.value.trim()) {
            // Get the label text associated with the field
            var labelText = field.closest('.inputbox').querySelector('span').innerText.trim();
            // Get the field type (input or select)
            var fieldType = field.tagName.toLowerCase();

            // Special handling for select elements to check if any option is selected
            if (fieldType === 'select') {
                if (field.selectedIndex === 0 && field.value === '') { // Check if the default "disabled" option is selected
                    emptyFieldsInfo.push(labelText);
                }
            } else {
                // For input elements, just add the label text to the array
                emptyFieldsInfo.push(labelText);
            }
        }
    });

    // Show alert message if any field is empty
    if (emptyFieldsInfo.length > 0) {
        var emptyFieldNames = emptyFieldsInfo.join(', ');
        alert('Please fill in all fields: ' + emptyFieldNames);
    } else {
        // Otherwise, let the form submit
        alert('Payment successful!');
        this.submit(); // Submit the form
    }
});




    </script>
</body>

</html>