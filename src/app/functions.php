<?php
// session_start();//セッション開始

//文字実体参照の関数。
function hsc($str){
  return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}