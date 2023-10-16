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
    <title>Add Product | ShoFFee</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php
            include "header.php";
            ?>

            <div class="col-12 p-4" style="background-color: #512E81">
                <div class="row">
                    <div class="col-12 border border-dark border-opacity-50 rounded p-3">
                        <div class="row">
                            <div class="col-12 py-3">
                                <div class="row text-center">
                                    <h4 class="">Add New Product</h4>
                                </div>
                                <hr>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-lg-4">
                                        <span class="form-label fw-bold">Select Category</span>
                                        <select class="form-infield mt-2" id="a_ct" onchange="seleted_sub(<?php echo(0) ?>);">
                                            <option value="">Select Category</option>
                                            <?php
                                            $cate_rs = Database::search("SELECT * FROM `category`");
                                            $cate_num = $cate_rs->num_rows;

                                            for ($x = 0; $x < $cate_num; $x++) {
                                                $cate_data = $cate_rs->fetch_assoc();
                                            ?>
                                                <option value="<?php echo ($cate_data["category_id"]) ?>"><?php echo ($cate_data["category"]); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-12 col-lg-4">
                                        <span class="form-label fw-bold">Select Sub Category</span>
                                        <select class="form-infield mt-2" id="a_sct" onchange="seleted_brand();">
                                            <option value="">Select Sub Category</option>
                                            <option value="3">Select Category First</option>
                                            
                                        </select>
                                    </div>
                                    <div class="d-none d-lg-block col-lg-4">
                                        <div class="row">
                                            <span class="form-label fw-bold">Popular Payment Methods</span>
                                            <div class="col-12">
                                                <div class="row">
                                                    <img src="resources/payment-icons/visa_img.png" style="height: 50px; width: 70px;">
                                                    <img src="resources/payment-icons/mastercard_img.png" class="mt-1" style="height: 45px; width: 70px;">
                                                    <img src="resources/payment-icons/paypal_img.png" style="height: 50px; width: 70px;">
                                                    <img src="resources/payment-icons/american_express_img.png" style="height: 50px; width: 70px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-12 col-lg-4">
                                        <span class="form-label fw-bold">Select Brand</span>
                                        <select class="form-infield mt-2" id="a_br" onchange="seleted_model();">
                                            <option value="3">Select Brand</option>
                                            <option value="3">Select Sub Category First!</option>
                                            
                                        </select>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <span class="form-label fw-bold">Select Model</span>
                                        <select class="form-infield mt-2" id="a_md">
                                            <option value="7">Select Model</option>
                                            <option value="7">Select Brand First!</option>
                                            
                                        </select>
                                    </div>
                                    <div class="d-none d-lg-block col-lg-4">
                                        <div class="row">
                                            <img src="images/logo.png" class=" position-absolute me-3" style="height: 30px; width: 180px;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-12 col-lg-10">
                                        <span class="form-label fw-bold">Add A Title</span>
                                        <input type="text" class="form-infield" id="a_tt" placeholder="Enter your title here..">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-12 col-lg-4 mb-3 mb-lg-1">
                                        <span class="form-label fw-bold">Select Condition</span>
                                        <div class="col-12 pt-2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="radio" id="a_cn1" name="con" value="1" checked>
                                                    <span class="form-label">Brand New</span>
                                                </div>
                                                <div class="col-6">
                                                    <input type="radio" id="a_cn2" name="con" value="2">
                                                    <span class="form-label">Used</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-4 mb-2 mb-lg-1">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label fw-bold">Select Colour</span>
                                                <select name="" id="a_cl" class="form-infield">
                                                    <option value="">Select Colour</option>
                                                    <?php
                                                    $color_rs = Database::search("SELECT * FROM `color`");
                                                    $color_num = $color_rs->num_rows;

                                                    for ($x = 0; $x < $color_num; $x++) {
                                                        $color_data = $color_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo ($color_data["color_id"]) ?>"><?php echo ($color_data["color"]) ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-4">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label fw-bold">Enter Quantity</span>
                                                <input type="number" class="form-infield" id="a_qt">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label fw-bold">Price Of Item</span>
                                                <input type="number" class="form-infield" id="a_pr">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label fw-bold">Delivery In Colombo</span>
                                                <input type="number" class="form-infield" id="a_dc">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label fw-bold">Delivery Out of Colombo</span>
                                                <input type="number" class="form-infield" id="a_do">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row px-2">
                                            <span class="form-label fw-bold px-0">Short Description</span>
                                            <textarea class="opacity-50" id="a_sd" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row px-2">
                                            <span class="form-label fw-bold px-0">Product Description</span>
                                            <textarea class="opacity-50" id="a_ds" cols="30" rows="15"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <span class="form-label fw-bold">Add Product Images</span>
                                            <div class="col-12 col-lg-10 offset-lg-1">
                                                <div class="row">

                                                    <div class="col-12 col-md-5 offset-md-1 pe-md-4">
                                                        <div class="row d-flex justify-content-between px-3 ps-md-2 ps-lg-0 px-md-0">
                                                            <div class="col-4 col-lg-2 overflow-hidden d-flex justify-content-center border border-secondary" style="width: 100px;  height: 100px;">
                                                                <img src="icon-svg/empty.jpg" style="height: 100px;" id="view0">
                                                            </div>
                                                            <div class="col-4 col-lg-2 overflow-hidden d-flex justify-content-center border border-secondary" style="width: 100px;  height: 100px;">
                                                                <img src="icon-svg/empty.jpg" style="height: 100px;" id="view1">
                                                            </div>
                                                            <div class="col-4 col-lg-2 overflow-hidden d-flex justify-content-center border border-secondary" style="width: 100px;  height: 100px;">
                                                                <img src="icon-svg/empty.jpg" style="height: 100px;" id="view2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-5 pe-md-4 mt-3 mt-md-0">
                                                        <div class="row d-flex justify-content-between px-3 px-md-0">
                                                            <div class="col-4 col-lg-2 overflow-hidden d-flex justify-content-center border border-secondary" style="width: 100px;  height: 100px;">
                                                                <img src="icon-svg/empty.jpg" style="height: 100px;" id="view3">
                                                            </div>
                                                            <div class="col-4 col-lg-2 overflow-hidden d-flex justify-content-center border border-secondary" style="width: 100px;  height: 100px;">
                                                                <img src="icon-svg/empty.jpg" style="height: 100px;" id="view4">
                                                            </div>
                                                            <div class="col-4 col-lg-2 overflow-hidden d-flex justify-content-center border border-secondary" style="width: 100px;  height: 100px;">
                                                                <img src="icon-svg/empty.jpg" style="height: 100px;" id="view5">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-10 offset-1 col-lg-6 offset-lg-3">
                                                <input type="file" class="d-none" id="ii" onclick="loadPimages();" multiple>
                                                <label for="ii" class="btn-1 d-flex align-items-center justify-content-center pointer">Select Images</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-1">
                                <div class="row">
                                    <div class="col-10 offset-1 col-lg-6 offset-lg-3">
                                        <button class="btn-1" onclick="addProduct();">Add Product</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-1">
                                <div class="row">
                                    <span class="fs-6 fw-bold mb-1">Notice</span>
                                    <p>5% from product price will be charged as service charge from every purchase. When a customer Purchase your product, 
                                        You must deliver the product within 3 days. Give a good service to your customer and earn customer's positive feedbacks.</p>
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
</body>

</html>

<?php } ?>