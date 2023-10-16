<?php
require "connection.php";
session_start();

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
    $email = $user["email"];
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Profile | ShoFFee.net</title>
        <link rel="stylesheet" href="bootstrap.css">
        <link rel="stylesheet" href="style.css">
    </head>

    <body class="d-body" onload="selectCity();">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 prof-header" style="z-index: 1;">
                    <div class="row mt-2 mt-md-0">
                        <div class="col-4 py-2 ps-3">
                            <div class="col-12 mp-logo ms-1 mt-lg-1 pointer" onclick="window.location='home.php'"></div>
                        </div>
                        <div class="col-4 text-center py-3">
                            <h4 class="fw-bold">My Profile</h4>
                        </div>
                        <div class="col-4 py-2">
                            <div class="col-12 dropdown d-flex justify-content-end">
                                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    My eShop
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="home.php">Home</a></li>
                                    <li><a class="dropdown-item" href="myProfile.php">My Profile</a></li>
                                    <li><a class="dropdown-item" href="addProduct.php">Sell On ShoFFee</a></li>
                                    <li><a class="dropdown-item" href="myListings.php">My Listings</a></li>
                                    <li><a class="dropdown-item" href="purchasehistory.php">Purchase History</a></li>
                                    <li><a class="dropdown-item" href="chat.php">Message</a></li>
                                    <li><a class="dropdown-item" href="wishlist.php">Wishlist</a></li>
                                    <li><a class="dropdown-item" href="cart.php">Cart</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <?php

                $user_rs = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON 
           user.gender_id=gender.gender_id WHERE `email`='" . $email . "'");

                $image_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $email . "'");

                $address_rs = Database::search("SELECT * FROM `user_has_user_address` INNER JOIN `user_address` ON 
           user_has_user_address.user_address_id=user_address.address_id INNER JOIN `city` ON 
           user_address.city_id=city.city_id INNER JOIN `district` ON 
           city.district_id=district.district_id WHERE `user_email`='" . $email . "'");

                $user_data = $user_rs->fetch_assoc();
                $image_data = $image_rs->fetch_assoc();
                $address_data = $address_rs->fetch_assoc();

                ?>

                <div class="col-12 prof-body">
                    <div class="col-12" style="padding: 0;">
                        <div class="col-12 border border-dark border-opacity-50 rounded overflow-hidden">

                            <div class="col-12 hder-sm bg-secondary bg-opacity-10">
                                <div class="row">

                                    <div class="col-8 ps-5 py-4">
                                        <span class="fw-bold"><?php echo ($user["fname"] . " " . $user["lname"]); ?></span><br>
                                        <span class=" text-black-50"><?php echo ($user["email"]); ?></span><br>
                                        <span class="text-success"><?php if ($user["status"] == 1) {
                                                                        echo ("Active");
                                                                    } else {
                                                                        echo ("Deactive");
                                                                    }  ?></span>
                                    </div>
                                    <div class="col-4 pt-1">
                                        <div class="row">
                                            <div class="col-12 pt-2">
                                                <button class="col-10 col-lg-4 offset-0 offset-lg-7 btn-1 btn-2 fw-bold my-4" onclick="logout();">Log Out</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <?php
                            $pro_img_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $email . "'");
                            $pro_img_num = $pro_img_rs->num_rows;

                            if ($pro_img_num > 0) {
                                $pro_img_data = $pro_img_rs->fetch_assoc();

                                $path = $pro_img_data["user_image_path"];
                            } else {
                                if ($user_data["gender_id"] == 1) {
                                    $path = "resources/user_male.jpg";
                                } else {
                                    $path = "resources/user_female.jpg";
                                }
                            } 
                            ?>

                            <div class="col-12 py-4 px-5 ps-lg-0">
                                <div class="row g-2">

                                    <div class="col-12 col-lg-4 mt-lg-4 pb-2">
                                        <div class="col-12 d-flex justify-content-center">
                                            <div class="pro-img-box2">
                                                <img src="<?php echo $path; ?>" class="col-12" id="proImgView">
                                            </div>
                                        </div>
                                        <div class="col-8 offset-2 col-lg-10 offset-lg-1 mt-3 px-3">
                                            <input type="file" id="proimgbtn" class="d-none">
                                            <label for="proimgbtn" class="col-12 col-lg-8 offset-lg-2 profUpBtn d-flex justify-content-center" onclick="viewProImg();">Change Profile Picture</label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-8 py-2">
                                        <div class="row">

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <label class="form-lable">First Name</label><br>
                                                        <input type="text" class="form-infield" value="<?php echo ($user_data["fname"]); ?>" id="fn">
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <label class="form-lable">Last Name</label><br>
                                                        <input type="text" class="form-infield" value="<?php echo ($user_data["lname"]); ?>" id="ln">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-lable">Email</label><br>
                                                <input type="text" class="form-infield" disabled value="<?php echo ($user_data["email"]); ?>">
                                            </div>

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <label class="form-lable">Password</label><br>
                                                        <input type="text" class="form-infield" disabled value="<?php echo ($user_data["password"]); ?>">
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <label class="form-lable">Joined Date</label><br>
                                                        <input type="text" class="form-infield" disabled value="<?php echo ($user_data["regitred_date"]); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <label class="form-lable">Mobile</label><br>
                                                        <input type="text" class="form-infield" value="<?php echo ($user_data["mobile"]); ?>" id="mb">
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <label class="form-lable">Office</label><br>
                                                        <input type="text" class="form-infield" value="<?php echo ($user_data["office"]); ?>" id="of">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-lable">Address No.</label><br>
                                                <input type="text" class="form-infield" value="<?php if (!empty($address_data)) {
                                                                                                    echo ($address_data["address_no"]);
                                                                                                } ?>" id="no">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-lable">Address Line 1</label><br>
                                                <input type="text" class="form-infield" value="<?php if (!empty($address_data)) {
                                                                                                    echo ($address_data["line_1"]);
                                                                                                } ?>" id="l1">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-lable">Address Line 2</label><br>
                                                <input type="text" class="form-infield" value="<?php if (!empty($address_data)) {
                                                                                                    echo ($address_data["line_2"]);
                                                                                                } ?>" id="l2">
                                            </div>

                                            <?php
                                            $discrict_rs = Database::search("SELECT * FROM `district`");
                                            $dist_num = $discrict_rs->num_rows;

                                            // $city_rs = Database::search("SELECT * FROM `city`");
                                            // $city_num = $city_rs->num_rows;
                                            ?>

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <label class="form-lable">District</label><br>
                                                        <select name="" id="dt" class="form-infield" onchange="selectCity();">
                                                            <option value="0">Select District</option>
                                                            <?php
                                                            for ($x = 0; $x < $dist_num; $x++) {
                                                                $dist_data = $discrict_rs->fetch_assoc();
                                                            ?>
                                                                <option value="<?php echo ($dist_data["district_id"]); ?>" <?php
                                                                                                                            if (!empty($address_data["district_id"])) {
                                                                                                                                if ($address_data["district_id"] == $dist_data["district_id"]) {
                                                                                                                            ?> selected <?php
                                                                                                                                    }
                                                                                                                                }
                                                                                                                                        ?>> <?php
                                                                                echo ($dist_data["district_name"]);
                                                                                ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <label class="form-lable">City</label><br>
                                                        <select name="" id="ct" class="form-infield">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <label class="form-lable">Postal Code</label><br>
                                                        <input type="text" class="form-infield" id="pc" value="<?php if (!empty($address_data)) {
                                                                                                                    echo ($address_data["postal_code"]);
                                                                                                                } ?>">
                                                    </div>

                                                    <div class="col-12 col-lg-6">
                                                        <label class="form-lable">Gender</label><br>
                                                        <input type="text" class="form-infield" disabled value="<?php echo ($user_data["gender_name"]); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button class="col-12 mt-3 btn-1" onclick="updateProfile();">Save Changes</button>
                                            </div>

                                        </div>
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

        <script src="bootstrap.js"></script>
        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>

    </html>

<?php

} else {
    header("Location:http://localhost/shoffee/home.php");
}
?>