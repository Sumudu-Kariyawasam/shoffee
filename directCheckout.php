<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wish List | ShoFFee</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="d-body body-bg">

    <div class="container-fluid contain2">
        <div class="row">
            <?php
            include "header.php";
            if (isset($_SESSION["user"])) {
                $user = $_SESSION["user"];
                $email = $_SESSION["user"]["email"];
            ?>

                <div class="col-12 py-3" style="background-color: rgb(220, 220, 220)">
                    <div class="row text-center">
                        <h4 class="fw-bold">Checkout</h4>
                    </div>
                </div>
                <div class="col-12 col-lg-7 p-3 ps-4">
                    <div class="row">
                        <div class="col-12 border border-dark border-opacity-50 rounded">
                            <div class="row p-2">
                                <div class="col-12">
                                    <div class="row p-3">
                                        <span class="fs-6 fw-bold mb-3">Personal Details</span>
                                        <hr>
                                        <div class="col-6">
                                            <div class="row pe-1">
                                                <label class="fw-bold">First Name</label>
                                                <input type="text" id="c-fn" class=" form-infield" value="<?php echo ($user["fname"]); ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row ps-1">
                                                <label class="fw-bold">Last Name</label>
                                                <input type="text" id="c-ln" class=" form-infield" value="<?php echo ($user["lname"]); ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <label class="fw-bold">Email Address</label>
                                                <input type="text" id="c-em" class=" form-infield" value="<?php echo ($email); ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row pe-1">
                                                <label class="fw-bold">Mobile</label>
                                                <input type="text" id="c-mb" class=" form-infield" value="<?php echo ($user["mobile"]); ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row ps-1">
                                                <label class="fw-bold">Office</label>
                                                <input type="text" id="c-of" class=" form-infield" value="<?php if(isset($user["office"])){ echo ($user["office"]); } ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row p-3">
                                        <span class="fs-6 fw-bold mb-1">Address Details</span>
                                        <div class="mb-3">
                                            <span class="fw-bold text-success" style="font-size: 14px;">Use my default address as delevery address</span> &nbsp;
                                            <input type="checkbox" id="add-use" onclick="setAddress();">
                                        </div>
                                        <hr>
                                        <div class="col-12">
                                            <div class="row">
                                                <label class="fw-bold">No.</label>
                                                <input type="text" id="c-no" class=" form-infield" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <label class="fw-bold">Line 01</label>
                                                <input type="text" id="c-l1" class=" form-infield" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <label class="fw-bold">Line 02</label>
                                                <input type="text" id="c-l2" class=" form-infield" value="">
                                            </div>
                                        </div>

                                    <?php
                                    $discrict_rs = Database::search("SELECT * FROM `district`");
                                    $dist_num = $discrict_rs->num_rows;
                                    ?>

                                        <div class="col-6">
                                            <div class="row pe-1">
                                                <label class="fw-bold">District</label>
                                                <select type="text" id="dt" class=" form-infield" value="" onchange="selectCity();">
                                                <option value="0">Select District</option>
                                                    <?php
                                                    for($x = 0; $x < $dist_num; $x++){
                                                        $dist_data = $discrict_rs->fetch_assoc();
                                                        ?>
                                                        <option value="<?php echo($dist_data["district_id"]); ?>"
                                                        <?php
                                                            if(!empty($address_data["district_id"])){
                                                                if($address_data["district_id"] == $dist_data["district_id"]){
                                                                ?>
                                                                selected 
                                                                <?php
                                                                }                                                     
                                                            }
                                                            ?> > <?php
                                                            echo ($dist_data["district_name"]);
                                                        ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row ps-1">
                                                <label class="fw-bold">City</label>
                                                <select id="ct" class=" form-infield" value="">
                                                    <option value="0">Select City</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <label class="fw-bold">Postal Code</label>
                                                <input type="text" id="c-pc" class=" form-infield" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <span class="fw-bold fs-6 text-danger mb-2">Warning!</span>
                                        <span class="mb-2">Fill the address field correctly. Your order will be sent to this address. We are not resposible
                                            for lost your order with incorrect address.
                                        </span>
                                        <span>Address fields has already filled with the address in your profile. If that address incorrect or
                                            need to ship to another address please fill this fields again with correct details.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5 p-3 ps-4 pe-4">
                    <div class="row pe-1">
                        <div class="col-12 border border-dark border-opacity-50 rounded">
                            <div class="row p-4">
                                <div class="col-12 border-bottom border-dark border-opacity-25 mb-2">
                                    <div class="row text-center">
                                        <p class="fs-6 fw-bold">Order Summery</p>
                                    </div>
                                </div>
                                <?php
                                $id = $_GET["id"];
                                $qty = $_GET["qty"];

                                $product_rs = Database::search("SELECT * FROM `product` WHERE `product_id`='" . $id . "'");
                                $product_data = $product_rs->fetch_assoc();

                                $link = $product_data['product_id'];
                                $total = ($product_data['price'] * $_GET["qty"]);
                                $tax = 0;
                                $discount = 0;
                                ?>

                                <div class="col-12 mb-2">
                                    <div class="row">
                                        <div class="col-12 border-bottom border-secondary border-opacity-25">
                                            <h5 class="fs-6 fw-bold"><?php echo ($product_data["title"]); ?></h5>
                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <span class="card-text text-secondary fw-bold">LKR. <?php echo ($product_data["price"]); ?> .00</span>
                                                </div>
                                                <div class="col-6">
                                                    <span class="card-text text-success fw-bold"><?php echo $qty; ?> items</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6 mt-3">
                                            <p class="">Sub Total</p>
                                            <p class="">Tax</p>
                                            <p class="">Discount</p>
                                            <p class="">Total</p>
                                        </div>
                                        <div class="col-6 mt-3 text-end">
                                            <p class=""><?php echo ($total); ?>.00</p>
                                            <p class=""><?php echo ($tax); ?>.00</p>
                                            <p class=""><?php echo ($discount); ?>.00</p>
                                            <p class=""><?php echo (($total + $tax) - $discount); ?>.00</p>
                                        </div>
                                        <input class="d-none col-12" id="ids" value="<?php echo($id); ?>">
                                        <input class="d-none col-12" id="qtys" value="<?php echo($qty); ?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="fs-6 fw-bold">Total To Pay</p>
                                            <p class="fs-6 fw-bold text-success">Saved</p>
                                        </div>
                                        <div class="col-6 text-end">
                                            <p class="fs-6 fw-bold"><?php echo (($total + $tax) - $discount); ?>.00</p>
                                            <p class="fs-6 fw-bold text-success"><?php echo ($discount); ?>.00</p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-12">
                                    <div class="row">
                                        <button class="btn-1 fw-bold" type="submit" id="payhere-payment" onclick="payNow();">Pay Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            } else {
            ?>
                <div class="col-12 d-flex justify-content-center align-items-center" style="height: 70vh;">
                    <div class="row text-center d-flex justify-content-center align-items-center pb-5">
                        <img src="images/not-found.gif" style="height: 250px; width: 300px;" class=" position-absolute opacity-50">
                        <span class="text-black-50 fw-bold pt-5" style="z-index: 1;">You're not logged in,</span>
                        <h3 class="fw-bold text-black-50" style="z-index: 1;">Please Login First!</h3>
                    </div>
                </div>

            <?php
            }
            include "footer.php";
            ?>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
</body>

</html>