<option value="">Select Brand</option>
<?php
require "connection.php";

$sub_category = $_POST["s"];
$brand = $_POST["b"];

if (!empty($sub_category)) {
    $sub_cate_rs = Database::search("SELECT * FROM `brand_has_sub_category` WHERE `sub_category_id`='" . $sub_category . "'");
    $sub_cate_num = $sub_cate_rs->num_rows;

    for ($x = 0; $x < $sub_cate_num; $x++) {
        $sub_cate_data = $sub_cate_rs->fetch_assoc();

        $selected_rs = Database::search("SELECT * FROM `brand` WHERE `brand_id`='" . $sub_cate_data["brand_id"] . "'");
        $selected_data = $selected_rs->fetch_assoc();

?>
        <option value="<?php echo ($selected_data["brand_id"]) ?>" <?php if ($selected_data["brand_id"] == $brand) {
                                                                        echo ("selected");
                                                                    } ?>><?php echo ($selected_data["brand"]) ?></option>
<?php
    }
}else{
    $selected_rs = Database::search("SELECT * FROM `brand`");
    $selected_num = $selected_rs->num_rows;
    for($y = 0; $y < $selected_num; $y++){
        $selected_data = $selected_rs->fetch_assoc();
?>
    <option value="<?php echo ($selected_data["brand_id"]) ?>" <?php if ($selected_data["brand_id"] == $brand) {
                                                                        echo ("selected");
                                                                    } ?>><?php echo ($selected_data["brand"]) ?></option>
<?php
    }
?>

<?php
}
?>