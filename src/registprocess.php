<?php
require('app/functions.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  validateToken();
}

try {
  //データベースへ接続
  $pdo = new PDO(
    'mysql:host=mysql;dbname=test_db;charset=utf8mb4',
    //↑これ改行入れるとだめくさい
    //ユーザー名
    'user_data_root',
    //パス
    'rootpass',
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

//接続テスト
//$stmt = $pdo->query("SELECT 1 + 1");
//$result = $stmt->fetch();
// var_dump($result);

include('app/_parts/_header.php');
?>
<?php
//まずは渡ってきた値を受ける

$regist_info = [
  "user_id" => hsc(filter_input(INPUT_POST, "user_id")),
  "user_password" => hsc(filter_input(INPUT_POST, "user_password")),
  "user_name" => hsc(filter_input(INPUT_POST, "user_name")),
  "user_sex" => filter_input(INPUT_POST, "user_sex"),
  "user_address" => hsc(filter_input(INPUT_POST, "user_address")),
  "user_tel" => hsc(trim(filter_input(INPUT_POST, "user_tel"))),
  "user_mail_address" => hsc(trim(filter_input(INPUT_POST, "user_mail_address"))),
  "user_mobile_device" => trim(filter_input(INPUT_POST, "user_mobile_device"))
];
//確認用のパスワードは別に受け取り
$user_pw_check = hsc(filter_input(INPUT_POST, "user_pw_check"));

//重複IDをチェックのため抽出
$stmt = $pdo->prepare(
  "SELECT user_id FROM users_data WHERE user_id = ?"
);
$stmt->bindValue(1, $regist_info["user_id"], PDO::PARAM_STR);
$stmt->execute();
$registed_id = $stmt->fetch();

// print_r($registed_id); //テスト


//未入力項目チェック
if (in_array("", $regist_info, true)) { ?>
  <ul class="alert_message">
    <?php
    foreach ($regist_info as $key => $entered) { ?>
      <?php
      if ($entered === "") {
        //キー名を表示のため日本語にする
        $japanse_key = "";
        if ($key === "user_id") {
          $japanse_key = "ID";
        } elseif ($key === "user_password") {
          $japanse_key = "パスワード";
        } elseif ($key === "user_name") {
          $japanse_key = "お名前";
        } elseif ($key === "user_sex") {
          $japanse_key = "性別";
        } elseif ($key === "user_address") {
          $japanse_key = "住所";
        } elseif ($key === "user_mail_address") {
          $japanse_key = "メールアドレス";
        } elseif ($key === "user_mobile_device") {
          $japanse_key = "モバイル端末";
        }
      ?>
        <li><?= $japanse_key ?>が未入力です。
        </li>
    <?php }
    } ?>
  </ul>
  <button type="button" onclick="history.back()" id="submit">戻る</button>
<?php
  //重複チェック
  //bool型を返す関数に対して配列オフセットを渡すと警告文が出る
} elseif (!empty($registed_id)) {
?>
  <p class="alert_message">そのIDは既に登録されているため使えません。</p>
  </div>
  <button type="button" onclick="history.back()" id="submit">戻る</button>
<?php
  //PW確認チェック 
} elseif ($regist_info["user_password"] !== $user_pw_check) { ?>
  <p class="alert_message">
    <>確認パスワードが合致していません。
  </p>
  <button type="button" onclick="history.back()" id="submit">戻る</button>
<?php
  //チェックが問題なければ登録
} else {
  //トランザクションは一気にレコードを複数挿入するなどクエリが複数ある時しか無意味なので削除。
  $stmt = $pdo->prepare('INSERT INTO users_data (user_id, user_password, user_name, user_sex, user_address, user_tel, user_mail_address, user_mobile_device) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
  $i = 1;
  foreach ($regist_info as $split_info) {
    // echo ($i . PHP_EOL);//テスト用
    if (gettype($split_info) === "integer") { //INTの場合。
      $stmt->bindValue($i, $split_info, PDO::PARAM_INT);
    } else { //stringはこちらへ誘導
      $stmt->bindValue($i, $split_info, PDO::PARAM_STR);
    }
    $i++;
    // echo ($split_info . PHP_EOL);//テスト用
  }
  $stmt->execute();
?>
  <p style="text-align: center; margin-top: 80px; font-size: x-large;">登録完了</p>
  <button type="button" onclick="location.href='dbtest.php'" id="submit">TOPへ戻る</button>
<?php
}
?>
<?php
include('app/_parts/_footer.php');
