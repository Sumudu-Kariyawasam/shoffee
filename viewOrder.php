<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders | ShoFFee</title>
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

                if (isset($_GET["id"])) {
                    $id = $_GET["id"];

                    $order_rs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON 
                    invoice.product_id=product.product_id WHERE `order_id`='" . $id . "' AND  product.user_email='" . $email . "'");
                    $order_num = $order_rs->num_rows;

                    $total = 0;
            ?>

                    <div class="col-12 p-3" style="background-color: rgb(220, 220, 220)">
                        <div class="row text-center">
                            <h4 class="fw-bold"><?php  ?></h4>
                        </div>
                    </div>

                    <div class="col-12 col-lg-10 offset-lg-1 my-3">
                        <div class="row">

                            <?php
                            $product_array = array();
                            if ($order_num > 0) {
                            ?>

                                <div class="col-12 border border-dark border-opacity-50 rounded bg-white">
                                    <div class="row p-3 pb-2">

                                        <?php

                                        for ($x = 0; $x < $order_num; $x++) {
                                            $order_data = $order_rs->fetch_assoc();

                                            $product_rs = Database::search("SELECT * FROM `product` WHERE `product_id`='" . $order_data["product_id"] . "'");
                                            $product_data = $product_rs->fetch_assoc();

                                            $img_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $order_data["product_id"] . "'");
                                            $img_data = $img_rs->fetch_assoc();

                                            $customer_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $order_data["user_email"] . "'");
                                            $customer_data = $customer_rs->fetch_assoc();
                                        ?>

                                            <div class="col-12 mt-2 wish-card">
                                                <div class="row mb-3">
                                                    <div class="col-4 col-lg-3" style="height: 6rem;">
                                                        <div class="col-12 d-flex justify-content-center overflow-hidden pointer" style="height: 100%;" onclick="singleProduct(<?php echo ($product_data['product_id']); ?>);">
                                                            <img src="<?php echo $img_data["product_image_path"]; ?>" style="height: 100%;">
                                                        </div>
                                                    </div>
                                                    <div class="col-8 col-lg-6">
                                                        <div class="row">
                                                            <h5 class="card-title mb-2"><?php echo $product_data["title"]; ?></h5>
                                                            <span class="card-text text-success fs-6 fw-bold mb-1"><?php echo $order_data["invoice_qty"]; ?> Items Purchased</span><br>
                                                            <span class="card-text text-dark">Purchased On <?php echo $order_data["date_time"]; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-3">
                                                        <div class="row mt-2">
                                                            <div class="col-12">
                                                                <div class="row">
                                                                    <div class="col-6 col-lg-12 px-3">
                                                                        <div class="row">
                                                                            <select class="form-infield3 border border-secondary text-black" id="o_status">
                                                                                <option value="2" <?php if($order_data["invoice_status"] == 2){ echo "selected"; } ?>>Pending</option>
                                                                                <option value="3" <?php if($order_data["invoice_status"] == 3){ echo "selected"; } ?>>Ready To Deliver</option>
                                                                                <option value="4" <?php if($order_data["invoice_status"] == 4){ echo "selected"; } ?>>Delivered</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 col-lg-12 px-3">
                                                                        <div class="row">
                                                                            <button class="btn-1 btn-2 mt-0 mt-lg-2" style="background-color: #7be29c;" onclick="updateOrderStatus(<?php echo $product_data['product_id']; ?>);">Update Status</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="text" id="order_id" class="d-none" value="<?php echo $id; ?>">

                                        <?php }

                                        // $order_data2 = $order_rs->fetch_assoc()
                                        ?>

                                        <div class="col-12 mt-3">
                                            <div class="row">
                                                <span class="fs-6 fw-bold">Delivery Address</span><br>
                                                <span class="mt-2"><?php echo $order_data["delivery_address"]; ?>.</span>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="row">
                                                <span class="fs-6 fw-bold">Customer Details</span><br>
                                                <div class="col-12 mt-2">
                                                    <span class="">Name :</span>
                                                    <span class=""><?php echo ($customer_data["fname"] . " " . $customer_data["lname"]); ?></span>
                                                </div>
                                                <div class="col-12 mt-1">
                                                    <span class="">Email :</span>
                                                    <span class=""><?php echo ($customer_data["email"]); ?></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            <?php
                            }
                            ?>

                        </div>
                    </div>

                    <div class="col-12 col-lg-10 offset-lg-1 pt-3 border border-dark border-opacity-50 rounded mb-3">
                        <div class="row">
                            <div class="col-12 col-lg-8">
                                <p class="fw-bold ps-2">Update All Products' Status to</p>
                                <div class="row px-3">
                                    <div class="col-6 col-lg-6 px-3">
                                        <div class="row">
                                            <select class="form-infield3 border border-secondary text-black" id="o_status2">
                                                <option value="0">Select Status</option>
                                                <option value="2">Pending</option>
                                                <option value="3">Ready To Deliver</option>
                                                <option value="4">Delivered</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-6 px-3">
                                        <div class="row">
                                            <button class="btn-1 btn-2" style="background-color: rgb(255, 105, 105);" onclick="updateOrderStatus('no');">Update Status</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <span class="fw-bold my-2 ps-3">Notice</span>
                            <span class="mb-3 ps-3">Please be kind to update the order status when you done a one of stage of status. 
                                It will help to know to your customer about the order status and will be improved the customer statisfaction.
                            </span>

                            <div class="col-12 col-lg-4 offset-lg-2">

                            </div>
                        </div>
                    </div>

                <?php
                } else {
                ?>
                    <div class="col-12 d-flex justify-content-center align-items-center" style="height: 70vh;">
                        <div class="row text-center d-flex justify-content-center align-items-center pb-5">
                            <img src="images/not-found.gif" style="height: 250px; width: 300px;" class=" position-absolute opacity-50">
                            <span class="text-black-50 fw-bold pt-5 fs-6" style="z-index: 1;">Oops.. Something is missing!,</span>
                            <h3 class="fw-bold text-black-50" style="z-index: 1;">Please try again later</h3>
                        </div>
                    </div>
                <?php
                }
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
        </div>
    </div>

    <div class="modal" tabindex="-1" id="feedback">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title fs-5 fw-bold">Your Feedback</span> &nbsp;
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4">
                                <img src="resources/positive.png" style="height: 40px; width: 40px;"><br>
                                <input type="radio" class="mt-1 pointer" name="feedradios" id="f-po" checked>
                                <label for="f-po" class="pointer">Positive</label>
                            </div>
                            <div class="col-4">
                                <img src="resources/nutral.png" style="height: 40px; width: 40px;"><br>
                                <input type="radio" class="mt-1 pointer" name="feedradios" id="f-nu">
                                <label for="f-nu" class="pointer">Nutral</label>
                            </div>
                            <div class="col-4">
                                <img src="resources/negative.png" style="height: 40px; width: 40px;"><br>
                                <input type="radio" class="mt-1 pointer" name="feedradios" id="f-ne">
                                <label for="f-ne" class="pointer">Negative</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="row">
                            <span class="mb-2 fw-bold">Give your Rate..</span>
                            <?php
                            for ($y = 0; $y < 5; $y++) {
                            ?>
                                <div class="col-1 pointer" onclick="starShow(<?php echo $y; ?>);">
                                    <img src="icon-svg/star-fill.svg" style="height: 20px; width: 20px;" id="<?php echo ("star-f" . $y); ?>">
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-12 mt-3 px-3">
                        <div class="row">
                            <span class="mb-2 fw-bold ps-0">Your Comment..</span>
                            <textarea cols="15" rows="5" id="comm" class="border border-secondary border-opacity-50 rounded" style="outline: none;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-1" onclick="sendFeedback();">Send Feedback</button>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="bootstrap.js"></script>
    <script src="script.js"></script>
</body>

</html>