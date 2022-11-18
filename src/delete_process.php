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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateToken();
include('app/_parts/_header.php');
}
$edit_id = filter_input(INPUT_POST, "edit_id");

$stmt = $pdo->query('DELETE FROM `users_data` WHERE `user_id` = ' . '\'' . $edit_id . '\'');

$stmt->execute();

?>
<p class="alert_message">削除完了</p>
<p><button type="button" onclick="history.go(-2)" class="submit">戻る</button></p>
<?php
include('app/_parts/_footer.php');
