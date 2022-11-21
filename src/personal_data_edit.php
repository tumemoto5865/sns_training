<?php
require('app/functions.php');
include('app/manage_parts/_header.php');
createToken();

// echo($_POST["edit_record"]);//post受け取りテスト
$stmt = $pdo->query('SELECT user_id, user_name, user_sex, user_address, user_tel, user_mail_address, user_mobile_device FROM users_data WHERE user_id = "' . $_POST["edit_record"] . '"');
$edit_record = ($stmt->fetch());
?>


<main>
    <h1>データ編集・削除</h1>

    <form action="edit_process.php" method="post">
        <span class="input-form">
            <p>
                <input type="hidden" name="edit_id" value="<?= $edit_record["user_id"] ?>">
                <label for="user_id">ID</label>
                <input type="text" pattern="^[a-zA-Z0-9_]+$" name="user_id" id="user_id" value="<?= $edit_record["user_id"] ?>">※半角英数字とアンダースコアのみです<br />
            </p>
            <p>
                <label for="user_name">お名前</label>
                <input type=text name="user_name" id="user_name" value="<?= $edit_record["user_name"] ?>"><br />
            </p>
            <p>
                <label for="user_sex">性別</label>
                <input type="radio" name="user_sex" value="1" id="user_sex1"
                <?php
                    $edit_record["user_sex"] === 1 ? print "checked" : print "";
                ?>
                >男性
                <input type="radio" name="user_sex" value="2" id="user_sex2"
                <?php
                        $edit_record["user_sex"] === 2 ? print "checked" : print "";
                    ?>
                >女性<br />
            </p>
            <p>
                <label for="user_address">住所</label>
                <input type=text name="user_address" id="user_address" value="<?= $edit_record["user_address"] ?>"><br />
            </p>
            <p>
                <label for="user_tel">電話番号</label>
                <input type=text pattern="^[0-9]+$" name="user_tel" id="user_tel" value="<?= $edit_record["user_tel"] ?>">※ハイフンなし数字のみで入力してください<br />
            </p>
            <p>
                <label for="user_mail_address">メールアドレス</label>
                <input type=text pattern="^[a-zA-Z0-9-_\.]+@[a-zA-Z0-9-_\.]+$" name="user_mail_address" id="user_mail_address" value="<?= $edit_record["user_mail_address"] ?>">※example@example<br />
            </p>
            <p>
                <label for="user_mobile_device">モバイル端末</label>
                <select name="user_mobile_device" id=user_mobile_device>
                    <option value="1"
                    <?php
                    $edit_record["user_mobile_device"] === 1 ? print "selected" : print "";
                    ?>
                    >iphone</option>
                    <option value="2"
                    <?php
                    $edit_record["user_mobile_device"] === 2 ? print "selected" : print "";
                    ?>
                    >android</option>
                    <option value="3"
                    <?php
                    $edit_record["user_mobile_device"] === 3 ? print "selected" : print "";
                    ?>
                    >その他</option>
                </select><br />
            </p>
        </span>
        <p>
            <input type="hidden" name="token" value="<?= hsc($_SESSION['token']); ?>">
            <input type="submit" value="登録" class="submit">
        </p>
        </div>
    </form>
    <p>
        <form action="delete_process.php" method="post">
            <input type="hidden" name="edit_id" value="<?= $edit_record["user_id"] ?>">
            <input type="hidden" name="token" value="<?= hsc($_SESSION['token']); ?>">
            <input type="submit" value="削除" class="submit">
        </form>
    </p>
    <p><button type="button" onclick="history.back()" class="submit">戻る</button></p>
</main>
<?php
include('app/manage_parts/_footer.php');
