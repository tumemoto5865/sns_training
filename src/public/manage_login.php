<?php
require('../app/functions.php');
//このページからのログイン以外は受け付けない。
createToken();
include('../app/manage_header.php');
?>
<main>
<h1>DB管理システムログイン</h1>
        <form action="db_manage.php" method="post">
            <span class="input-form">
                <p>
                    <label for="manager_id" class="manager_label">ID</label>
                    <input type="text" name="manager_id" id="manager_id"><br />
                </p>
                <p>
                    <label for="manager_pw" class="manager_label">パスワード</label>
                    <input type="password" name="manager_pw" id="manager_pw"><br />
                </p>
            </span>
            <input type="hidden" name="token" value="<?= hsc($_SESSION['token']); ?>">
            <p><input type="submit" value="送信" class="submit"></p>
        </form>
        <p>IDはabc</p>
        <p>PWはxyz<p>
</main>
<?php
include('../app/user_footer.php');
