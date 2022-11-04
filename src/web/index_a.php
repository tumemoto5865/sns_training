<?php 

require("../app/functions.php");

include("../app/_parts/_header.php");//ヘッダー
?>

<h1></h1>
<a href="dbsearch.php">DB-search</a>
<h1></h1>
<?php
$messages = file("../app/postedText.txt", FILE_IGNORE_NEW_LINES);
?>
<ul>
  <?php foreach ($messages as $messageKey => $message): ?>
  <li style="display: flex";>
    <?= hsc($message); ?>
    <form action="../app/postProcess.php" method="post" style="padding-left: 8px";>
      <input type="hidden" name="delete" value="<?= $messageKey ?>"><!-- インデックス番号取得 -->
      <button>削除</button>
    </form>

  </li>
  <?php endforeach; ?>
</ul>

<form action="../app/postProcess.php" method="post">
    <input type="text" name="postingMessage">
  <button>Post</button>
</form>

<?php 
include("../app/_parts/_footer.php");