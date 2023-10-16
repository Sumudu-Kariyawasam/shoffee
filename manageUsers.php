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
    <title>Manage Products | ShoFFee</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="admin_bg text-white overflow-hidden" onload="adminAllUsers('1','all');">

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
                                <div class="col-11 offset-1 mt-2 pointer active_nav" onclick="window.location = 'manageUsers.php'">
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

                            <div class="col-12 overflow-hidden d-body">
                                <div class="row p-3 pt-2">

                                    <div class="col-12 mb-2 dash_border rounded bg-dark shadow_nav overflow-hidden admin-mng-prod1">
                                        <div class="row p-3 pb-0">
                                            <ul class="nav nav-tabs">
                                                <li class=" nav-item pointer" onclick="AdminUSerChange('all');">
                                                    <a class="nav-link nav2 active" id="tabU1">All Users</a>
                                                </li>
                                                <li class=" nav-item pointer" onclick="AdminUSerChange('act');">
                                                    <a class="nav-link nav2" id="tabU2">Active</a>
                                                </li>
                                                <li class=" nav-item pointer" onclick="AdminUSerChange('dct');">
                                                    <a class="nav-link nav2" id="tabU3">Deactive</a>
                                                </li>
                                                <li class=" nav-item pointer" onclick="AdminUSerChange('dlt');">
                                                    <a class="nav-link nav2" id="tabU4">Deleted</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-12">
                                            <div class="row p-3 pt-0">

                                                <div class="collapse filters-b" id="collapse2">
                                                    <div class="col-12 pb-0 pb-lg-2 mt-3">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="row px-2">
                                                                    <input type="text" placeholder="Search with First Name" class="form-infield3 px-3" id="adm_usr_fn">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="row px-2">
                                                                    <input type="text" placeholder="Search with Last Name" class="form-infield3 px-3" id="adm_usr_ln">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 pb-0 pb-lg-2">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="row px-2">
                                                                    <input type="date" placeholder="Registered Date From" class="form-infield3 px-3" id="adm_usr_df">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="row px-2">
                                                                    <input type="date" placeholder="Registered Date To" class="form-infield3 px-3" id="adm_usr_dt">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 py-2">
                                                        <div class="row">
                                                            <div class="col-12 col-lg-7">
                                                                <div class="row px-2">
                                                                    <input type="email" id="adm_usr_em" class=" form-infield3 bg-dark" placeholder="Search with Email">
                                                                </div>
                                                            </div>
                                                            <div class="col-6 col-lg-3">
                                                                <div class="row px-2">
                                                                    <select type="text" class="form-infield4 bg-dark" id="adu_sort_time">
                                                                        <option value="0">Sort By Time</option>
                                                                        <option value="1">Newest First</option>
                                                                        <option value="2">Oldest First</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 col-lg-2">
                                                                <div class="row ps-1 pe-2">
                                                                    <button type="" id="" class="btn-6" onclick="adminAllUsers('1','get');">Search</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <div class="row">
                                                        <div class="d-flex justify-content-end">
                                                            <div class="row">
                                                                <a type="" class="btn5 bg-pri" href="#collapse2" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse2">All Filters &nbsp;
                                                                    <img src="icon-svg/filter.svg" style="height: 15px;"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 overflow-y admin-mng-prod2" id="ad_all_usr_view">

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

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>



