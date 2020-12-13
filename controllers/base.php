<?php
require_once dirname(dirname(__FILE__)).'/models/user.php';

class BaseController {
  public function checkLogin($requiredLogin = true) {
    $isLogin = UserModel::checkLogin();

    if($requiredLogin) {
      if(!$isLogin) {
        header("Location: ".APP_URL."/login");
        die();
      }
    }

    else {
      if($isLogin) {
        header("Location: ".APP_URL."/mypage");
        die();
      }
    }
  }

  public function getLoginUser() {
    $session_user = isset($_SESSION['login_user']) ? $_SESSION['login_user'] : null;

    if($session_user) {
      return UserModel::getUserById($session_user['id']);
    }
    return null;
  }
}
 ?>
