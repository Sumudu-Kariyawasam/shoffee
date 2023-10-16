<?php if(!isset($_SESSION["user"])){ ?>

<script>
    alert("Please signin first");
    window.location = "index.php";
</script>

<?php }else{ ?>
    
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
            $email = $_SESSION["user"]["email"];

            $cart_rs = Database::search("SELECT * FROM `recent` WHERE `user_email`='" . $email . "' && `type`='1'");
            $cart_num = $cart_rs->num_rows;

            $total = 0;
            $tax = 0;
            $discount = 0;
            ?>
        <form action="checkout.php" method="POST">
            <div class="col-12">
                <div class="row">
                    
                    <div class="col-12 py-3" style="background-color: rgb(220, 220, 220)">
                        <div class="row text-center">
                            <h4 class="fw-bold">Cart</h4>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7 p-3 ps-4">
                        <div class="row">
                            <div class="col-12 border border-dark border-opacity-50 rounded">
                                <div class="row p-2">

                                    <?php
                                    if ($cart_num > 0) {
                                        for ($x = 0; $x < $cart_num; $x++) {
                                            $cart_data = $cart_rs->fetch_assoc();

                                            $product_rs = Database::search("SELECT * FROM `product` WHERE `product_id`='" . $cart_data["product_id"] . "'");
                                            $product_data = $product_rs->fetch_assoc();

                                            $img_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $cart_data["product_id"] . "'");
                                            $img_data = $img_rs->fetch_assoc();

                                            $total = ($total + ($product_data["price"] * $cart_data["qty"]));
                                            $link = ($product_data['product_id']);

                                            $arr[] = array(
                                                "id" => $link,
                                                "price" => $product_data["price"]
                                            );

                                            $array = json_encode($arr);
                                    ?>

                                            <div class="col-12 card mb-2">
                                                <div class="row">
                                                    <div class="cardimg" style="width: 12rem; height: 10rem;">
                                                        <div class="d-flex justify-content-center overflow-hidden" style="height: 100%; width: 100%;">
                                                            <img src="<?php echo ($img_data["product_image_path"]); ?>" class="card-img-top" style="height: 100%; width: auto;">
                                                        </div>
                                                    </div>
                                                    <input class="d-none col-1" name="product<?php echo ($x); ?>" value="<?php echo ($link); ?>">
                                                    <input class="d-none col-1" name="title<?php echo ($x); ?>" value="<?php echo ($product_data["title"]); ?>">
                                                    <input class="d-none col-12" name="arr" value="<?php echo ($array); ?>">

                                                    <div class="card-body" style="width: calc(100% - 12rem);">
                                                        <h5 class="card-title"><?php echo ($product_data["title"]); ?></h5>
                                                        <span class="card-text text-secondary fw-bold">LKR. <?php echo ($product_data["price"] * $cart_data["qty"]); ?> .00</span><br>
                                                        <input type="number" class=" form-infield2 text-danger fw-bold" style="width: 50px;" name="qty<?php echo ($x); ?>" 
                                                        id="p-qty-c" value="<?php echo $cart_data["qty"]; ?>" min="0" onchange="priceCal();">
                                                        <span class="card-text text-danger fw-bold"> items Selected</span> &nbsp;/&nbsp;
                                                        <span class="card-text text-success fw-bold"><?php echo ($product_data["qty"]); ?> items Available</span>
                                                        <div class="col-12 mb-2">
                                                            <div class="row pe-4">
                                                                <div class="col-6">
                                                                    <label class="btn-1 fw-bold d-flex justify-content-center align-items-center pointer" onclick="toproduct(<?php echo ($link); ?>);">View</label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <button class="btn-1 fw-bold" style="background-color: rgb(255, 105, 105);" onclick="removecart(<?php echo $link; ?>);">Remove</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                    } else {
                                    ?>
                                        <div class="col-12 d-flex justify-content-center align-items-center" style="height: 84vh;">
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
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 p-3 ps-4 pe-4">
                        <div class="row pe-1">
                            <div class="col-12 border border-dark border-opacity-50 rounded">
                                <div class="row p-4">
                                    <div class="col-12">
                                        <div class="row text-center">
                                            <p class="fs-6 fw-bold">Order Summery</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <span class="p-0 mb-2">Enter Promo Code</span>
                                            <input type="text" class="form-infield">
                                            <label class="btn-1 fw-bold d-flex justify-content-center align-items-center pointer">Submit</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6 mt-3">
                                                <p class="">Sub Total</p>
                                                <p class="">Tax</p>
                                                <p class="">Discount</p>
                                                <p class="">Total</p>
                                            </div>
                                            <div class="col-6 mt-3 text-end">
                                                <p id="total1"><?php echo ($total); ?>.00</p>
                                                <p class=""><?php echo ($tax); ?>.00</p>
                                                <p class=""><?php echo ($discount); ?>.00</p>
                                                <p class=""><?php echo (($total + $tax) - $discount); ?>.00</p>
                                            </div>
                                            <input class="d-none col-12" name="total" id="total" value="<?php echo (($total + $tax) - $discount); ?>">
                                            <input class="d-none col-12" name="cart_num" value="<?php echo ($cart_num); ?>">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="fs-6 fw-bold">Total To Pay</p>
                                                <p class="fs-6 fw-bold text-success">Saved</p>
                                            </div>
                                            <div class="col-6 text-end">
                                                <p class="fs-6 fw-bold"><?php echo (($total + $tax) - $discount); ?>.00</p>
                                                <p class="fs-6 fw-bold text-success"><?php echo ($discount); ?>.00</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        <div class="row">
                                            <button class="btn-1 fw-bold" type="submit" <?php if($cart_num == 0){ echo ("disabled"); } ?>>Proceed To Checkout</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
            <?php
            include "footer.php";
            ?>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>

<?php } ?>