<?php
require_once('../private/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];

try {
    //データベースへ接続
    $pdo = new PDO(
        'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8mb4',
        //ユーザー名
         $db_user,
        //パス
         $db_pass,
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
