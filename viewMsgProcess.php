<?php

require "connection.php";
session_start();
$email = $_SESSION["user"]["email"];

if (isset($_GET["em"])) {
    $email_cu = $_GET["em"];

    $chat_rs = Database::search("SELECT * FROM `chat` 
    WHERE (`from`='" . $email . "' AND `to`='" . $email_cu . "') OR (`to`='" . $email . "' AND `from`='" . $email_cu . "') ORDER BY `sent_date_time` ASC");

    $chat_num = $chat_rs->num_rows;

    for ($x = 0; $x < $chat_num; $x++) {
        $chat_data = $chat_rs->fetch_assoc();

        if ($chat_data["to"] == $email_cu && $chat_data["from"] == $email) {
?>
            <div class="col-9 offset-3">
                <div class="row">
                    <div class="col-12 bg-dark bg-opacity-25 rounded">
                        <div class="row p-2">
                            <span><?php echo $chat_data["content"]; ?></span>
                        </div>
                    </div>
                    <div class="col-12 p-1 mb-2">
                        <div class="row text-end">
                            <span style="font-size: 11px;"><?php echo $chat_data["sent_date_time"]; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } else if ($chat_data["to"] == $email && $chat_data["from"] == $email_cu) {
        ?>
            <div class="col-9">
                <div class="row">
                    <?php
                    if ($chat_data["msg_status"] == 1) {
                    ?>
                        <span class="p-1" style="font-size: 11px;">Unread</span>
                    <?php
                    }
                    ?>
                    <div class="col-12 bg-pri rounded">
                        <div class="row p-2">
                            <span><?php echo $chat_data["content"]; ?></span>
                        </div>
                    </div>
                    <div class="col-12 p-1 mb-2">
                        <div class="row text-end">
                            <span style="font-size: 11px;"><?php echo $chat_data["sent_date_time"]; ?></span>
                        </div>
                    </div>
                </div>
            </div>
<?php

        }
    }

    if(!isset($_GET["re"])){
        Database::iud("UPDATE `chat` SET `msg_status`='2' WHERE (`from`='" . $email . "' AND `to`='" . $email_cu . "') 
        OR (`to`='" . $email . "' AND `from`='" . $email_cu . "')");
    }
} else {
    echo "Something went wrong! Please try again";
}

?>