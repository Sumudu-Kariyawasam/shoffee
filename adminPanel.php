<?php

require "connection.php";
session_start();
$admin = $_SESSION["admin"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | ShoFFee</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="admin_bg text-white">

    <div class="container-fluid">
        <div class="row contain2">

            <div class="col-12" style="min-height: 100vh;">
                <div class="row" style="height: 100%;">

                    <div class="col-10 col-lg-3 bg-dark position-absolute shadow_nav admin_nav nav_close" id="nav_menu_box">
                        <div class="row">
                            <div class="col-12 p-3 ps-2 pb-2 border-bottom border-light border-opacity-50">
                                <img src="images/logo2.png" style="height: 40px;"><br>
                                <div class="col-12 d-flex justify-content-between">
                                    <span class="ps-2">Admin Control Panel</span>
                                    <button class="btn-nav-close fw-bold d-lg-none" onclick="closeNavMenu();">Close</button>
                                </div>
                            </div>
                            <div class="col-12 p-0 mt-3">
                                <div class="col-11 offset-1 mt-2 pointer active_nav" onclick="window.location = 'adminPanel.php'">
                                    <div class="row py-2 ps-3">
                                        <span>Dashboard</span>
                                    </div>
                                </div>
                                <div class="col-11 offset-1 mt-2 pointer" onclick="window.location = 'manageOrders.php'">
                                    <div class="row py-2 ps-3">
                                        <span>Manage Orders</span>
                                    </div>
                                </div>
                                <div class="col-11 offset-1 mt-2 pointer" onclick="window.location = 'manageProducts.php'">
                                    <div class="row py-2 ps-3">
                                        <span>Manage Products</span>
                                    </div>
                                </div>
                                <div class="col-11 offset-1 mt-2 pointer" onclick="window.location = 'manageUsers.php'">
                                    <div class="row py-2 ps-3">
                                        <span>Manage Users</span>
                                    </div>
                                </div>
                                <div class="col-11 offset-1 mt-2 pointer" onclick="window.location = 'otherManagemets.php'">
                                    <div class="row py-2 ps-3">
                                        <span>Other Managements</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 bg-dark d-lg-none shadow_nav">
                        <div class="row py-3">
                            <div class="col-2">
                                
                            </div>
                            <div class="col-8 text-center">
                                <span class="fs-5">Admin Panel</span>
                            </div>
                            <div class="col-2 d-flex justify-content-end pe-4">
                                <img src="images/menu_white.png" style="height: 25px; width: 25px;" onclick="showNavMenu();">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-9 offset-lg-3 p-4">
                        <div class="row">

                            <div class="col-12">
                                <div class="row">

                                    <?php
                                    $users_rs = Database::search("SELECT * FROM `user` WHERE `status`='1'");
                                    $users_num = $users_rs->num_rows;
                                    ?>

                                    <div class="col-12 col-lg-4 px-3 dash-height">
                                        <div class="row py-3 text-center dash_border rounded bg-dark shadow_nav">
                                            <span class="nav_fw fs-5 dash_tx_blue"><?php echo $users_num; ?></span>
                                            <span class="mb-2">Active Users, Worldwide</span>
                                            <span class="nav_fw dash_tx_green fs-5"><?php echo (rand(1, $users_num)); ?></span>
                                            <span class="dash_tx_green">Users Online Now</span>
                                        </div>
                                    </div>

                                    <?php
                                    $product_rs = Database::search("SELECT * FROM `product`");
                                    $product_num = $product_rs->num_rows;
                                    ?>

                                    <div class="col-12 col-lg-4 px-3 dash-height">
                                        <div class="row py-3 text-center dash_border rounded bg-dark shadow_nav">
                                            <span class="nav_fw fs-5 dash_tx_blue"><?php echo $product_num; ?></span>
                                            <span class="mb-2">Active Listings</span>
                                            <span class="nav_fw dash_tx_red fs-5"><?php echo (rand(1, ($product_num / 2))); ?></span>
                                            <span class="dash_tx_red">Pending Listings</span>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-4 px-3 dash-height">
                                        <div class="row py-3 text-center dash_border rounded bg-dark shadow_nav">
                                            <span class="nav_fw fs-5 dash_tx_blue">837</span>
                                            <span class="mb-2">Total Visits Today</span>
                                            <span class="nav_fw dash_tx_green fs-5">112</span>
                                            <span class="dash_tx_green">Total Visitors Today</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $d = new DateTime();
                            $start_date = $d->format('Y-m')."-1 00:00:00";
                            $end_date = date('Y-m')."-31 23:59:59";
                            $last_month = date('Y-m');

                            $sold_items_rs = Database::search("SELECT SUM(invoice_qty) AS `sold` FROM `invoice` WHERE `date_time` BETWEEN '" . $start_date . "' AND '" . $end_date . "'");
                            $sold_items_data = $sold_items_rs->fetch_assoc();
                            ?>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-lg-6 px-3 dash-height">
                                        <div class="row py-3 text-center dash_border rounded bg-dark shadow_nav">
                                            <span class="nav_fw fs-5 dash_tx_blue"><?php echo $sold_items_data['sold']; ?></span>
                                            <span class="mb-2">Items Sold In This Month</span>
                                            <span class="nav_fw dash_tx_red fs-5">0</span>
                                            <span class="dash_tx_red">Items Returned</span>
                                        </div>
                                    </div>
                                    <?php
                                    $income = 0;
                                    $income_rs = Database::search("SELECT DISTINCT `order_id` FROM `invoice` WHERE `date_time` BETWEEN '" . $start_date . "' AND '" . $end_date . "'");
                                    $income_num = $income_rs->num_rows;

                                    for ($y = 0; $y < $income_num; $y++) {
                                        $income_data = $income_rs->fetch_assoc();

                                        $income_rs2 = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $income_data["order_id"] . "'");
                                        $income_data2 = $income_rs2->fetch_assoc();

                                        $income = $income + $income_data2["total"];
                                    }
                                    ?>

                                    <div class="col-12 col-lg-6 px-3 dash-height">
                                        <div class="row py-3 text-center dash_border rounded bg-dark shadow_nav">
                                            <span class="nav_fw fs-5 dash_tx_blue">Rs <?php echo $income; ?></span>
                                            <span class="mb-2">Total Income In This Month</span>
                                            <span class="nav_fw dash_tx_green fs-5">Rs <?php echo ceil(($income * 5) / 100); ?></span>
                                            <span class="dash_tx_green">Total Profit In This Month</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $dt = new DateTime();
                            $today = $dt->format('Y-m-d');
                            $day_start = $today . " 00:00:00";
                            $day_end = $today . " 23:59:59";

                            $listing_rs = Database::search("SELECT * FROM `product` WHERE `datetime_added` BETWEEN '" . $day_start . "' AND '" . $day_end . "'");
                            $listing_num = $listing_rs->num_rows;

                            $new_users_rs = Database::search("SELECT * FROM `user` WHERE `regitred_date` BETWEEN '" . $day_start . "' AND '" . $day_end . "'");
                            $new_users_num = $new_users_rs->num_rows;
                            ?>

                            <div class="col-12 px-3 dash-height">
                                <div class="row dash_border rounded bg-dark shadow_nav pb-3 px-3">
                                    <span class="py-3 ps-3 fs-5" style="color: rgb(200, 200, 200);">Additional Informations</span>
                                    <hr>
                                    <div class="col-12 <?php if($listing_num > 0){ echo ("dash_tx_green"); }else{ echo ("dash_tx_red"); } ?>">
                                        <span style="font-size: 13px;">Today New Listings :</span> &nbsp;
                                        <span style="font-size: 13px;"><?php echo $listing_num; ?> Products</span>
                                    </div>
                                    <div class="col-12 <?php if($new_users_num > 0){ echo ("dash_tx_green"); }else{ echo ("dash_tx_red"); } ?>">
                                        <span style="font-size: 13px;">Today New Registrations :</span> &nbsp;
                                        <span style="font-size: 13px;"><?php echo $new_users_num; ?> Users</span>
                                    </div>

                                    <?php
                                    $listing_rs2 = Database::search("SELECT * FROM `product` WHERE `datetime_added` BETWEEN '" . $start_date . "' AND '" . $end_date . "'");
                                    $listing_num2 = $listing_rs2->num_rows;

                                    $new_users_rs2 = Database::search("SELECT * FROM `user` WHERE `regitred_date` BETWEEN '" . $start_date . "' AND '" . $end_date . "'");
                                    $new_users_num2 = $new_users_rs2->num_rows;
                                    ?>

                                    <div class="col-12 mt-3 <?php if($listing_num2 > 0){ echo ("dash_tx_green"); }else{ echo ("dash_tx_red"); } ?>">
                                        <span style="font-size: 13px;">Total New Listings This Month :</span> &nbsp;
                                        <span style="font-size: 13px;"><?php echo $listing_num2; ?> Products</span>
                                    </div>
                                    <div class="col-12 <?php if($new_users_num2 > 0){ echo ("dash_tx_green"); }else{ echo ("dash_tx_red"); } ?>">
                                        <span style="font-size: 13px;">Total New Registrations This Month :</span> &nbsp;
                                        <span style="font-size: 13px;"><?php echo $new_users_num2; ?> Users</span>
                                    </div>

                                    <?php
                                    $listing_rs3 = Database::search("SELECT * FROM `product` WHERE `datetime_added` BETWEEN '" . $last_month . "' AND '" . $start_date . "'");
                                    $listing_num3 = $listing_rs3->num_rows;

                                    $new_users_rs3 = Database::search("SELECT * FROM `user` WHERE `regitred_date` BETWEEN '" . $last_month . "' AND '" . $start_date . "'");
                                    $new_users_num3 = $new_users_rs3->num_rows;
                                    ?>

                                    <div class="col-12 mt-3 <?php if($listing_num3 > 0){ echo ("dash_tx_green"); }else{ echo ("dash_tx_red"); } ?>">
                                        <span style="font-size: 13px;">Total New Listings Last Month :</span> &nbsp;
                                        <span style="font-size: 13px;"><?php echo $listing_num3; ?> Products</span>
                                    </div>
                                    <div class="col-12 <?php if($new_users_num3 > 0){ echo ("dash_tx_green"); }else{ echo ("dash_tx_red"); } ?>">
                                        <span style="font-size: 13px;">Total New Registrations Last Month :</span> &nbsp;
                                        <span style="font-size: 13px;"><?php echo $new_users_num3; ?> Users</span>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>