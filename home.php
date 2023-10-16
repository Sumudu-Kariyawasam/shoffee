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

                <!-- carousel -->

                <div class="col-12 d-none d-lg-block mb-0 mt-0 contain2 p-0">
                    <div class="row">

                        <div id="carouselExampleIndicators" class="col-12 carousel slide carousel-fade" data-bs-ride="true">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active d-flex justify-content-center">
                                    <img src="resources/slider images/posterimg.jpg" class="d-block poster-img-1" />
                                    <div class="carousel-caption d-none d-md-block poster-caption">

                                    </div>
                                </div>
                                <div class="carousel-item d-flex justify-content-center">
                                    <img src="resources/slider images/posterimg2.jpg" class="d-block poster-img-1" />
                                </div>
                                <div class="carousel-item d-flex justify-content-center">
                                    <img src="resources/slider images/posterimg3.jpg" class="d-block poster-img-1" />
                                    <div class="carousel-caption d-none d-md-block poster-caption-1">

                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>

                    </div>
                </div>

                <!-- carousel -->

                <div class="col-12 glass-box2 mb-0 p-3">
                    <div class="col-12 mb-3">
                        <a href="<?php echo ("productList.php?id=latest") ?>" class=" text-decoration-none fs-5 text-black">Latest Products</a>&nbsp;
                        <a href="<?php echo ("productList.php?id=latest") ?>" class="fw-bold text-decoration-none text-black opacity-75">See All &rarr;</a>
                    </div>

                    <div class="col-12">
                        <div class="row gap-2 d-flex justify-content-center">

                            <?php
                            $product_rs = Database::search("SELECT * FROM `product` WHERE 
                                `status`='1' ORDER BY `datetime_added` DESC LIMIT 4 OFFSET 0");
                            $pnum = $product_rs->num_rows;

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

                <!-- -- end screens-- -->

                <div class="col-12 glass-box2 mb-0 p-3">
                    <div class="col-12 mb-3">
                        <a href="<?php echo ("productList.php?id=popular") ?>" class=" text-decoration-none fs-5 text-black">Best Selling Products</a>&nbsp;
                        <a href="<?php echo ("productList.php?id=popular") ?>" class="fw-bold text-decoration-none text-black opacity-75">See All &rarr;</a>
                    </div>

                    <div class="col-12">
                        <div class="row gap-2 d-flex justify-content-center">

                            <?php
                            $invoice_rs = Database::search("SELECT invoice.product_id FROM `invoice` 
                            INNER JOIN `product` ON product.product_id=invoice.product_id WHERE product.status='1' GROUP BY invoice.product_id ORDER BY SUM(invoice_qty) DESC");
                            $inum = $invoice_rs->num_rows;
                            $loop;

                            if ($inum <= 4) {
                                $loop = $inum;
                            } else {
                                $loop = 4;
                            }

                            for ($y = 0; $y < $loop; $y++) {
                                $idata = $invoice_rs->fetch_assoc();
                                $product_rs = Database::search("SELECT * FROM `product` WHERE 
                                    `status`='1' AND `product_id`='" . $idata["product_id"] . "'");
                                $pdata = $product_rs->fetch_assoc();

                                $image_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id`='" . $pdata["product_id"] . "'");
                                $img_data = $image_rs->fetch_assoc();

                            ?>

                                <div class="card p-0 overflow-hidden" style="width: 12rem; height: 25rem;">
                                    <span class="badge color_primary position-absolute mt-2 ms-2">New</span>
                                    <div class="overflow-hidden cardimage pointer" onclick="singleProduct(<?php echo ($pdata['product_id']); ?>);">
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

                <?php
                // }
                ?>

                <?php
                include "footer.php";
                ?>

            </div>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>