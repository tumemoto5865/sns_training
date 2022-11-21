<?php
require('../private/app/functions.php');
validateLogin();
require('../private/app/connect_database.php');
include('../private/app/manage_header.php');

$edit_id = filter_input(INPUT_POST, "edit_id");

$edit_info = [
    "user_id" => hsc(filter_input(INPUT_POST, "user_id")),
    "user_name" => hsc(filter_input(INPUT_POST, "user_name")),
    "user_sex" => (int)filter_input(INPUT_POST, "user_sex"),
    "user_address" => hsc(filter_input(INPUT_POST, "user_address")),
    "user_tel" => hsc(trim(filter_input(INPUT_POST, "user_tel"))),
    "user_mail_address" => hsc(trim(filter_input(INPUT_POST, "user_mail_address"))),
    "user_mobile_device" => (int)filter_input(INPUT_POST, "user_mobile_device")
];

$stmt = $pdo->prepare('UPDATE `users_data` SET `user_id` = :user_id, `user_name` = :user_name, `user_sex` = :user_sex, `user_address` = :user_address, `user_tel` = :user_tel, `user_mail_address` = :user_mail_address, `user_mobile_device` = :user_mobile_device WHERE `user_id` = :edit_id');

foreach ($edit_info as $key => $value) {
    if (gettype($value) === "string") {
        $stmt->bindValue(':' . $key, $value, PDO::PARAM_STR);
    } else if (gettype($value) === "integer") {
        $stmt->bindValue(':' . $key, $value, PDO::PARAM_INT);
    }
}

$stmt->bindValue(':edit_id', $edit_id, PDO::PARAM_STR);

$stmt->execute();

?>
<p class="alert_message">編集完了</p>
<p><button type="button" onclick="location.href='searchresult.php'" class="submit">戻る</button></p>
<?php
include('../private/app/manage_footer.php');
