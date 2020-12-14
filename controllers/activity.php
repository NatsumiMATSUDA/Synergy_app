<?php

require_once dirname(__FILE__).'/base.php';
require_once dirname(dirname(__FILE__)).'/utils/view.php';
require_once dirname(dirname(__FILE__)).'/models/activity.php';
require_once dirname(dirname(__FILE__)).'/models/user.php';
require_once dirname(dirname(__FILE__)).'/models/report.php';
require_once dirname(dirname(__FILE__)).'/utils/activity.php';


class ActivityController extends BaseController {

  var $inputValues = array(
    'content' => '',
    'activity_title' => '',
    'start_year' => 0,
    'start_month' => 0,
    'start_day' => 0,
    'end_year' => 0,
    'end_month' => 0,
    'end_day' => 0,
    'category' => 0,
    'recruitment_state' => 0,
  );

  public function create() {
    parent::checkLogin();

    $view = dirname(dirname(__FILE__))."/views/pages/activity/create/index.php";
    includeTemplateWithVariables('default', $view, array(
      'inputValues' => $this->inputValues,
    ));
  }

  public function createSubmit() {
    parent::checkLogin();
    $login_user = parent::getLoginUser();

    $view = dirname(dirname(__FILE__))."/views/pages/activity/create/index.php";

    $err = [];
    $content = filter_input(INPUT_POST, 'content');
    if (!$content) {
      $err['content'] = '内容を記入してください。';
    }

    $activity_title = filter_input(INPUT_POST, 'activity_title');
    if (!$activity_title) {
      $err['activity_title'] = 'アクティビティ名を記入してください。';
    }

    $start_year = filter_input(INPUT_POST, 'start_year');
    $start_month = filter_input(INPUT_POST, 'start_month');
    $start_day = filter_input(INPUT_POST, 'start_day');

    if(!$start_year || !$start_month || !$start_day) {
      $err['start_date'] = '開始日を選択してください。';
    }

    $end_year = filter_input(INPUT_POST, 'end_year');
    $end_month = filter_input(INPUT_POST, 'end_month');
    $end_day = filter_input(INPUT_POST, 'end_day');

    if(!$end_year || !$end_month || !$end_day) {
      $err['end_date'] = '終了日を選択してください。';
    }

    $start_date_time = strtotime($start_year."/".$start_month."/".$start_day);
    $end_date_time = strtotime($end_year."/".$end_month."/".$end_day);

    if($start_date_time > $end_date_time) {
      $err['end_date'] = '終了日は開始日よりも後の日付に設定してください。';
    }

    if(!$category = filter_input(INPUT_POST, 'category')) {
      $err['category'] = '分野を選択してください。';
    }

    if(!$recruitment_state = filter_input(INPUT_POST, 'recruitment_state')) {
      $err['recruitment_state'] = '募集有無を選択してください。';
    }


    $this->inputValues = array(//activities
      'content' => $content,
      'activity_title' => $activity_title,
      'start_year' => $start_year,
      'start_month' => $start_month,
      'start_day' => $start_day,
      'end_year' => $end_year,
      'end_month' => $end_month,
      'end_day' => $end_day,
      'category' => $category,
      'recruitment_state' => $recruitment_state,
    );

    if (count($err) === 0) {
      $activity_id = ActivityModel::createActivity(array(
        'user_id' => $login_user['id'],
        'category' => $category,
        'activity_title' => $activity_title,
        'content' => $content,
        'recruitment_state' => $recruitment_state,
        'start_date' => date('Y/m/d', $start_date_time),
        'end_date' => date('Y/m/d', $end_date_time),
      ));

      $hasCreated = false;
      if($activity_id) {
        $hasCreated = ActivityModel::addEntryState(array(
          'activity_id' => $activity_id,
          'user_id' => $login_user['id'],
          'state' => 3, //承認済み
        ));
      }

      if(!$hasCreated){
        $err['alert'] = '登録に失敗しました';
      } else {
        $view = dirname(dirname(__FILE__))."/views/pages/activity/create/success.php";
        includeTemplateWithVariables('default', $view, array(
          'err' => $err,
          'inputValues' => $this->inputValues,
        ));
        die();
      }
    }

    includeTemplateWithVariables('default', $view, array(
      'err' => $err,
      'inputValues' => $this->inputValues,
    ));
  }

  public function detail($activity_id) {
    parent::checkLogin();

    $activity = ActivityModel::getActivityById($activity_id);
    if(!$activity) {
      header('Location: mypage');
      die();
    }

    $login_user = parent::getLoginUser();
    $entry_state = ActivityModel::getEntryState($activity_id, $login_user['id']);
    $attendees = ActivityModel::getAllUserFromEntryState($activity_id);

    $is_owner = $activity['user_id'] === $login_user['id'];
    $activity_create_user = $is_owner ? $login_user : UserModel::getUserById($activity['user_id']);

    $attendees = array_filter($attendees, function($attendee, $key) use ($is_owner) {
      if($is_owner) {
        return true;
      }
      return $attendee['state'] == 3 || $attendee['state'] == 5;
    }, ARRAY_FILTER_USE_BOTH);

    $isEnd = strtotime(date('Y-m-d')) > strtotime($activity['end_date']);
    $isRecruiting = $activity['recruitment_state'] == 1;

    $reports = ReportModel::getReportsByActivityId($activity_id);
    $user_name_map = [];
    $user_ids = [];

    if($reports && count($reports)) {
      foreach ($reports as $report) {
        array_push($user_ids, $report['user_id']);
        array_push($user_ids, $report['leadership']);
        array_push($user_ids, $report['ideaman']);
        array_push($user_ids, $report['writer']);
        array_push($user_ids, $report['presenter']);
        array_push($user_ids, $report['mvp']);
      }

      $user_ids = array_unique($user_ids);
      $user_ids = count($user_ids) ? $user_ids : array();

      $users = UserModel::getUserByIds($user_ids);
      if(count($users)) {
        foreach ($users as $user) {
          $user_name_map[$user['id']] = $user['user_name'];
        }
      }
    }

    $view = dirname(dirname(__FILE__))."/views/pages/activity/detail/index.php";
    includeTemplateWithVariables('default', $view, array(
      'activity' => $activity,
      'entryState' => $entry_state,
      'attendees' => $attendees,
      'is_owner' => $is_owner,
      'activity_create_user' => $activity_create_user,
      'isEnd' => $isEnd,
      'isRecruiting' => $isRecruiting,
      'reports' => $reports,
      'user_name_map' => $user_name_map,
    ));
  }

  public function updateState() {
    parent::checkLogin();

    $login_user = parent::getLoginUser();

    $activity_id = filter_input(INPUT_POST, 'activity_id');
    $state_id = filter_input(INPUT_POST, 'state_id');
    $user_id = filter_input(INPUT_POST, 'user_id');
    $context = filter_input(INPUT_POST, 'context');
    //作成者であることを確認してから、出席者確認を表示する
    if(!$activity_id || !$state_id) {
      header("Location: ".APP_URL."/mypage");
    }

    $activity = ActivityModel::getActivityById($activity_id);
    if(!$activity) {
      header("Location: ".APP_URL."/mypage");
      die();
    }

    if($activity['user_id'] !== $login_user['id']) {
      header("Location: ".APP_URL."/activity/detail/".$activity_id);
    }

    if(!$user_id) {
      $user_id = $login_user['id'];
    }

    $entry_state = ActivityModel::getEntryState($activity_id, $user_id);
    if($entry_state) {
      ActivityModel::updateEntryState($entry_state['id'], $state_id);
    }

    if($context === "detail") {
      header("Location: ".APP_URL."/activity/detail/".$activity_id);
    }
    elseif($context === "attendee") {
      header("Location: ".APP_URL."/activity/attendees/".$activity_id);
    }
    else {
      header("Location: ".APP_URL."/mypage");
    }
  }

  public function join() {
    parent::checkLogin();

    $activity_id = filter_input(INPUT_POST, 'activity_id');
    if(!$activity_id) {
      header("Location: ".APP_URL."/activity/detail/".$activity_id);
    }

    $activity = ActivityModel::getActivityById($activity_id);
    if(!$activity) {
      header("Location: ".APP_URL."/mypage");
      die();
    }

    $login_user = parent::getLoginUser();

    ActivityModel::addEntryState(array(
      'activity_id' => $activity_id,
      'user_id' => $login_user['id'],
      'state' => 2, //未承認
    ));

    header("Location: ".APP_URL."/activity/detail/".$activity_id);
  }


  public function attendees($activity_id) {

    parent::checkLogin();

    $activity = ActivityModel::getActivityById($activity_id);
    if(!$activity) {
      header('Location: mypage');
      die();
    }

    $login_user = parent::getLoginUser();
    $is_owner = $activity['user_id'] === $login_user['id'];
    $activity_create_user = $is_owner ? $login_user : UserModel::getUserById($activity['user_id']);
    if(!$is_owner) {
      header("Location: ".APP_URL."/activity/detail/".$activity_id);
      die();
    }

    $attendees = ActivityModel::getAllUserFromEntryState($activity_id);

    $attendees = array_filter($attendees, function($attendee, $key) {
      return $attendee['state'] == 3 || $attendee['state'] == 5 || $attendee['state'] == 6;
    }, ARRAY_FILTER_USE_BOTH);

    $view = dirname(dirname(__FILE__))."/views/pages/activity/attendees/index.php";
    includeTemplateWithVariables('default', $view, array(
      'activity' => $activity,
      'attendees' => $attendees,
      'is_owner' => $is_owner,
      'activity_create_user' => $activity_create_user,
    ));

  }
}

?>
