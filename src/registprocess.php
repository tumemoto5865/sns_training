<?php
require('app/functions.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateToken();
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
    "user_sex" => (int)filter_input(INPUT_POST, "user_sex"),
    "user_address" => hsc(filter_input(INPUT_POST, "user_address")),
    "user_tel" => hsc(trim(filter_input(INPUT_POST, "user_tel"))),
    "user_mail_address" => hsc(trim(filter_input(INPUT_POST, "user_mail_address"))),
    "user_mobile_device" => (int)(filter_input(INPUT_POST, "user_mobile_device"))
];
//確認用のパスワードは別に受け取り
$user_pw_check = hsc(filter_input(INPUT_POST, "user_pw_check"));



//重複IDをチェックのため抽出
$stmt = $pdo->prepare(
    "SELECT user_id FROM users_data WHERE user_id = :registed_ID"
);
$stmt->bindValue(':registed_ID', $regist_info["user_id"], PDO::PARAM_STR);
$stmt->execute();
$registed_id = $stmt->fetch();

// print_r($registed_id); //テスト


//未入力項目チェック
if (in_array("", $regist_info, true)) {
    //キー名を表示のため日本語にする
    $japanse_key = [
        "user_id" => "ID",
        "user_password" => "パスワード",
        "user_name" => "お名前",
        "user_sex" => "性別",
        "user_address" => "住所",
        "user_tel" => "電話番号",
        "user_mail_address" => "メールアドレス",
        "user_mobile_device" => "モバイル端末"
    ];
?>
    <ul class="alert_message">
        <?php
        foreach ($regist_info as $key => $entered) {
            if ($entered === "" or $entered === null) {
        ?>
                <li><?= $japanse_key[$key] ?>が未入力です。
                </li>
        <?php }
        } ?>
    </ul>
    <p><button type="button" onclick="history.back()" class="submit">戻る</button></p>
<?php
    //重複チェック
    //bool型を返す関数に対して配列オフセットを渡すと警告文が出る
} elseif (!empty($registed_id)) {
?>
    <p class="alert_message">そのIDは既に登録されているため使えません。</p>
    </div>
    <p><button type="button" onclick="history.back()" class="submit">戻る</button></p>
<?php
    //PW確認チェック
} elseif ($regist_info["user_password"] !== $user_pw_check) { ?>
    <p class="alert_message">
        <>確認パスワードが合致していません。
    </p>
    <p><button type="button" onclick="history.back()" class="submit">戻る</button></p>
<?php
//チェックが問題なければ登録プロセス開始
} else {
    //パスワードをハッシュ化
    $regist_info['user_password'] = password_hash($regist_info['user_password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('INSERT INTO `users_data` (`user_id`, `user_password`, `user_name`, `user_sex`, `user_address`, `user_tel`, `user_mail_address`, `user_mobile_device`) VALUES (:user_id, :user_password, :user_name, :user_sex, :user_address, :user_tel, :user_mail_address, :user_mobile_device)');
    //プレースホルダの型付け関数
    $place_holder_type = function ($value) {
        if (gettype($value) === 'integer') {
            return PDO::PARAM_INT;
        } else {
            return PDO::PARAM_STR;
        }
    };
    //バインド
    foreach ($regist_info as $key => $split_info) {
        $stmt->bindValue(':' . $key, $split_info, $place_holder_type($split_info));
    }
    $stmt->execute();
    ?>
<p style="text-align: center; margin-top: 80px; font-size: x-large;">登録完了</p>
<?php
}
?>
<button type="button" onclick="location.href='db_manage.php'" class="submit">TOPへ戻る</button>

<?php
include('app/_parts/_footer.php');
