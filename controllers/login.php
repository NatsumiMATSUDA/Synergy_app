<?php

require_once dirname(__FILE__).'/base.php';
require_once dirname(dirname(__FILE__)).'/utils/view.php';
require_once dirname(dirname(__FILE__)).'/models/user.php';

class LoginController extends BaseController {

  var $inputValues = array(
    'email' => ''
  );

  function index() {
    self::checkLogin(false);

    $err = [];


    $view = dirname(dirname(__FILE__))."/views/pages/login.php";
    includeTemplateWithVariables('logout', $view, array(
      'err' => $err,
      'inputValues' => $this->inputValues
    ));
  }

  function submit() {
    self::checkLogin(false);

    $err = [];
    // バリデーション（フォームの内容が、DBに格納する上でエラーがないか確認する）
    if (!$email = filter_input(INPUT_POST, 'email')) {
      $err['email'] = 'メールアドレスを記入してください。';//$_SESSIONは連想配列なので、$errの中の要素に名前をつけてあげる
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $err['email'] = 'メールアドレスのフォーマットが違います。';
    }

    if(!$password = filter_input(INPUT_POST, 'password')) {
      $err['password'] = 'パスワードを記入してください。';
    }

    //ログイン成功時の処理
    $isLogin = UserModel::login($email, $password);
    if ($isLogin) {
      header('Location: mypage');//login_form.phpに戻す処理
      die();
    }

    $err['alert'] = 'メールアドレス、またはパスワードが違います。';
    $this->inputValues = array(
      'email' => $email
    );

    $view = dirname(dirname(__FILE__))."/views/pages/login.php";
    includeTemplateWithVariables('logout', $view, array(
      'err' => $err,
      'inputValues' => $this->inputValues
    ));
  }

  function logout() {
    $_SESSION = array();
    session_destroy();
    header('Location: login');
    die();
  }
}

?>
