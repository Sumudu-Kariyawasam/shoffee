<option value="">Select Modal</option>
<?php
require "connection.php";

$brand = $_POST["b"];
$sub_category = $_POST["s"];
$modal = $_POST["m"];

if (!empty($brand)) {
    $brand_rs = Database::search("SELECT * FROM `brand_has_model` WHERE `brand_id`='" . $brand . "' AND `sub_category_id`='".$sub_category."'");
    $brand_num = $brand_rs->num_rows;

    for ($x = 0; $x < $brand_num; $x++) {
        $brand_data = $brand_rs->fetch_assoc();

        $selected_rs = Database::search("SELECT * FROM `model` WHERE `model_id`='" . $brand_data["model_id"] . "'");
        $selected_data = $selected_rs->fetch_assoc();

        ?>
        <option value="<?php echo ($selected_data["model_id"]) ?>" <?php if ($selected_data["model_id"] == $modal) {
                                                                        echo ("selected");
                                                                    } ?>><?php echo ($selected_data["model"]) ?></option>
<?php
    }
}else{
    $selected_rs = Database::search("SELECT * FROM `model`");
    $selected_num = $selected_rs->num_rows;
    for($y = 0; $y < $selected_num; $y++){
        $selected_data = $selected_rs->fetch_assoc();
?>
    <option value="<?php echo ($selected_data["model_id"]) ?>" <?php if ($selected_data["model_id"] == $modal) {
                                                                        echo ("selected");
                                                                    } ?>><?php echo ($selected_data["model"]) ?></option>
<?php
    }
?>

<?php
}
?>