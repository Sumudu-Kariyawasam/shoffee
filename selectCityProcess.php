<?php
require "connection.php";
session_start();
$email = $_SESSION["user"]["email"];

$dist = $_GET["d"];

$address_rs = Database::search("SELECT * FROM `user_has_user_address` INNER JOIN `user_address` ON 
    user_has_user_address.user_address_id=user_address.address_id INNER JOIN `city` ON 
    user_address.city_id=city.city_id INNER JOIN `district` ON 
    city.district_id=district.district_id WHERE `user_email`='".$email."'");

$address_data = $address_rs->fetch_assoc();

$city_rs = Database::search("SELECT * FROM `city` WHERE `district_id`='".$dist."'");
$city_num = $city_rs->num_rows;

for($x = 0; $x < $city_num; $x++){
    $city_data = $city_rs->fetch_assoc(); ?>

    <option value="<?php echo($city_data["city_id"]); ?>"
        <?php
            if(!empty($address_data["city_id"])){
                if($address_data["city_id"] == $city_data["city_id"]){
                ?>
                selected 
                <?php
                }                                                       
            }
        ?> > <?php
        echo ($city_data["city_name"]); 
        ?>
    </option>

    <?php
}

?>