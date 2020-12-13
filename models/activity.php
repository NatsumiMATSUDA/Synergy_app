<?php
class ActivityModel
{

  /**
  *
  * @param string $category
  * @return array $activityData //categoryの番号に基づいたデータを返す
  */
  function getActivitiesByCategory($category)
  {
    $sql = 'SELECT * FROM activities WHERE category = :category';
    $stmt = connect()->prepare($sql);

    $stmt -> bindValue(':category', (int)$category, PDO::PARAM_INT);//int型に変換して受け取った情報をint専用のオプションで受け取り、WHEREの方に返してあげる
    //②SQLの実行
    $stmt -> execute();
    //③SQLの結果を受け取る
    $activityData = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $activityData;
  }


  /**
  * アクティビティを新規登録する
  * @param array $activity
  * @return bool $result
  */
  public static function createActivity($activity)
  {
    $result = false;//デフォルトをfalseに指定する。処理がなされると自動的にtrueになる

    $sql = 'INSERT INTO activities (user_id, category, activity_title, start_date, end_date, content, recruitment_state) VALUES(?, ?, ?, ?, ?, ?, ?) ';//日付入ってない

    //ユーザデータを配列に入れる
    $arr = [];
    $arr[] = $activity['user_id'];
    $arr[] = $activity['category'];
    $arr[] = $activity['activity_title'];
    $arr[] = $activity['start_date'];
    $arr[] = $activity['end_date'];
    //$arr[] = $activityData['']//日付をどうやっていれる？？
    $arr[] = $activity['content'];
    $arr[] = $activity['recruitment_state'];

    try{
      $db = connect();
      $stmt = $db->prepare($sql);
      $result = $stmt->execute($arr);//executeは返り値がbool。処理がうまくいったか確認するためにresultにtrue/falseを格納
      if($result) {
        return $db->lastInsertId();
      }
      return false;
      } catch(\Exception $e) {
        var_dump($e);
        return $e;
      }
  }


/**
* アクティビティ参加記録を新規登録する
* @param array $entry_state
* @return bool $result
*/
public static function addEntryState($entry_state)
{
  $result = false;//デフォルトfalse

  $sql = 'INSERT INTO activity_entry_states (activity_id, user_id, state) VALUES(?, ?, ?) ';

  //ユーザデータを配列に入れる
  $arr = [];
  $arr[] = $entry_state['activity_id'];
  $arr[] = $entry_state['user_id'];
  $arr[] = $entry_state['state'];

  try{
    $stmt = connect()->prepare($sql);
    $result = $stmt->execute($arr);//executeは返り値がbool。処理がうまくいったか確認するためにresultにtrue/falseを格納
    return $result;
  } catch(\Exception $e) {
    var_dump($e);
    return $e;
  }
}

  public static function getAllActivities()
  {
    $sql = 'SELECT * FROM activities';

    $stmt = connect()->prepare($sql);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }



  /**
  * 振り返りを新規登録する
  * @param void
  * @return int $result
  */
  public static function getActivityById($id)
  {
    $sql = 'SELECT * FROM activities WHERE id = ?';

    //emailを配列に入れる
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
  *
  * @param string $category
  * @return array $activityData //categoryの番号に基づいたデータを返す
  */
  function getEntryActivitiesByUserIdAndCategory($user_id, $category, $paging)
  {
    $page = isset($paging['page']) ? $paging['page'] : 1;
    $count = isset($paging['count']) ? $paging['count'] : 10;
    $offset = ($page - 1) * $count;

    $sql = "
      SELECT
        activities.*,
        activity_entry_states.state
      FROM
        activities
        RIGHT JOIN activity_entry_states
        ON activity_entry_states.activity_id = activities.id
      WHERE activities.category = :category AND activity_entry_states.user_id = :user_id
      ORDER BY activities.start_date DESC
      LIMIT " . $offset . ", " . $count . "
      ";

    $stmt = connect()->prepare($sql);

    $stmt -> bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);//int型に変換して受け取った情報をint専用のオプションで受け取り、WHEREの方に返してあげる
    $stmt -> bindValue(':category', (int)$category, PDO::PARAM_INT);
    //②SQLの実行
    $stmt -> execute();
    //③SQLの結果を受け取る
    $activityData = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $activityData;
  }


  function getEntryState($activity_id, $user_id) {

    $sql = "SELECT * FROM activity_entry_states WHERE activity_id = :activity_id AND user_id = :user_id";

    $stmt = connect()->prepare($sql);

    $stmt -> bindValue(':activity_id', (int)$activity_id, PDO::PARAM_INT);
    $stmt -> bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);
    //②SQLの実行
    $stmt -> execute();
    //③SQLの結果を受け取る
    $entryState = $stmt->fetch(PDO::FETCH_ASSOC);
    return $entryState;
  }

  function getAllUserFromEntryState($activity_id, $paging) {
    $page = isset($paging['page']) ? $paging['page'] : 1;
    $count = isset($paging['count']) ? $paging['count'] : 10;
    $offset = ($page - 1) * $count;

    $sql = "
      SELECT
        users.*,
        activity_entry_states.state
      FROM
        users
        RIGHT JOIN activity_entry_states
        ON activity_entry_states.user_id = users.id
      WHERE activity_entry_states.activity_id = :activity_id
      ORDER BY users.user_name DESC
      LIMIT " . $offset . ", " . $count . "
      ";

    $stmt = connect()->prepare($sql);

    $stmt -> bindValue(':activity_id', (int)$activity_id, PDO::PARAM_INT);
    //②SQLの実行
    $stmt -> execute();
    //③SQLの結果を受け取る
    $users = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $users;
  }

  function updateEntryState($entry_state_id, $state_id) {
    $sql = "
      UPDATE activity_entry_states
      SET state = :state_id
      WHERE id = :entry_state_id;
      ";

    $stmt = connect()->prepare($sql);
    $stmt -> bindValue(':entry_state_id', (int)$entry_state_id, PDO::PARAM_INT);
    $stmt -> bindValue(':state_id', (int)$state_id, PDO::PARAM_INT);

    $stmt -> execute();
  }

  function searchActivities($category_id, $keywords) {

    if($category_id) {
      $sql = 'SELECT * FROM activities WHERE category = :category_id AND activity_title LIKE :keywords ORDER BY end_date DESC';
    }
    else {
      $sql = 'SELECT * FROM activities WHERE activity_title LIKE :keywords ORDER BY end_date DESC';
    }

    $stmt = connect()->prepare($sql);

    if($category_id) {
      $stmt->bindValue(':category_id', (int)$category_id, PDO::PARAM_INT);
    }
    $stmt->bindValue(':keywords', (string)'%'.$keywords.'%', PDO::PARAM_STR);

    //②SQLの実行
    $stmt->execute();
    //③SQLの結果を受け取る
    $activityData = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $activityData;
  }
}

 ?>
