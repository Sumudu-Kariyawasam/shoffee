<?php

$id = $_GET["id"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product | ShoFFee</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php
            include "header.php";

            $product_rs = Database::search("SELECT * FROM `product` INNER JOIN `brand_has_model` ON 
            product.brand_has_model_id=brand_has_model.brand_has_model_id INNER JOIN `brand` ON 
            brand_has_model.brand_id=brand.brand_id INNER JOIN `model` ON 
            model.model_id=brand_has_model.model_id INNER JOIN `color` ON 
            color.color_id=product.color_id INNER JOIN `condition` ON 
            condition.condition_id=product.condition_id INNER JOIN `category_has_sub_category` ON 
            category_has_sub_category.2_category_id=product.categories_id INNER JOIN `category` ON 
            category.category_id=category_has_sub_category.category_id INNER JOIN `sub_category` ON 
            sub_category.sub_category_id=category_has_sub_category.sub_category_id WHERE `product_id`='" . $id . "'");
            $product_data = $product_rs->fetch_assoc();

            $product_img = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $id . "'");
            $img_num = $product_img->num_rows;
            ?>

            <div class="col-12 px-4 py-5">
                <div class="row">
                    <div class="col-12 offset-lg-1 col-lg-10 border border-dark border-opacity-50 rounded">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-lg-6" style="height: 350px;">
                                        <?php
                                        $main_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $id . "'");
                                        $main_data = $main_rs->fetch_assoc();
                                        ?>
                                        <div class="col-12 d-flex justify-content-center align-items-center overflow-hidden" style="height: 80%;" onclick="ViewMainImg();">
                                            <img src="<?php echo $main_data["product_image_path"]; ?>" style="height: 100%;" id="main_img">
                                        </div>
                                        <div class="col-12" style="height: 50px;">
                                            <div class="row">
                                                <?php
                                                if ($img_num > 0) {
                                                    for ($x = 0; $x < 6; $x++) {
                                                        $img_data = $product_img->fetch_assoc();
                                                ?>
                                                        <div class="col-2 overflow-hidden d-flex justify-content-center pointer" onclick="mainImg(<?php echo $x; ?>);">
                                                            <img src="<?php if (isset($img_data["product_image_path"])) {
                                                                            echo $img_data["product_image_path"];
                                                                        } else {
                                                                            echo "icon-svg/empty.jpg";
                                                                        } ?>" style="height: 50px;" id="<?php echo ("img_view" . $x); ?>">
                                                        </div>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <div class="col-2 overflow-hidden d-flex justify-content-center">
                                                        <img src="icon-svg/empty.jpg" style="height: 50px;">
                                                    </div>
                                                    <div class="col-2 overflow-hidden d-flex justify-content-center">
                                                        <img src="icon-svg/empty.jpg" style="height: 50px;">
                                                    </div>
                                                    <div class="col-2 overflow-hidden d-flex justify-content-center">
                                                        <img src="icon-svg/empty.jpg" style="height: 50px;">
                                                    </div>
                                                    <div class="col-2 overflow-hidden d-flex justify-content-center">
                                                        <img src="icon-svg/empty.jpg" style="height: 50px;">
                                                    </div>
                                                    <div class="col-2 overflow-hidden d-flex justify-content-center">
                                                        <img src="icon-svg/empty.jpg" style="height: 50px;">
                                                    </div>
                                                    <div class="col-2 overflow-hidden d-flex justify-content-center">
                                                        <img src="icon-svg/empty.jpg" style="height: 50px;">
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $feedback_rs = Database::search("SELECT * FROM `feedback` WHERE `product_id`='" . $id . "'");
                                    $feedback_num = $feedback_rs->num_rows;

                                    $feedback_rate_rs = Database::search("SELECT AVG(stars) AS `stars` FROM `feedback` WHERE `product_id`='" . $id . "'");
                                    $feedback_rate = $feedback_rate_rs->fetch_assoc();

                                    $stars = $feedback_rate["stars"];
                                    ?>

                                    <div class="col-12 col-lg-6 pt-4 ps-4" style="height: 300px;">
                                        <div class="row">
                                            <h4 class="fw-bold mb-1"><?php echo $product_data["title"]; ?></h4>
                                            <?php
                                            for ($y = 0; $y < 5; $y++) {
                                            ?>

                                                <?php
                                                if ($stars <= ($y + 0.5)) {
                                                    if ($stars <= ($y)) {
                                                ?>
                                                        <div class="col-1">
                                                            <img src="icon-svg/star.svg">
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="col-1">
                                                            <img src="icon-svg/star-half.svg">
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="col-1">
                                                        <img src="icon-svg/star-fill.svg">
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                            <?php
                                            }
                                            ?>
                                            <span class="card-text text-secondary fw-bold fs-6 mt-2">LKR. <?php echo $product_data["price"]; ?>.00</span><br>
                                            <span class="card-text text-danger text-decoration-line-through fw-bold mb-1">LKR. <?php echo ($product_data["price"] + 1000); ?>.00</span><br>
                                            <span class="card-text text-success fw-bold"><?php echo $product_data["qty"]; ?> items Available</span>

                                            <div class="col-10 col-md-6 mt-4">
                                                <span>I need to Buy</span>
                                                <input type="number" class="form-infield" value="1" id="p-qty">
                                            </div>

                                            <div class="col-12 col-lg-11">
                                                <button class="btn-1" onclick="addtoCart(<?php echo $id; ?>);">Add To Cart</button>
                                                <button class="btn-1 m-0" onclick="directCheckout(<?php echo $id; ?>);">Buy Now</button>
                                            </div>
                                            <div class="col-1 offset-lg-4 offset-md-5 offset-9 position-absolute">
                                                <img src="resources/h1.png" style="height: 30px;" class="pointer" onclick="addtowish(<?php echo $id; ?>);">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 px-3">
                                <div class="col-6 offset-3 text-center my-2">
                                    <!-- <h5>Short Description</h5> -->
                                </div>
                                <div class="col-12  border-dark border-opacity-25 rounded mb-3 ps-3">
                                    <p><?php echo $product_data["title"]; ?></p>
                                </div>
                                <div class="col-12 border-bottom border-dark border-opacity-25 mt-3"></div>
                            </div>

                            <div class="col-12 px-4 pt-2">
                                <div class="row">
                                    <div class="col-6 offset-3 text-center mb-2">
                                        <h5>Product Detais</h5>
                                    </div>
                                    <div class="col-6 col-lg-4 text-white-75">
                                        <div class="row">
                                            <span class="fw-bold mb-2">Brand</span>
                                            <span class="fw-bold mb-2">Model</span>
                                            <span class="fw-bold mb-2">Color</span>
                                            <span class="fw-bold mb-2">Condition</span>
                                            <span class="fw-bold mb-2">Delivery In Colombo</span>
                                            <span class="fw-bold mb-2">Delivery Out Of Colombo</span>
                                            <span class="fw-bold mb-2">Category</span>
                                            <span class="fw-bold mb-2">Sub Category</span>
                                        </div>
                                    </div>
                                    <div class="col-4 text-white-75">
                                        <div class="row">
                                            <span class="fw-bold mb-2">: <?php echo $product_data["brand"]; ?></span>
                                            <span class="fw-bold mb-2">: <?php echo $product_data["model"]; ?></span>
                                            <span class="fw-bold mb-2">: <?php echo $product_data["color"]; ?></span>
                                            <span class="fw-bold mb-2">: <?php echo $product_data["condition"]; ?></span>
                                            <span class="fw-bold mb-2">: LKR <?php echo $product_data["delivery_fee_inside"]; ?>.00</span>
                                            <span class="fw-bold mb-2">: LKR <?php echo $product_data["delivery_fee_outside"]; ?>.00</span>
                                            <span class="fw-bold mb-2">: <?php echo $product_data["category"]; ?></span>
                                            <span class="fw-bold mb-2">: <?php echo $product_data["sub_category_name"]; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-6 offset-3 text-center my-2">
                                        <h5>Product Description</h5>
                                    </div>
                                    <div class="col-12 border border-dark border-opacity-25 rounded mb-3 pt-2">
                                        <textarea class=" border-0" style="height: 100%; width: 100%; outline: none;" cols="30" rows="10"><?php echo $product_data["description"]; ?></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="main-img-box d-none" id="mainimg-box">
                <div class="main-img-view d-flex justify-content-center align-items-center">
                    <img src="" id="main_img_view" style="width: 100%;">
                </div>
                <img src="icon-svg/x.svg" id="main_img_close" class="main-img-close pointer" onclick="closeMainImg();">
            </div>

            <div class="col-1 offset-7 offset-md-10 fixed-bottom pointer">
                <img src="icon-svg/contact_seller.png" onclick="contactSeller();" style="height: 45px; width: 125px; margin-top: -60px;">
            </div>

            <div class="modal" tabindex="-1" id="new-msg_product">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-dark bg-opacity-10">
                            <span class="modal-title fs-5 fw-bold">New Messgae</span> &nbsp;
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php
                            if(isset($_SESSION["user"])){
                                $email = $_SESSION["user"]["email"];
                            ?>
                            <div class="col-12">
                                <div class="">
                                    <span class="fw-bold">From :</span>
                                    <span><?php echo $email; ?></span><br><br>
                                    <span class="fw-bold">To :</span>
                                    <span id="direct_email"><?php echo $product_data["user_email"]; ?></span><br><br>
                                    <span class="fw-bold">About The Product :</span>
                                    <span><?php echo $product_data["title"]; ?></span><br><br>
                                    <span style="color:gray; font-size: 12px;">This is direct message to the seller of this product. 
                                        You can ask anything about this product directly.</span>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="bg-dark bg-opacity-10 p-3">
                            <div class="input-group">
                                <input type="text" class="form-control" style="font-size: 14px;" placeholder="Type your text" id="dir_msg_txt">
                                <button class="btn-send rounded-end bg-pri" type="button" onclick="send_new_msg('direct');"><img src="icon-svg/cursor-fill.svg"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            include "footer2.php";
            ?>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>