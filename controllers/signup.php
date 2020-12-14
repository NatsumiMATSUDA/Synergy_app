<?php

require_once dirname(__FILE__).'/base.php';
require_once dirname(dirname(__FILE__)).'/utils/string.php';
require_once dirname(dirname(__FILE__)).'/utils/token.php';
require_once dirname(dirname(__FILE__)).'/utils/view.php';
require_once dirname(dirname(__FILE__)).'/models/user.php';

class SignupController extends BaseController {

  var $inputValues = array(
    'email' => '',
    'username' => '',
  );

  function index() {
    parent::checkLogin(false);

    $err = [];
    $csrf_token = h(setToken());
    $view = dirname(dirname(__FILE__))."/views/pages/signup.php";
    includeTemplateWithVariables('default', $view, array(
      'csrf_token' => $csrf_token,
      'err' => [],
      'inputValues' => $this->inputValues
    ));
  }

  function submit() {
    parent::checkLogin(false);

    $err = [];
    $csrf_token = h(setToken());

    if (!$username = filter_input(INPUT_POST, 'username')) {
      $err['username'] = 'ユーザー名を記入してください。';
    }

    if (!$email = filter_input(INPUT_POST, 'email')) {
      $err['email'] = 'メールアドレスを記入してください。';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $err['email'] = 'メールアドレスのフォーマットが違います。';
    }

    if(!$password = filter_input(INPUT_POST, 'password')) {
      $err['password'] = 'パスワードを記入してください。';
    }

    if(!$password_conf = filter_input(INPUT_POST, 'password_conf')) {
      $err['password_conf'] = '確認パスワードを記入してください。';
    }

    if($password && $password_conf && $password_conf !== $password) {
      $err['password_conf'] = '確認パスワードが間違っています';
    }

    $checkUser = UserModel::getUserByEmail($email);
    if($checkUser) {
      $err['alert'] = 'メールアドレスは既に使われています';
    }

    $this->inputValues = array(
      'username' => $username,
      'email' => $email
    );

    if(!count($err)) {

      $createUserResult = UserModel::createUser(array(
        'username' => $username,
        'email' => $email,
        'password' => $password
      ));
      if($createUserResult) {
        header('Location: login');
        die();
      }
    }

    $view = dirname(dirname(__FILE__))."/views/pages/signup.php";
    includeTemplateWithVariables('default', $view, array(
      'csrf_token' => $csrf_token,
      'err' => $err,
      'inputValues' => $this->inputValues
    ));
  }
}

?>
