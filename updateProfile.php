<?php

session_start();
require "connection.php";

if(isset($_SESSION["user"])){

$fname = $_POST["fn"];
$lname = $_POST["ln"];
$mobile = $_POST["mb"];
$office = $_POST["of"];
$no = $_POST["no"];
$line1 = $_POST["l1"];
$line2 = $_POST["l2"];
$district = $_POST["dt"];
$city = $_POST["ct"];
$postal = $_POST["pc"];

if(empty($fname)){
    echo ("Please enter your First Name!");
}else if(strlen($fname) > 50){
    echo ("First Name must have less than 50 characters!");
}else if(empty($lname)){
    echo ("Please enter your Last Name!");
}else if(strlen($lname) > 50){
    echo ("Last Name must have less than 50 characters!");
}else if(empty($mobile)){
    echo ("Please enter your Mobile Number!");
}else if(strlen($mobile) < 10){
    echo ("Invalid Mobile Number!");
}else if(!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/",$mobile)){
    echo ("Invalid Mobile Number!");
}else if(!empty($office) && strlen($office) < 10){
    echo ("Invalid Mobile Number!");
}else if(empty($line1)){
    echo ("Address line1 your First Name!");
}else if(strlen($line1) > 50){
    echo ("Address line1 must have less than 50 characters!");
}else if(isset($line2) && strlen($line2) > 50){
    echo ("Address line2 must have less than 50 characters!");
}else if(empty($city)){
    echo ("Please select your City!");
}else if(empty($district)){
    echo ("Please select your District!");
}else if(empty($postal)){
    echo ("Please enter your POtal code!");
}else if(strlen($postal) != 5){
    echo ("INvalid Postal code!");
}else{
    
    $email = $_SESSION["user"]["email"];
    $add_rs = Database::search("SELECT * FROM `user_has_user_address` WHERE `user_email`='".$email."'");
    $add_num = $add_rs->num_rows;
    $add_data = $add_rs->fetch_assoc();

    if($add_num > 0){
        Database::iud("UPDATE `user_address` SET `address_no`='".$no."',`line_1`='".$line1."',`line_2`='".$line2."',
        `postal_code`='".$postal."',`city_id`='".$city."' WHERE `address_id`='".$add_data["user_address_id"]."'");
    }else{
        Database::iud("INSERT INTO `user_address` (`address_no`,`line_1`,`line_2`,`postal_code`,`city_id`) 
        VALUES ('".$no."','".$line1."','".$line2."','".$postal."','".$city."')");

        $address_id = Database::$connection->insert_id;

        Database::iud("INSERT INTO `user_has_user_address` (`user_email`,`user_address_id`) 
        VALUES ('".$email."','".$address_id."')");
    }

    Database::iud("UPDATE `user` SET `fname`='".$fname."',`lname`='".$lname."',`mobile`='".$mobile."',`office`='".$office."' 
    WHERE `email`='".$email."'");
    
    $accepted_ext = array('image/jpg', 'image/jpeg', 'image/png', 'image/svg+xml');
    $img_num = sizeof($_FILES);

    if ($img_num == 1) {
        $img = $_FILES["img"];
        $ext = $img["type"];

        if (in_array($ext, $accepted_ext)) {
            $new_ext;
            if ($ext == "image/jpg") {
                $new_ext = ".jpg";
            } else if ($ext == "image/jpeg") {
                $new_ext = ".jpeg";
            } else if ($ext == "image/png") {
                $new_ext = ".png";
            } else if ($ext == "image/svg+xml") {
                $new_ext = ".svg";
            }

            $new_file_name = "images/profile_images/" . uniqid() . "profil_img" . $new_ext;
            move_uploaded_file($img["tmp_name"], $new_file_name);

            $pro_img_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $email . "'");
            $pro_img_num = $pro_img_rs->num_rows;

            if ($pro_img_num > 0) {
                Database::iud("UPDATE `profile_image` SET `user_image_path`='" . $new_file_name . "' WHERE `user_email`='" . $email . "'");
            } else {
                Database::iud("INSERT INTO `profile_image` (`user_email`,`user_image_path`) VALUES ('" . $email . "','" . $new_file_name . "')");
            }
        } else {
            echo "Invalid image Format";
        }
    }

    echo "success";

}

}else{
    header("Location:http://localhost/shoffee/home.php");
}
?>