<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="atyle.css">
    <link rel="stylesheet" href="bootstrap.css">
</head>

<body style="font-size: 13px;">
    <div class="col-12 bg-dark">
        <div class="row p-5">
            <div class="col-4 text-white" style="height: 300px;">
                <div class="row">
                    <div class="col-12 fs-6 mt-2 fw-bold mb-3" style="height: 40px;">
                        <p style="color: rgb(0, 225, 255);">Navigations</p>
                    </div>
                    <div class="col-12 ">
                        <p><a href="home.php" class="text-decoration-none text-white">Home</a></p>
                        <p><a href="shop.php" class="text-decoration-none text-white">Shop Now</a></p>
                        <p><a href="myProfile.php" class="text-decoration-none text-white">My Profile</a></p>
                        <p><a href="myListings.php" class="text-decoration-none text-white">My Listings</a></p>
                        <p><a href="aboutus.php" class="text-decoration-none text-white">About Us</a></p>
                        <p><a onclick="logout();" class="text-decoration-none text-white pointer">Sign Out</a></p>
                    </div>
                </div>
            </div>
            <div class="col-4" style="height: 300px;">
                <div class="row">
                    <div class="col-12 fs-6 mt-2 fw-bold text-white" style="height: 40px;">
                        <p style="color: rgb(0, 225, 255);">Contact Us</p>
                    </div>
                    <div class="col-12 mt-3">
                        <p class="text-white">No. 353</p>
                        <p class="text-white">Elpitiya Road,</p>
                        <p class="text-white">Pitigala.</p>
                        <p class="text-white">091 254 6871</p>
                        <p class="text-white">091 254 6871</p>
                    </div>
                </div>
            </div>
            <div class="col-4 " style="height: 300px;">
                <div class="row">
                    <div class="col-12 fs-6 mt-2 fw-bold mb-3 text-white" style="height: 40px;">
                        <p style="color: rgb(0, 225, 255);">Find Us On Social Media</p>
                    </div>
                    <div class="col-12 ">
                        <p><a href="#" class="text-decoration-none text-white">Facebook</a></p>
                        <p><a href="#" class="text-decoration-none text-white">Twitter</a></p>
                        <p><a href="#" class="text-decoration-none text-white">Whatsapp</a></p>
                        <p><a href="#" class="text-decoration-none text-white">Instergram</a></p>
                        <p><a href="#" class="text-decoration-none text-white">Linked In</a></p>
                        <p><a href="#" class="text-decoration-none text-white">YouTube</a></p>
                    </div>
                </div>
            </div>
            <div class="col-12 border-top border-info d-flex justify-content-center mt-2 pt-3">
                <span class="text-white">&copy; Shoffee.net 2022 || All Rights Reserved.</span>
            </div>
        </div>
    </div>

    <div class="col-1 offset-10 offset-md-11 fixed-bottom pointer">
        <img src="icon-svg/chat.png" onclick="window.location = 'chat.php'" style="height: 45px; width: 45px; margin-top: -60px;">
    </div>
</body>

</html>