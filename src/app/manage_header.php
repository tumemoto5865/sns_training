<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>test_DB</title>
  <link rel="stylesheet" href="../app/css/styles.css">
</head>
<header>
    <?php
    if (isset($_SESSION['login'])) {
        ?><p>ログインID:<?= $_SESSION['login']; ?></p>
    <?php
    } else {
        ?><p>未ログイン</p>
    <?php
    }
    ?>
</header>
<body>
