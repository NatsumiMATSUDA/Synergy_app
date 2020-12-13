<?php

require_once dirname(__FILE__).'/base.php';
require_once dirname(dirname(__FILE__)).'/utils/view.php';
require_once dirname(dirname(__FILE__)).'/models/activity.php';
require_once dirname(dirname(__FILE__)).'/models/user.php';
require_once dirname(dirname(__FILE__)).'/models/report.php';
require_once dirname(dirname(__FILE__)).'/utils/activity.php';


class ReportController extends BaseController {

  var $inputValues = array(
    'impression' => '',
    'contribution' => '',
    'leadership' => 0,
    'ideaman' => 0,
    'writer' => 0,
    'presenter' => 0,
    'mvp' => 0,
  );

  public function write($activity_id) {
    parent::checkLogin();

    $activity = ActivityModel::getActivityById($activity_id);
    if(!$activity) {
      header('Location: mypage');
      die();
    }

    $isEnd = strtotime(date('Y-m-d')) > strtotime($activity['end_date']);
    $isRecruiting = $activity['recruitment_state'] == 1;

    $login_user = parent::getLoginUser();
    $entry_state = ActivityModel::getEntryState($activity_id, $login_user['id']);

    if(!$isRecruiting || !$isEnd || !$entry_state || $entry_state['state'] != 5) {
      header("Location: ".APP_URL."/activity/detail/".$activity_id);
      die();
    }

    $is_owner = $activity['user_id'] === $login_user['id'];
    $activity_create_user = $is_owner ? $login_user : UserModel::getUserById($activity['user_id']);

    $attendees = ActivityModel::getAllUserFromEntryState($activity_id);
    $attendees = array_filter($attendees, function($attendee, $key) {
      return $attendee['state'] == 5;
    }, ARRAY_FILTER_USE_BOTH);

    $report = ReportModel::getReportByActivityIdAndUserId($activity_id, $login_user['id']);
    if($report) {
      $this->inputValues = array(
        'impression' => $report['impression'],
        'contribution' => $report['contribution'],
        'leadership' => $report['leadership'],
        'ideaman' => $report['ideaman'],
        'writer' => $report['writer'],
        'presenter' => $report['presenter'],
        'mvp' => $report['mvp'],
      );
    }

    $view = dirname(dirname(__FILE__))."/views/pages/activity/report/write.php";
    includeTemplateWithVariables('default', $view, array(
      'activity' => $activity,
      'entryState' => $entry_state,
      'attendees' => $attendees,
      'is_owner' => $is_owner,
      'activity_create_user' => $activity_create_user,
      'inputValues' => $this->inputValues,
      'err' => [],
    ));
  }

  public function writeSubmit($activity_id) {
    parent::checkLogin();

    $activity = ActivityModel::getActivityById($activity_id);
    if(!$activity) {
      header('Location: mypage');
      die();
    }

    $isEnd = strtotime(date('Y-m-d')) > strtotime($activity['end_date']);
    $isRecruiting = $activity['recruitment_state'] == 1;

    $login_user = parent::getLoginUser();
    $entry_state = ActivityModel::getEntryState($activity_id, $login_user['id']);

    if(!$isRecruiting || !$isEnd || !$entry_state || $entry_state['state'] != 5) {
      header("Location: ".APP_URL."/activity/detail/".$activity_id);
      die();
    }

    $is_owner = $activity['user_id'] === $login_user['id'];
    $activity_create_user = $is_owner ? $login_user : UserModel::getUserById($activity['user_id']);

    $err = [];
    $contribution = filter_input(INPUT_POST, 'contribution');
    if (!$contribution) {
      $err['contribution'] = '内容を記入してください。';
    }

    $impression = filter_input(INPUT_POST, 'impression');
    $leadership = filter_input(INPUT_POST, 'leadership');
    $ideaman = filter_input(INPUT_POST, 'ideaman');
    $writer = filter_input(INPUT_POST, 'writer');
    $presenter = filter_input(INPUT_POST, 'presenter');
    $mvp = filter_input(INPUT_POST, 'mvp');

    $this->inputValues = array(
      'impression' => $impression,
      'contribution' => $contribution,
      'leadership' => $leadership,
      'ideaman' => $ideaman,
      'writer' => $writer,
      'presenter' => $presenter,
      'mvp' => $mvp,
    );

    if (count($err) === 0) {
      $report = ReportModel::getReportByActivityIdAndUserId($activity_id, $login_user['id']);
      $success = false;
      if(!$report) {
        $success = ReportModel::createReport(array(
          'activity_id' => $activity_id,
          'impression' => $impression,
          'contribution' => $contribution,
          'user_id' => $login_user['id'],
          'leadership' => $leadership,
          'ideaman' => $ideaman,
          'writer' => $writer,
          'presenter' => $presenter,
          'mvp' => $mvp,
        ));
      } else {
        $success = ReportModel::updateReport($report['id'], array(
          'activity_id' => $activity_id,
          'impression' => $impression,
          'contribution' => $contribution,
          'user_id' => $login_user['id'],
          'leadership' => $leadership,
          'ideaman' => $ideaman,
          'writer' => $writer,
          'presenter' => $presenter,
          'mvp' => $mvp,
        ));
      }

      if(!$success){
        $err[] = 'レポートの保存に失敗しました';
      }
    }

    $attendees = ActivityModel::getAllUserFromEntryState($activity_id);
    $attendees = array_filter($attendees, function($attendee, $key) {
      return $attendee['state'] == 5;
    }, ARRAY_FILTER_USE_BOTH);

    $view = dirname(dirname(__FILE__))."/views/pages/activity/report/write.php";
    includeTemplateWithVariables('default', $view, array(
      'activity' => $activity,
      'entryState' => $entry_state,
      'attendees' => $attendees,
      'is_owner' => $is_owner,
      'activity_create_user' => $activity_create_user,
      'inputValues' => $this->inputValues,
      'err' => $err,
      'saveSuccess' => $success,
    ));
  }

}

?>
