<?php

require_once dirname(__FILE__).'/base.php';
require_once dirname(dirname(__FILE__)).'/utils/view.php';
require_once dirname(dirname(__FILE__)).'/models/activity.php';
require_once dirname(dirname(__FILE__)).'/models/user.php';
require_once dirname(dirname(__FILE__)).'/utils/string.php';

class MyPageController extends BaseController {

  function index() {
    parent::checkLogin();

    $login_user = parent::getLoginUser();

    $activities1 = ActivityModel::getEntryActivitiesByUserIdAndCategory($login_user['id'], 1);
    $activities2 = ActivityModel::getEntryActivitiesByUserIdAndCategory($login_user['id'], 2);
    $activities3 = ActivityModel::getEntryActivitiesByUserIdAndCategory($login_user['id'], 3);

    $view = dirname(dirname(__FILE__))."/views/pages/mypage.php";
    includeTemplateWithVariables('default', $view, array(
      'login_user' => $login_user,
      'activities1' => $activities1,
      'activities2' => $activities2,
      'activities3' => $activities3,
    ));


  }
}


?>
