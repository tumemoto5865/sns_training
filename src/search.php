<?php
require('app/functions.php');
include('app/_parts/_header.php');

createToken();
?>
<main>
<h1>検索フォーム</h1>
  <div class="main">


    <form action="searchresult.php" method="post">
    <span class="input-form">
    <p>
      <label for ="user_id">ID</label>
      <input type="text" pattern="^[a-zA-Z0-9\S_]+$" name="user_id" id="user_id"><br />
    </p>
    <p>
      <label for ="user_name">お名前</label>
      <input type=text name="user_name" id="user_name"><br />
    </p>
    <p>
      <label for ="user_ad">住所</label>
      <input type=text name="user_ad" id="user_ad"><br />
    </p>
    <p>    
      <label for ="user_tel">電話番号</label>
      <input type=text pattern="^[0-9]+$" name="user_tel" id="user_tel"><br />
    </p>
    <p>    
      <label for ="user_mail">メールアドレス</label>
      <input type=text pattern="^[a-zA-Z0-9-_\.]+@[a-zA-Z0-9-_\.]+$" name="user_mail" id="user_mail"<br />
    </p>
    </span>
    <p>
      <input type="hidden" name="token" value="<?= hsc($_SESSION['token']);?>">
      <input type="submit" value="検索" id="submit">
    </div>
    </p>
</form>

<button type="button" onclick="location.href='dbtest.php'" id="submit">TOPへ戻る</button>
</main>
<?php
    include('app/_parts/_footer.php');