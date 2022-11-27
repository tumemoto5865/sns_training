<?php
require('../app/functions.php');
//このページからのログイン以外は受け付けない。
createToken();
include('../app/user_header.php');

if (isset($_POST['logout'])) {
    if (isset($_SESSION['login'])) {
        unset($_SESSION['login']);
    }
}
?>
<main>
<h1>db_test</h1>
<p>ユーザーログイン</p>
        <form action="user_login_process.php" method="post">
            <span class="input-form">
                <p>
                    <label for="end_user_id" class="user_label">ID</label>
                    <input type="text" name="end_user_id" id="end_user_id"><br />
                </p>
                <p>
                    <label for="end_user_pw" class="user_label">パスワード</label>
                    <input type="password" name="end_user_pw" id="end_user_pw"><br />
                </p>
            </span>
            <input type="hidden" name="token" value="<?= hsc($_SESSION['token']); ?>">
            <p><input type="submit" value="送信" class="submit"></p>
        </form>

<p id="manage_link"><a href="manage_login.php">DB管理</a></p>
</main>
<?php
include('../app/user_footer.php');
