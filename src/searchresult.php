<?php
require('app/functions.php');
try {
    //データベースへ接続
    $pdo = new PDO(
        'mysql:host=mysql;dbname=test_db;charset=utf8mb4',
        //ユーザー名
        'test_db_docker',
        //パス
        'test_db_docker_pass',
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

//cookieにURLクエリを保存しておく
if (strpos($_SERVER['HTTP_REFERER'], 'search.php')) {
    setcookie("search_querys", $_SERVER['QUERY_STRING']);
}
// ついでにsetcookie直後のページネイションリンク作成の際におかしくならないように
$search_querys = $_SERVER['QUERY_STRING'] ?? $_COOKIE['search_querys'];

//1ページあたりの表示件数のcookie
if (isset($_GET['display_items_count'])) {
    setcookie("display_items_count", $_GET['display_items_count']);
}
include('app/_parts/_header.php');
?>

<?php
//GET情報取得
$search_info = [];
if (!empty($_GET['user_id'])) {
    $search_info['user_id'] = $_GET['user_id'];
}
if (!empty($_GET['user_name'])) {
    $search_info['user_name'] = $_GET['user_name'];
}
if (!empty($_GET['user_sex'])) {
    (int)$search_info['user_sex'] = $_GET['user_sex'];
}
if (!empty($_GET['user_address'])) {
    $search_info['user_address'] = $_GET['user_address'];
}
if (!empty($_GET['user_tel'])) {
    $search_info['user_tel'] = $_GET['user_tel'];
}
if (!empty($_GET['user_mail_address'])) {
    $search_info['user_mail_address'] = $_GET['user_mail_address'];
}
if (!empty($_GET['user_mobile_device'])) {
    (int)$search_info['user_mobile_device'] = $_GET['user_mobile_device'];
}
// var_dump($search_info);//テスト
$WHERE_condition = function ($search_info) {
    $WHERE_condition = "";
    $count = 1;
    foreach ($search_info as $key => $value) {
        if (!empty($key)) {
            if ($count === 1) {
                $WHERE_condition = " WHERE " . $key . " LIKE :" . $key;
            } else {
                $WHERE_condition .= " AND " . $key . " LIKE :" . $key;
            }
            $count++;
        }
    }
    return $WHERE_condition;
};
// echo $WHERE_condition($search_info);//テスト

$stmt = $pdo->prepare('SELECT user_id, user_name, user_sex, user_address, user_tel, user_mail_address, user_mobile_device FROM users_data' . $WHERE_condition($search_info) . ' ORDER BY user_name');

foreach ($search_info as $key => $value) {
    if (gettype($value) === "string") {
        $stmt->bindValue(':' . $key, "%" . $value . "%", PDO::PARAM_STR);
    } else if (gettype($value) === "integer") {
        $stmt->bindValue(':' . $key, $value, PDO::PARAM_INT);
    }
}

$stmt->execute();
$search_results = $stmt->fetchAll();
// var_dump($search_results);//テスト

?>
<main>
  <h1>検索結果</h1>
  <form class="display_items_count">
    <select onChange="location.href=value" ;>
      <option selected>表示件数</option>
      <option value="searchresult.php?<?= $search_querys ?>&display_items_count=20">20件ごと</option>
      <option value="searchresult.php?<?= $search_querys ?>&display_items_count=30">30件ごと</option>
      <option value="searchresult.php?<?= $search_querys ?>&display_items_count=50">50件ごと</option>
      <option value="searchresult.php?<?= $search_querys ?>&display_items_count=100">100件ごと</option>
    </select>
  </form>
  <?php
    //まずページ表示件数の変数。
    $display_items_count = $_GET['display_items_count'] ?? $_COOKIE["display_items_count"] ?? 20;
    //次に全体件数を調べる。$search_resultsの中を調べればいいはず
    $search_items_count = count($search_results);
    //トータルのページ数
    $max_page_count = ceil($search_items_count / $display_items_count);
    //表示しているページ。何もgetされてこなければ1ページ目とする
    $now_display = !isset($_GET['page_number']) ? 1 : (int)$_GET['page_number'];
    // echo "now_displayのデータ型は".gettype($now_display) . "です". PHP_EOL;//テスト
    // echo "now_displayは". $now_display . "です";//テスト
    //配列の何番目から表示する？
    $start_number = ($now_display - 1) * $display_items_count;
    // echo $start_number;//テスト
    // echo $display_items_count;//テスト
    //allayslice。配列の中で*番目から*個分切り出す
    $display_search_results = array_slice($search_results, $start_number, $display_items_count, true);
    // var_dump($search_results);//テスト

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
      <th>編集ボタン作成予定</th>
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
      <td>編集ボタン作成予定</td>
    </tr><?php
    }
        ?>

    <!-- 増やすのはここまで -->
  </table>
  <!-- 検索結果表示終了 -->
  <!-- ページ切り替えリンク生成 -->
  <p class="page_select">
    <?php
        for ($i = 1; $i <= $max_page_count; $i++) {
            if ($i === $now_display) {
                echo $now_display . ' ';
            } else {
                ?>
    <a href="searchresult.php?<?= $search_querys ?>&page_number=<?= $i ?>"><?= $i ?></a>
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
