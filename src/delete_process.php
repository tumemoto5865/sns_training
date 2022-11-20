<?php
require('app/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateToken();
include('app/_parts/_header.php');
}
$edit_id = filter_input(INPUT_POST, "edit_id");

$stmt = $pdo->prepare('DELETE FROM `users_data` WHERE `user_id` = :edit_id');

$stmt->bindValue(':edit_id', $edit_id, PDO::PARAM_STR);

$stmt->execute();

?>
<p class="alert_message">削除完了</p>
<p><button type="button" onclick="history.go(-2)" class="submit">戻る</button></p>
<?php
include('app/_parts/_footer.php');
