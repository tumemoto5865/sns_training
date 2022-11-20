<?php
require('app/functions.php');
include('app/_parts/_header.php');
createtoken();
?>
<h1>DB管理システムログイン</h1>
<main>
    <div class="manage">
        <form action="db_manage.php" method="post" class="manage">
            <span class="input-form">
                <p>
                    <label for="manage_id">ID</label for="manage_id" class="manage_label">
                    <input type="text" name="manage_id" id="manage_id"><br />
                </p>
                <p>
                    <label for="manage_pw" class="manage_label">パスワード</label>
                    <input type="text" name="manage_pw" id="manage_pw"><br />
                </p>
            </span>
            <!-- 念のためチェックトークンを生成してそれも送信 -->
            <input type="hidden" name="token" value="<?= hsc($_SESSION['token']); ?>">
            <p><input type="submit" value="送信" class="submit"></p>
        </form>
    </div>
</main>
<?php
include('app/_parts/_footer.php');
