<?php 

require("../app/functions.php");

include("../app/_parts/_header.php");//ヘッダー
?>

        <form action="user_list.php" method="post">
            ID:<input type="text" name="id"><br>
            Name:<input type="text" name="user_name"><br>
            <input type="submit">
        </form>

<p><a href="index_a.php">web/index_a.php</a></p>

<?php 
include("../app/_parts/_footer.php");
