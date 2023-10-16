<?php

require "connection.php";
session_start();
if(isset($_SESSION["admin"])){
    $admin = $_SESSION["admin"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products | ShoFFee</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class=" admin_bg text-white overflow-hidden" onload="loadOtherManages('cat');">

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
                                <div class="col-11 offset-1 mt-2 pointer" onclick="window.location = 'adminPanel.php'">
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
                                <div class="col-11 offset-1 mt-2 pointer active_nav" onclick="window.location = 'otherManagemets.php'">
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

                            <div class="col-12 overflow-hidden d-body">
                                <div class="row p-3 pt-2">

                                    <div class="col-12 mb-2 dash_border rounded bg-dark shadow_nav overflow-hidden admin-mng-prod1">
                                        <div class="row p-3 pb-0">
                                            <ul class="nav nav-tabs">
                                                <li class=" nav-item pointer" onclick="AdminOtherChange('cat');">
                                                    <a class="nav-link nav2 active" id="ad_cat_view">Categories</a>
                                                </li>
                                                <li class=" nav-item pointer" onclick="AdminOtherChange('sub');">
                                                    <a class="nav-link nav2" id="ad_sub_view">Sub Categories</a>
                                                </li>
                                                <li class=" nav-item pointer" onclick="AdminOtherChange('brd');">
                                                    <a class="nav-link nav2" id="ad_brd_view">Brands</a>
                                                </li>
                                                <li class=" nav-item pointer" onclick="AdminOtherChange('mdl');">
                                                    <a class="nav-link nav2" id="ad_mdl_view">Models</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-12">
                                            <div class="row p-3 pt-0">

                                                <div class="col-12 admin-mng-prod2" id="ad_other_view">

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- -------- Add Categories Modal ---------- -->

    <div class="modal" tabindex="-1" id="add_cate_adm" data-mdb-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content admin_bg">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeOtherModals('cat');"></button>
                </div>
                <div class="modal-body">
                    <label for="" class="form-label">Category Name</label>
                    <input type="text" class="form-infield4 white-75 ps-2" id="ad_cat_name">
                    <label for="" class="form-label">Password</label>
                    <input type="password" class="form-infield4 white-75 ps-2" id="ad_cat_pw">
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn7" onclick="admSaveCategory();">Save Category</button>
                </div>
            </div>
        </div>
    </div>

        <!-- -------- Add Sub Categories Modal ---------- -->

        <div class="modal" tabindex="-1" id="add_sub_adm" data-mdb-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content admin_bg">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  onclick="closeOtherModals('sub');"></button>
                </div>
                <div class="modal-body">
                    <label for="" class="form-label">Sub Category Name</label>
                    <input type="text" class="form-infield4 white-75 ps-2" id="ad_sub_name">
                    <label for="" class="form-label">Select Parent Category</label>
                    <select class="form-infield4 white-75 ps-2" id="ad_sltd_cat" style="background-color: rgb(44, 44, 44);">
                        <option value="0">Select Category</option>
                        <?php
                        $cate_rs = Database::search("SELECT * FROM category");
                        $cate_num = $cate_rs->num_rows;

                        for($x = 0; $x < $cate_num; $x++) {
                            $cate_data = $cate_rs->fetch_assoc();
                        ?>
                        <option value="<?php echo $cate_data["category_id"]; ?>"><?php echo $cate_data["category"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <label for="" class="form-label">Password</label>
                    <input type="password" class="form-infield4 white-75 ps-2" id="ad_sub_pw">
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn7" onclick="admSaveSubCategory();">Save Sub Category</button>
                </div>
            </div>
        </div>
    </div>

            <!-- -------- Add Brand Modal ---------- -->

            <div class="modal" tabindex="-1" id="add_brd_adm" data-mdb-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content admin_bg">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Add New Brand</h5>
                    <button type="button" onclick="closeOtherModals('brd');" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                </div>
                <div class="modal-body">
                    <label for="" class="form-label">Brand Name</label>
                    <input type="text" class="form-infield4 white-75 ps-2" id="ad_brd_name">
                    <label for="" class="form-label">Select Parent Sub Category</label>
                    <select class="form-infield4 white-75 ps-2" id="ad_sltd_bsub" style="background-color: rgb(44, 44, 44);">
                        <option value="0">Select Sub Category</option>
                        <?php
                        $sub_cate_rs = Database::search("SELECT * FROM sub_category");
                        $sub_cate_num = $sub_cate_rs->num_rows;

                        for($i = 0; $i < $sub_cate_num; $i++) {
                            $sub_cate_data = $sub_cate_rs->fetch_assoc();
                        ?>
                        <option value="<?php echo $sub_cate_data["sub_category_id"]; ?>"><?php echo $sub_cate_data["sub_category_name"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <label for="" class="form-label">Password</label>
                    <input type="password" class="form-infield4 white-75 ps-2" id="ad_brd_pw">
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn7" onclick="admSaveBrand();">Save Brand</button>
                </div>
            </div>
        </div>
    </div>

            <!-- -------- Add Model Modal ---------- -->

            <div class="modal" tabindex="-1" id="add_mdl_adm" data-mdb-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content admin_bg">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Add New Model</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  onclick="closeOtherModals('mdl');"></button>
                </div>
                <div class="modal-body">
                    <label for="" class="form-label">Model Name</label>
                    <input type="text" class="form-infield4 white-75 ps-2" id="ad_mdl_name">
                    <label for="" class="form-label">Select Parent Brand</label>
                    <select class="form-infield4 white-75 ps-2" id="ad_sltd_brd" style="background-color: rgb(44, 44, 44);">
                        <option value="0">Select Brand</option>
                        <?php
                        $brand_rs = Database::search("SELECT * FROM brand");
                        $brand_num = $brand_rs->num_rows;

                        for($y = 0; $y < $brand_num; $y++) {
                            $brand_data = $brand_rs->fetch_assoc();
                        ?>
                        <option value="<?php echo $brand_data["brand_id"]; ?>"><?php echo $brand_data["brand"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <label for="" class="form-label">Select Parent Sub Category</label>
                    <select class="form-infield4 white-75 ps-2" id="ad_sltd_sub" style="background-color: rgb(44, 44, 44);">
                        <option value="0">Select Sub Category</option>
                        <?php
                        $sub_rs = Database::search("SELECT * FROM sub_category");
                        $sub_num = $sub_rs->num_rows;

                        for($z = 0; $z < $sub_num; $z++) {
                            $sub_data = $sub_rs->fetch_assoc();
                        ?>
                        <option value="<?php echo $sub_data["sub_category_id"]; ?>"><?php echo $sub_data["sub_category_name"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <label for="" class="form-label">Password</label>
                    <input type="password" class="form-infield4 white-75 ps-2" id="ad_mdl_pw">
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn7" onclick="admSaveModel();">Save Model</button>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>

<?php

}else{
    header("location:adminSignin.php");
}

?>