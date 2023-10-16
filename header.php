<?php

require "connection.php";
session_start();

if(isset($_SESSION["user"])){
    $user = $_SESSION["user"];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="col-12 hd-main d-none d-lg-block bg-white">
        <div class="row ps-2 pe-3">
            <div class="col-12 py-2 top-box">
                <div class="col-3 logo-header pointer" onclick="window.location='home.php'"></div>
                <div class="col-8 hd-search">
                    <input type="text" class="sr-inp">
                    <button class="sr-btn">| search</button>
                </div>
                <div class="col-1">
                    <div class="row">
                        <a href="cart.php" class="hd-cart-a col-7 d-flex justify-content-end" >
                            <img src="images/cartico.svg" class="hd-cart">
                        </a>
                        <a href="myProfile.php" class="hd-cart-a col-5 d-flex justify-content-end">
                        <img src="images/man.svg" class="hd-man">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 pb-2 mid-box">
                <div class="col-5 ps-2">
                    <?php
                    if(isset($user["email"])){
                    ?>
                    <span><?php echo($user["fname"]); ?>, Welcome to <b>ShoFFee.net</b></span></span>
                    <?php
                    }else{
                    ?>
                    <span><a href="index.php" class="text-decoration-none">Sign in or Register </a><b>ShoFFee.net</b></span></span>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-7 link-grp">
                    <div class="column hd-links">
                        <a href="home.php" class="hd-link">Home</a>
                        <a href="shop.php" class="hd-link">Shop Now</a>
                        <a class="dropdown-toggle hd-link" type="button" data-bs-toggle="dropdown" aria-expanded="false">Sell</a>
                        <ul class=" dropdown-menu">
                            <li><a href="addProduct.php" class="dropdown-header hd-link">Add Product</a></li>
                            <li><a href="myListings.php" class="dropdown-header hd-link">My Listings</a></li>
                            <li><a href="myOrders.php" class="dropdown-header hd-link">My Orders</a></li>
                        </ul>
                        <a href="wishlist.php" class="hd-link">Wishlist</a>
                        <a href="myProfile.php" class="hd-link">My Profile</a>
                        <a href="aboutus.php" class="hd-link">About Us</a>
                        <a href="#" onclick="logout();" class="hd-link ">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- -- small devices header -- -->

    <div class="bg-white hder-sm">
        <div class="hdr-md d-lg-none">
            <div class="row p-2 pt-3 ps-4" style="height: 50px;">
                <div class="col-4 logo-header"></div>
                <div class="col-8 d-flex justify-content-end">
                    <div class="col-12 hd-search">
                        <input type="text" class="sr-inp">
                        <button class="sr-btn">| search</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="hdr-md d-lg-none">
            <div class="row">
                <div class="col-6 ps-4 pt-2">
                <?php
                    if(isset($user["email"])){
                    ?>
                    <p class="ps-2">Welcome <?php echo ($user["fname"]) ?>..</p>
                    <?php
                    }else{
                    ?>
                    <span><a href="index.php" class="text-decoration-none">Sign in or Register </a></span>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-6">
                    <div class="col-12 dropdown d-flex justify-content-end">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        My eShop
                    </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="home.php">Home</a></li>
                            <li><a class="dropdown-item" href="myProfile.php">My Profile</a></li>
                            <li><a class="dropdown-item" href="shop.php">Shop on ShoFFee</a></li>
                            <li><a class="dropdown-item" href="#">Sell On ShoFFee</a></li>
                            <li><a class="dropdown-item" href="myListings.php">My Listings</a></li>
                            <li><a class="dropdown-item" href="#">Purchase History</a></li>
                            <li><a class="dropdown-item" href="#">Message</a></li>
                            <li><a class="dropdown-item" href="#">Wishlist</a></li>
                            <li><a class="dropdown-item" href="#">Cart</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="bootstrap.js"></script> -->
    <!-- <script src="bootstrap.bundle.js"></script> -->
    <!-- <script src="script.js"></script> -->
</body>
</html>




                    