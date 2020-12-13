<?php
//ユーザデータに関する操作を行う

class UserModel
{
  /** PHPDoc
  *ユーザを登録する
  * @param array $userData  ←これは、引数を配列で受け取るという意味！
  * @return bool $result  ←値をbool（true or false）で返す！
  */
  public static function createUser($userData)
  {
    $result = false;
    $sql = 'INSERT INTO users (user_name, email, password) VALUES(?, ?, ?) ';

    //ユーザデータを配列に入れる
    $arr = [];
    $arr[] = $userData['username'];
    $arr[] = $userData['email'];
    $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT);

    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);//executeは返り値がbool。処理がうまくいったか確認するためにresultにtrue/falseを格納
      return $result;
    } catch(\Exception $e) {
      return false;
    }
  }

  /** PHPDoc
  *ログイン処理
  * @param string $email <- 今回引数は二つ！
  * @param string $password
  * @return bool $result
  */
  public static function login($email, $password)
  {
    //結果
    $result = false;//デフォルトをfalseに設定
    //ユーザをemailから検索して取得
    $user = self::getUserByEmail($email);

    if (!$user) {
      $_SESSION['msg'] = 'emailが一致しません。';
      return $result;//resultはfalseのままになっている
    }

    //パスワードの照会
    if (password_verify($password, $user['password'])) {
      //ログイン成功
      session_regenerate_id(true);//古いセッションを破棄して、新しいセッションを作成する＝セッションハイジャック対策はこれでOK！
      $_SESSION['login_user'] = $user;
      $result = true;//成功したことを示すためにデフォルトのfalseからtrueに置き換える
      return $result;
    }
    $_SESSION['msg'] = 'パスワードが一致しません。';
    return $result;//resultはfalseのままになっている
  }

  /** PHPDoc
  *emailからユーザを取得
  * @param string $email <- 今回引数は二つ！
  * @return array|bool $user|false <- 成功したらarray(ユーザデータ)、失敗したらbool(false)を返す。
  */
  public static function getUserByEmail($email)
  {
    // SQLの準備
    // SQLの実行
    // SQLの結果を返す
    $sql = 'SELECT * FROM users WHERE email = ?';

    //emailを配列に入れる
    $arr = [];
    $arr[] = $email;


    try{
      $stmt = connect()->prepare($sql);
      $stmt->execute($arr);
      // SQLの結果を返す
      $user = $stmt->fetch();
      return $user;
    } catch(\Exception $e) {
      return false;
    }
  }

  /*
  *idからユーザを取得
  * @param string $id <- 今回引数は二つ！
  * @return array|bool $user|false <- 成功したらarray(ユーザデータ)、失敗したらbool(false)を返す。
  */
  public static function getUserById($id)
  {
    // SQLの準備
    // SQLの実行
    // SQLの結果を返す
    $sql = 'SELECT * FROM users WHERE id = ?';

    //idを配列に入れる
    $arr = [];
    $arr[] = $id;


    try{
      $stmt = connect()->prepare($sql);
      $stmt->execute($arr);
      // SQLの結果を返す
      $user = $stmt->fetch();
      return $user;
    } catch(\Exception $e) {
      return false;
    }
  }

  /**
  * ログインチェック
  * @param void
  * @return bool $result
  */
  public static function checkLogin()
  {
    $result = false;//初期値をfalseに設定

    //セッションにログインユーザが入ってなかったらfalse
    if (isset($_SESSION['login_user'])
    //&& $_SESSION['login_user']['user_id'] > 0 ←ここが条件あってるはずなのにfalseになってしまう;;あとで確認！
    ) {
      return $result = true;
    }
    return $result;
  }
}

 ?>
