<?php
require("../app/functions.php");

include("../app/_parts/_header.php");//ヘッダー

if ($_SERVER["REQUEST_METHOD"] === "POST")//リクエストメソッドがPOSTだったら
{

  if (isset($_POST["postingMessage"]))//postingMessageに値が入っていたら
  {
    $postingMessage = trim(filter_input(INPUT_POST, "postingMessage"));//postingMessageの内容を$同名変数で受けて

    if ("" === filter_input(INPUT_POST, "postingMessage"))
    {//POSTのpostingMessageがカラだったら
      ?><p>メッセージがカラです</p>
      <p><a href="../web/index_a.php">戻る</a></p>
      <?php
      exit();//終了
    }
    
    else
    {//$postingMessageが空欄でなかったら
    $fp = fopen("../app/postedText.txt", "a");//追記モードでfopen
    fwrite($fp, $postingMessage . "\n");//$postingMessageと改行を書き込んで
    fclose($fp);//ファイル閉じ
    header ("Location: ../web/index_a.php");//元のページに戻る
    }
  }

  else if (isset($_POST["delete"]))//渡ってきたdeleteに値が入っていたら
  { 
    $messages = file("../app/postedText.txt", FILE_IGNORE_NEW_LINES);//書き込みファイルの中身を配列にして取得して(改行無視)
    array_splice ($messages, filter_input(INPUT_POST, "delete"), 1);//配列からdeleteに入っていたインデックス番号の要素を削除して
    $fp = fopen("../app/postedText.txt", "w");//書き込み(上書き)モードでファイルを開いて
    fwrite($fp, implode("\n", $messages) . "\n");//配列から文字列に戻して書き込んで
    fclose($fp);//ファイル閉じ
    header ("Location: ../web/index_a.php");//元のページに戻る
  }
}

else {//リクエストメソッドがPOSTではなかったら終了
  ?><p>Invalid Request</p><?php
  exit();
}

include("../app/_parts/_footer.php");

  ?>

