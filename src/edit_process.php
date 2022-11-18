<?php
require('app/functions.php');
try {
    //データベースへ接続
    $pdo = new PDO(
        'mysql:host=mysql;dbname=test_db;charset=utf8mb4',
        //ユーザー名
        'test_db_docker',
        //パス
        'test_db_docker_pass',
        //PDOのオプションを指定
        [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}
include('app/_parts/_header.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateToken();
}

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
<p><button type="button" onclick="history.go(-2)" id="submit">戻る</button></p>
<?php
include('app/_parts/_footer.php');
