<?php

require "connection.php";
session_start();

    $email = $_GET["ae"];

    if(empty($email)){
        echo ("Please enter your Email!");
    }else if(strlen($email) > 100){
        echo ("Email must have less than 100 characters!");
    }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        echo ("Invalid Email!");
    }else{

        $admin_rs = Database::search("SELECT * FROM `admin`");
        $admin_num = $admin_rs->num_rows;
        $admin_data = $admin_rs->fetch_assoc();

        if($admin_num > 0){

            $code = rand(100000, 999999);
            Database::iud("UPDATE `admin` SET `verification_code`='".$code."' WHERE `admin_email`='".$email."'");

            echo("success");

        }else{
            echo("Incorrect Email!");
        }

    }
