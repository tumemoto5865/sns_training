<?php
try {
    //データベースへ接続
    $pdo = new PDO(
        'mysql:host=mysql;dbname=test_db;charset=utf8mb4',
        //ユーザー名
        'test_db_docker',
        //パス
        'test_db_docker_pass',
    //PDOのオプションを指定
    [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
      ]
    );
} catch (PDOException $e) {
    echo $e->getMessage();
    ?>
    <p style="text-align: center;"><button type="button" onclick="history.back()" class="submit">戻る</button></p>
    <?php
    exit;
}
?>
