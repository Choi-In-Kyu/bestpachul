<?php
define('_ROOT',dirname(__FILE__)."/");
define('_APP',_ROOT."application/");
define('_PUBLIC',_ROOT."public/");
define('_MODEL',_APP."model/");
define('_CONFIG',_APP."config/");
define('_CONTROLLER',_APP."controller/");
define('_VIEW',_APP."view/");

$url = str_replace("index.php","","http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}");//bestpachul.com

define('_URL',$url);
define('_IMG',_URL.'public/img/');
define('_CSS',_URL.'public/css/');
define('_JS',_URL.'public/js/');

define('BOOKMARK','orangered');
define('WARNING','red');
define('DEACTIVATED','gray');



require_once(_CONFIG."lib.php");
require_once(_CONFIG."db.php");
//앱 실행(/application/application.php)
new Application();