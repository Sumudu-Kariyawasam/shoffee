<?php
require "connection.php";

$catid = $_GET["id"];


if ($catid == "0") {

    $cat_rs = Database::search("SELECT * FROM `sub_category`");
    $cat_num = $cat_rs->num_rows;

    for ($z = 0; $z < $cat_num; $z++) {
        $cat_data = $cat_rs->fetch_assoc();
        $selected_cate_rs = Database::search("SELECT * FROM `category_has_sub_category` WHERE `sub_category_id`='" . $cat_data["sub_category_id"] . "'");
        $selected_cate_data = $selected_cate_rs->fetch_assoc();

        $product_rs = Database::search("SELECT * FROM `product` WHERE `status`='1' AND `categories_id`='" . $selected_cate_data["2_category_id"] . "' ORDER BY `datetime_added` LIMIT 20 OFFSET 0");
        $pnum = $product_rs->num_rows;

        if ($pnum > 0) {
?>

            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <a class="text-black fs-5 text-decoration-none" href="<?php echo ('productList.php?id='.$cat_data['sub_category_id']); ?>"><?php echo $cat_data["sub_category_name"] ?></a>
                    </div>
                </div>
                <div class="col-12 mb-4 p-3">
                    <div class="col-12">
                        <div class="row gap-2 d-flex justify-content-center">

                            <?php

                            for ($y = 0; $y < $pnum; $y++) {
                                $pdata = $product_rs->fetch_assoc();

                                $image_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $pdata["product_id"] . "'");
                                $img_data = $image_rs->fetch_assoc();

                            ?>
                                <div class="card p-0 overflow-hidden" style="width: 12rem; height: 25rem;">
                                    <span class="badge color_primary position-absolute mt-2 ms-2">New</span>
                                    <div class="overflow-hidden cardimage">
                                        <div class="d-flex justify-content-center pointer" style="height: 100%; width: 100%;" onclick="singleProduct(<?php echo ($pdata['product_id']); ?>);">
                                            <img src="<?php echo ($img_data["product_image_path"]); ?>" class="card-img-top" style="height: 100%; width: auto;">
                                        </div>
                                    </div>
                                    <input type="number" class="d-none" value="1" id="p-qty">
                                    <div class="card-body">
                                        <h5 class="card-title fs-6"><?php echo ($pdata["title"]); ?></h5>
                                        <span class="card-text text-secondary fw-bold">LKR. <?php echo ($pdata["price"]) ?> .00</span><br>
                                        <span class="card-text text-success fw-bold"><?php echo ($pdata["qty"]) ?> items Available</span>
                                        <div class="col-12 btn-group mt-lg-2" role="group">
                                            <button class="col-6 btn d-flex justify-content-start" onclick="addtowish(<?php echo ($pdata['product_id']); ?>);">
                                                <img src="resources/h1.png" style="height: 25px;" id="wish-h">
                                            </button>
                                            <button onclick="addtoCart(<?php echo ($pdata['product_id']); ?>);" class="col-6 btn d-flex justify-content-end">
                                                <img src="resources/c1.png" class="d-block" style="height: 25px;">
                                            </button>
                                        </div>
                                        <button class="col-12 btn" style="background-color: rgb(0, 255, 255);" onclick="singleProduct(<?php echo ($pdata['product_id']); ?>);">Buy Now</button>
                                    </div>
                                </div>
                            <?php
                            }

                            ?>

                            <div class="col-12">

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
} else {
    $selected_cate_rs = Database::search("SELECT * FROM `category_has_sub_category` WHERE `category_id`='" . $catid . "'");
    $selected_cate_num = $selected_cate_rs->num_rows;

    if ($selected_cate_num > 0) {
        $selected_cate_data = $selected_cate_rs->fetch_assoc();
        $selected_sub_cate_rs = Database::search("SELECT * FROM `category_has_sub_category` INNER JOIN `sub_category` ON 
        sub_category.sub_category_id=category_has_sub_category.sub_category_id WHERE `category_id`='" . $selected_cate_data["category_id"] . "'");
        $selected_sub_cate_num = $selected_sub_cate_rs->num_rows;

        for ($z = 0; $z < $selected_sub_cate_num; $z++) {
            $selected_sub_cate_data = $selected_sub_cate_rs->fetch_assoc();

            $product_rs = Database::search("SELECT * FROM `product` WHERE `categories_id`='" . $selected_sub_cate_data["2_category_id"] . "' AND
            `status`='1' ORDER BY `datetime_added` LIMIT 20 OFFSET 0");
            $pnum = $product_rs->num_rows;

            if ($pnum > 0) {
            ?>

                <div class="row">
                    <div class="col-12">
                        <div class="row">
                        <a class="text-black fs-5 text-decoration-none" href="<?php echo ('productList.php?id='.$selected_sub_cate_data['sub_category_id']); ?>"><?php echo $selected_sub_cate_data["sub_category_name"] ?></a>
                        </div>
                    </div>
                    <div class="col-12 mb-4 p-3">
                        <div class="col-12">
                            <div class="row gap-2 d-flex justify-content-center">

                                <?php

                                for ($y = 0; $y < $pnum; $y++) {
                                    $pdata = $product_rs->fetch_assoc();

                                    $image_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $pdata["product_id"] . "'");
                                    $img_data = $image_rs->fetch_assoc();

                                ?>
                                    <div class="card p-0 overflow-hidden" style="width: 12rem; height: 25rem;">
                                        <span class="badge color_primary position-absolute mt-2 ms-2">New</span>
                                        <div class="overflow-hidden cardimage">
                                            <div class="d-flex justify-content-center" style="height: 100%; width: 100%;">
                                                <img src="<?php echo ($img_data["product_image_path"]); ?>" class="card-img-top" style="height: 100%; width: auto;">
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title fs-6"><?php echo ($pdata["title"]); ?></h5>
                                            <span class="card-text text-secondary fw-bold">LKR. <?php echo ($pdata["price"]) ?> .00</span><br>
                                            <span class="card-text text-success fw-bold"><?php echo ($pdata["qty"]) ?> items Available</span>
                                            <div class="col-12 btn-group mt-lg-2" role="group">
                                                <button class="col-6 btn d-flex justify-content-start" onclick="addtowish();">
                                                    <img src="resources/h1.png" style="height: 25px;" id="wish-h">
                                                </button>
                                                <button onclick="addtoCart();" class="col-6 btn d-flex justify-content-end">
                                                    <img src="resources/c1.png" class="d-block" style="height: 25px;">
                                                </button>
                                            </div>
                                            <button class="col-12 btn" style="background-color: rgb(0, 255, 255);" onclick="window.location = 'singleProduct.php'">Buy Now</button>
                                        </div>
                                    </div>
                                <?php
                                }
                            } else {
                                ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <h5 class="pointer" onclick="window.location = '<?php echo ('productList.php?id='.$selected_sub_cate_data['sub_category_id']); ?>'"><?php echo $selected_sub_cate_data["sub_category_name"] ?></h5>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center align-items-center" style="height: 50vh;">
                                        <div class="row text-center d-flex justify-content-center align-items-center pb-5">
                                            <img src="images/not-found.gif" style="height: 250px; width: 300px;" class=" position-absolute opacity-50">
                                            <span class="text-black-50 fw-bold pt-5" style="z-index: 1;">We're Sorry To Say. But,</span>
                                            <h3 class="fw-bold text-black-50" style="z-index: 1;">No Result Found!</h3>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                            <div class="col-12">

                            </div>

                            </div>
                        </div>
                    </div>
                </div>

            <?php
        }
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
}
    ?>