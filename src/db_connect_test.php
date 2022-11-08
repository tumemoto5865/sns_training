<?php
				
try {
	// DB接続設定
	$dsn = 'mysql:host=mysql;dbname=test_db;';
	
	$db = new PDO($dsn, 'test_db_docker', 'test_db_docker_pass');
				
	// SQL実行
	$sql = 'SELECT * FROM sample_table;';
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
	// デバッグ
	var_dump($result);
				
} catch (PDOException $e) {
	echo $e->getMessage();
	exit;
}
