<?php
namespace Modules\Login;

use Dragon\CModule;
use Model\Login\LoginModel;

class Login extends CModule{
	
	public function run() {
		$username = (string)$_POST['username'];
		$password = (string)md5($_POST['password']);
		//获取这个用户的密码
		$helper = new LoginModel();
		$user = $helper->getUserPass($username, 'uid,password,groupid');
		if ($password == $user[0]['password']) {
			//设置session
			$_SESSION['user'] = $username;
			$_SESSION['group'] = $user[0]['groupid'];
			$_SESSION['uid'] = $user[0]['uid'];
			//更新登陆时间
			$helper->updateLoginTime($user[0]['uid']);
		}
		header("location:admin");

	
	}
}
