<?php 

require("../app/functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $postingMessage = trim(filter_input(INPUT_POST, "postingMessage")) ?? "";
  
  if ($postingMessage !== "") {
  $fp = fopen("../app/postedText.txt", "a");
  fwrite($fp, $postingMessage . "\n");
  fclose($fp);
  }

} else {
//  exit("Invalid Request");
}

$messages = file("../app/postedText.txt", FILE_IGNORE_NEW_LINES);

include("../app/_parts/_header.php");//ヘッダー
?>



<ul>
  <?php foreach ($messages as $message): ?>
  <li><?= hsc($message); ?></li>
  <?php endforeach; ?>
</ul>

<form action="" method="post">
    <input type="text" name="postingMessage">
  <button>Post</button>
</form>

<?php 
include("../app/_parts/_footer.php");