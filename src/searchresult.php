<?php

require('app/functions.php');
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

include('app/_parts/_header.php');
?>

<?php
validateToken();
//POST情報取得
$search_info = [
    "user_id" => hsc("%" . filter_input(INPUT_POST, "user_id") . "%"),
    "user_name" => hsc("%" . filter_input(INPUT_POST, "user_name") . "%"),
    "user_sex" => hsc("%" . filter_input(INPUT_POST, "user_sex") . "%"),
    "user_address" => hsc("%" . filter_input(INPUT_POST, "user_address") . "%"),
    "user_tel" => hsc(trim("%" . filter_input(INPUT_POST, "user_tel")) . "%"),
    "user_mail_address" => hsc(trim("%" . filter_input(INPUT_POST, "user_mail_address")) . "%"),
    "user_mobile_device" => hsc("%" . filter_input(INPUT_POST, "user_mobile_device") . "%"),
];

// var_dump($search_info);//テスト

//クエリに変数入れたいのでプリペアドステートメントを使う(メモ)
$stmt = $pdo->prepare('SELECT user_id, user_name, CAST(user_sex AS CHAR(1)) AS user_sex, user_address, user_tel, user_mail_address, CAST(user_mobile_device AS CHAR(1)) AS user_mobile_device FROM users_data WHERE 
        user_id LIKE ? AND
        user_name LIKE ? AND
        user_sex LIKE ? AND
        user_address LIKE ? AND
        user_tel LIKE ? AND
        user_mail_address LIKE ? AND
        user_mobile_device LIKE ? ORDER BY user_name');
$stmt->bindValue(1, $search_info["user_id"], PDO::PARAM_STR);
$stmt->bindValue(2, $search_info["user_name"], PDO::PARAM_STR);
$stmt->bindValue(3, $search_info["user_sex"], PDO::PARAM_STR);
$stmt->bindValue(4, $search_info["user_address"], PDO::PARAM_STR);
$stmt->bindValue(5, $search_info["user_tel"], PDO::PARAM_STR);
$stmt->bindValue(6, $search_info["user_mail_address"], PDO::PARAM_STR);
$stmt->bindValue(7, $search_info["user_mobile_device"], PDO::PARAM_STR);
$stmt->execute();
$search_results = $stmt->fetchAll();
// var_dump($searchResults);//テスト


?>

<main>
    <h1>検索結果</h1>

    <!-- 検索結果結果表示開始 -->
    <table>
        <tr>
            <th>ID</th>
            <th>お名前</th>
            <th>性別コード</th>
            <th>住所</th>
            <th>電話番号</th>
            <th>メールアドレス</th>
            <th>モバイル端末コード</th>
        </tr>
        <!-- これをforeachで増やす。 -->
        <?php
        foreach ($search_results as $personal_data) {
        ?><tr>
                <td><?= $personal_data["user_id"] ?></td>
                <td><?= $personal_data["user_name"] ?></td>
                <td><?= $personal_data["user_sex"] ?></td>
                <td><?= $personal_data["user_address"] ?></td>
                <td><?= $personal_data["user_tel"] ?></td>
                <td><?= $personal_data["user_mail_address"] ?></td>
                <td><?= $personal_data["user_mobile_device"] ?></td>
            </tr><?php
                }
                    ?>
        <!-- 増やすのはここまで -->
    </table>
    <!-- 検索結果表示終了 -->

    <!-- よく見る検索結果件数に応じてページを切り替えになる仕組みを作る。 -->




    <p><button type="button" onclick="history.back()" id="submit">戻る</button></p>
    </p>
    <button type="button" onclick="location.href='dbtest.php'" id="submit">TOPへ戻る</button>
</main>
<?php
include('app/_parts/_footer.php');
