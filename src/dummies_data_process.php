<?php
require('app/functions.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  validateToken();
}


//接続テスト
//$stmt = $pdo->query("SELECT 1 + 1");
//$result = $stmt->fetch();
// var_dump($result);

include('app/_parts/_header.php');
validateToken()
?>
<?php
//値を受け取る
$dummies_install = (int)filter_input(INPUT_POST, "dummies_install");
if ($dummies_install === 1) {
  $pdo->query('INSERT INTO users_data
	SELECT *
FROM dummies_data AS t_b
WHERE NOT EXISTS (
	SELECT 	*
	FROM
		users_data AS t_a
	WHERE
		t_a.user_id = t_b.user_id
  );')
?>
  <p class="alert_message">ダミーデータを挿入しました。</p>
<?php
} else {
  $pdo->query(
    'DELETE FROM users_data AS t_a
    WHERE
        user_id IN
      (SELECT user_id
          FROM dummies_data AS t_b
   );'
  )
?>
  <p class="alert_message">ダミーデータを削除しました。</p>
<?php
}
?>
<button type="button" onclick="location.href='db_manage.php'" class="submit">TOPへ戻る</button>
<?php
include('app/_parts/_footer.php');
