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
      <label for ="id">ID</label>
      <input type="text" pattern="^[a-zA-Z0-9\S_]+$" name="user_id" id="id">※半角英数字とアンダースコアのみです<br />
    </p>
    <p>
      <label for ="pw">パスワード</label>
      <input type="password"  pattern="^[a-zA-Z0-9]+$" name="user_pw" id="pw">※半角英数字とアンダースコアのみです<br />
    </p>

    <p>
      <label for ="user_pw_check">パスワード(確認)</label>
      <input type="password"  pattern="^[a-zA-Z0-9]+$" name="user_pw_check" id="user_pw_check">※上と同じものを入力してください<br />
    </p>

    <p>
      <label for ="name">お名前</label>
      <input type=text name="user_name" id="name"><br />
    </p>
    <p>
      <label for ="ad">住所</label>
      <input type=text name="user_ad" id="ad"><br />
    </p>
    <p>    
      <label for ="tel">電話番号</label>
      <input type=text pattern="^[0-9]+$" name="user_tel" id="tel">※ハイフンなし数字のみで入力してください<br />
    </p>
    <p>    
      <label for ="mail">メールアドレス</label>
      <input type=text pattern="^[a-zA-Z0-9-_\.]+@[a-zA-Z0-9-_\.]+$" name="user_mail" id="mail">※example@example<br />
    </p>
    </span>
    <p>
      <input type="hidden" name="token" value="<?= hsc($_SESSION['token']);?>">
      <input type="submit" value="登録" id="submit">
    </div>
    </p>
  </form>
  <button type="button" onclick="location.href='dbtest.php'" id="submit">TOPへ戻る</button>
<?php
  include('app/_parts/_footer.php');