<?php
require_once dirname(dirname(__FILE__)).'/utils/view.php';
require_once dirname(dirname(__FILE__))."/models/activity.php";

class SearchController extends BaseController {

  function index() {
    parent::checkLogin();

    $activities = [];

    $keywords = isset($_GET['keywords']) ? $_GET['keywords'] : '';
    $category = isset($_GET['category']) ? $_GET['category'] : 0;
    
    if($keywords || $category) {
      $activities = ActivityModel::searchActivities($category, $keywords);
    }

    $view = dirname(dirname(__FILE__))."/views/pages/search.php";
    includeTemplateWithVariables('default', $view, array(
    'activities' => $activities,
    'category' => $category,
    'keywords' => $keywords,
    ));
  }
}

?>
