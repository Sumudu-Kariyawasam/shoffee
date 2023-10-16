<?php

require "connection.php";

$title = $_POST["tt"];
$price_f = $_POST["pf"];
$price_t = $_POST["pt"];
$category = $_POST["ct"];
$sub_cate = $_POST["sc"];
$brand = $_POST["br"];
$model = $_POST["md"];
$condition = $_POST["cn"];

$quary = "SELECT * FROM `product`";
$status = 0;

if (!empty($title)) {
    $quary .= " WHERE `title` LIKE '%" . $title . "%'";
    $status = 1;
}

if ($sub_cate != 0) {
    $sub_category_rs = Database::search("SELECT * FROM `category_has_sub_category` WHERE `sub_category_id`='" . $sub_cate . "'");
    $sub_category_data = $sub_category_rs->fetch_assoc();

    if ($status == 1) {
        $quary .= " AND `categories_id`='" . $sub_category_data["2_category_id"] . "'";
    } else {
        $quary .= " WHERE `categories_id`='" . $sub_category_data["2_category_id"] . "'";
    }

    if ($brand != 0 && $model != 0) {
        $brand_rs = Database::search("SELECT * FROM `brand_has_model` WHERE `brand_id`='" . $brand . "' AND `model_id`='" . $model . "'");
        $brand_data = $brand_rs->fetch_assoc();

        $quary .= " AND `brand_has_model_id`='" . $brand_data['brand_has_model_id'] . "'";
    } else if ($brand != 0 && $model == 0) {
        $brand_rs = Database::search("SELECT * FROM `brand_has_model` WHERE `brand_id`='" . $brand . "'");
        $brand_num = $brand_rs->num_rows;

        for ($x = 0; $x < $brand_num; $x++) {
            $brand_data = $brand_rs->fetch_assoc();
            $list_brand = $brand_data["brand_has_model_id"];

            if ($x == 0) {
                $quary .= " AND (`brand_has_model_id`='" . $list_brand . "'";
            } else {
                if ($x == ($brand_num - 1)) {
                    $quary .= " OR `brand_has_model_id`='" . $list_brand . "')";
                } else {
                    $quary .= " OR `brand_has_model_id`='" . $list_brand . "'";
                }
            }
        }
    } else if ($brand == 0 && $model != 0) {
        $model_rs = Database::search("SELECT * FROM `brand_has_model` WHERE `model_id`='" . $model . "'");
        $model_num = $model_rs->num_rows;

        for ($y = 0; $y < $model_num; $y++) {
            $model_data = $model_rs->fetch_assoc();
            $list_model = $model_data["brand_has_model_id"];

            if ($y == 0) {
                $quary .= " AND `brand_has_model_id`='" . $list_model . "'";
            } else {
                if ($y == ($model_num - 1)) {
                    $quary .= " OR `brand_has_model_id`='" . $list_model . "')";
                } else {
                    $quary .= " OR `brand_has_model_id`='" . $list_model . "'";
                }
            }
        }
    }

    if ($condition != 0) {
        $quary .= " AND `condition_id`='" . $condition . "'";
    }

    if (!empty($price_f) && !empty($price_t)) {
        $quary .= " AND `price` BETWEEN '" . $price_f . "' AND '" . $price_t . "'";
    } else if (!empty($price_f) && empty($price_t)) {
        $quary .= " AND `price` >= '" . $price_f . "'";
    } else if (empty($price_f) && !empty($price_t)) {
        $quary .= " AND `price` <= '" . $price_t . "'";
    }

    //    viewing area   //

    $result1 = Database::search($quary);
    $num = $result1->num_rows;

    $results_per_page = 1;
    $pages = ceil($num / $results_per_page);

    $page = 1;
    if (isset($_POST["page"])) {
        if ($pages > $_POST["page"]) {
            $page = $_POST["page"];
        } else {
            $page = $pages;
        }
    }
    $skip = ($page - 1) * $results_per_page;

    $quary .= "LIMIT " . $results_per_page . " OFFSET " . $skip . "";

    $result = Database::search($quary);
    $loop = $result->num_rows;

?>

    <div class="col-12 glass-box2 mb-0 p-3">
        <div class="col-12">
            <div class="row gap-2 d-flex justify-content-center">

                <?php

                for ($y = 0; $y < $loop; $y++) {
                    $pdata = $result->fetch_assoc();

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
                        <input type="number" class="d-none" value="1" id="p-qty">
                        <div class="card-body">
                            <h5 class="card-title fs-6"><?php echo ($pdata["title"]); ?></h5>
                            <span class="card-text text-secondary fw-bold">LKR. <?php echo ($pdata["price"]) ?> .00</span><br>
                            <span class="card-text text-success fw-bold"><?php echo ($pdata["qty"]) ?> items Available</span>
                            <div class="col-12 btn-group mt-lg-2" role="group">
                                <button class="col-6 btn d-flex justify-content-start" onclick="addtowish(<?php echo $pdata['product_id']; ?>);">
                                    <img src="resources/h1.png" style="height: 25px;" id="wish-h">
                                </button>
                                <button onclick="addtoCart(<?php echo $pdata['product_id']; ?>);" class="col-6 btn d-flex justify-content-end">
                                    <img src="resources/c1.png" class="d-block" style="height: 25px;">
                                </button>
                            </div>
                            <button class="col-12 btn" style="background-color: rgb(0, 255, 255);" onclick="singleProduct(<?php echo ($pdata['product_id']); ?>);">Buy Now</button>
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>
    </div>

    <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
        <nav>
            <ul class="pagination pagination-md justify-content-center pointer">
                <li class="page-item">
                    <a class="page-link" onclick="advancedSearch(<?php if ($page <= 1) {
                                                                        echo '#';
                                                                    } else {
                                                                        echo ($page - 1);
                                                                    } ?>);" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <?php
                if ($pages < 3) {
                    $loop = $pages + 1;
                } else {
                    $loop = 4;
                }
                for ($y = 1; $y < $loop; $y++) {
                    if ($pages < 3) {
                        $x = $y;
                    } else {
                        $x = ($page - 1) + $y;
                    }
                    if ($x == $page) {
                ?>
                        <li class="page-item active">
                            <a class="page-link" onclick="advancedSearch(<?php echo $x; ?>);"><?php echo $x; ?></a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item">
                            <a class="page-link" onclick="advancedSearch(<?php echo $x; ?>);"><?php echo $x; ?></a>
                        </li>
                <?php
                    }
                }
                ?>

                <li class="page-item">
                    <a class="page-link" onclick="advancedSearch(<?php if ($page >= $pages) {
                                                                        echo '#';
                                                                    } else {
                                                                        echo ($page + 1);
                                                                    } ?>);" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

<?php

} else {
    echo "";
?>
    <div class="col-12 d-flex justify-content-center align-items-center" style="height: 50vh;">
        <div class="row text-center d-flex justify-content-center align-items-center pb-5">
            <span class="text-black-50 fs-5 fw-bold" style="z-index: 1;">You Must Select Sub Category</span>
        </div>
    </div>
<?php
}

?>