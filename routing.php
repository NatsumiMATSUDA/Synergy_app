<?php
//ここで全てのページを管理。
//・ ロジックの操作を行える（＝「~完了画面」を作らなくて済む！）
//・ get/postによって動作を変える分岐ができる。
require_once './classes/router.php';
require_once dirname(__FILE__).'/utils/view.php';

include_once dirname(__FILE__)."/controllers/login.php";
include_once dirname(__FILE__)."/controllers/signup.php";
include_once dirname(__FILE__)."/controllers/mypage.php";
include_once dirname(__FILE__)."/controllers/activity.php";
include_once dirname(__FILE__)."/controllers/search.php";
include_once dirname(__FILE__)."/controllers/account.php";
include_once dirname(__FILE__)."/controllers/report.php";





Route::add('/', function() {
  includeWithVariables(dirname(__FILE__)."/controllers/index.php");//ログイン管理
});


/*
 * ログイン画面
 */
Route::add('/login', function() {
  $controller = new LoginController;
  $controller->index();
}, 'get');

Route::add('/login', function() {
  $controller = new LoginController;
  $controller->submit();
}, 'post');

/*
 * ユーザー新規登録
 */
Route::add('/signup', function() {
  $controller = new SignupController;
  $controller->index();
}, 'get');

Route::add('/signup', function() {
  $controller = new SignupController;
  $controller->submit();
}, 'post');

/*
 * ログアウト
 */
Route::add('/logout', function() {
  $controller = new LoginController;
  $controller->logout();
}, 'get');

/*
 * マイページ
 */
Route::add('/mypage', function() {
  $controller = new MyPageController;
  $controller->index();
}, 'get');

/*
 * アクティビティ新規作成
 */
Route::add('/activity/create', function() {
  $controller = new ActivityController;
  $controller->create();
}, 'get');

Route::add('/activity/create', function() {
  $controller = new ActivityController;
  $controller->createSubmit();
}, 'post');


Route::add('/activity/detail/([0-9]*)', function($activity_id) {
  $controller = new ActivityController;
  $controller->detail($activity_id);
}, 'get');

Route::add('/activity/update/state', function() {
  $controller = new ActivityController;
  $controller->updateState();
}, 'post');

Route::add('/activity/join', function() {
  $controller = new ActivityController;
  $controller->join();
}, 'post');

/*
 * 出席者確定画面
 */
Route::add('/activity/attendees/([0-9]*)', function($activity_id) {//変数を受け取りたい時は[0-9]*
  $controller = new ActivityController;//リンクを直接書き込むときは/activity/attendees/0~9認知の数字
  $controller->attendees($activity_id);
}, 'get');

/*
 * アクティビティ振り返り登録
 */
Route::add('/activity/report/([0-9]*)/write', function($activity_id) {//変数を受け取りたい時は[0-9]*
  $controller = new ReportController;
  $controller->write($activity_id);
}, 'get');

Route::add('/activity/report/([0-9]*)/write', function($activity_id) {//変数を受け取りたい時は[0-9]*
  $controller = new ReportController;
  $controller->writeSubmit($activity_id);
}, 'post');


/*
 * 参加可能アクティビティ一覧
 */
Route::add('/search', function() {
  $controller = new SearchController;
  $controller->index();
}, 'get');

/*
 * ユーザ情報変更画面（開発中!）
 */
Route::add('/account', function() {
  $controller = new AccountController;
  $controller->index();
}, 'get');



Route::run("/".BASE_URL);
