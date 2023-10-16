<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | ShoFFee</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="d-body">

    <div class="bg-body col-12">
        <div class="container-fluid">
            <div class="row">

                <?php
                include "header.php";
                ?>

                <?php

                if (isset($_GET["id"])) {
                    $id = $_GET["id"];
                    $quary;

                    if($id != "latest" && $id != "popular"){
                        $category_rs = Database::search("SELECT * FROM `category_has_sub_category` WHERE `sub_category_id`='" . $id . "'");
                        $category_data = $category_rs->fetch_assoc();

                        $cid = $category_data["2_category_id"];
                    }

                    if ($id == "latest") {
                        $quary = "SELECT * FROM `product` WHERE `status`='1' ORDER BY `datetime_added`";
                    } else if ($id == "popular") {
                        $quary = "SELECT * FROM `product` WHERE `status`='1' ORDER BY `datetime_added`";
                    } else {
                        $quary = "SELECT * FROM `product` WHERE `status`='1' AND `categories_id`='" . $cid . "' ORDER BY `datetime_added`";
                    }

                    $result0 = Database::search($quary);
                    $num = $result0->num_rows;

                    $results_per_page = 20;
                    $pages = ceil($num / $results_per_page);

                    $page = 1;
                    if (isset($_GET["page"])) {
                        if($pages > $_GET["page"]){
                            $page = $_GET["page"];
                        }else{
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
                            <ul class="pagination pagination-md justify-content-center">
                                <li class="page-item">
                                    <a class="page-link" href="<?php if ($page <= 1) {
                                                                    echo "#";
                                                                } else {
                                                                    echo "?page=" . ($page - 1)."&id=".$id;
                                                                } ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>

                                <?php
                                if($pages < 3){
                                    $loop = $pages + 1;
                                }else{
                                    $loop = 4;
                                }
                                for ($y = 1; $y < $loop; $y++) {
                                    if ($pages < 3) {
                                        $x = $y;
                                    } else {
                                        $x = ($page - 1) + $y;
                                    }
                                    if($x == $page){
                                ?>
                                    <li class="page-item active">
                                        <a class="page-link" href="<?php echo "?page=" . ($x)."&id=".$id; ?>"><?php echo $x; ?></a>
                                    </li>
                                <?php
                                    }else{
                                ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo "?page=" . ($x)."&id=".$id; ?>"><?php echo $x; ?></a>
                                    </li>
                                <?php
                                    }
                                }
                                ?>
                        
                                <li class="page-item">
                                    <a class="page-link" href="<?php if ($page >= $pages) {
                                                                    echo "#";
                                                                } else {
                                                                    echo "?page=" . ($page + 1)."&id=".$id;
                                                                } ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                <?php
                } else {
                }

                include "footer.php";
                ?>

            </div>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>