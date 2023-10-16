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
    <title>My Orders | ShoFFee.net</title>
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
                        <h4 class="fw-bold mt-2">My Orders</h4>
                    </div>

                    <a href="#collapse2" class="col-10 offset-1 mt-3 d-lg-none btn btn-info" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse1">
                        Fiter Listings
                    </a>

                    <div class="col-12 col-lg-4 collapse" id="collapse2">
                        <div class="col-12 b mt-3 p-4 rounded border border-secondary border-opacity-25">
                            <div class="col-12 border-bottom border-info">
                                <h5>Filters..</h5>
                            </div>
                            <div class="col-12 py-3 border-bottom border-info">
                                <input type="text" class="form-control" style="font-size: 14px;" placeholder="Search by Order ID" id="o_txt">
                            </div>

                            <div class="col-12 py-3 border-bottom border-info">
                                <p class="fw-bold">Select by date</p>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <input type="radio" class="form-check-input me-1" id="o_time1" name="o_time">
                                        <label for="o_time1" class="form-check-lable">Newest to Oldest</label>
                                    </li>
                                    <li class="list-group-item">
                                        <input type="radio" class="form-check-input me-1" id="o_time2" name="o_time">
                                        <label for="o_time2" class="form-check-lable">Oldest to Newest</label>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-12 py-3 border-bottom border-info">
                                <p class="fw-bold">Select by Status</p>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <input type="radio" class="form-check-input me-1" id="o_status1" name="status">
                                        <label for="o_status1" class="form-check-lable">Pending</label>
                                    </li>
                                    <li class="list-group-item">
                                        <input type="radio" class="form-check-input me-1" id="o_status2" name="status">
                                        <label for="o_status2" class="form-check-lable">Ready to ship</label>
                                    </li>
                                    <li class="list-group-item">
                                        <input type="radio" class="form-check-input me-1" id="o_status3" name="status">
                                        <label for="o_status3" class="form-check-lable">Delivered</label>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-12 py-3 border-bottom border-info">
                                <p class="fw-bold">Sort Peroid</p>
                                <ul class="list-group">
                                    <li class="list-group-item p-0">
                                        <input type="date" class="form-control me-1 border-0 mt-1" id="o_date1" format style="font-size: 13px;">
                                    </li>
                                    <li class="list-group-item p-0">
                                        <input type="date" class="form-control me-1 border-0 mb-1" id="o_date2" style="font-size: 13px;">
                                    </li>
                                </ul>
                            </div>

                            <div class="col-12 py-3">
                                <div class="row">
                                    <div class="col-6">
                                        <button class="col-12 btn-1 fw-bold" style="background-color: rgb(0, 255, 255);" onclick="orderSort('no');">Sort</button>
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
                            <div class="col-12" id="order_sorted">
                                <div class="col-12 mt-3">

                                    <?php
                                    $quary = "SELECT DISTINCT `order_id` FROM `invoice` INNER JOIN `product` ON 
                                    invoice.product_id=product.product_id WHERE product.user_email='" . $email . "' AND `invoice_status`<'5'";

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

                                    $quary .= "LIMIT " . $results_per_page . " OFFSET " . $skip . "";

                                    $result = Database::search($quary);
                                    $loop = $result->num_rows;

                                    if ($result_num > 0) {
                                        for ($y = 0; $y < $loop; $y++) {
                                            $result_data = $result->fetch_assoc();

                                            $selected_rs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON 
                                            invoice.product_id=product.product_id WHERE `order_id`='" . $result_data["order_id"] . "' AND  product.user_email='" . $email . "'");
                                            $selected_num = $selected_rs->num_rows;
                                            $selected_data = $selected_rs->fetch_assoc();

                                            $customer_rs = Database::search("SELECT * FROM `user` WHERE `email`='".$selected_data["user_email"]."'");
                                            $customer_data = $customer_rs->fetch_assoc();
                                    ?>

                                            <div class="col-12 card mb-2 overflow-hidden">
                                                <div class="row">
                                                    <div class="card-body" style="width: calc(100% - 12rem);">
                                                        <div class="row">
                                                            <div class="col-8 ps-4">
                                                                <span class="fw-bold">Order Id :</span> &nbsp;
                                                                <span class="card-title fs-6 fw-bold" id="<?php echo ("ord_id" . $y) ?>"><?php echo $selected_data["order_id"]; ?></span><br>
                                                                <span class="fw-bold">Customer Name :</span> &nbsp;
                                                                <span class="card-text text-secondary fw-bold"><?php echo ($customer_data["fname"]." ".$customer_data["lname"]); ?></span><br>
                                                                <span class="fw-bold">No. of Products :</span> &nbsp;
                                                                <span class="card-text text-success fw-bold"><?php echo $selected_num; ?> items</span><br>
                                                                <span class="fw-bold">Order Date :</span> &nbsp;
                                                                <span class="card-text text-secondary fw-bold"><?php echo $selected_data["date_time"]; ?></span>
                                                            </div>
                                                            <div class="col-4 pe-4">
                                                                <button class="btn-1 mt-2" onclick="window.location = '<?php echo ('viewOrder.php?id=' . $result_data['order_id']); ?>'">View Order</button>
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
                                                <img src="images/not-found.gif" style="height: 250px; width: 300px;" class="d-none position-absolute opacity-50">
                                                <span class="text-black-50 fw-bold pt-5 fs-5" style="z-index: 1;">You Have Nothing Purchased Yet,</span>
                                                <button class="btn-1 mt-3 col-6" style="z-index: 1;">Start Shopping Now</button>
                                            </div>
                                        </div>
                                    <?php } ?>

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
            document.getElementById("collapse2").classList = "collapse col-12 col-lg-4";
        } else {
            document.getElementById("collapse2").classList = "collapse show col-12 col-lg-4";

        }
    </script>
</body>

</html>

<?php } ?>