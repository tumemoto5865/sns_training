<?php
require('app/manage_parts/functions.php');
include('app/user_parts/_header.php');

if (isset($_post['logout'])) {
   unset($_SESSION['manage_id']);
   unset($_SESSION['manage_pw']);
}

createToken()
?>
<main>
<h1>db_test</h1>
<p>ユーザーログイン</a></p>
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

<p id="manage_link"><a href="manage_login.php">DB管理</a></p>
</main>
<?php
include('app/user_parts/_footer.php');
