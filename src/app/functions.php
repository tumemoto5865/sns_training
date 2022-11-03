<?php
//セッション開始
session_start();

//文字実体参照
  function hsc($hsc) {
    return htmlspecialchars($hsc, ENT_QUOTES, "UTF-8");
  }
?>