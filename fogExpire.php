<?php
require "connection.php";
sleep(60);

$email = $_GET["em"];
$code = rand(100000, 999999);

Database::iud("UPDATE `user` SET `verification_code`='".$code."' WHERE `email`='".$email."'");

?>