<?php
require('app/functions.php');
include('app/_parts/_header.php');
?>
<main>
<h1>検索</h1>
  <div class="main">


    <form action="registProcess.php" method="post">
    <span class="input-form">
    <p>
      <label for ="id">ID</label>
      <input type="text" pattern="^[a-zA-Z0-9\S_]+$" name="user_id" id="id"><br />
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
      <input type=text pattern="^[0-9]+$" name="user_tel" id="tel"><br />
    </p>
    <p>    
      <label for ="mail">メールアドレス</label>
      <input type=text pattern="^[a-zA-Z0-9-_\.]+@[a-zA-Z0-9-_\.]+$" name="user_mail" id="mail"<br />
    </p>
    </span>
    <p>
      <input type="submit" value="検索" id="submit">
    </div>
    </p>
</form>

<button type="button" onclick="location.href='dbtest.php'" id="submit">TOPへ戻る</button>
</main>
<?php
    include('app/_parts/_footer.php');