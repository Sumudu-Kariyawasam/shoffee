<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History | ShoFFee</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="d-body">

    <div class="container-fluid contain2">
        <div class="row">
            <?php
            include "header.php";

            if ($_SESSION["user"]) {
                $user = $_SESSION["user"];
                $email = $user["email"];
            ?>

                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-12 py-3 bg-info text-center hd-main">
                            <h4 class="">Purchasing History</h4>
                        </div>

                        <a href="#collapse1" class="col-10 offset-1 mt-3 d-lg-none btn btn-info" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse1">
                            Fiter Listings
                        </a>

                        <!-- <div class=""> -->
                            <div class="collapse show col-12 col-lg-4" id="collapse1">
                                <div class="col-12 b mt-3 p-4 rounded border border-dark border-opacity-50">
                                    <div class="col-12 border-bottom border-info">
                                        <h5>Filters..</h5>
                                    </div>
                                    <div class="col-12 py-3 border-bottom border-info">
                                        <input type="text" class="form-control" placeholder="Search By Invoice ID" id="ph_oi" style="font-size: 14px;">
                                    </div>

                                    <div class="col-12 py-3 border-bottom border-info">
                                    <p class="fw-bold">Sort by date</p>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <input type="radio" class="form-check-input me-1" id="time1" name="time">
                                            <lable class="form-check-lable">Newest to Oldest</lable>
                                        </li>
                                        <li class="list-group-item">
                                            <input type="radio" class="form-check-input me-1" id="time2" name="time">
                                            <lable class="form-check-lable">Oldest to Newest</lable>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-12 py-3 border-bottom border-info">
                                    <p class="fw-bold">Sort Peroid</p>
                                    <ul class="list-group">
                                        <li class="list-group-item p-0">
                                            <input type="date" class="form-control me-1 border-0 mt-1" id="date1" format style="font-size: 13px;">
                                        </li>
                                        <li class="list-group-item p-0">
                                            <input type="date" class="form-control me-1 border-0 mb-1" id="date2" style="font-size: 13px;">
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-12 py-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <button class="col-12 btn-1" onclick="historySort('no');">Sort</button>
                                        </div>
                                        <div class="col-6">
                                            <button class="col-12 btn-1" style="background-color: rgb(255, 105, 105);" onclick="window.location.reload();">Clear</button>
                                        </div>
                                    </div>
                                </div>

                                </div>
                            </div>

                        <!-- </div> -->

                        

                        <?php
                        $quary = "SELECT DISTINCT `order_id` FROM `invoice` WHERE `user_email`='" . $email . "' AND `status`<'3'";

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
                        ?>

                        <div class="col-12 col-lg-8">
                            <div class="row p-3">
                                <div class="col-12 border border-dark border-opacity-50 rounded" id="p_history">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-7 col-md-9">
                                                <p class="pt-4 fs-6 ps-4 t-pri"><?php echo $result_num; ?> records in History</p>
                                            </div>
                                            <div class="col-5 col-md-3">
                                                <button class="btn-1" style="background-color: rgb(255, 105, 105);" onclick="deleteall();">Delete All Records</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row px-3 pt-1">

                                        <?php
                                        if ($result_num > 0) {
                                            for ($y = 0; $y < $loop; $y++) {
                                                $result_data = $result->fetch_assoc();

                                                $selected_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $result_data["order_id"] . "'");
                                                $selected_num = $selected_rs->num_rows;
                                                $selected_data = $selected_rs->fetch_assoc();
                                        ?>

                                                <div class="col-12 card mb-2 overflow-hidden">
                                                    <div class="row">
                                                        <div class="cardimg ps-0 d-none d-lg-block" style="width: 10rem; height: 7.5rem;">
                                                            <div class="d-flex justify-content-center overflow-hidden" style="height: 100%; width: 100%;">
                                                                <img src="resources/orderlist.png" class="card-img-top" style="height: 100%; width: auto;">
                                                            </div>
                                                        </div>
                                                        <div class="card-body" style="width: calc(100% - 12rem);">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <h5 class="card-title fs-6 fw-bold" id="<?php echo ("ino_id" . $y) ?>"><?php echo $selected_data["order_id"]; ?></h5>
                                                                    <span class="card-text text-secondary fw-bold">LKR. <?php echo $selected_data["total"]; ?>.00</span><br>
                                                                    <span class="card-text text-success fw-bold"><?php echo $selected_num; ?> Products</span><br>
                                                                    <span class="card-text text-secondary fw-bold"><?php echo $selected_data["date_time"]; ?></span>
                                                                </div>
                                                                <div class="col-4">
                                                                    <button class="btn-1 mt-2" onclick="window.location = '<?php echo ('viewInvoice.php?id=' . $result_data['order_id']); ?>'">Details</button>
                                                                    <button class="btn-1 m-0" style="background-color: rgb(255, 105, 105);" onclick="deleteInvoice(<?php echo $y; ?>);">Delete</button>
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
                </div>

            <?php
            } else {
                header("Location: http://localhost/shoffee/home.php");
            }
            include "footer.php";
            ?>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
    <script>
        var width = window.innerWidth;

        if(width < 992){
            document.getElementById("collapse1").classList = "collapse col-12 col-lg-4";
        }else{
            document.getElementById("collapse1").classList = "collapse show col-12 col-lg-4";

        }
    </script>
</body>

</html>