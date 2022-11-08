<?php
<<<<<<< HEAD
// session_start();//セッション開始
=======
session_start();//セッション開始
>>>>>>> 20221107hasegawa

//文字実体参照の関数。
function hsc($str){
  return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
<<<<<<< HEAD
=======
}
//トークン生成関数
function createtoken()
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
>>>>>>> 20221107hasegawa
}