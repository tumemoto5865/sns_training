<footer>
    <?php
    if (isset($_SESSION['login'])) {
    ?>
        <p>
        <form action="index.php" method="post">
            <input type="hidden" name="logout" value="">
            <input type="submit" value="ログアウト" class="submit">
        </form>
        </p>
    <?php
    } else {
    ?>
        <p><a href="index.php">index.phpに戻る</a></p>
    <?php
    }
    ?>
</footer>
<script>
</script>
</body>

</html>
