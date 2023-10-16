<?php
require "connection.php";

$sub_cate = $_POST["sc"];
$brand = $_POST["br"];
$model = $_POST["md"];
$condition = $_POST["cn"];
$text = $_POST["tt"];
$order_id = $_POST["id"];
$date_f = $_POST["df"];
$date_t = $_POST["dt"];
$email = $_POST["em"];
$type = $_POST["type"];
$time = $_POST["tm"];

$quary = "SELECT * FROM `invoice` INNER JOIN `product` ON invoice.product_id=product.product_id INNER JOIN `category_has_sub_category` ON product.categories_id=category_has_sub_category.2_category_id 
INNER JOIN `category` ON category_has_sub_category.category_id=category.category_id 
INNER JOIN `sub_category` ON category_has_sub_category.sub_category_id=sub_category.sub_category_id 
INNER JOIN `brand_has_model` ON brand_has_model.brand_has_model_id=product.brand_has_model_id 
INNER JOIN `brand` ON brand_has_model.brand_id=brand.brand_id 
INNER JOIN `model` ON brand_has_model.model_id=model.model_id 
INNER JOIN `color` ON product.color_id=color.color_id 
INNER JOIN `condition` ON product.condition_id=condition.condition_id 
INNER JOIN `status` ON product.status=status.status_id";

if ($type == "all") {
    $quary .= " WHERE invoice.invoice_status <= 5";
} else if ($type == "del") {
    $quary .= " WHERE invoice.invoice_status = 4";
} else if ($type == "cof") {
    $quary .= " WHERE invoice.invoice_status = 3";
} else if ($type == "pen") {
    $quary .= " WHERE invoice.invoice_status = 2";
} else if ($type == "rtn") {
    $quary .= " WHERE invoice.invoice_status = 5";
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
if (!empty($text)) {
    $quary .= " AND `title` LIKE '%" . $text . "%'";
}

if (!empty($order_id)) {
    $quary .= " AND `order_id` LIKE '%" . $order_id . "%'";
}
if (!empty($email)) {
    $quary .= " AND invoice.user_email LIKE '%" . $email . "%'";
}
if (!empty($date_f) && !empty($date_t)) {
    $quary .= " AND `date_time` BETWEEN '" . $date_f . "' AND '" . $date_t . "'";
} else if (!empty($date_f) && empty($status_data)) {
    $quary .= " AND `date_time` > '" . $date_f . "'";
} else if (empty($date_f) && !empty($date_t)) {
    $quary .= " AND `date_time` < '" . $date_t . "'";
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

if ($num > 0) {
    if ($time != 2) {
        $quary .= " GROUP BY `order_id` ORDER BY `datetime_added` DESC";
    } else {
        $quary .= " GROUP BY `order_id` ORDER BY `datetime_added` ASC";
    }
    $quary .= " LIMIT " . $results_per_page . " OFFSET " . $skip . "";
}

$order_rs = Database::search($quary);
$order_num = $order_rs->num_rows;

if ($order_num > 0) {

?>

    <div class="row pe-2">

        <!--  product view  -->

        <?php
        for ($i = 0; $i < $order_num; $i++) {
            $order_data = $order_rs->fetch_assoc();
        ?>

            <div class="col-12 border border-light border-opacity-50 rounded mb-2 admin_bg">
                <div class="row">
                    <div class="col-12 col-lg-5 py-3">
                        <span class=""><?php echo $order_data["user_email"]; ?></span><br>
                        <span class="t-pri"><?php echo $order_data["order_id"]; ?></span>
                    </div>
                    <div class="col-6 col-lg-2 py-lg-3">
                        <span class="">Order Date</span><br>
                        <span class=""><?php echo $order_data["date_time"]; ?></span>
                    </div>
                    <div class="col-6 col-lg-2 py-lg-3">
                        <span class="">Order Total</span><br>
                        <span class=" text-warning">Rs. <?php echo $order_data["total"]; ?>.00</span>
                    </div>
                    <div class="col-12 col-lg-3 py-lg-3">
                        <button class="btn-1 m-0 mt-2 tm-lg-1 mb-3 mb-lg-0 text-white" data-bs-toggle="collapse" type="button" data-bs-target="<?php echo ("#aord_collapse" . $i); ?>" aria-expanded="false" aria-controls="<?php echo ("aord_collapse" . $i); ?>">Manage Product</button>
                    </div>
                </div>
                <div class="row collapse" id="<?php echo ("aord_collapse" . $i); ?>">
                    <div class="col-12 mb-2">
                        <div class="row">
                            <span class="">Buyer Details</span>

                            <?php
                                $buyer_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $order_data["user_email"] . "'");
                                $buyer_data = $buyer_rs->fetch_assoc();
                            ?>

                            <div class="row overflow-hidden tx-mute">
                                <div class="col-6 col-lg-4">
                                    <span class="">Name</span><br>
                                    <span class="">Email</span><br>
                                    <span class="">Contact No</span><br>
                                    <span class="">Delivery Address</span><br>
                                </div>
                                <div class="col-6 col-lg-8">
                                    <span class=""><?php echo ($buyer_data["fname"]." ".$buyer_data["lname"]); ?></span><br>
                                    <span class=""><?php echo $order_data["user_email"]; ?></span><br>
                                    <span class=""><?php echo ($buyer_data["mobile"]); if(!empty($buyer_data["office"])){ echo (" / ".$buyer_data["office"]); } ?></span><br>
                                    <span class=""><?php echo $order_data["delivery_address"]; ?></span><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 p-3 pb-2 pt-0">
                        <?php
                        $selected_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id` = '" . $order_data["order_id"] . "'");
                        $selected_num = $selected_rs->num_rows;

                        for ($j = 0; $j < $selected_num; $j++) {
                            $selected_data = $selected_rs->fetch_assoc();

                            $prod_rs = Database::search("SELECT * FROM `product` WHERE `product_id`='" . $selected_data["product_id"] . "'");
                            $prod_data = $prod_rs->fetch_assoc();

                            $prod_img_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $selected_data["product_id"] . "'");
                            $prod_img_data = $prod_img_rs->fetch_assoc();
                        ?>
                            <div class="row pb-2 py-3 border border-light border-opacity-50 rounded my-2">
                                <div class="col-12 col-lg-9">
                                    <div class="row overflow-hidden">
                                        <div class="col-6 col-lg-4">
                                            <span class="">Product Title</span><br>
                                            <span class="">Price</span><br>
                                            <span class="">Seller Email</span><br>
                                            <span class="">Available Quantity</span><br>
                                        </div>
                                        <div class="col-6 col-lg-8">
                                            <span class=""><?php echo $prod_data["title"]; ?></span><br>
                                            <span class="">LKR. <?php echo $prod_data["price"]; ?>.00</span><br>
                                            <span class=""><?php echo $prod_data["user_email"]; ?></span><br>
                                            <span class=""><?php echo $prod_data["qty"]; ?> Items Available</span><br>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 mt-3 mt-lg-0">
                                    <div class="row">
                                        <img src="<?php echo $prod_img_data["product_image_path"]; ?>" alt="" style="height: 100px; width: auto;">
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="row">
                                        <div class="col-12 col-lg-8">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row px-2">
                                                        <select class="form-infield4 text-warning" id="adm_chg_ost" style="background-color: rgb(44, 44, 44);">
                                                            <?php
                                                            $status_rs = Database::search("SELECT * FROM `invoice_status` WHERE `status_id` > '1'");
                                                            $status_num = $status_rs->num_rows;

                                                            for ($k = 0; $k < $status_num; $k++) {
                                                                $status_data = $status_rs->fetch_assoc();
                                                            ?>
                                                                <option value="<?php echo $status_data["status_id"]; ?>" <?php if ($status_data["status_id"] == $selected_data["invoice_status"]) {
                                                                                                                                echo "selected";
                                                                                                                            } ?>><?php echo $status_data["status"]; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row px-2">
                                                        <button class="btn-6 text-white" style="background-color: #ffc61c;" onclick="adminOrderStatusUpdate('<?php echo $order_data['invoice_id']; ?>');">Update Status</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="row px-2">
                                                <button class="btn-6 text-white" onclick="window.location='<?php echo ('singleProduct.php?id='.$selected_data['product_id']); ?>'">View Product</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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
                    <a class="page-link" onclick="adminAllProducts('<?php if ($page <= 1) {
                                                                        echo '1';
                                                                    } else {
                                                                        echo ($page - 1);
                                                                    } ?>');" aria-label="Previous">
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
                            <button class="page-link" onclick="adminAllProducts('<?php echo ($x); ?>');" <?php if ($x > $pages) {
                                                                                                                echo "disabled";
                                                                                                            } ?>><?php echo $x; ?></button>
                        </li>
                <?php
                    }
                }
                ?>

                <li class="page-item">
                    <a class="page-link" onclick="adminAllProducts('<?php if ($page >= $pages) {
                                                                        echo $pages;
                                                                    } else {
                                                                        echo ($page + 1);
                                                                    } ?>');" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

<?php
} else {
?>
    <div class="col-12">
        <div class="row text-center">
            <span class="text-white-25 mt-5 fs-6">No Results</span>
        </div>
    </div>
<?php
}
?>