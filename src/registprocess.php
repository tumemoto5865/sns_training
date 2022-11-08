<?php
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

require('app/functions.php');
include('app/_parts/_header.php');
?>
<?php
//まずは渡ってきた値を受ける

// $user_id = trim(filter_input(INPUT_POST, "user_id"));
// $user_id = $user_id !== "" ? $user_id : "IDが空欄です";

// $user_pw = trim(filter_input(INPUT_POST, "user_pw"));
// $user_pw = $user_pw !== "" ? $user_pw : "パスワードが空欄です";

// $user_name = trim(filter_input(INPUT_POST, "user_name"));
// $user_name = $user_name !== "" ? $user_name : "お名前が空欄です";

// $user_ad = trim(filter_input(INPUT_POST, "user_ad"));
// $user_ad = $user_ad !== "" ? $user_ad : "住所が空欄です";

// $user_tel = trim(filter_input(INPUT_POST, "user_tel"));
// $user_tel = $user_tel !== "" ? $user_tel : "電話番号が空欄です";

//スッキリと配列にして受け取るべし。htmlspecialcharactorsも使っておく。
$regist_info = [
  "ID"=>hsc(filter_input(INPUT_POST, "user_id")),
  "パスワード"=>hsc(filter_input(INPUT_POST, "user_pw")),
  "お名前"=>hsc(filter_input(INPUT_POST, "user_name")),
  "住所"=>hsc(filter_input(INPUT_POST, "user_ad")),
  "電話番号"=>hsc(trim(filter_input(INPUT_POST, "user_tel"))),
  "メールアドレス"=>hsc(trim(filter_input(INPUT_POST, "user_mail")))
];
//確認用のパスワードは別に受け取り
$user_pw_check = hsc(filter_input(INPUT_POST, "user_pw_check"));


if (in_array("", $regist_info, true)) { ?>
  <div class=input-invalid>
  <ul>
  <?php
  foreach($regist_info as $key=>$entered) { ?>
    <?php 
    if($entered === "") { ?>
        <li><?= $key ?>が未入力です。
        </li>
    <?php }
  } ?>
  </ul>
  </div>
  <button type="button" onclick="history.back()" id="submit">戻る</button>
<?php
} elseif ($regist_info["パスワード"] !== $user_pw_check) { ?>
  <p style="text-align: center; margin-top: 80px; font-size: large;">確認パスワードが合致していません。</p>
  </div>
  <button type="button" onclick="history.back()" id="submit">戻る</button>
<?php
} else {


  //配列にしたはいいがプリペアドステートメントに配列を渡して一気に処理する方法がわからなかったのでforeachでひとつずつやるしか...
$stmt = $pdo->prepare('INSERT INTO user_data (ID, パスワード, お名前, 住所, 電話番号, メールアドレス) VALUE (?, ?, ?, ?, ?, ?)');
$i = 1;
foreach($regist_info as $split_info) {
  // echo ($i . PHP_EOL);
  $stmt->bindValue($i, $split_info , PDO::PARAM_STR);
  $i++;
  // echo ($split_info . PHP_EOL);
  
}
$i = 1;
$stmt->execute();
?>
<p style="text-align: center; margin-top: 80px; font-size: x-large;">登録完了</p>
<button type="button" onclick="location.href='dbtest.php'" id="submit">TOPへ戻る</button>
<?php 
}
?>
  
  
  
  <?php
    include('app/_parts/_footer.php');