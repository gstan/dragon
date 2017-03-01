<?php
use  Dragon\Dragon;
//设置此页面的过期时间(用格林威治时间表示)，只要是已经过去的日期即可。
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
//设置此页面的最后更新日期(用格林威治时间表示)为当天，可以强制浏览器获取最新资料
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
ini_set('display_errors', 'on');
define('ROOT_PATH', __DIR__);
//add the config
require(ROOT_PATH . '/config/config.inc.php');
//add the dragon framework
require(DRAGON_PATH . 'Dragon.class.php');
//加载通用方法
require(COMMON_PATH . 'Common.php');

Dragon::start();




