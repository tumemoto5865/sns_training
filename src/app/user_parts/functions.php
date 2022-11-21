<?php
session_start();//セッション開始

//文字実体参照の関数。
function hsc($str){
  return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}
//トークン生成関数
function createToken()
{
  if (!isset($_SESSION['token'])){
    $_SESSION['token'] = bin2hex(random_bytes(32));
  }
}
//トークンチェック関数
function validateToken()
{
  if (
  empty($_SESSION['token']) ||
  $_SESSION['token'] !== filter_input(INPUT_POST,'token')
  ) {
    exit('Invalid post request');
  }
}
//データベース接続
if (isset($_POST["manage_id"])) {
$_SESSION['manage_id'] = hsc($_POST["manage_id"]);
}
if (isset($_POST["manage_id"])) {
$_SESSION['manage_pw'] = hsc($_POST["manage_pw"]);
}
try {
    //データベースへ接続
    $pdo = new PDO(
        'mysql:host=mysql;dbname=test_db;charset=utf8mb4',
        //ユーザー名
        $_SESSION['manage_id'],
        //パス
        $_SESSION['manage_pw']
    );
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}
