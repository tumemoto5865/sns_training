<?php
require('../private/app/functions.php');
include('../private/app/manage_header.php');
createToken();
?>
<main>
    <h1>データベース練習</h1>
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
include('../private/app/manage_footer.php');
