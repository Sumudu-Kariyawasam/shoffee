<?php if(!isset($_SESSION["user"])){ ?>

    <script>
        alert("Please signin first");
        window.location = "index.php";
    </script>

<?php }else{ ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Listings | ShoFFee.net</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">

</head>

<body class="d-body">
    <div class="container-fluid">
        <div class="row">
            <?php
            include "header.php";

            $user = $_SESSION["user"];
            $email = $user["email"];
            ?>

            <div class="col-12 px-4 py-4">
                <div class="row border border-dark border-opacity-50 rounded pb-3">
                    <div class="text-center pt-4 pb-4 bg-secondary bg-opacity-10 hder-sm d-flex justify-content-between px-4">
                        <h4 class="fw-bold mt-2">My Listings</h4>
                        <button class="btn btn-info" onclick="window.location = 'addProduct.php'">Add Product</button>
                    </div>

                    <a href="#collapse3" class="col-10 offset-1 mt-3 d-lg-none btn btn-info" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse1">
                        Fiter Listings
                    </a>

                        <div class="col-12 col-lg-4 collapse" id="collapse3">
                            <div class="col-12 b mt-3 p-4 rounded border border-secondary border-opacity-25">
                                <div class="col-12 border-bottom border-info">
                                    <h5>Filters..</h5>
                                </div>
                                <div class="col-12 py-3 border-bottom border-info">
                                    <input type="text" class="form-control" placeholder="Search By Title" style="font-size: 14px;" id="ml_txt">
                                </div>

                                <div class="col-12 py-3 border-bottom border-info">
                                    <p class="fw-bold">Select by date</p>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <input type="radio" class="form-check-input me-1" id="ml_time1" name="time">
                                            <lable class="form-check-lable">Newest to Oldest</lable>
                                        </li>
                                        <li class="list-group-item">
                                            <input type="radio" class="form-check-input me-1" id="ml_time2" name="time">
                                            <lable class="form-check-lable">Oldest to Newest</lable>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-12 py-3 border-bottom border-info">
                                    <p class="fw-bold">Select by quantity</p>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <input type="radio" class="form-check-input me-1" id="ml_qty1" name="time">
                                            <lable class="form-check-lable">High to low</lable>
                                        </li>
                                        <li class="list-group-item">
                                            <input type="radio" class="form-check-input me-1" id="ml_qty2" name="time">
                                            <lable class="form-check-lable">Low to High</lable>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-12 py-3 border-bottom border-info">
                                    <p class="fw-bold">Select by Confition</p>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <input type="radio" class="form-check-input me-1" id="ml_con1" name="con">
                                            <lable class="form-check-lable">Brand New</lable>
                                        </li>
                                        <li class="list-group-item">
                                            <input type="radio" class="form-check-input me-1" id="ml_con2" name="con">
                                            <lable class="form-check-lable">Used</lable>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-12 py-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <button class="col-12 btn-1 fw-bold" style="background-color: rgb(0, 255, 255);" onclick="sortListings();">Sort</button>
                                        </div>
                                        <div class="col-6">
                                            <button class="col-12 btn-1 fw-bold" style="background-color: rgb(255, 105, 105);" onclick="window.location.reload();">Clear</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    <div class="col-12 col-lg-8">
                        <div class="row">
                            <div class="col-12" id="listing_sorted">
                                <div class="col-12 mt-3">

                                    <?php
                                    $quary = "SELECT * FROM `product` WHERE `user_email`='" . $email . "' AND `status`!='3'";

                                    $result1 = Database::search($quary);
                                    $num = $result1->num_rows;

                                    $results_per_page = 4;
                                    $pages = ceil($num / $results_per_page);

                                    $page = 1;
                                    if (isset($_GET["page"])) {
                                        if ($pages > $_GET["page"]) {
                                            $page = $_GET["page"];
                                        } else {
                                            $page = $pages;
                                        }
                                    }
                                    $skip = ($page - 1) * $results_per_page;

                                    $quary .= " ORDER BY `datetime_added` DESC LIMIT " . $results_per_page . " OFFSET " . $skip . "";
                                    $product_rs = Database::search($quary);
                                    $pnum = $product_rs->num_rows;

                                    for ($y = 0; $y < $pnum; $y++) {
                                        $pdata = $product_rs->fetch_assoc();

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
                                                        <label class="form-check-label fw-bold text-info" for="fd<?php echo $pdata["status"]; ?>" id="<?php echo ("status_p".$pdata["product_id"]) ?>">
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
                                                if($x == $page){
                                            ?>
                                                <li class="page-item active">
                                                    <a class="page-link" href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a>
                                                </li>
                                            <?php
                                                }else{
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

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <?php
            include "footer.php";
            ?>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
    <script>
        var width = window.innerWidth;

        if (width < 992) {
            document.getElementById("collapse3").classList = "collapse col-12 col-lg-4";
        } else {
            document.getElementById("collapse3").classList = "collapse show col-12 col-lg-4";

        }
    </script>
</body>

</html>

<?php } ?>