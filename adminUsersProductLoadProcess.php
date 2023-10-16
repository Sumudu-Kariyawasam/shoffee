<?php
require "connection.php";

$sub_cate = $_POST["sc"];
$brand = $_POST["br"];
$model = $_POST["md"];
$condition = $_POST["cn"];
$price_f = $_POST["pf"];
$proce_t = $_POST["pt"];
$text = $_POST["tt"];
$type = $_POST["type"];
$time = $_POST["tm"];

$umail = $_POST["um"];

$quary = "SELECT * FROM `product` INNER JOIN `category_has_sub_category` ON product.categories_id=category_has_sub_category.2_category_id 
INNER JOIN `category` ON category_has_sub_category.category_id=category.category_id 
INNER JOIN `sub_category` ON category_has_sub_category.sub_category_id=sub_category.sub_category_id 
INNER JOIN `brand_has_model` ON brand_has_model.brand_has_model_id=product.brand_has_model_id 
INNER JOIN `brand` ON brand_has_model.brand_id=brand.brand_id 
INNER JOIN `model` ON brand_has_model.model_id=model.model_id 
INNER JOIN `color` ON product.color_id=color.color_id 
INNER JOIN `condition` ON product.condition_id=condition.condition_id 
INNER JOIN `status` ON product.status=status.status_id WHERE `user_email`='".$umail."'";

if($type == "all"){
    $quary.=" AND product.status <= 3";
}else if($type == "act"){
    $quary.=" AND product.status = 1";
}else if($type == "dct"){
    $quary.=" AND product.status = 2";
}else if($type == "dlt"){
    $quary.=" AND product.status = 3";
}

if ($sub_cate != 0) {
    $quary .= " AND category_has_sub_category.sub_category_id='" . $sub_cate . "'";
}
if ($brand != 0) {
    $quary .= " AND brand.brand_id='" . $brand . "'";
}
if ($model != 0) {
    $quary .= " AND model.model_id='" . $model . "'";
}
if ($condition != 0) {
    $quary .= " AND condition.condition_id='" . $condition . "'";
}
if (isset($price_f) && isset($price_t)) {
    $quary .= " AND `price` BETWEEN '" . $price_f . "' AND '" . $price_t . "'";
} else if (isset($price_f) && !isset($price_t)) {
    $quary .= " AND `price` > '" . $price_f . "'";
} else if (!isset($price_f) && isset($price_t)) {
    $quary .= " AND `price` < '" . $price_t . "'";
}
if (isset($text)) {
    $quary .= " AND `title` LIKE '%" . $text . "%'";
}

$result1 = Database::search($quary);
$num = $result1->num_rows;

$results_per_page = 50;
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

if($num > 0) {
    if($time != 2) {
        $quary .= " ORDER BY `datetime_added` DESC";
    }else{
        $quary .= " ORDER BY `datetime_added` ASC";
    }
    $quary .= " LIMIT " . $results_per_page . " OFFSET " . $skip . "";
}

$prod_rs = Database::search($quary);
$prod_num = $prod_rs->num_rows;

if($prod_num > 0){

?>

<div class="row pe-2">

    <!--  product view  -->

    <?php
    for ($i = 0; $i < $prod_num; $i++) {
        $prod_data = $prod_rs->fetch_assoc();

        $prod_img_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $prod_data["product_id"] . "'");
        $prod_img_data = $prod_img_rs->fetch_assoc();

    ?>

        <div class="col-12 border border-light border-opacity-50 rounded mb-2 admin_bg">
            <div class="row">
                <div class="col-12 col-lg-5 py-3">
                    <span class=""><?php echo $prod_data["title"]; ?></span><br>
                    <span class="t-pri">Rs. <?php echo $prod_data["price"]; ?>.00</span>
                </div>
                <div class="col-6 col-lg-2 py-lg-3">
                    <span class="">Listed Date</span><br>
                    <span class=""><?php echo $prod_data["datetime_added"]; ?></span>
                </div>
                <div class="col-6 col-lg-2 py-lg-3">
                    <span class="">Status</span><br>
                    <span class="<?php if ($prod_data["status"] == 1) {
                                        echo "t-suc";
                                    } else if ($prod_data["status"] == 2) {
                                        echo "text-warning";
                                    } else if ($prod_data["status"] == 3) {
                                        echo "t-dng";
                                    } ?>" id="<?php echo ('status_a' . $prod_data["product_id"]); ?>"><?php echo $prod_data["status_name"]; ?></span>
                </div>
                <div class="col-12 col-lg-3 py-lg-3">
                    <button class="btn-1 m-0 mt-2 tm-lg-1 mb-3 mb-lg-0 text-white" data-bs-toggle="collapse" type="button" data-bs-target="<?php echo ("#apro_collapse" . $i); ?>" aria-expanded="false" aria-controls="<?php echo ("apro_collapse" . $i); ?>">Manage Product</button>
                </div>
            </div>
            <div class="row collapse" id="<?php echo ("apro_collapse" . $i); ?>">
                <div class="col-12 py-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <span class="fw-bold mb-2">Deatils</span>
                                <div class="col-6 col-lg-2">
                                    <span class="">Category</span><br>
                                    <span class="">Sub category</span><br>
                                    <span class="">Brand</span><br>
                                    <span class="">Model</span><br>
                                    <span class="">Colour</span><br>
                                    <span class="">Condition</span><br>
                                    <span class="">Quantity</span><br>
                                </div>
                                <div class="col-6 col-lg-4">
                                    <span class=""><?php echo $prod_data["category"]; ?></span><br>
                                    <span class=""><?php echo $prod_data["sub_category_name"]; ?></span><br>
                                    <span class=""><?php echo $prod_data["brand"]; ?></span><br>
                                    <span class=""><?php echo $prod_data["model"]; ?></span><br>
                                    <span class=""><?php echo $prod_data["color"]; ?></span><br>
                                    <span class=""><?php echo $prod_data["condition"]; ?></span><br>
                                    <span class=""><?php echo $prod_data["qty"]; ?> Items Available</span><br>
                                </div>
                                <div class="col-12 col-lg-4 offset-2 mt-3 mt-lg-0">
                                    <div class="overflow-hidden" style="height: 140px; width: 200px;">
                                        <img src="<?php echo $prod_img_data["product_image_path"]; ?>" style="height: 140px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-check form-switch ms-4 pt-3 <?php if ($prod_data["status"] == 3) {
                                                                            echo "d-none";
                                                                        } ?>">
                            <input class="form-check-input" type="checkbox" role="switch" id="aod<?php echo $i; ?>" onclick="changeStatusAdm(<?php echo $prod_data['product_id']; ?>);" <?php if ($prod_data["status"] == 1) {
                                                                                                                                                                                            echo "checked";
                                                                                                                                                                                        } ?> /> &nbsp;

                            <label class="form-check-label <?php if ($prod_data["status"] == 1) {
                                                                echo "t-dng";
                                                            } else if ($prod_data["status"] == 2) {
                                                                echo "t-suc";
                                                            } ?>" for="aod<?php echo $i; ?>" id="<?php echo ('status_p' . $prod_data["product_id"]); ?>">
                                <?php if ($prod_data["status"] == 1) {
                                    echo "Make this product Dectivated";
                                } else if ($prod_data["status"] == 2) {
                                    echo "Make this product Activated";
                                } ?>
                            </label>

                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-4">
                                    <button class="btn-1 text-white" onclick="window.location = '<?php echo ('singleProduct.php?id=' . $prod_data['product_id']); ?>'">View</button>
                                </div>
                                <div class="col-4">
                                    <button class="btn-1 text-white" onclick="window.location = '<?php echo ('updateProduct.php?id=' . $prod_data['product_id']); ?>'" style="background-color: rgb(215, 180, 70);" <?php if ($prod_data["status"] == 3) {
                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                    } ?>>Edit</button>
                                </div>
                                <div class="col-4">
                                    <button class="btn-1 text-white" onclick="deleteProduct('<?php echo $prod_data['product_id']; ?>');" style="background-color: rgb(255, 105, 105);" <?php if ($prod_data["status"] == 3) {
                                                                                                                                                                                            echo "disabled";
                                                                                                                                                                                        } ?>>Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    <?php } ?>

    <!--  product view  -->

</div>

<div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
    <nav>
        <ul class="pagination pagination-md justify-content-center">
            <li class="page-item">
                <a class="page-link" onclick="adminAllProducts('<?php if ($page <= 1) { echo '1'; } else { echo ($page - 1); } ?>');" aria-label="Previous">
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
                        <a class="page-link" onclick="adminAllProducts('<?php echo ($x); ?>');"><?php echo $x; ?></a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="page-item">
                        <button class="page-link" onclick="adminAllProducts('<?php echo ($x); ?>');" <?php if($x > $pages){ echo "disabled"; } ?> ><?php echo $x; ?></button>
                    </li>
            <?php
                }
            }
            ?>

            <li class="page-item">
                <a class="page-link" onclick="adminAllProducts('<?php if ($page >= $pages) { echo $pages; } else { echo ($page + 1); } ?>');" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<?php
}else{
?>
<div class="col-12">
    <div class="row text-center">
        <span class="text-white-25 mt-5 fs-6">No Results</span>
    </div>
</div>
<?php
}
?>