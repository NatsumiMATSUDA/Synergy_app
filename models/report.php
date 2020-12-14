<?php
class ReportModel
{

  /**
  * 振り返りを新規登録する
  * @param array $report
  * @return bool $result
  */
  public static function createReport($report)
  {
    $result = false;

    //reportsテーブルに入れる
    $sql = 'INSERT INTO reports (activity_id, user_id, impression, contribution, leadership, ideaman, writer, presenter, mvp) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?) ';

    $arr = [];
    $arr[] = $report['activity_id'];
    $arr[] = $report['user_id'];
    $arr[] = $report['impression'];
    $arr[] = $report['contribution'];
    $arr[] = $report['leadership'];
    $arr[] = $report['ideaman'];
    $arr[] = $report['writer'];
    $arr[] = $report['presenter'];
    $arr[] = $report['mvp'];

    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
    } catch(\Exception $e) {
      return $e;
    }
    return $result;
  }

  public static function updateReport($report_id, $values)
  {
    $sql = "
      UPDATE reports
      SET
        impression = :impression,
        contribution = :contribution,
        leadership = :leadership,
        ideaman = :ideaman,
        writer = :writer,
        presenter = :presenter,
        mvp = :mvp
      WHERE id = :report_id;
    ";

    $stmt = connect()->prepare($sql);
    $stmt -> bindValue(':impression', (string)$values['impression'], PDO::PARAM_STR);
    $stmt -> bindValue(':contribution', (string)$values['contribution'], PDO::PARAM_STR);
    $stmt -> bindValue(':leadership', (int)$values['leadership'], PDO::PARAM_INT);
    $stmt -> bindValue(':ideaman', (int)$values['ideaman'], PDO::PARAM_INT);
    $stmt -> bindValue(':writer', (int)$values['writer'], PDO::PARAM_INT);
    $stmt -> bindValue(':presenter', (int)$values['presenter'], PDO::PARAM_INT);
    $stmt -> bindValue(':mvp', (int)$values['mvp'], PDO::PARAM_INT);
    $stmt -> bindValue(':report_id', (int)$report_id, PDO::PARAM_INT);

    try{
      return $stmt -> execute();
    } catch(\Exception $e) {
      return false;
    }
  }

  public function getReportByActivityIdAndUserId($activity_id, $user_id) {
    $sql = 'SELECT * FROM reports WHERE activity_id = ? AND user_id = ?';

    $arr = [];
    $arr[] = $activity_id;
    $arr[] = $user_id;

    try{
      $stmt = connect()->prepare($sql);
      $stmt->execute($arr);

      return $stmt->fetch();
    } catch(\Exception $e) {
      return false;
    }
  }

  public function getReportsByActivityId($activity_id) {
    $sql = 'SELECT reports.*, users.user_name FROM reports RIGHT JOIN users ON users.id = reports.user_id WHERE activity_id = ? ORDER BY created_at DESC';

    $arr = [];
    $arr[] = $activity_id;

    try{
      $stmt = connect()->prepare($sql);
      $stmt->execute($arr);
      
      return $stmt->fetchall(PDO::FETCH_ASSOC);
    } catch(\Exception $e) {
      return false;
    }
  }
}

 ?>
