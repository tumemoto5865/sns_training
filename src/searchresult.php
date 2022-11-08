<?php
require('app/functions.php');
include('app/_parts/_header.php');
?>
<main>
<h1>検索</h1>
<p>
<form action="search_result.php">
ID
お名前
住所
電話
メアド
</form>
</p>


<button type="button" onclick="location.href='dbtest.php'" id="submit">TOPへ戻る</button>
</main>
<?php
    include('app/_parts/_footer.php');