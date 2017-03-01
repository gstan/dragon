<?php
namespace Model\Login;
use Model\Helper\MailDB;

class LoginModel {

	private $table = 't_mail_common_user';

	public function __construct() {
	
	}
	public function __destruct() {
	
	}
	//获取用户密码
	public function getUserPass($username, $colum = "password") {
		$sqlComm = "select {$colum} from {$this->table} where username =:username";
		$sqlData['username'] = $username;
		$result = MailDB::instance()->read($sqlComm, $sqlData);
		return $result;
	}
	//更新用户登陆时间
	public  function updateLoginTime($uid) {
		$sqlComm = "update {$this->table} set lastlogin=:_lastlogin where uid=:_uid";
		$sqlData['_lastlogin'] = time();
		$sqlData['_uid'] = $uid;
		$result = MailDB::instance()->write($sqlComm, $sqlData);
		return $result;
	}
	//获取用户信息
	public function getInfoByUid($uid, $colum = "*") {
		$sqlComm =  "select {$colum} from {$this->table} where uid=:_uid";
		$sqlData['_uid'] = $uid;
		$result = MailDB::instance()->read($sqlComm, $sqlData);
		return $result;
	}
}
