<?php
require('app/functions.php');
$_SESSION['manage_id'] = $_POST["manage_id"];
$_SESSION['manage_pw'] = $_POST["manage_pw"];

include('app/_parts/_header.php');
createToken();
?>
<main>
    <h1>DB管理</h1>
    <p><a href="regist.php">登録</a></p>
    <p><a href="search.php">検索</a></p>

    <p>
    <form action="dummies_data_process.php" method="post">

        <input type="hidden" name="token" value="<?= hsc($_SESSION['token']); ?>">

        <button class="button" type="submit" name="dummies_install" value="1">ダミーデータ500件挿入</button>

        <button class="button" type="submit" name="dummies_install" value="0">挿入したダミーデータを削除</button>

    </form>
    </p>
</main>
<?php
include('app/_parts/_footer.php');
