<?php
defined('ROOT_PATH') or exit;
/******路径定义********/
define('DRAGON_PATH', ROOT_PATH . "/dragon/");
define('MODEL_PATH',  ROOT_PATH . "/model/");
define('LIB_PATH', ROOT_PATH . "/lib/");
define('COMMON_PATH', ROOT_PATH . "/common/");
define('MODULES_PATH', ROOT_PATH . "/modules/");
define('LOG_PATH', '/tmp/log/');
/*******redis定义************/
define('REDIS', 1);//是否使用redis
defined('REDIS') and define('REDIS_PATH', ROOT_PATH  . "/redis/");
/*****日志相关*********/
define('LOG_RECORD', 1); //是否记录日志
define('LOG_COLLECT', 0); //是否采用日志收集,默认不收集
define('LOG_FATAL', 2);//错误日志
define('LOG_WARNING', 1); //警告日志
define('LOG_NORMAL', 0);//普通日志
define('LOG_DB', "db_error");//数据库异常sql
/*****页面相关**********/
define('DEFAULT_MODULES', 'welcome');//默认路径
define('DEFAULT_METHOD', 'run');//默认方法
/*****smarty配置********/
define('SMARTY_TMPDIR', ROOT_PATH . '/view/');
define('SMARTY_TMPDIRC', "/tmp/complie/");
define('SMARTY_CACHEDIR', "/tmp/complie/");
define('SMARTY_DLEFT', "{");
define('SMARTY_DRIGHT', "}");
define('LIFTTIME', 0);
/*****数据库相关******/
define('CONNECT_POOL', 2);//数据库连接池的连接数的个数
$GLOBALS['mail.meilishuo.com']['slaves'] = array (0 => array('HOST'=>'192.168.60.1', 'USER' => 'dolphin', 'PASS' => 'dolphin', 'PORT' => 3306));
$GLOBALS['mail.meilishuo.com']['master'] = array('HOST'=>'192.168.60.1', 'USER' => 'dolphin', 'PASS' => 'dolphin', 'PORT' => 3306);




