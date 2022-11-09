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
$serch_info = [
    "ID"=>hsc(filter_input(INPUT_POST, "user_id")),
    "お名前"=>hsc(filter_input(INPUT_POST, "user_name")),
    "住所"=>hsc(filter_input(INPUT_POST, "user_ad")),
    "電話番号"=>hsc(trim(filter_input(INPUT_POST, "user_tel"))),
    "メールアドレス"=>hsc(trim(filter_input(INPUT_POST, "user_mail")))
    ];

//サーチ情報挿入予定

//クエリに変数入れたいのでプリペアドステートメントを使う(メモ)
$stmt = $pdo->query(
    "SELECT * FROM user_data"
    WHERE ID LIKE "ID");
$stmt->bindValue(1, , PDO::PARAM_STR);
$stmt->execute();

$results = $stmt->fetchAll();

// var_dump($results);//テスト

?>

<main>
    <h1>検索フォーム</h1>
    
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
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
<!-- 増やすのはここまで -->
    </table>
    <!-- 検索結果表示終了 -->


  

</form>
</p>
<button type="button" onclick="location.href='dbtest.php'" id="submit">TOPへ戻る</button>
</main>
<?php
    include('app/_parts/_footer.php');