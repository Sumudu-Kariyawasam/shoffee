<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wish List | ShoFFee</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="d-body body-bg">

    <div class="container-fluid contain2">
        <div class="row">
            <?php
            include "header.php";
            ?>

            <div class="col-12 py-5">
                <div class="row">
                    <div class="col-12 col-lg-6 d-flex justify-content-center py-5">
                        <img src="images/about.png" style="height: 200px;" class=" opacity-75">
                    </div>
                    <div class="col-12 col-lg-6 py-3 py-lg-5" style="height: 100%;">
                        <div class="col-12 ps-3 pt-lg-5">
                            <span class="fw-bold text-white fs-3">Know</span><br>
                            <h1 class="fw-bold t-pri" style="font-family: Arial;">About Us..</h1>
                            <span class=" text-white-75">We are a world trusted Online Shopping Center.</span><br>
                            <span class=" text-white-75">World's best shopping platform..</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="col-12 card-box card1">
                <div class="row py-5 px-3 text-center">
                    <h4 class="fw-bold t-pri pb-2">Shopping On World Trusted Platform</h4>
                    <p class=" ">Spend your money in a globally trusted company and get the real value of your money.<br>
                        We have every technical items wich you dreams. 
                        Just enjoy the tour of online shopping with us and feed your needs.
                    </p>
                    <div class="col-8 offset-2 col-lg-4 offset-lg-4">
                        <button class="btn-1 fw-bold" onclick="window.location = 'shop.php'">Shop On ShoFFee</button>
                    </div>
                    <div class="col-8 offset-2 col-lg-4 offset-lg-4">
                        <button class="btn-1 fw-bold" onclick="window.location = 'index.php'">Register On ShoFFee</button>
                    </div>
                </div>
            </div>

            <?php
            include "footer.php";
            ?>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>
</html>