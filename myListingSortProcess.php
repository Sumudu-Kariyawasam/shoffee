<?php

require "connection.php";
session_start();

$txt = $_POST["txt"];
$time = $_POST["time"];
$qty = $_POST["qty"];
$condition = $_POST["use"];

$email = $_SESSION["user"]["email"];

$quary = "SELECT * FROM `product` WHERE `user_email`='" . $email . "' AND `status`!='3'";

if (!empty($txt)) {
    $quary .= " AND `title` LIKE '%" . $txt . "%'";
}

if ($condition == 1) {
    $quary .= " AND `condition_id`='1'";
} else if ($condition == 2) {
    $quary .= " AND `condition_id`='2'";
}

if ($qty == 2) {
    $quary .= " ORDER BY `qty` ASC";
} else if ($qty == 1) {
    $quary .= " ORDER BY `qty` DESC";
}

if ($time == 2) {
    $quary .= " ORDER BY `datetime_added` ASC";
} else if ($time == 1) {
    $quary .= " ORDER BY `datetime_added` DESC";
}

$result_rs = Database::search($quary);
$result_num = $result_rs->num_rows;

$results_per_page = 6;
$pages = ceil($result_num / $results_per_page);

$page = 1;
if (isset($_GET["page"])) {
    if ($pages > $_GET["page"]) {
        $page = $_GET["page"];
    } else {
        $page = $pages;
    }
}
$skip = ($page - 1) * $results_per_page;

$quary .= " LIMIT " . $results_per_page . " OFFSET " . $skip . "";

$result = Database::search($quary);
$loop = $result->num_rows;

?>




<div class="col-12 mt-3">

    <?php
    for ($y = 0; $y < $loop; $y++) {
        $pdata = $result->fetch_assoc();

        $image_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $pdata["product_id"] . "'");
        $img_data = $image_rs->fetch_assoc();
    ?>

        <div class="col-12 card mb-2 overflow-hidden">
            <div class="row">
                <div class="cardimg" style="width: 12rem; height: 10rem;">
                    <div class="d-flex justify-content-center overflow-hidden" style="height: 100%; width: 100%;">
                        <img src="<?php echo ($img_data["product_image_path"]); ?>" class="card-img-top" style="height: 100%; width: auto;">
                    </div>
                </div>
                <div class="card-body" style="width: calc(100% - 12rem);">
                    <h5 class="card-title"><?php echo ($pdata["title"]); ?></h5>
                    <span class="card-text text-secondary fw-bold">LKR. <?php echo ($pdata["price"]) ?> .00</span><br>
                    <span class="card-text text-success fw-bold"><?php echo ($pdata["qty"]) ?> items Available</span>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="fd<?php echo $pdata["status"]; ?>" <?php if ($pdata["status"] == 1) { ?> checked <?php } ?> onclick="changeStatus(<?php echo $pdata['product_id']; ?>);" />
                        <label class="form-check-label fw-bold text-info" for="fd<?php echo $pdata["status"]; ?>" id="<?php echo ("status_p" . $pdata["product_id"]) ?>">
                            <?php if ($pdata["status"] == 1) { ?>
                                Activated
                            <?php } else { ?>
                                Deactivated
                            <?php } ?>
                        </label>
                    </div>

                    <div class="col-12">
                        <div class="row pe-4">
                            <div class="col-6">
                                <button class="btn-1 fw-bold" onclick="window.location = '<?php echo ('updateproduct.php?id=' . $pdata['product_id']); ?>'">Update</button>
                            </div>
                            <div class="col-6">
                                <button class="btn-1 fw-bold" onclick="deleteProduct(<?php echo $pdata['product_id'] ?>);" style="background-color: rgb(255, 120, 120);">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>

<div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
    <nav>
        <ul class="pagination pagination-md justify-content-center">
            <li class="page-item">
                <a class="page-link" href="<?php if ($page <= 1) {
                                                echo "#";
                                            } else {
                                                echo "?page=" . ($page - 1);
                                            } ?>" aria-label="Previous">
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
                        <a class="page-link" href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a>
                    </li>
            <?php
                }
            }
            ?>

            <li class="page-item">
                <a class="page-link" href="<?php if ($page >= $pages) {
                                                echo "#";
                                            } else {
                                                echo "?page=" . ($page + 1);
                                            } ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
