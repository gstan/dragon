<?php

namespace Dragon;

class Application {
	
	public static function init() {
		//url调度
		Dispatcher::instance()->dispatch();
		//过滤非法传入
		unset($_GET, $_POST, $_COOKIE, $_REQUEST, $_FILES);
		$_GET = zaddslashes($_GET, 1, TRUE);
		$_POST = zaddslashes($_POST, 1, TRUE);
		$_COOKIE = zaddslashes($_COOKIE, 1, TRUE);
		$_REQUEST = zaddslashes($_REQUEST, 1, TRUE);
		$_FILES = zaddslashes($_FILES);
	}

	public static function run() {
		self::init();
	}
	
	
	
	
	
	
}

