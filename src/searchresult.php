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
//GET情報取得
// $search_info = [
//     "user_id" => !empty(filter_input(INPUT_GET, "user_id")) ? hsc("%" . filter_input(INPUT_GET, "user_id") . "%") : NULL,
//     "user_name" => !empty(filter_input(INPUT_GET, "user_name")) ? hsc("%" . filter_input(INPUT_GET, "user_name") . "%") : NULL,
//     "user_sex" => !empty(filter_input(INPUT_GET, "user_sex")) ? hsc("%" . filter_input(INPUT_GET, "user_sex") . "%") : NULL,
//     "user_address" => !empty(filter_input(INPUT_GET, "user_address")) ? hsc("%" . filter_input(INPUT_GET, "user_address") . "%") : NULL,
//     "user_tel" => !empty(filter_input(INPUT_GET, "user_tel")) ? hsc(trim("%" . filter_input(INPUT_GET, "user_tel")) . "%") : NULL,
//     "user_mail_address" => !empty(filter_input(INPUT_GET, "user_mail_address")) ? hsc(trim("%" . filter_input(INPUT_GET, "user_mail_address")) . "%") : NULL,
//     "user_mobile_device" => !empty(filter_input(INPUT_GET, "user_mobile_device")) ? hsc("%" . filter_input(INPUT_GET, "user_mobile_device") . "%") : NULL
// ];

//関数で動的に配列生成しよう。※array_pushは連想配列のキー指定追加はできない。
//融通を効かせられるよう受け取り方法変更…したかったけど逆に長くなった。しかもどうも挙動が上と違う気がする...関数の練習にはなったけれど...
//クエリ文も動的に生成(しようと思ったけどできなかった、考えてみればそれができたらプリペアドステートメントの意味がないかも)。関数を作って使ってみる。難しい。

function search_info_add($recieved_name)
{
// $search_info = [];
    //空欄だったらNULLを入れる
    if (filter_input(INPUT_GET, $recieved_name) === "") {
        global $search_info;
        $search_info[$recieved_name] = NULL;
    } else { //何か入ってたら$search_infoに追加していく。
        global $search_info;
        if ($recieved_name != "user_sex" && $recieved_name !=  "user_mobile_device") {
            $search_info[$recieved_name] = hsc("%" . filter_input(INPUT_GET, $recieved_name) . "%");
        } elseif ($recieved_name === "user_sex" || $recieved_name ===  "user_mobile_device") {
            $search_info[$recieved_name] = (int)(filter_input(INPUT_GET, $recieved_name));
        }
    }
};

    search_info_add("user_id");
    search_info_add("user_name");
    search_info_add("user_sex");
    search_info_add("user_address");
    search_info_add("user_tel");
    search_info_add("user_mail_address");
    search_info_add("user_mobile_device");

// var_dump($search_info);//テスト
// var_dump(array_keys($search_info));//テスト

//プレースホルダを使ってクエリを動的に生成できないかと長時間試したがどうやら無理らしい。考えて見れば当たり前な気もするが
// クエリに変数入れたいのでプリペアドステートメントを使う

$stmt = $pdo->prepare('SELECT user_id, user_name, user_sex, user_address, user_tel, user_mail_address, user_mobile_device FROM users_data WHERE 
        (user_id LIKE ? AND
        user_name LIKE ? AND
        user_sex LIKE ? AND
        user_address LIKE ? AND
        user_tel LIKE ? AND
        user_mail_address LIKE ? AND
        user_mobile_device LIKE ?)IS NOT FALSE ORDER BY user_name');

$stmt->bindValue(1, $search_info["user_id"], PDO::PARAM_STR);
$stmt->bindValue(2, $search_info["user_name"], PDO::PARAM_STR);
$stmt->bindValue(3, $search_info["user_sex"], PDO::PARAM_STR);
$stmt->bindValue(4, $search_info["user_address"], PDO::PARAM_STR);
$stmt->bindValue(5, $search_info["user_tel"], PDO::PARAM_STR);
$stmt->bindValue(6, $search_info["user_mail_address"], PDO::PARAM_STR);
$stmt->bindValue(7, $search_info["user_mobile_device"], PDO::PARAM_STR);
$stmt->execute();
$search_results = $stmt->fetchAll();
// var_dump($search_results);//テスト


//検索クエリ動的生成。入力されなかった項目はそもそもSELECTのカラム指定に入れないような文にした。これにより仮にカラムが増えてもこのスクリプトの変更部分が少なくなる。
//プレースホルダに名前を付け、バインド内容を考えればできるはず...と思ったけどできませんでした。
// $stmt = $pdo->prepare('SELECT * FROM users_data WHERE ORDER BY user_name');
// echo 'プリペアドステートメント準備';

// $search_values = '';

// if ($search_info === []) {
//     $search_values = '';
//     echo $selected_coulmns;
// } else {

//     foreach ($search_info as $key => $search_value) {
//         if ($key === array_key_last($search_info)) {
//             $search_values = $search_values . $key . " LIKE " . $search_value;
//         } elseif ($key === array_key_first($search_info)) {
//             $search_values = "WHERE " . $search_values . $key . " LIKE " . $search_value . " AND ";
//         } else {
//             $search_values = " " . $search_values . $key . " LIKE " . $search_value . " AND ";
//         }
//     }
// }
// // $search_values = '';//テスト用
// // echo $search_values;//テスト用
// // echo gettype($search_values);//テスト用
// $stmt->bindValue(':search_values', $search_values, PDO::PARAM_STR);
// $stmt->execute();
// $search_results = $stmt->fetchAll();
// 

?>
<main>
    <h1>検索結果</h1>

    <!-- よく見る検索結果件数に応じてページを切り替えになる仕組みを作る。 -->
    <?php
    //まずページ表示件数の変数。後で変更できるようにしたいが。
    $display_items_count = 20;
    //次に件数を調べる。$search_resultsの中を調べればいいはず
    $search_items_count = count($search_results);
    //トータルのページ数
    $max_page_count = ceil($search_items_count / $display_items_count);
    // echo $max_page_count;
    //表示しているページ。何もgetされてこなければ1ページ目とする
    $now_display = !isset($_GET['page_number']) ? 1 : (int)$_GET['page_number'];
    // echo "now_displayのデータ型は".gettype($now_display) . "です". PHP_EOL;//テスト 
    // echo "now_displayは". $now_display . "です";//テスト 

    //配列の何番目から表示する？
    $start_number = ($now_display - 1) * $display_items_count;
    // echo $start_number;//テスト
    // echo $display_items_count;//テスト
    //allayslice。便利な関数があったが忘れている。配列の中で*番目から*個分切り出す
    $display_search_results = array_slice($search_results, $start_number, $display_items_count, true);
    // var_dump($search_results)//テスト
    ?>

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
        foreach ($display_search_results as $personal_data) {
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
    <!-- ページ切り替えリンク生成 -->
    <p class="page_select">
        <?php
        for ($i = 1; $i < $max_page_count; $i++) {
            if ($i === $now_display) {
                echo $now_display . ' ';
            } else {
        ?>
                <!-- ポイントとしては、授受する値をGETにしておけばリンクとしてaタグに簡単に仕込めるっていうこと。INPUT系のはGETで授受すれば利用者がブックマークにして利用することもできる。検索関係はPOSTよりGETのが向いているようだ -->
                <a href="<?= $_SERVER['REQUEST_URI'] ?>&page_number=<?= $i ?>"><?= $i ?></a>
        <?php
            }
        }
        ?>
    </p>
    <!-- ページ切り替えリンク生成〆 -->

    <p><button type="button" onclick="location.href='search.php'" id="submit">検索画面へ戻る</button></p>
    </p>
    <button type="button" onclick="location.href='dbtest.php'" id="submit">TOPへ戻る</button>
</main>
<?php
include('app/_parts/_footer.php');
