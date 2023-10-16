<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | ShoFFee.net</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="d-body bg-dark text-white">
    <div class="container-fluid contain">
        <div class="row px-5">
            <div class="col-10 offset-1 col-lg-6 offset-lg-3" style="min-height: 100vh;">
                <div class="row d-flex justify-content-center align-items-center" style="min-height: 100vh;">
                    <div class="col-12 border border-light border-opacity-50 rounded bg-black bg-opacity-10">
                        <div class="row py-4">
                            <div class="col-12 d-flex justify-content-center">
                                <img src="images/logo2.png" style="height: 30px;">
                            </div>
                            <div class="col-12 ps-4 mt-1">
                                <p>Login As Admin to <b>ShoFFee.net</b></p>
                            </div>
                            <hr>
                            <div class="col-12 px-4">
                                <span class="">Email</span>
                                <input type="email" class="form-infield text-white-25" id="adm_em">
                                <button class="btn-1" onclick="adminSigninVerify();">Send Verification Code</button>
                            </div>
                            <div class="col-12 px-4">
                                <span class="">Verification Code</span>
                                <input type="text" class="form-infield text-white-25" id="adm_vc">
                                <span class="">Password</span>
                                <input type="password" class="form-infield text-white-25" id="adm_pw">
                                <button class="btn-1" onclick="adminSignin();">Sign in</button>
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