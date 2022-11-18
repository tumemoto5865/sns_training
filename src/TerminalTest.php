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
// echo bin2hex(random_bytes(16));

$stmt = $pdo->query('SELECT `user_id` FROM `dummies_data`');
$stmt->execute();
$user_ids = $stmt->fetchALL();


foreach ($user_ids as $id) {

$stmt = $pdo->query('UPDATE `dummies_data` SET `user_salt` = ' . '\'' . bin2hex(random_bytes(8)) . '\'' . ' WHERE `user_id` = ' . '\'' . $id . '\'');
$stmt->execute();

}
//cryptでハッシュ化
