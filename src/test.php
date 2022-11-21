<?php
// require('app/functions.php');
// require('app/connect_database.php');
// include('app/manage_parts/_header.php');

// $stmt = $pdo->query('SELECT `user_id`, `user_password` FROM `dummies_data`');
// $stmt->execute();
// $dummies_data = $stmt->fetchALL();

// $stmt = $pdo->prepare('UPDATE `dummies_data` SET `user_password` = :personal_pw WHERE `user_id` = :personal_id');

// foreach ($dummies_data as $personal_data) {

//     $hushed_pw = password_hash($personal_data["user_password"], PASSWORD_DEFAULT);

//     $stmt->bindValue(':personal_id', $personal_data["user_id"], PDO::PARAM_STR);
//     $stmt->bindValue(':personal_pw', $hushed_pw, PDO::PARAM_STR);


//     $stmt->execute();
// }

//password_verify($password, $hash)でハッシュをパスに戻せる

//ｺﾋﾟﾍﾟ用トークン送信フォーム
// <input type="hidden" name="token" value="<?= hsc($_SESSION['token']); ?>">
<?php
//コピペ用トークン受信部
