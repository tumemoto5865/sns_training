<?php
require('../app/functions.php');
validateLogin();
require('../app/connect_database.php');


include('../app/manage_header.php');
validateLogin();
?>
<?php
//cookieに検索のURLクエリを保存しておく。
$search_info = [];
if (strpos($_SERVER['HTTP_REFERER'], 'search.php')) {
    setcookie('search_querys', $_SERVER['QUERY_STRING']);
    parse_str($_SERVER['QUERY_STRING'], $search_querys);
} else {
    parse_str($_COOKIE['search_querys'], $search_querys);
}

//ソート情報がcookieに保存されていればそれを入れた配列を、cookieが存在しなければ空の配列を作成
//GET情報取得
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
$where_conndition = function ($search_info) {
    $where_conndition = "";
    $count = 1;
    foreach ($search_info as $key => $value) {
        if (!empty($key)) {
            if ($count === 1) {
                $where_conndition = " WHERE " . $key . " LIKE :" . $key;
            } else {
                $where_conndition .= " AND " . $key . " LIKE :" . $key;
            }
            $count++;
        }
    }
    return $where_conndition;
};

$search_querys = (http_build_query($search_querys));
// echo $where_conndition($search_info);//テスト

$sort_info = [];
if (!empty($_COOKIE['sort_info'])) {
    parse_str($_COOKIE['sort_info'], $sort_info);//クエリ文字列を変数に
}
//get情報が渡ってきたら追加していく。cookieも更新。
if (!empty($_GET["sort_column"])) {
    if (array_key_exists($_GET["sort_column"], $sort_info)) {
        if ($sort_info[$_GET["sort_column"]] === 'ASC') {
            unset($sort_info[$_GET["sort_column"]]);
            $addvalue[$_GET["sort_column"]] = 'DESC';
            $sort_info = array_merge($addvalue, $sort_info);
        } else if ($sort_info[$_GET["sort_column"]] === 'DESC') {
            unset($sort_info[$_GET["sort_column"]]);
            $addvalue[$_GET["sort_column"]] = 'ASC';
            $sort_info = array_merge($addvalue, $sort_info);
        }
    } else {
        $addvalue[$_GET["sort_column"]] = 'ASC';
        $sort_info = array_merge($addvalue, $sort_info);
    }
    //文字列に変換してcookieに保存する。
    setcookie('sort_info', http_build_query($sort_info));
}
// var_dump($sort_info);//テスト

//1ページあたりの表示件数のcookie
if (isset($_GET['display_items_count'])) {
    setcookie("display_items_count", $_GET['display_items_count']);
}

//ORDER BY文生成
$oreder_by_condition = function ($sort_info) {
    $oreder_by_condition = "";
    $count = 1;
    foreach ($sort_info as $key => $order_condition) {
        if (!empty($key)) {
            if ($count === 1) {
                $oreder_by_condition = " ORDER BY `" . $key . "` " . $order_condition;
            } else {
                $oreder_by_condition .= ", `" . $key . "` " . $order_condition;
            }
            $count++;
        }
    }
    return $oreder_by_condition;
};
// echo $oreder_by_condition($sort_info);//テスト

$stmt = $pdo->prepare('SELECT user_id, user_name, user_sex, user_address, user_tel, user_mail_address, user_mobile_device FROM users_data' . $where_conndition($search_info) . $oreder_by_condition($sort_info));

foreach ($search_info as $key => $value) {
    if (gettype($value) === "string") {
        $stmt->bindValue(':' . $key, "%" . $value . "%", PDO::PARAM_STR);
    } else if (gettype($value) === "integer") {
        $stmt->bindValue(':' . $key, $value, PDO::PARAM_INT);
    }
}

//ここでソートのバインドを行う
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
            <th><a href="searchresult.php?<?= $search_querys ?>&sort_column=user_id">ID</a></th>
            <th><a href="searchresult.php?<?= $search_querys ?>&sort_column=user_name">お名前</a></th>
            <th><a href="searchresult.php?<?= $search_querys ?>&sort_column=user_sex">性別コード</a></th>
            <th><a href="searchresult.php?<?= $search_querys ?>&sort_column=user_address">住所</a></th>
            <th><a href="searchresult.php?<?= $search_querys ?>&sort_column=user_tel">電話番号</a></th>
            <th><a href="searchresult.php?<?= $search_querys ?>&sort_column=user_mail_address">メールアドレス</a></th>
            <th><a href="searchresult.php?<?= $search_querys ?>&sort_column=user_mobile_device">モバイル端末コード</a></th>
            <th></th>
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
                <td>
                    <form action="personal_data_edit.php" method="post">
                        <input type="hidden" name="edit_record" value="<?= $personal_data["user_id"] ?>">
                        <input type="submit" id="edit_button" value="編集・削除">
                    </form>
                </td>
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

    <p><button type="button" onclick="location.href='search.php'" class="submit">検索画面へ戻る</button></p>
    <p>
        <button type="button" onclick="location.href='db_manage.php'" class="submit">管理TOPへ戻る</button>
    </p>
</main>
<?php
include('../app/manage_footer.php');
