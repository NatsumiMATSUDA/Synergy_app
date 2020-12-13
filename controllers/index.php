<?php
//ログイン状態の確認

require_once dirname(dirname(__FILE__)).'/models/user.php';

$isLogin = UserModel::checkLogin();
if($isLogin === false) {
  header("Location: login");
  die();
}
header("Location: mypage");
?>
