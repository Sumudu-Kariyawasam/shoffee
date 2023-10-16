<?php
    require "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <title>Shoffee - Shop Here For Free..</title>
</head>
<body class="body-bg">
    <div class="container-fluid contain 100vh d-flex">
        <div class="row main-box">

            <div class="col-6 d-none d-lg-block left-box"></div>
            <div class="col-12 col-md-10 offset-md-1 offset-lg-0 right-box">
                
                <!-- glass box Start -->
            <div class="glass-box">
                    <!-- error-box Start -->
                <div class="error-box d-none" id="error-box">
                    <p class="error-text" id="error-text"></p>
                    <button class="error-btn" onclick="errorClose();"><img src="icon-svg/x.svg" class="close-svg"></button>
                </div>

                <!-- error-box Start -->
                <!-- Sign Up Start -->

                <div class="row d-none" id="signUpBox">
                    <div class="col-12 heading-btm">
                        <h5>Create New Account..</h5>
                    </div>
                    <div class="col-6">
                        <lable class="form-lable">First Name</lable>
                        <input type="text" class="form-infield" id="fn"/>
                    </div>
                    <div class="col-6">
                        <lable class="form-lable">Last Name</lable>
                        <input type="text" class="form-infield" id="ln"/>
                    </div>
                    <div class="col-12">
                        <lable class="form-lable">Email</lable>
                        <input type="email" class="form-infield" id="em"/>
                    </div>
                    <div class="col-12">
                        <lable class="form-lable">Password</lable>
                        <input type="password" class="form-infield" id="pw"/>
                        <button class="eye-pw" onclick="eye_toggle();">
                            <img src="icon-svg/eye-fill.svg" class="de3 b-block" id="eye3">
                            <img src="icon-svg/eye-slash-fill.svg" class="de4 d-none" id="eye4">
                        </button>
                    </div>
                    <div class="col-6">
                        <lable class="form-lable">Mobile</lable>
                        <input type="text" class="form-infield" id="mb"/>
                    </div>
                    <div class="col-6">
                        <lable class="form-lable">Gender</lable>
                        <select class="form-infield" id="gd">
                            <?php
                            $rs = Database::search("SELECT * FROM `gender`");
                            $n = $rs->num_rows;

                            for($x; $x<$n; $x++){
                                $d = $rs->fetch_assoc();
                            ?>
                                <option value="<?php echo ($d["gender_id"]); ?>"><?php echo ($d["gender_name"]); ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 terms-box">
                        <input type="checkbox" class="form-check-input" id="tc">
                        <lable class="form-lable text_sm">I agree with <a href="terms.php" class="txt-link">Terms and Conditions</a></lable>
                    </div>
                    <div class="col-12">
                        <button class="btn-1" onclick="signup();">Sign Up</button>
                        <lable class="text_sm">Already have an Account? <a href="#" class="txt-link" onclick="changeView();">Sign In</a></lable>
                    </div>
                </div>
            
                <!-- Sign in start -->
                <?php
                $email_cc = "";
                $password_cc = "";
                $checked = "checked";

                if(isset($_COOKIE["USem-rEbme"])){
                    $email_cc = $_COOKIE["USem-rEbme"];
                }
                if(isset($_COOKIE["USpd-rEbme"])){
                    $password_cc = $_COOKIE["USpd-rEbme"];
                    $checked = "checked";
                }else{
                    $checked = "";
                }
                ?>

                <div class="row" id="signInBox">
                    <div class="col-12 heading-btm">
                        <h5>Log Into Your Account..</h5>
                    </div>
                    <div class="col-12">
                        <lable class="form-lable">Email</lable>
                        <input type="email" class="form-infield" id="em2" value="<?php echo($email_cc); ?>"/>
                    </div>
                    <div class="col-12">
                        <lable class="form-lable">Password</lable>
                        <input type="password" class="form-infield pw-field" id="pw2" value="<?php echo($password_cc); ?>" />
                        <button class="eye-pw" onclick="eye_toggle();">
                            <img src="icon-svg/eye-fill.svg" class="de1 d-block" id="eye1"/>
                            <img src="icon-svg/eye-slash-fill.svg" class="de2 d-none" id="eye2">
                        </button>
                    </div>
                    <div class="col-12 terms-box">
                        <input type="checkbox" class="form-check-input" id="rm" <?php echo($checked)?>>
                        <lable class="form-lable text_sm">Remember me</lable>
                    </div>
                    <div class="col-12">
                        <button class="btn-1" onclick="signin();">Sign In</button>
                    </div>
                    <div class="col-12 col-link-1">
                        <lable class="text_sm">Not Account yet? <a href="#" class="txt-link" onclick="changeView();">Sign Up</a></lable>
                    </div>
                    <div class="col-12 col-link-1">
                        <a href="#" class="txt-link text_sm" onclick="fog_open();">Forget Password?</a>
                    </div>
                </div>
                <!-- Sign in close -->
                <!-- verify email start -->
                <div class="row d-none" id="verify-Box">
                    <div class="col-12 heading-btm">
                        <h5>Verify Your Email..</h5>
                    </div>
                    <div class="col-12">
                        <lable class="form-lable">Enter your verification code</lable>
                        <input type="text" class="form-infield" id="v-code"/>
                    </div>
                    <div class="col-12">
                        <button class="btn-1" onclick="verifyEmail();">Verify Email</button>
                    </div>
                    <div>
                        <p>Verification code expire in &nbsp;</p>
                    </div>
                    <div class="col-5">
                        <p id="countdown" class="d-block">1:00</p>
                        <p id="countdown2" class="d-none"></p>
                    </div>
                    <div class="col-12">
                        <a href="#" class="txt-link text_sm" onclick="resend_vc();">Re-send verification code</a>

                    </div>
                </div>
            </div>
                <!-- glass box close -->
            </div>
                <!-- forget password box start -->
            <div class="col-10 col-lg-5 offset-1 fog-box d-none" id="fog-box">
                <div class="col-12 fog-head">
                    <div class="col-10">
                        <h5>Reset Password..</h5>
                    </div>
                    <div class="col-2 fog-btn-box">
                        <button class="fog-btn" onclick="fog_close();"><img src="icon-svg/x.svg" class="close-svg2"></button>
                    </div>
                </div>
                <div class="col-12 fog-body">
                    <div class="col-12">
                        <lable class="form-lable">Enter your verification code</lable>
                        <input type="text" class="form-infield" id="v-code2"/>
                    </div>
                    <div class="fog-pw-box">
                        <div class="fog-input">
                            <lable class="form-lable">New password</lable>
                            <input type="password" class="form-infield" id="n-pw"/>
                            
                        </div>
                        <div class="fog-input2">
                            <lable class="form-lable">Confirm password</lable>
                            <input type="password" class="form-infield" id="c-pw"/>
                            <button class="eye-pw" onclick="eye_toggle();">
                                <img src="icon-svg/eye-fill.svg" class="de5 d-block" id="eye5">
                                <img src="icon-svg/eye-slash-fill.svg" class="de6 d-none" id="eye6">
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn-1 btn-fog" onclick="resetPassword();">Reset Password</button>
                    </div>
                    <div class="fog-vc">
                        <div>
                            <p>Verification code expire in &nbsp;</p> 
                        </div>
                        <div class="col-3">
                            <p id="countdown3" class="d-block">1:00</p>
                        </div>
                    </div>
                    <div class="fog-text">Verification code sent,Check your inbox</div>
                </div>
            </div>
            <!-- forget password box close -->
            <!-- success box start -->
            <div class="col-8 col-md-6 col-lg-4 offset-lg-4 suc-box flex-column gap-3 d-none" id="suc_box">
                <img src="images/success.png" class="suc-img">
                <h5 class="suc-msg" id="suc-txt">Email Verified</h5>
            </div>
            <!-- success box close -->
        </div>
        <div class="col-12 footer-sec fixed-bottom">
            <p class="text_sm text-center">&copy; 2022 Shoffee.net || All Rights Reserved!</p>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>