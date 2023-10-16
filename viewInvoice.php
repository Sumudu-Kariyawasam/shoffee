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

                    $order_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $id . "'");
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

                                        ?>

                                            <div class="col-12 mt-2 wish-card">
                                                <div class="row mb-3">
                                                    <div class="col-6 col-lg-3" style="height: 6rem;">
                                                    <?php
                                                    $single_item_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='".$id."' AND `product_id`='".$order_data["product_id"]."'");
                                                    $single_item_data = $single_item_rs->fetch_assoc();

                                                    if($single_item_data["invoice_status"] == 2){
                                                    ?>
                                                        <span class="badge rounded-pill text-bg-warning text-white position-absolute">Pending</span>
                                                    <?php
                                                    }else if($single_item_data["invoice_status"] == 3){
                                                    ?>
                                                        <span class="badge rounded-pill text-bg-info text-white position-absolute">Confirmed</span>
                                                    <?php
                                                    }else if($single_item_data["invoice_status"] == 4){
                                                    ?>
                                                        <span class="badge rounded-pill text-bg-success position-absolute">Delivered</span>
                                                    <?php
                                                        }
                                                    ?>
                                                        <div class="col-12 d-flex justify-content-center overflow-hidden" style="height: 100%;">
                                                            <img src="<?php echo $img_data["product_image_path"]; ?>" style="height: 100%;">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <h5 class="card-title mb-2"><?php echo $product_data["title"]; ?></h5>
                                                            <span class="card-text text-secondary fw-bold mb-1">LKR. <?php echo $product_data["price"]; ?> .00</span><br>
                                                            <span class="card-text text-success fw-bold mb-1"><?php echo $order_data["invoice_qty"]; ?> Items Purchased</span><br>
                                                            <span class="card-text text-dark">Purchased On <?php echo $order_data["date_time"]; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-3">
                                                        <div class="row mt-2">
                                                            <div class="col-12">
                                                                <div class="row">
                                                                    <button class="btn-1 fw-bold" onclick="singleProduct(<?php echo ($product_data['product_id']); ?>);">View Product</button>
                                                                    <button class="btn-1 fw-bold" onclick="Feedback(<?php echo ($product_data['product_id']); ?>);" style="background-color: #7be29c;">Send Feedback</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="text" id="invo_id" class="d-none" value="<?php echo $id; ?>">

                                        <?php } ?>

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
                                <p class="fw-bold"><?php echo $order_num; ?> Items in invoice</p>
                                <p class="fw-bold">Total Amount : LKR. <?php echo $order_data["total"]; ?>.00</p>
                            </div>

                            <div class="col-12 col-lg-4 offset-lg-2">
                                <button class="btn-1 fw-light col-12 mt-2 fw-bold" onclick="deleteInvoice();" style="background-color: rgb(255, 105, 105);">Delete This Record</button>
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
                            for($y = 0; $y < 5; $y++){
                            ?>
                            <div class="col-1 pointer" onclick="starShow(<?php echo $y; ?>);">
                                <img src="icon-svg/star-fill.svg" style="height: 20px; width: 20px;" id="<?php echo("star-f".$y); ?>">
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