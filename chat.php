<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat | ShoFFee</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="d-body">

    <div class="container-fluid">
        <div class="row">
            <?php require "header.php";

            if (isset($_SESSION["user"])) {
                $email = $_SESSION["user"]["email"];
            } else {
                $email = "null";
            }
            ?>
            <div class="col-12">
                <div class="row p-4">
                    <div class="col-12 col-lg-4 border border-secondary border-opacity-50 rounded" id="all_chat">
                        <div class="row">
                            <div class="col-12 p-3 pb-0 bg-secondary bg-opacity-25">
                                <div class="row">
                                    <ul class="nav nav-tabs">
                                        <li class=" nav-item pointer" onclick="chatChange('r');">
                                            <a class="nav-link active" id="nav1">Received</a>
                                        </li>
                                        <li class=" nav-item pointer" onclick="chatChange('s');">
                                            <a class="nav-link" id="nav2">Sent</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 chat_box">

                                <?php
                                if ($email != "null") {

                                ?>

                                    <!-- Received -->
                                    <div class="row p-2" id="received_msg">

                                        <?php
                                        $rece_rs = Database::search("SELECT DISTINCT `from` FROM `chat` WHERE `to`='" . $email . "'");
                                        $rece_num = $rece_rs->num_rows;

                                        for ($x = 0; $x < $rece_num; $x++) {
                                            $rece_data = $rece_rs->fetch_assoc();

                                            $selected_rs = Database::search("SELECT * FROM `chat` WHERE `from`='" . $rece_data["from"] . "' AND `to`='" . $email . "' ORDER BY `sent_date_time` DESC");
                                            $selected_data = $selected_rs->fetch_assoc();

                                            $sender_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $rece_data["from"] . "'");
                                            $sender_data = $sender_rs->fetch_assoc();

                                            $sender_profile_img = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $rece_data["from"] . "'");
                                            $sender_profile_img_data = $sender_profile_img->fetch_assoc();

                                            $sender = $rece_data["from"];
                                            $pro_pic;
                                            if (isset($sender_profile_img_data["user_image_path"])) {
                                                $pro_pic = $sender_profile_img_data["user_image_path"];
                                            } else {
                                                if ($sender_data["gender_id"] == 2) {
                                                    $pro_pic = "resources/user_female.jpg";
                                                } else {
                                                    $pro_pic = "resources/user_male.jpg";
                                                }
                                            }
                                        ?>

                                            <div class="col-12 py-2 border-bottom border-secondary border-opacity-50 pointer">
                                                <div class="row" onclick="viewMsg(<?php echo $x; ?>);">
                                                    <input type="text" class="d-none" id="<?php echo ("sender_em" . $x); ?>" value="<?php echo $sender; ?>">
                                                    <div class="col-3">
                                                        <?php
                                                        if ($selected_data["msg_status"] == 1) {
                                                        ?>
                                                            <div>
                                                                <img src="icon-svg/unread.png" class="position-absolute" style="height: 10px; width: 10px;">
                                                            </div>
                                                        <?php } ?>
                                                        <img src="<?php echo $pro_pic; ?>" class="rounded-circle" style="height: 50px; width: 50px;">
                                                    </div>
                                                    <div class="col-9">
                                                        <div class="row p-0">
                                                            <span style="font-size: 14px;" class=" fw-bold"><?php echo ($sender_data["fname"] . " " . $sender_data["lname"]); ?></span>
                                                            <span style="font-size: 11px;"><?php echo $selected_data["sent_date_time"]; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <!-- Received -->

                                    <!-- sent -->
                                    <div class="row p-2 d-none" id="sent_msg">

                                        <?php
                                        $sent_rs = Database::search("SELECT DISTINCT `to` FROM `chat` WHERE `from`='" . $email . "'");
                                        $sent_num = $sent_rs->num_rows;

                                        for ($x = 0; $x < $sent_num; $x++) {
                                            $sent_data = $sent_rs->fetch_assoc();

                                            $selected_rs = Database::search("SELECT * FROM `chat` WHERE `to`='" . $sent_data["to"] . "' AND `from`='" . $email . "' ORDER BY `sent_date_time` DESC");
                                            $selected_data = $selected_rs->fetch_assoc();

                                            $sender_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $sent_data["to"] . "'");
                                            $sender_data = $sender_rs->fetch_assoc();

                                            $sender_profile_img = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $sent_data["to"] . "'");
                                            $sender_profile_img_data = $sender_profile_img->fetch_assoc();

                                            $sender = $sent_data["to"];
                                            $pro_pic;
                                            if (isset($sender_profile_img_data["user_image_path"])) {
                                                $pro_pic = $sender_profile_img_data["user_image_path"];
                                            } else {
                                                if ($sender_data["gender_id"] == 2) {
                                                    $pro_pic = "resources/user_female.jpg";
                                                } else {
                                                    $pro_pic = "resources/user_male.jpg";
                                                }
                                            }
                                        ?>

                                            <div class="col-12 py-2 border-bottom border-secondary border-opacity-50 pointer">
                                                <div class="row" onclick="viewMsg(<?php echo $x; ?>);">
                                                    <input type="text" class="d-none" id="<?php echo ("sender_em" . $x); ?>" value="<?php echo $sender; ?>">
                                                    <div class="col-3">
                                                        <img src="<?php echo $pro_pic; ?>" class="rounded-circle" style="height: 50px; width: 50px;">
                                                    </div>
                                                    <div class="col-9">
                                                        <div class="row p-0">
                                                            <span style="font-size: 14px;" class=" fw-bold" id="<?php echo ("msg_name" . $x) ?>"><?php echo ($sender_data["fname"] . " " . $sender_data["lname"]); ?></span>
                                                            <span style="font-size: 11px;"><?php echo $selected_data["sent_date_time"]; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php } ?>

                                    </div>
                                    <!-- sent -->

                                <?php
                                } else {
                                ?>
                                    <div class="col-12 d-flex justify-content-center align-items-center" style="min-height: 65vh;">
                                        <div class="row text-center">
                                            <span class=" text-black-50">Please Login First To Show</span><br>
                                            <span class="fs-5">Messages</span>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>

                    <div class="d-none d-lg-block ms-0 ms-lg-5 col-12 col-lg-7 border border-secondary border-opacity-50 rounded" id="selected_chat">
                        <div class="row pb-0">
                            <div class="col-12 bg-secondary bg-opacity-25 pointer">
                                <div class="row p-3">
                                    <div class="d-lg-none" style="width: 30px;" onclick="backToMsg();">
                                        <img src="icon-svg/caret-left-fill.svg" style="height: 15px; width: 15px;">
                                    </div>
                                    <div class="col-10">
                                        <span class="fs-6 fw-bold" id="msg_name_view">View Chat</span><br>
                                        <span class="d-none" style="font-size: 12px;" id="msg_email_view">View Chat</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 chat_view_box">
                                        <div class="row p-3" id="chat_view">

                                            <div class="col-12">
                                                <div class="row text-center">
                                                    <span class="fs-6 mt-4 text-black-50">Click on a chat to view</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-12 bg-secondary bg-opacity-25">
                                        <div class="row pt-2 pb-2">
                                            <div class=" input-group">
                                                <input type="text" class="form-control" style="font-size: 14px;" placeholder="Type your text" id="msg_txt">
                                                <button class="btn-send rounded-end bg-pri" type="button" onclick="send_msg();"><img src="icon-svg/cursor-fill.svg"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-1 offset-10 offset-md-11 fixed-bottom pointer">
                <img src="icon-svg/new_msg.png" onclick="newMsg();" style="height: 45px; width: 45px; margin-top: -60px;">
            </div>

            <div class="modal" tabindex="-1" id="new-msg">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-dark bg-opacity-10">
                            <span class="modal-title fs-5 fw-bold">New Messgae</span> &nbsp;
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">
                                <div class="">
                                    <span class="fw-bold">From :</span>
                                    <span><?php echo $email; ?></span><br><br>
                                    <span class="fw-bold">To :</span><br>
                                    <input type="text" id="new_msg_em" class="mt-2 form-control" style="font-size: 14px;" placeholder="Enter Receiver's Email">
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="row">
                                    <span class=" text-black-50">Enter receiver's Email to start Chat</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-dark bg-opacity-10 p-3">
                            <div class="input-group">
                                <input type="text" class="form-control" style="font-size: 14px;" placeholder="Type your text" id="new_msg_txt">
                                <button class="btn-send rounded-end bg-pri" type="button" onclick="send_new_msg();"><img src="icon-svg/cursor-fill.svg"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>