<?php

require_once dirname(__FILE__).'/base.php';
require_once dirname(dirname(__FILE__)).'/utils/view.php';


class AccountController extends BaseController {

  function index() {
    parent::checkLogin();

    $login_user = parent::getLoginUser();

    $view = dirname(dirname(__FILE__))."/views/pages/account.php";
    includeTemplateWithVariables('default', $view, array(
      'login_user' => $login_user,
    ));


  }


}

?>
