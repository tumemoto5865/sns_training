<?php
require('app/functions.php');
include('app/_parts/_header.php');

createToken();
?>
<h1>登録フォーム</h1>
<div class="main">
  <form action="registProcess.php" method="post">
    <span class="input-form">
      <p>
        <label for="user_id">ID</label>
        <input type="text" pattern="^[a-zA-Z0-9_]+$" name="user_id" id="user_id">※半角英数字とアンダースコアのみです<br />
      </p>
      <p>
        <label for="user_password">パスワード</label>
        <input type="password" pattern="^[a-zA-Z0-9_]+$" name="user_password" id="user_password">※半角英数字とアンダースコアのみです<br />
      </p>

      <p>
        <label for="user_pw_check">パスワード(確認)</label>
        <input type="password" pattern="^[a-zA-Z0-9]+$" name="user_pw_check" id="user_pw_check">※上と同じものを入力してください<br />
      </p>
      <p>
        <label for="user_name">お名前</label>
        <input type=text name="user_name" id="user_name"><br />
      </p>
      <p>
        <label for="user_sex">性別</label>
        <input type="radio" name="user_sex" value="1" id="user_sex1" style>男性
        <input type="radio" name="user_sex" value="2" id="user_sex2">女性<br />
      </p>
      <p>
        <label for="user_address">住所</label>
        <input type=text name="user_address" id="user_address"><br />
      </p>
      <p>
        <label for="user_tel">電話番号</label>
        <input type=text pattern="^[0-9]+$" name="user_tel" id="user_tel">※ハイフンなし数字のみで入力してください<br />
      </p>
      <p>
        <label for="user_mail_address">メールアドレス</label>
        <input type=text pattern="^[a-zA-Z0-9-_\.]+@[a-zA-Z0-9-_\.]+$" name="user_mail_address" id="user_mail_address">※example@example<br />
      </p>
      <p>
        <label for="user_mobile_device">モバイル端末</label>
        <select name="user_mobile_device" id=user_mobile_device>
          <option value="1">iphone</option>
          <option value="2">android</option>
          <option value="3">その他</option>
        </select><br />
      </p>
    </span>
    <p>
      <input type="hidden" name="token" value="<?= hsc($_SESSION['token']); ?>">
      <input type="submit" value="登録" class="submit">
    </p>
</div>
</form>
<button type="button" onclick="location.href='db_manage.php'" class="submit">TOPへ戻る</button>

<?php
include('app/_parts/_footer.php');
