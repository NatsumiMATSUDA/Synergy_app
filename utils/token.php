<?php
function setToken(){
  //トークンを生成する
  //フォームからそのトークンを送信
  //送信後の画面でそのトークンを照会
  //トークンを削除
  $csrf_token = bin2hex(random_bytes(32));//破られにくい暗号が生成される
  $_SESSION['csrf_token'] = $csrf_token;//$_SESSIONの中にハコを作って代入

  return $csrf_token;//$_SESSIONの中に入ってるのとreturnされたのが一緒か照会する
}
?>
