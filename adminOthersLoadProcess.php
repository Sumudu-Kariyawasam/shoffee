<?php

require "connection.php";

if (isset($_POST['view'])) {
    $View = $_POST["view"];

    if ($View == "cat") {

?>

        <div class="row mt-4">
            <div class="col-12 col-md-6">
                <div class="col-12 border border-light border-opacity-50 rounded mb-2 admin_bg pointer" onclick="addNewCategory();">
                    <div class="row p-3 t-pri">
                        <span class="ps-3">Add New Category +</span>
                    </div>
                </div>
            </div>
            <div class="col-12 my-3">
                <div class="row px-0">
                    <span class="fs-6 mb-3">All Categories</span>

                    <div class="col-12">
                        <div class="row overflow-y" style="max-height: calc(100vh - 270px);">

                            <?php

                            $cate_rs = Database::search("SELECT * FROM `category`");
                            $cate_num = $cate_rs->num_rows;

                            for ($x = 0; $x < $cate_num; $x++) {
                                $cate_data = $cate_rs->fetch_assoc();
                            ?>

                                <div class="col-12 col-md-6">
                                    <div class="col-12 p-3 border border-light border-opacity-50 rounded mb-2 admin_bg">
                                        <div class="row">
                                            <div class="col-10">
                                                <span class="ps-0"><?php echo $cate_data["category"] ?></span>
                                            </div>
                                            <div class="col-2 pe-3 d-flex justify-content-between pointer" onclick="admDeleteCategory(<?php echo $cate_data['category_id']; ?>);">
                                                <span class="">|</span>
                                                <span class="t-dng">Trash</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php

                            }

                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php

    } else if ($View == "sub") {

    ?>

        <div class="row mt-4">
            <div class="col-12 col-md-6">
                <div class="col-12 border border-light border-opacity-50 rounded mb-2 admin_bg pointer" onclick="addNewSubCategory();">
                    <div class="row p-3 t-pri">
                        <span class="ps-3">Add New Sub Category +</span>
                    </div>
                </div>
            </div>
            <div class="col-12 my-3">
                <div class="row px-0">
                    <span class="fs-6 mb-3">All Sub Categories</span>

                    <div class="col-12">
                        <div class="row overflow-y" style="max-height: calc(100vh - 270px);">

                            <?php

                            $sub_cate_rs = Database::search("SELECT * FROM `sub_category` 
                            INNER JOIN `category_has_sub_category` ON category_has_sub_category.sub_category_id=sub_category.sub_category_id 
                            INNER JOIN `category` ON category.category_id=category_has_sub_category.category_id ORDER BY category.category_id ASC");
                            $sub_cate_num = $sub_cate_rs->num_rows;

                            for ($y = 0; $y < $sub_cate_num; $y++) {
                                $sub_cate_data = $sub_cate_rs->fetch_assoc();
                            ?>

                                <div class="col-12 col-md-6">
                                    <div class="col-12 p-3 border border-light border-opacity-50 rounded mb-2 admin_bg">
                                        <div class="row">
                                            <div class="col-10">
                                                <span class="ps-0"><?php echo $sub_cate_data["sub_category_name"] ?></span>
                                                <span class="tx-mute">(<?php echo $sub_cate_data["category"] ?>)</span>
                                            </div>
                                            <div class="col-2 pe-3 d-flex justify-content-between pointer" onclick="admDeleteSubCategory('<?php echo $sub_cate_data['sub_category_id']; ?>');">
                                                <span class="">|</span>
                                                <span class="t-dng">Trash</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php

                            }

                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php

    } else if ($View == "brd") {

    ?>

        <div class="row mt-4">
            <div class="col-12 col-md-6">
                <div class="col-12 border border-light border-opacity-50 rounded mb-2 admin_bg pointer" onclick="addNewBrand();">
                    <div class="row p-3 t-pri">
                        <span class="ps-3">Add New Brand +</span>
                    </div>
                </div>
            </div>
            <div class="col-12 my-3">
                <div class="row px-0">
                    <span class="fs-6 mb-3">All Brands</span>

                    <div class="col-12">
                        <div class="row overflow-y" style="max-height: calc(100vh - 270px);">

                            <?php

                            $brand_rs = Database::search("SELECT * FROM `brand` INNER JOIN `brand_has_sub_category` ON brand_has_sub_category.brand_id=brand.brand_id
                            INNER JOIN `sub_category` ON sub_category.sub_category_id=brand_has_sub_category.sub_category_id");
                            $brand_num = $brand_rs->num_rows;

                            for ($z = 0; $z < $brand_num; $z++) {
                                $brand_data = $brand_rs->fetch_assoc();
                            ?>

                                <div class="col-12 col-md-6">
                                    <div class="col-12 p-3 border border-light border-opacity-50 rounded mb-2 admin_bg">
                                        <div class="row">
                                            <div class="col-10">
                                                <span class="ps-0"><?php echo $brand_data["brand"] ?></span>
                                                <span class="tx-mute">(<?php echo $brand_data["sub_category_name"] ?>)</span>
                                            </div>
                                            <div class="col-2 pe-3 d-flex justify-content-between pointer" onclick="admDeleteBrand(<?php echo $brand_data['brand_id']; ?>);">
                                                <span class="">|</span>
                                                <span class="t-dng">Trash</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php

                            }

                            ?>

                        </div>
                    </div>
                </div>
            </div>

        <?php

    } else if ($View == "mdl") {

        ?>

            <div class="row mt-4">
                <div class="col-12 col-md-6">
                    <div class="col-12 border border-light border-opacity-50 rounded mb-2 admin_bg pointer" onclick="addNewModel();">
                        <div class="row p-3 t-pri">
                            <span class="ps-3">Add New Model +</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 my-3">
                    <div class="row px-0">
                        <span class="fs-6 mb-3">All Models</span>

                        <div class="col-12">
                            <div class="row overflow-y" style="max-height: calc(100vh - 270px);">

                                <?php

                                $model_rs = Database::search("SELECT * FROM `model` INNER JOIN `brand_has_model` ON 
                                brand_has_model.model_id = model.model_id INNER JOIN `brand` ON 
                                brand_has_model.brand_id = brand.brand_id INNER JOIN `sub_category` ON 
                                sub_category.sub_category_id=brand_has_model.sub_category_id GROUP BY model ORDER BY sub_category.sub_category_id");
                                $model_num = $model_rs->num_rows;

                                for ($a = 0; $a < $model_num; $a++) {
                                    $model_data = $model_rs->fetch_assoc();
                                ?>

                                    <div class="col-12 col-md-6">
                                        <div class="col-12 p-3 border border-light border-opacity-50 rounded mb-2 admin_bg">
                                            <div class="row">
                                                <div class="col-10">
                                                    <span class="ps-0"><?php echo $model_data["model"] ?></span>
                                                    <span class="tx-mute">(<?php echo $model_data["brand"] ?>)</span>
                                                </div>
                                                <div class="col-2 pe-3 d-flex justify-content-between pointer" onclick="admDeleteModel(<?php echo $model_data['model_id']; ?>);">
                                                    <span class="">|</span>
                                                    <span class="t-dng">Trash</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php

                                }

                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php

    }
} else {

        ?>

        <div class="col-12">
            <div class="row pt-4 text-center">
                <span class="">Something Went Wrong!</span>
            </div>
        </div>

    <?php

}

    ?>