<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | ShoFFee.net</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="d-body">
    <div class="container-fluid">
        <div class="row">
            <?php
            include "header.php";
            ?>

            <div class="col-12">
                <div class="row py-3">
                    <div class="col-10 offset-1 border border-dark border-opacity-50 rounded">
                        <div class="row">
                            <div class="col-12 p-3 px-4 ">
                                <div class="row border border-dark border-opacity-25 rounded py-3">
                                    <div class="col-12 text-center">
                                        <h5>Advanced Search</h5>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" placeholder="Search Here.." class="form-infield">
                                    </div>
                                    <div class="col-4 pt-2">
                                        <select class="form-infield text-white-75">
                                            <option value="">Select By Category</option>
                                            <option value="">Mobile & Tablets</option>
                                            <option value="">Laptop & PCs</option>
                                            <option value="">Cameras</option>
                                            <option value="">Drones</option>
                                        </select>
                                    </div>
                                    <div class="col-4 pt-2">
                                        <select class="form-infield text-white-75">
                                            <option value="">Select By Brand</option>
                                            <option value="">Apple</option>
                                            <option value="">Sony</option>
                                            <option value="">Samsung</option>
                                            <option value="">Nokia</option>
                                        </select>
                                    </div>
                                    <div class="col-4 pt-2">
                                        <select class="form-infield text-white-75">
                                            <option value="">Select By Model</option>
                                            <option value="">iPhone 12</option>
                                            <option value="">iPhone 8</option>
                                            <option value="">HTC-U</option>
                                            <option value="">A 50</option>
                                            <option value="">X Peria</option>
                                        </select>
                                    </div>
                                    <div class="col-6 pt-2">
                                        <select class="form-infield text-white-75">
                                            <option value="">Select By Color</option>
                                            <option value="">Black</option>
                                            <option value="">White</option>
                                            <option value="">Rose Gold</option>
                                            <option value="">Sky Blue</option>
                                            <option value="">Red</option>
                                        </select>
                                    </div>
                                    <div class="col-6 pt-2">
                                        <select class="form-infield text-white-75">
                                            <option class="">Select By Condition</option>
                                            <option value="">Brand New</option>
                                            <option value="">Used</option>
                                        </select>
                                    </div>
                                    <div class="col-6 pt-2">
                                        <input type="text" class="form-infield" placeholder="Price From..">
                                    </div>
                                    <div class="col-6 pt-2">
                                        <input type="text" class="form-infield" placeholder="Price To..">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-center py-4">
                                <div class="row gap-3">
                                    
                                    <div class="card p-0 overflow-hidden" style="width: 12rem; height: 25rem;">
                                        <span class="badge color_primary position-absolute mt-2 ms-2">New</span>
                                        <div class="overflow-hidden cardimage">
                                            <div class="d-flex justify-content-center" style="height: 100%; width: 100%;">
                                                <img src="resources/product-images/iphone12.jpg" class="card-img-top" style="height: 100%; width: auto;">
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">Apple iPhone 12</h5>
                                            <span class="card-text text-secondary fw-bold">LKR. 120,000 .00</span><br>
                                            <span class="card-text text-success fw-bold">11 items Available</span>
                                            <div class="col-12 btn-group mt-lg-2" role="group">
                                                <button class="col-6 btn d-flex justify-content-start" onclick="addtowish();">
                                                    <img src="resources/h1.png" style="height: 25px;" id="wish-h">
                                                </button>
                                                <button onclick="addtoCart();" class="col-6 btn d-flex justify-content-end">
                                                    <img src="resources/c1.png" class="d-block" style="height: 25px;">
                                                </button>
                                            </div>
                                            <button class="col-12 btn fw-bold" style="background-color: rgb(0, 255, 255);" onclick="window.location = 'singleProduct.php'">Buy Now</button>
                                        </div>
                                    </div>
                                    <div class="card p-0 overflow-hidden" style="width: 12rem; height: 25rem;">
                                        <span class="badge color_primary position-absolute mt-2 ms-2">New</span>
                                        <div class="overflow-hidden cardimage">
                                            <div class="d-flex justify-content-center" style="height: 100%; width: 100%;">
                                                <img src="resources/product-images/iphone12.jpg" class="card-img-top" style="height: 100%; width: auto;">
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">Apple iPhone 12</h5>
                                            <span class="card-text text-secondary fw-bold">LKR. 120,000 .00</span><br>
                                            <span class="card-text text-success fw-bold">11 items Available</span>
                                            <div class="col-12 btn-group mt-lg-2" role="group">
                                                <button class="col-6 btn d-flex justify-content-start" onclick="addtowish();">
                                                    <img src="resources/h1.png" style="height: 25px;" id="wish-h">
                                                </button>
                                                <button onclick="addtoCart();" class="col-6 btn d-flex justify-content-end">
                                                    <img src="resources/c1.png" class="d-block" style="height: 25px;">
                                                </button>
                                            </div>
                                            <button class="col-12 btn fw-bold" style="background-color: rgb(0, 255, 255);" onclick="window.location = 'singleProduct.php'">Buy Now</button>
                                        </div>
                                    </div>
                                    <div class="card p-0 overflow-hidden" style="width: 12rem; height: 25rem;">
                                        <span class="badge color_primary position-absolute mt-2 ms-2">New</span>
                                        <div class="overflow-hidden cardimage">
                                            <div class="d-flex justify-content-center" style="height: 100%; width: 100%;">
                                                <img src="resources/product-images/iphone12.jpg" class="card-img-top" style="height: 100%; width: auto;">
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">Apple iPhone 12</h5>
                                            <span class="card-text text-secondary fw-bold">LKR. 120,000 .00</span><br>
                                            <span class="card-text text-success fw-bold">11 items Available</span>
                                            <div class="col-12 btn-group mt-lg-2" role="group">
                                                <button class="col-6 btn d-flex justify-content-start" onclick="addtowish();">
                                                    <img src="resources/h1.png" style="height: 25px;" id="wish-h">
                                                </button>
                                                <button onclick="addtoCart();" class="col-6 btn d-flex justify-content-end">
                                                    <img src="resources/c1.png" class="d-block" style="height: 25px;">
                                                </button>
                                            </div>
                                            <button class="col-12 btn fw-bold" style="background-color: rgb(0, 255, 255);" onclick="window.location = 'singleProduct.php'">Buy Now</button>
                                        </div>
                                    </div>
                                    <div class="card p-0 overflow-hidden" style="width: 12rem; height: 25rem;">
                                        <span class="badge color_primary position-absolute mt-2 ms-2">New</span>
                                        <div class="overflow-hidden cardimage">
                                            <div class="d-flex justify-content-center" style="height: 100%; width: 100%;">
                                                <img src="resources/product-images/iphone12.jpg" class="card-img-top" style="height: 100%; width: auto;">
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">Apple iPhone 12</h5>
                                            <span class="card-text text-secondary fw-bold">LKR. 120,000 .00</span><br>
                                            <span class="card-text text-success fw-bold">11 items Available</span>
                                            <div class="col-12 btn-group mt-lg-2" role="group">
                                                <button class="col-6 btn d-flex justify-content-start" onclick="addtowish();">
                                                    <img src="resources/h1.png" style="height: 25px;" id="wish-h">
                                                </button>
                                                <button onclick="addtoCart();" class="col-6 btn d-flex justify-content-end">
                                                    <img src="resources/c1.png" class="d-block" style="height: 25px;">
                                                </button>
                                            </div>
                                            <button class="col-12 btn fw-bold" style="background-color: rgb(0, 255, 255);" onclick="window.location = 'singleProduct.php'">Buy Now</button>
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
            <script src="bootstrap.bundle.js"></script>
            <script src="script.js"></script>
        </div>
    </div>
</body>

</html>