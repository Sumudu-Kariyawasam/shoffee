<?php
require "connection.php";

$id = $_GET["id"];

$product_rs = Database::search("SELECT * FROM `product` INNER JOIN `brand_has_model` ON 
brand_has_model.brand_has_model_id=product.brand_has_model_id INNER JOIN `brand` ON 
brand.brand_id=brand_has_model.brand_id INNER JOIN `model` ON 
model.model_id=brand_has_model.model_id INNER JOIN `category_has_sub_category` ON 
category_has_sub_category.2_category_id=product.categories_id INNER JOIN `category` ON 
category.category_id=category_has_sub_category.category_id INNER JOIN `sub_category` ON 
sub_category.sub_category_id=category_has_sub_category.sub_category_id INNER JOIN `color` ON 
color.color_id=product.color_id INNER JOIN `condition` ON 
condition.condition_id=product.condition_id WHERE `product_id`='" . $id . "'");
$product_num = $product_rs->num_rows;

if ($product_num == 1) {
    $product_data = $product_rs->fetch_assoc();
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Product | ShoFFee</title>
        <link rel="stylesheet" href="bootstrap.css">
        <link rel="stylesheet" href="style.css">
    </head>

    <body onload="seleted_sub(<?php echo ($product_data['sub_category_id']); ?>), seleted_brand(<?php echo ($product_data['brand_id']); ?>), seleted_model(<?php echo ($product_data['model_id']); ?>);">

        <div class="container-fluid">
            <div class="row">
                <?php
                require "header2.php";
                ?>

                <div class="col-12 p-4">
                    <div class="row">
                        <div class="col-12 border border-dark border-opacity-50 rounded p-3">
                            <div class="row">
                                <div class="col-12 py-3">
                                    <div class="row text-center">
                                        <h4 class="">Update Product</h4>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <span class="form-label fw-bold">Select Category</span>
                                            <select class="form-infield mt-2" id="a_ct" onchange="seleted_sub(<?php echo ($product_data['sub_category_id']); ?>);">
                                                <option value="">Select Category</option>
                                                <?php
                                                $cate_rs = Database::search("SELECT * FROM `category`");
                                                $cate_num = $cate_rs->num_rows;

                                                for ($x = 0; $x < $cate_num; $x++) {
                                                    $cate_data = $cate_rs->fetch_assoc();
                                                ?>
                                                    <option value="<?php echo ($cate_data["category_id"]) ?>" <?php if ($cate_data["category_id"] == $product_data["category_id"]) {
                                                                                                                    echo ("selected");
                                                                                                                }
                                                                                                                ?>> <?php echo ($cate_data["category"]); ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-12 col-lg-4">
                                            <span class="form-label fw-bold">Select Sub Category</span>
                                            <select class="form-infield mt-2" id="a_sct" onchange="seleted_brand(<?php echo ($product_data['brand_id']); ?>);">
                                                <option value="">Select Sub Category</option>

                                            </select>
                                        </div>
                                        <div class="d-none d-lg-block col-lg-4">
                                            <div class="row">
                                                <span class="form-label fw-bold">Popular Payment Methods</span>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <img src="resources/payment-icons/visa_img.png" style="height: 50px; width: 70px;">
                                                        <img src="resources/payment-icons/mastercard_img.png" class="mt-1" style="height: 45px; width: 70px;">
                                                        <img src="resources/payment-icons/paypal_img.png" style="height: 50px; width: 70px;">
                                                        <img src="resources/payment-icons/american_express_img.png" style="height: 50px; width: 70px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <span class="form-label fw-bold">Select Brand</span>
                                            <select class="form-infield mt-2" id="a_br" onchange="seleted_model(<?php echo ($product_data['model_id']); ?>);">

                                            </select>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <span class="form-label fw-bold">Select Model</span>
                                            <select class="form-infield mt-2" id="a_md">

                                            </select>
                                        </div>
                                        <div class="d-none d-lg-block col-lg-4">
                                            <div class="row">
                                                <img src="images/logo.png" class=" position-absolute me-3" style="height: 30px; width: 180px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="row">
                                        <div class="col-12 col-lg-10">
                                            <span class="form-label fw-bold">Add A Title</span>
                                            <input type="text" class="form-infield" id="u_tt" value="<?php echo ($product_data["title"]); ?>" placeholder="Enter your title here..">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 mb-3 mb-lg-1">
                                            <span class="form-label fw-bold">Select Condition</span>
                                            <div class="col-12 pt-2">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <input type="radio" id="a_cn1" name="con" value="1" <?php if($product_data["condition_id"] == 1){ echo "checked"; } ?>>
                                                        <span class="form-label">Brand New</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="radio" id="a_cn2" name="con" value="2" <?php if($product_data["condition_id"] == 2){ echo "checked"; } ?>>
                                                        <span class="form-label">Used</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4 mb-2 mb-lg-1">
                                            <div class="row">
                                                <div class="col-12">
                                                    <span class="form-label fw-bold">Select Colour</span>
                                                    <select name="" id="u_cl" class="form-infield">
                                                        <option value="">Select Colour</option>
                                                        <?php
                                                        $color_rs = Database::search("SELECT * FROM `color`");
                                                        $color_num = $color_rs->num_rows;

                                                        for ($x = 0; $x < $color_num; $x++) {
                                                            $color_data = $color_rs->fetch_assoc();
                                                        ?>
                                                            <option value="<?php echo ($color_data["color_id"]); ?>" <?php if ($color_data["color_id"] == $product_data["color_id"]) {
                                                                                                                            echo ("selected");
                                                                                                                        }
                                                                                                                        ?>><?php echo ($color_data["color"]); ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4">
                                            <div class="row">
                                                <div class="col-12">
                                                    <span class="form-label fw-bold">Enter Quantity</span>
                                                    <input type="number" class="form-infield" id="u_qt" value="<?php echo ($product_data["qty"]); ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <span class="form-label fw-bold">Price Of Item LKR.</span>
                                                    <input type="number" class="form-infield" id="u_pr" value="<?php echo ($product_data["price"] . ".00"); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <span class="form-label fw-bold">Delivery In Colombo LKR.</span>
                                                    <input type="number" class="form-infield" id="u_dc" value="<?php echo ($product_data["delivery_fee_inside"] . ".00"); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <span class="form-label fw-bold">Delivery Out of Colombo LKR.</span>
                                                    <input type="number" class="form-infield" id="u_do" value="<?php echo ($product_data["delivery_fee_outside"] . ".00"); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row px-2">
                                                <span class="form-label fw-bold px-0">Short Description</span>
                                                <textarea class="opacity-50" id="u_sd" cols="30" rows="5"><?php echo ($product_data["short_desc"]); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row px-2">
                                                <span class="form-label fw-bold px-0">Product Description</span>
                                                <textarea class="opacity-50" id="u_ds" cols="30" rows="15"><?php echo ($product_data["description"]); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <span class="form-label fw-bold">Add Product Images</span>
                                                <div class="col-12 col-lg-10 offset-lg-1">
                                                    <div class="row">

                                                        <?php
                                                        $img_rs0 = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $id . "'");
                                                        $img_num0 = $img_rs0->num_rows;
                                                        ?>

                                                        <div class="col-12 col-md-5 offset-md-1 pe-md-4">
                                                            <div class="row d-flex justify-content-between px-3 ps-md-2 ps-lg-0 px-md-0">
                                                                <?php
                                                                if ($img_num0 >= 3) {
                                                                    $img_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $id . "' LIMIT 3");
                                                                    for ($x = 0; $x < 3; $x++) {
                                                                        $img_data = $img_rs->fetch_assoc();
                                                                ?>
                                                                        <div class="col-4 col-lg-2 overflow-hidden d-flex justify-content-center border border-secondary" style="width: 100px;  height: 100px;">
                                                                            <img src="<?php echo $img_data["product_image_path"]; ?>" style="height: 100px;" id="<?php echo ("view" . $x); ?>">
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    $img_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $id . "' LIMIT 3");
                                                                    $img_num = $img_rs->num_rows;
                                                                    for ($x = 0; $x < 3; $x++) {
                                                                        $img_data = $img_rs->fetch_assoc();
                                                                    ?>
                                                                        <div class="col-4 col-lg-2 overflow-hidden d-flex justify-content-center border border-secondary" style="width: 100px;  height: 100px;">
                                                                            <img src="<?php
                                                                                        if (isset($img_data["product_image_path"])) {
                                                                                            echo $img_data["product_image_path"];
                                                                                        } else {
                                                                                            echo "icon-svg/empty.jpg";
                                                                                        }
                                                                                        ?>" style="height: 100px;" id="<?php echo ("view" . $x); ?>">
                                                                        </div>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-5 pe-md-4 mt-3 mt-md-0">
                                                            <div class="row d-flex justify-content-between px-3 px-md-0">
                                                                <?php
                                                                $img_rs1 = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $id . "' LIMIT 3 OFFSET 3");
                                                                for ($y = 0; $y < 3; $y++) {
                                                                    $img_data1 = $img_rs1->fetch_assoc();
                                                                ?>
                                                                    <div class="col-4 col-lg-2 overflow-hidden d-flex justify-content-center border border-secondary" style="width: 100px;  height: 100px;">
                                                                        <img src="<?php
                                                                                    if (isset($img_data1["product_image_path"])) {
                                                                                        echo $img_data1["product_image_path"];
                                                                                    } else {
                                                                                        echo "icon-svg/empty.jpg";
                                                                                    }
                                                                                    ?>" style="height: 100px;" id="<?php echo ("view" . (3 + $y)); ?>">
                                                                    </div>
                                                                <?php
                                                                }

                                                                ?>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-10 offset-1 col-lg-6 offset-lg-3">
                                                    <input type="file" class="d-none" id="ii" onclick="loadPimages();" multiple>
                                                    <label for="ii" class="btn-1 d-flex align-items-center justify-content-center pointer">Select Images</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-1">
                                    <div class="row">
                                        <div class="col-10 offset-1 col-lg-6 offset-lg-3">
                                            <button class="btn-1" onclick="updateProduct(<?php echo $id; ?>);">Add Product</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            <?php
        } else {
            ?>
                <div class="col-12 d-flex justify-content-center align-items-center" style="height: 90vh;">
                    <div class="row text-center d-flex justify-content-center align-items-center">
                        <img src="resources/missing.jpg" style="height: 400px; width: 600px;" class="opacity-75">
                        <span class="text-black-50 fw-bold" style="z-index: 1; margin-top: -50px;">We're Sorry To Say. But,</span>
                        <h3 class="fw-bold text-black-75" style="z-index: 1; margin-top: -18px;">Something Is Missing!</h3>
                    </div>
                </div>
            <?php
        }
        include "footer.php";
            ?>
            </div>
        </div>

        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>

    </html>