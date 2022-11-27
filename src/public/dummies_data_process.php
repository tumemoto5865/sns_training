<?php
require('../app/functions.php');
validateLogin();
require('../app/connect_database.php');
include('../app/manage_header.php');
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
<button type="button" onclick="location.href='db_manage.php'" class="submit">管理TOPへ戻る</button>
<?php
include('../app/manage_footer.php');
