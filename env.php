<?php
//DBの管理者の設定、グローバルコンスタントはrequire_onceがなくても使えるようになる

define('DB_HOST', 'localhost');
define('DB_NAME', 'project1');
define('DB_USER', 'natsumi');
define('DB_PASS', 'academicpaper2020');

define('BASE_URL', 'Synergy_app');
define('APP_URL', "//".$_SERVER['SERVER_NAME']."/".BASE_URL);//URLを組み合わせる

 ?>
