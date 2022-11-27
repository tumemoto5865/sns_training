<?php
require('../app/functions.php');
validateLogin();
require('../app/connect_database.php');
include('../app/manage_header.php');
$edit_id = filter_input(INPUT_POST, "edit_id");

$stmt = $pdo->prepare('DELETE FROM `users_data` WHERE `user_id` = :edit_id');

$stmt->bindValue(':edit_id', $edit_id, PDO::PARAM_STR);

$stmt->execute();

?>
<p class="alert_message">削除完了</p>
<p><button type="button" onclick="location.href='searchresult.php'" class="submit">戻る</button></p>
<?php
include('../app/manage_footer.php');
