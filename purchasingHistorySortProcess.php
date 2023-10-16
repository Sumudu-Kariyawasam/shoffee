<?php

require "connection.php";
session_start();

$txt = $_POST["txt"];
$time = $_POST["time"];
$date1 = $_POST["date1"];
$date2 = $_POST["date2"];

$dt1 = $date1 . " 00:00:00";
$dt2 = $date2 . " 23:59:59";

$email = $_SESSION["user"]["email"];

$quary = "SELECT DISTINCT `order_id` FROM `invoice` WHERE `user_email`='" . $email . "' AND `invoice_status`<'5'";

if (!empty($txt)) {
    $quary .= " AND `order_id` LIKE '%" . $txt . "%'";
}
if (!empty($date1) && !empty($date2)) {
    $quary .= " AND `date_time` BETWEEN '" . $dt1 . "' AND '" . $dt2 . "'";
} else if (!empty($date1) && empty($date2)) {
    $quary .= " AND `date_time`>='" . $dt1 . "'";
} else if (empty($txt) && !empty($date2)) {
    $quary .= " AND `date_time`<='" . $dt2 . "'";
}
if ($time == 2) {
    $quary .= " ORDER BY `date_time` ASC";
} else if($time == 1){
    $quary .= " ORDER BY `date_time` DESC";
}


$result1 = Database::search($quary);
$num = $result1->num_rows;

$results_per_page = 6;
$pages = ceil($num / $results_per_page);

$page = 1;
if ($_POST["page"] != "no") {
    if ($pages > $_POST["page"]) {
        $page = $_POST["page"];
    } else {
        $page = $pages;
    }
}
$skip = ($page - 1) * $results_per_page;

$quary .= " LIMIT " . $results_per_page . " OFFSET " . $skip . "";

$result = Database::search($quary);
$loop = $result->num_rows;

// echo $page;

?>

<div class="col-12">
    <div class="row">
        <div class="col-9">
            <p class="pt-4 fs-6 ps-4 t-pri"><?php echo $num; ?> records in History</p>
        </div>
        <div class="col-3">
            <button class="btn-1" style="background-color: rgb(255, 105, 105);" onclick="deleteall();">Delete All Records</button>
        </div>
    </div>
</div>

<div class="row px-3 pt-1">

    <?php
    if ($num > 0) {
        for ($y = 0; $y < $loop; $y++) {
            $result_data = $result->fetch_assoc();

            $selected_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $result_data["order_id"] . "'");
            $selected_num = $selected_rs->num_rows;
            $selected_data = $selected_rs->fetch_assoc();
    ?>

            <div class="col-12 card mb-2 overflow-hidden">
                <div class="row">
                    <div class="cardimg ps-0" style="width: 10rem; height: 7.5rem;">
                        <div class="d-flex justify-content-center overflow-hidden" style="height: 100%; width: 100%;">
                            <img src="resources/orderlist.png" class="card-img-top" style="height: 100%; width: auto;">
                        </div>
                    </div>
                    <div class="card-body" style="width: calc(100% - 12rem);">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="card-title fs-6 fw-bold" id="<?php echo ("ino_id" . $y) ?>"><?php echo $selected_data["order_id"]; ?></h5>
                                <span class="card-text text-secondary fw-bold">LKR. <?php echo $selected_data["total"]; ?>.00</span><br>
                                <span class="card-text text-success fw-bold"><?php echo $selected_num; ?> items</span><br>
                                <span class="card-text text-secondary fw-bold"><?php echo $selected_data["date_time"]; ?></span>
                            </div>
                            <div class="col-4">
                                <button class="btn-1 mt-2" onclick="window.location = '<?php echo ('viewOrder.php?id=' . $result_data['order_id']); ?>'">Details</button>
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
            <ul class="pagination pagination-md justify-content-center pointer">
                <li class="page-item">
                    <a class="page-link" onclick="historySort(<?php if ($page <= 1) { echo '#'; }else{ echo ($page - 1); } ?>);" aria-label="Previous">
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
                            <a class="page-link" onclick="historySort(<?php echo $x; ?>);"><?php echo $x; ?></a>
                        </li>
                    <?php
                    }else{
                ?>
                    <li class="page-item">
                        <a class="page-link" onclick="historySort(<?php echo $x; ?>);"><?php echo $x; ?></a>
                    </li>
                <?php
                    }
                }
                ?>

                <li class="page-item">
                    <a class="page-link" onclick="historySort(<?php if ($page >= $pages) { echo '#'; } else { echo ($page + 1); } ?>);" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

</div>

<?php


?>