<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | ShoFFee.net</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>

<body onload="selectCateHome('0');" class="d-body">
    <div class="container-fluid">
        <div class="row">
            <?php
            include "header.php";

            $category_rs = Database::search("SELECT * FROM `category`");
            $n = $category_rs->num_rows;

            ?>

            <div class="col-12 p-2 bg-pri">
                <div class="row">
                    <div class="col-6 col-md-8">
                        <h4 class="fw-bold pt-2" style="font-family: Arial;">Shop ON ShoFFee</h4>
                    </div>
                    <div class="col-6 col-md-4 d-flex justify-content-end">
                        <div class="col-8">
                            <div class="row pe-3">
                                <select name="" id="cat_sele" class=" form-select border-0" style="background-color: rgb(0, 255, 255, 0);" onchange="selectCateHome();">
                                    <option value="0">Select By Category</option>
                                    <?php
                                    for ($x = 0; $x < $n; $x++) {
                                        $cdata = $category_rs->fetch_assoc();
                                    ?>
                                        <option value="<?php echo ($cdata["category_id"]); ?>"><?php echo ($cdata["category"]); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="collapse filters-b" id="collapse2">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="row p-2">
                                <select id="ssub" class=" form-infield3">
                                    <option value="0">Select Sub Category</option>
                                    <?php
                                    $sub_cate_rs = Database::search("SELECT * FROM `sub_category`");
                                    $sub_cate_num = $sub_cate_rs->num_rows;

                                    for($y = 0; $y < $sub_cate_num; $y++){
                                        $sub_cate_data = $sub_cate_rs->fetch_assoc();
                                    ?>
                                    <option value="<?php echo $sub_cate_data["sub_category_id"] ?>" ><?php echo $sub_cate_data["sub_category_name"] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="row p-2">
                                <select id="sbrd" class=" form-infield3">
                                    <option value="0">Select Brand</option>
                                    <?php
                                    $brand_rs = Database::search("SELECT * FROM `brand`");
                                    $brand_num = $brand_rs->num_rows;

                                    for($z = 0; $z < $brand_num; $z++){
                                        $brand_data = $brand_rs->fetch_assoc();
                                    ?>
                                    <option value="<?php echo $brand_data["brand_id"] ?>" ><?php echo $brand_data["brand"] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="row p-2">
                                <select id="smdl" class=" form-infield3">
                                    <option value="0">Select Model</option>
                                    <?php
                                    $model_rs = Database::search("SELECT * FROM `model`");
                                    $model_num = $model_rs->num_rows;

                                    for($z = 0; $z < $model_num; $z++){
                                        $model_data = $model_rs->fetch_assoc();
                                    ?>
                                    <option value="<?php echo $model_data["model_id"] ?>" ><?php echo $model_data["model"] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 pb-2">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="row px-2">
                                <select id="scon" class=" form-infield3">
                                    <option value="0">Select Condition</option>
                                    <?php
                                    $condition_rs = Database::search("SELECT * FROM `condition`");
                                    $condition_num = $condition_rs->num_rows;

                                    for($z = 0; $z < $condition_num; $z++){
                                        $condition_data = $condition_rs->fetch_assoc();
                                    ?>
                                    <option value="<?php echo $condition_data["condition_id"] ?>" ><?php echo $condition_data["condition"] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="row px-2">
                                <input placeholder="Price From" class="form-infield3 px-3" id="ad_pf">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="row px-2">
                                <input placeholder="Price To" class="form-infield3 px-3" id="ad_pt">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 pb-2">
                    <div class="row">
                        <div class="col-9 col-lg-10">
                            <div class="row ps-2 pe-1">
                                <input placeholder="Search Here" class="form-infield4 px-3" id="ad_tt">
                            </div>
                        </div>
                        <div class="col-3 col-lg-2">
                            <div class="row ps-1 pe-2">
                                <button type="" id="" class="btn-1" onclick="advancedSearch();">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="d-flex justify-content-end">
                        <div class="row pe-0">
                            <a type="" class="btn4 bg-pri" href="#collapse2" data-bs-toggle="collapse" role="button" 
                            aria-expanded="false" aria-controls="collapse2">All Filters &nbsp;
                            <img src="icon-svg/filter.svg" style="height: 15px;"></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 pt-4" id="shopview">

            </div>

            <?php
            include "footer.php";
            ?>
            <script src="bootstrap.bundle.js"></script>
            <script src="script.js"></script>
        </div>
    </div>
</body>

</html>