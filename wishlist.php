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
            if (isset($_SESSION["user"])) {
                $email = $_SESSION["user"]["email"];


                $wishlist_rs = Database::search("SELECT * FROM `recent` WHERE `type`='2' && `user_email`='" . $email . "'");
                $wishlist_num = $wishlist_rs->num_rows;

                $total = 0;
            ?>

                <div class="col-12 p-3" style="background-color: rgb(220, 220, 220)">
                    <div class="row text-center">
                        <h4 class="fw-bold">WishList</h4>
                    </div>
                </div>

                <div class="col-12 col-lg-10 offset-lg-1 my-3">
                    <div class="row">

                        <?php
                        $product_array = array();
                        if ($wishlist_num > 0) {
                        ?>

                            <div class="col-12 border border-dark border-opacity-50 rounded bg-white">
                                <div class="row p-3 pb-2">

                                    <?php

                                    for ($x = 0; $x < $wishlist_num; $x++) {
                                        $wishlist_data = $wishlist_rs->fetch_assoc();

                                        $product_rs = Database::search("SELECT * FROM `product` WHERE `product_id`='" . $wishlist_data["product_id"] . "'");
                                        $product_data = $product_rs->fetch_assoc();

                                        $img_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $wishlist_data["product_id"] . "'");
                                        $img_data = $img_rs->fetch_assoc();

                                        $total = ($total + $product_data["price"]);
                                        $product_array[] = $product_data["product_id"];

                                    ?>

                                        <div class="col-12 mt-2 wish-card">
                                            <div class="row mb-3">
                                                <div class="col-6 col-lg-3" style="height: 6rem;">
                                                    <div class="col-12 d-flex justify-content-center overflow-hidden" style="height: 100%;">
                                                        <img src="<?php echo $img_data["product_image_path"]; ?>" style="height: 100%;">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <h5 class="card-title mb-2"><?php echo $product_data["title"]; ?></h5>
                                                        <span class="card-text text-secondary fw-bold mb-1">LKR. <?php echo $product_data["price"]; ?> .00</span><br>
                                                        <span class="card-text text-success fw-bold mb-1"><?php echo $product_data["qty"]; ?> items Available</span><br>
                                                        <span class="card-text text-dark">Added On <?php echo $wishlist_data["added_date"]; ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-3">
                                                    <div class="row mt-2">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <button class="btn-1 fw-bold" onclick="wishOnetoCart(<?php echo $product_data['product_id']; ?>);">Add to Cart</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <button class="btn-1 fw-bold" style="background-color: rgb(255, 105, 105);" onclick="removewish(<?php echo $wishlist_data['product_id']; ?>);">Remove</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } ?>

                                </div>
                            </div>

                        <?php
                        } else {
                        ?>
                            <div class="col-12 d-flex justify-content-center align-items-center" style="height: 70vh;">
                                <div class="row text-center d-flex justify-content-center align-items-center pb-5">
                                    <img src="images/not-found.gif" style="height: 250px; width: 300px;" class=" position-absolute opacity-50">
                                    <span class="text-black-50 fw-bold pt-5" style="z-index: 1;">We're Sorry To Say. But,</span>
                                    <h3 class="fw-bold text-black-50" style="z-index: 1;">No Result Found!</h3>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>

                <div class="col-10 offset-1 pt-3 border border-dark border-opacity-50 rounded mb-3">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <p class="fw-bold"><?php echo $wishlist_num; ?> Items In Wishlist</p>
                            <p class="fw-bold">Total Amount : LKR. <?php echo $total; ?>.00</p>
                        </div>

                        <div class="col-12 col-lg-6">
                            <button class="btn-1 fw-light col-12 mt-2 fw-bold" onclick="wishtoCart();">Checkout all through cart</button>
                        </div>
                    </div>
                </div>

            <?php
            } else {
            ?>
                <div class="col-12 d-flex justify-content-center align-items-center" style="height: 70vh;">
                    <div class="row text-center d-flex justify-content-center align-items-center pb-5">
                        <img src="images/not-found.gif" style="height: 250px; width: 300px;" class=" position-absolute opacity-50">
                        <span class="text-black-50 fw-bold pt-5" style="z-index: 1;">You're not logged in,</span>
                        <h3 class="fw-bold text-black-50" style="z-index: 1;">Please Login First!</h3>
                    </div>
                </div>
            <?php
            }
            include "footer.php";
            ?>
            <script>
                function wishtoCart() {
                    var array = <?php echo json_encode($product_array); ?>;
                    var f = new FormData();
                    f.append("ar",array);

                    var r = new XMLHttpRequest();
                    r.onreadystatechange = function() {
                        if (r.readyState == 4) {
                            var t = r.responseText;
                            if (t == "success") {
                                window.location = "cart.php";
                            } else {
                                alert(t);
                            }
                        }
                    };

                    r.open("POST", "wishtoCartProcess.php", true);
                    r.send(f);

                }
            </script>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>