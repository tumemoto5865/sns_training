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

//ログイン情報チェック
function validateLogin() {
    if (!isset($_SESSION['login'])) {
        include('../app/manage_header.php');
        ?>
        <p class="alert_message">ログインされていません。</p>
        <?php
        include('../app/manage_footer.php');
        exit;
    }
}
?>
