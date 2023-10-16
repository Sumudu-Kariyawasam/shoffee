<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    $email = $_SESSION["user"]["email"];

    Database::iud("UPDATE `invoice` SET `invoice_status`='5' WHERE `user_email`='" . $email . "'");
    echo "success";

} else {
    echo "Something went wrong! Please try again later";
}
