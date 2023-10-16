<option value="">Select Sub Category</option>
<?php
require "connection.php";

$category = $_POST["c"];
$sub_category = $_POST["s"];

$sub_cate_rs = Database::search("SELECT * FROM `category_has_sub_category` WHERE `category_id`='".$category."'");
$sub_cate_num = $sub_cate_rs->num_rows;

for ($x = 0; $x < $sub_cate_num; $x++) {
    $sub_cate_data = $sub_cate_rs->fetch_assoc();

    $sub_cate_rs2 = Database::search("SELECT * FROM `sub_category` WHERE `sub_category_id`='".$sub_cate_data["sub_category_id"]."'");
    $sub_cate_data2 = $sub_cate_rs2->fetch_assoc();

?>
    <option value="<?php echo ($sub_cate_data2["sub_category_id"]) ?>" 
    <?php if($sub_cate_data2["sub_category_id"] == $sub_category){ 
        echo ("selected");
     } ?> ><?php echo ($sub_cate_data2["sub_category_name"]) ?></option>
<?php
}
?>