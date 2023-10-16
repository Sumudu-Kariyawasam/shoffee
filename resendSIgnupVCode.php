<?php
require "connection.php";

$email = $_GET["em"];

$code = rand(100000, 999999);
Database::iud("UPDATE `user` SET `verification_code`='".$code."' WHERE `email`='".$email."'");

echo ("Re-Sent Verification Code Successfuly");

?>