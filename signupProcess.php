<?php
require "connection.php";
session_start();

$fname = $_POST["fn"];
$lname = $_POST["ln"];
$email = $_POST["em"];
$password = $_POST["pw"];
$mobile = $_POST["mb"];
$gender = $_POST["gd"];
$tnc = $_POST["tc"];

if(empty($fname)){
    echo ("Please enter your First Name!");
}else if(strlen($fname) > 50){
    echo ("First Name must have less than 50 characters!");
}else if(empty($lname)){
    echo ("Please enter your Last Name!");
}else if(strlen($lname) > 50){
    echo ("Last Name must have less than 50 characters!");
}else if(empty($email)){
    echo ("Please enter your Email!");
}else if(strlen($email) > 100){
    echo ("Email must have less than 100 characters!");
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo ("Invalid Email!");
}else if(empty($password)){
    echo ("Please enter your Password!");
}else if(strlen($password) > 20 || strlen($password) < 5){
    echo ("Password must have been 5 - 20 characters!");
}else if(empty($mobile)){
    echo ("Please enter your Mobile Number!");
}else if(strlen($mobile) < 10){
    echo ("Invalid Mobile Number!");
}else if(!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/",$mobile)){
    echo ("Invalid Mobile Number!");
}else if($tnc != "true"){
    echo ("Please agree with Terms & Conditions");
}else{

    $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."' OR `mobile`='".$mobile."'");
    $n = $rs->num_rows;

    if($n == 0){
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("y-m-d h-i-s");

        $code = rand(100000, 999999);

        Database::iud("INSERT INTO `user` (`email`,`password`,`fname`,`lname`,`mobile`,`regitred_date`,`gender_id`,`verification_code`,`status`)
        VALUES ('".$email."','".$password."','".$fname."','".$lname."','".$mobile."','".$date."','".$gender."','".$code."','0')");
        
        echo ("success");

        $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."' AND `password`='".$password."'");
        $data = $rs->fetch_assoc();
        $_SESSION["user"] = $data;

    }else{
        echo ("User with same Email or Mobile, Already exists!");
    }
}

?>