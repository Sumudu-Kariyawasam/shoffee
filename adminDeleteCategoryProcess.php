<?php

session_start();
require "connection.php";

if(isset($_SESSION["admin"])){

    $id = $_GET["id"];

    $cat_rs = Database::search("SELECT * FROM `category_has_sub_category` WHERE `category_id` = '".$id."'");
    $cat_num = $cat_rs->num_rows;
    
    echo $cat_num;

}

?>