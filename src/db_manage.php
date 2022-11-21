<?php
require('app/functions.php');
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    //トークンチェック。ログインページ以外からのPOSTリクエストは受け付けない
    validateToken();
    
    //認証
    $manager_info = [
        'manager_id' => hsc(filter_input(INPUT_POST, 'manager_id')),
        'manager_pw' => hsc(filter_input(INPUT_POST, 'manager_pw')),
    ];

    require('app/connect_database.php');
    $stmt = $pdo->prepare('SELECT * FROM managers_data WHERE `manager_id` = :manager_id');
    $stmt->bindValue(':manager_id', $manager_info['manager_id'], PDO::PARAM_STR);
    $stmt->execute();
    $registerd_info = $stmt->fetch();

    if (empty($registerd_info)) {
        include('app/error_parts/_header.php');
        ?>
        <p class="alert_message">ログイン情報が間違っています。</p>
        <p><button type="button" onclick="history.back()" class="submit">戻る</button></p>
        <?php
        include('app/error_parts/_footer.php');
        exit;
    } elseif (
        password_verify(
            $manager_info['manager_pw'],
            $registerd_info['manager_password']
        )
    ) {
        $_SESSION['login'] = bin2hex(random_bytes(32));
        setcookie('login', $_SESSION['login']);
    } else {
        include('app/error_parts/_header.php');
        ?>
        <p class="alert_message">ログイン情報が間違っています。</p>
        <p><button type="button" onclick="history.back()" class="submit">戻る</button></p>
        <?php
        include('app/error_parts/_footer.php');
        exit;
    }
} else {
    validateLogin();
}
include('app/manage_parts/_header.php');
?>
<main>
    <h1>DB管理</h1>
    <p><a href="regist.php">登録</a></p>
    <p><a href="search.php">検索</a></p>

    <p>
    <form action="dummies_data_process.php" method="post">
        <button class="button" type="submit" name="dummies_install" value="1">
            ダミーデータ500件挿入</button>
        <button class="button" type="submit" name="dummies_install" value="0">
            挿入したダミーデータを削除</button>
    </form>
    </p>
</main>
<?php
include('app/manage_parts/_footer.php');
