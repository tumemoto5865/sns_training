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
            PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
        );
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    
        require('app/functions.php');
    include('app/_parts/_header.php');
    ?>

<?php 
validateToken();
//POST情報取得
$search_info = [
    "ID"=>hsc("%" . filter_input(INPUT_POST, "user_id") . "%"),
    "お名前"=>hsc("%" . filter_input(INPUT_POST, "user_name") . "%"),
    "性別コード"=>filter_input(INPUT_POST, "user_sex"),
    "住所"=>hsc("%" . filter_input(INPUT_POST, "user_ad") . "%"),
    "電話番号"=>hsc(trim("%" . filter_input(INPUT_POST, "user_tel")) . "%"),
    "メールアドレス"=>hsc(trim("%" . filter_input(INPUT_POST, "user_mail")) . "%"),
    "モバイル端末コード"=>filter_input(INPUT_POST, "user_mobDev")
    ];

// if ($search_info["性別コード"] === "3") {
//     $search_info["性別コード"] = "CAST 1";
// }
// if ($search_info["モバイル端末コード"] === "4") {
//     $search_info["モバイル端末コード"] = 4;
// }

var_dump($search_info);//テスト

//クエリに変数入れたいのでプリペアドステートメントを使う(メモ)
echo ("ok");
$stmt = $pdo->prepare('SELECT ID, お名前, 性別コード 住所, 電話番号, メールアドレス, モバイル端末コード FROM user_data WHERE 
        ID LIKE ? AND
        お名前 LIKE ? AND
        性別コード ()mnmnvbvb ? AND
        住所 LIKE ? AND
        電話番号 LIKE ? AND
        メールアドレス LIKE ? AND
        モバイル端末コード () IS NOT FALSE 
        ORDER BY お名前');
$stmt->bindValue(1, $search_info["ID"], PDO::PARAM_STR);
$stmt->bindValue(2, $search_info["お名前"], PDO::PARAM_STR);
$stmt->bindValue(3, $search_info["性別コード"], PDO::PARAM_STR);
$stmt->bindValue(4, $search_info["住所"], PDO::PARAM_STR);
$stmt->bindValue(5, $search_info["電話番号"], PDO::PARAM_STR);
$stmt->bindValue(6, $search_info["メールアドレス"], PDO::PARAM_STR);
$stmt->bindValue(7, $search_info["モバイル端末コード"], PDO::PARAM_STR);
$stmt->execute();
$searchResults = $stmt->fetchAll();
var_dump($searchResults);//テスト


?>

<main>
    <h1>検索結果</h1>
    
    <!-- 検索結果結果表示開始 -->
    <table>
        <tr>
            <th>ID</th>
            <th>お名前</th>
            <th>住所</th>
            <th>電話番号</th>
            <th>メールアドレス</th>
        </tr>
<!-- これをforeachで増やす。 -->
        <?php 
        foreach ($searchResults as $personalData) {
            ?><tr>
                <td><?= $personalData["ID"]?></td>
                <td><?= $personalData["お名前"]?></td>
                <td><?= $personalData["性別コード"]?></td>
                <td><?= $personalData["住所"]?></td>
                <td><?= $personalData["電話番号"]?></td>
                <td><?= $personalData["メールアドレス"]?></td>
                <td><?= $personalData["モバイル端末コード"]?></td>
            </tr><?php
        }
        ?>
<!-- 増やすのはここまで -->
    </table>
    <!-- 検索結果表示終了 -->


  

<p><button type="button" onclick="history.back()" id="submit">戻る</button></p>
</p>
<button type="button" onclick="location.href='dbtest.php'" id="submit">TOPへ戻る</button>
</main>
<?php
    include('app/_parts/_footer.php');