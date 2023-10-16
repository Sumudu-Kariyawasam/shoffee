<?php
require "connection.php";

$umail = $_POST["em"];
$fname = $_POST["fn"];
$lname = $_POST["ln"];
$date_f = $_POST["df"];
$date_t = $_POST["dt"];
$type = $_POST["type"];
$time = $_POST["tm"];

$quary = "SELECT * FROM `user` INNER JOIN `gender` ON gender.gender_id=user.gender_id 
INNER JOIN `status` ON status.status_id=user.status";

if ($type == "all") {
    $quary .= " WHERE user.status <= 3";
} else if ($type == "act") {
    $quary .= " WHERE user.status = 1";
} else if ($type == "dct") {
    $quary .= " WHERE user.status = 2";
} else if ($type == "dlt") {
    $quary .= " WHERE user.status = 3";
}

if (!empty($umail)) {
    $quary .= " AND email LIKE '%" . $umail . "%'";
}
if (!empty($fname)) {
    $quary .= " AND fname LIKE '%" . $fname . "%'";
}
if (!empty($lname)) {
    $quary .= " AND lname LIKE '%" . $lname . "%'";
}

if (!empty($date_f) && !empty($date_t)) {
    $quary .= " AND `regitred_date` BETWEEN '" . $date_f . "' AND '" . $date_t . "'";
} else if (!empty($date_f) && empty($date_t)) {
    $quary .= " AND `regitred_date` > '" . $date_f . "'";
} else if (empty($date_f) && !empty($date_t)) {
    $quary .= " AND `regitred_date` < '" . $date_t . "'";
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
        $quary .= " ORDER BY `regitred_date` DESC";
    } else {
        $quary .= " ORDER BY `regitred_date` ASC";
    }
    $quary .= " LIMIT " . $results_per_page . " OFFSET " . $skip . "";
}

$user_rs = Database::search($quary);
$user_num = $user_rs->num_rows;

if ($user_num > 0) {

?>

    <div class="row pe-2">

        <!--  product view  -->

        <?php
        for ($i = 0; $i < $user_num; $i++) {
            $user_data = $user_rs->fetch_assoc();

            $user_img_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $user_data["email"] . "'");
            $user_img_data = $user_img_rs->fetch_assoc();

            if (isset($user_img_data["user_image_path"])) {
                $path = $user_img_data["user_image_path"];
            } else {
                if ($user_data["gender_id"] == "1") {
                    $path = "resources/user_male.jpg";
                } else if ($user_data["gender_id"] == "2") {
                    $path = "resources/user_female.jpg";
                }
            }

            $address_rs = Database::search("SELECT * FROM `user_has_user_address` 
            INNER JOIN `user_address` ON user_address.address_id=user_has_user_address.user_address_id 
            INNER JOIN `city` ON city.city_id=user_address.city_id 
            INNER JOIN `district` ON city.district_id=district.district_id WHERE `user_email`='" . $user_data["email"] . "'");
            $address_data = $address_rs->fetch_assoc();

        ?>

            <div class="col-12 border border-light border-opacity-50 rounded mb-2 admin_bg p-3">
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <span class=""><?php echo ($user_data["fname"] . " " . $user_data["lname"]); ?></span><br>
                        <span class="t-pri"><?php echo ($user_data["email"]); ?></span>
                    </div>
                    <div class="col-6 col-lg-2">
                        <span class="">Joined</span><br>
                        <span class=""><?php echo ($user_data["regitred_date"]); ?></span>
                    </div>
                    <div class="col-6 col-lg-2">
                        <span class="">Status</span><br>
                        <span id="<?php echo ("status_ua".$user_data["mobile"]) ?>" class="<?php if ($user_data["status"] == 1) {
                                            echo "t-suc";
                                        } else if ($user_data["status"] == 2) {
                                            echo "text-warning";
                                        } else if ($user_data["status"] == 3) {
                                            echo "t-dng";
                                        } ?>"><?php echo ($user_data["status_name"]); ?></span>
                    </div>
                    <div class="col-12 col-lg-3">
                        <button class="btn-1 m-0 mt-2 tm-lg-1 mb-3 mb-lg-0 text-white" data-bs-toggle="collapse" type="button" data-bs-target="<?php echo ("#apro_collapse" . $i); ?>" aria-expanded="false" aria-controls="<?php echo ("apro_collapse" . $i); ?>">Manage Users</button>
                    </div>
                </div>
                <div class="collapse" id="<?php echo ("apro_collapse" . $i) ?>">
                    <div class="col-12 py-3">
                        <div class="row">
                            <div class="col-12 col-lg-10">
                                <div class="row">
                                    <span class="fw-bold mb-2">Address Details</span>
                                    <div class="col-3">
                                        <span class="">No</span><br>
                                        <span class="">Line 1</span><br>
                                        <span class="">Line 2</span><br>
                                        <span class="">City</span><br>
                                        <span class="">Postal Code</span><br>
                                        <span class="">District</span><br>
                                    </div>
                                    <div class="col-3">
                                        <span class=""><?php if (isset($address_data["address_no"])) {
                                                            echo ($address_data["address_no"]);
                                                        } ?></span><br>
                                        <span class=""><?php if (isset($address_data["line_1"])) {
                                                            echo ($address_data["line_1"]);
                                                        } ?></span><br>
                                        <span class=""><?php if (isset($address_data["line_2"])) {
                                                            echo ($address_data["line_2"]);
                                                        } ?></span><br>
                                        <span class=""><?php if (isset($address_data["city_name"])) {
                                                            echo ($address_data["city_name"]);
                                                        } ?></span><br>
                                        <span class=""><?php if (isset($address_data["postal_code"])) {
                                                            echo ($address_data["postal_code"]);
                                                        } ?></span><br>
                                        <span class=""><?php if (isset($address_data["district_name"])) {
                                                            echo ($address_data["district_name"]);
                                                        } ?></span><br>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="row">
                                            <span class="fw-bold mb-2">Personal Details</span>
                                            <div class="col-6">
                                                <span class="">DOB</span><br>
                                                <span class="">Joined date</span><br>
                                                <span class="">Gender</span><br>
                                                <span class="">Mobile</span><br>
                                                <span class="">Office</span><br>
                                            </div>
                                            <div class="col-5">
                                                <span class=""><?php if (isset($user_data["dob"])) {
                                                                    echo ($user_data["dob"]);
                                                                } ?></span><br>
                                                <span class=""><?php echo ($user_data["regitred_date"]); ?></span><br>
                                                <span class=""><?php echo ($user_data["gender_name"]); ?></span><br>
                                                <span class=""><?php if (isset($user_data["mobile"])) {
                                                                    echo ($user_data["mobile"]);
                                                                } ?></span><br>
                                                <span class=""><?php if (isset($user_data["office"])) {
                                                                    echo ($user_data["office"]);
                                                                } ?></span><br>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $total_sold = 0;
                                    $total_qty = 0;
                                    $total_earning = 0;

                                    $prod_rs2 = Database::search("SELECT * FROM `product` WHERE `user_email`='" . $user_data["email"] . "' AND `status`='1'");
                                    $prod_num2 = $prod_rs2->num_rows;

                                    $prod_rs = Database::search("SELECT * FROM `product` WHERE `user_email`='" . $user_data["email"] . "'");
                                    $prod_num = $prod_rs->num_rows;

                                    for ($t = 0; $t < $prod_num; $t++) {
                                        $prod_data = $prod_rs->fetch_assoc();

                                        $sold_rs = Database::search("SELECT * FROM `invoice` WHERE `product_id`='" . $prod_data['product_id'] . "'");
                                        $sold_num = $sold_rs->num_rows;

                                        $total_earn = Database::search("SELECT AVG(total) AS `earn` FROM `invoice` WHERE `product_id`='" . $prod_data['product_id'] . "'");
                                        $total_earn2 = $total_earn->fetch_assoc();

                                        $total_earning = ($total_earning + $total_earn2["earn"]);

                                        $total_qty = $total_qty + $sold_num;

                                        for ($z = 0; $z < $sold_num; $z++) {
                                            $sold_data = $sold_rs->fetch_assoc();

                                            $total_sold = ($total_sold + $sold_data["invoice_qty"]);
                                        }
                                    }
                                    ?>

                                    <div class="col-12 col-lg-6">
                                        <div class="row">
                                            <span class="fw-bold mb-2">Product Deatils</span>
                                            <div class="col-6">
                                                <span class="">All Listed Products</span><br>
                                                <span class="">Active Products</span><br>
                                                <span class="">Total Sold</span><br>
                                                <span class="">Avarage Earning</span><br>
                                            </div>
                                            <div class="col-6">
                                                <span class=""><?php echo $prod_num; ?></span><br>
                                                <span class=""><?php echo $prod_num2; ?></span><br>
                                                <span class=""><?php echo $total_sold; ?></span><br>
                                                <span class=""><?php echo $total_earning; ?></span><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12 col-lg-6 <?php if ($user_data["status"] == 3) { echo ("d-none"); } ?>">
                                                <div class="form-check form-switch ms-4 pt-3 <?php if ($user_data["status"] == 3) {
                                                                                                    echo "d-none";
                                                                                                } ?>">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="aod<?php echo $i; ?>" onclick="changeStatusUser('<?php echo $user_data['email']; ?>','<?php echo $user_data['mobile']; ?>');" <?php if ($user_data["status"] == 1) {
                                                                                                                                                                                                                    echo "checked";
                                                                                                                                                                                                                } ?> /> &nbsp;

                                                    <label class="form-check-label <?php if ($user_data["status"] == 1) {
                                                                                        echo "t-dng";
                                                                                    } else if ($user_data["status"] == 2) {
                                                                                        echo "t-suc";
                                                                                    } ?>" for="aod<?php echo $i; ?>" id="<?php echo ('status_up' . $user_data["mobile"]); ?>">
                                                        <?php if ($user_data["status"] == 1) {
                                                            echo "Make this User Dectivated";
                                                        } else if ($user_data["status"] == 2) {
                                                            echo "Make this User Activated";
                                                        } ?>
                                                    </label>

                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <button class="btn-1 text-white" onclick="window.location = '<?php echo ('productOfUser.php?em=' . $user_data['email']); ?>'">View Products of User</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2 mt-3 mt-lg-0">
                                <div class="border border-light rounded overflow-hidden" style="height: 80px; width: 80px;">
                                    <img src="<?php echo $path; ?>" style="height: 78px; width: 78px;">
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
                    <a class="page-link" onclick="adminAllUsers('<?php if ($page <= 1) { echo '1'; } else { echo ($page - 1); } ?>');" aria-label="Previous">
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
                            <a class="page-link" onclick="adminAllUsers('<?php echo ($x); ?>');"><?php echo $x; ?></a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item">
                            <button class="page-link" onclick="adminAllUsers('<?php echo ($x); ?>');" <?php if ($x > $pages) { echo "disabled"; } ?>><?php echo $x; ?></button>
                        </li>
                <?php
                    }
                }
                ?>

                <li class="page-item">
                    <a class="page-link" onclick="adminAllUsers('<?php if ($page >= $pages) { echo $pages; } else { echo ($page + 1); } ?>');" aria-label="Next">
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