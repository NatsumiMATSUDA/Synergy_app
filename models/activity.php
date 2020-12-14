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

    $stmt -> bindValue(':category', (int)$category, PDO::PARAM_INT);

    $stmt -> execute();

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
    $result = false;

    $sql = 'INSERT INTO activities (user_id, category, activity_title, start_date, end_date, content, recruitment_state) VALUES(?, ?, ?, ?, ?, ?, ?) ';

    $arr = [];
    $arr[] = $activity['user_id'];
    $arr[] = $activity['category'];
    $arr[] = $activity['activity_title'];
    $arr[] = $activity['start_date'];
    $arr[] = $activity['end_date'];
    $arr[] = $activity['content'];
    $arr[] = $activity['recruitment_state'];

    try{
      $db = connect();
      $stmt = $db->prepare($sql);
      $result = $stmt->execute($arr);
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

  //活動エントリー
  $arr = [];
  $arr[] = $entry_state['activity_id'];
  $arr[] = $entry_state['user_id'];
  $arr[] = $entry_state['state'];

  try{
    $stmt = connect()->prepare($sql);
    $result = $stmt->execute($arr);
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

    $arr = [];
    $arr[] = $id;


    try{
      $stmt = connect()->prepare($sql);
      $stmt->execute($arr);

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
  function getEntryActivitiesByUserIdAndCategory($user_id, $category)
  {
    $sql = "
      SELECT
        activities.*,
        activity_entry_states.state
      FROM
        activities
        RIGHT JOIN activity_entry_states
        ON activity_entry_states.activity_id = activities.id
      WHERE activities.category = :category AND activity_entry_states.user_id = :user_id
      ORDER BY activities.start_date DESC";

    $stmt = connect()->prepare($sql);

    $stmt -> bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);
    $stmt -> bindValue(':category', (int)$category, PDO::PARAM_INT);

    $stmt -> execute();

    $activityData = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $activityData;
  }


  function getEntryState($activity_id, $user_id) {

    $sql = "SELECT * FROM activity_entry_states WHERE activity_id = :activity_id AND user_id = :user_id";

    $stmt = connect()->prepare($sql);

    $stmt -> bindValue(':activity_id', (int)$activity_id, PDO::PARAM_INT);
    $stmt -> bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);

    $stmt -> execute();

    $entryState = $stmt->fetch(PDO::FETCH_ASSOC);
    return $entryState;
  }

  function getAllUserFromEntryState($activity_id) {
    $sql = "
      SELECT
        users.*,
        activity_entry_states.state
      FROM
        users
        RIGHT JOIN activity_entry_states
        ON activity_entry_states.user_id = users.id
      WHERE activity_entry_states.activity_id = :activity_id
      ORDER BY users.user_name DESC";

    $stmt = connect()->prepare($sql);

    $stmt -> bindValue(':activity_id', (int)$activity_id, PDO::PARAM_INT);

    $stmt -> execute();

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

    $stmt->execute();

    $activityData = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $activityData;
  }
}

 ?>
