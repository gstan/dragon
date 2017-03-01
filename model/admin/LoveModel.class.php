<?php
namespace Model\Admin;
use Model\Helper\MailDB;

class LoveModel{

	private $table = "t_mail_user_action";
	
    //用户的常用操作
	public function getUserAction($uid) {
		$sqlComm = "select * from {$this->table} where uid=:_uid";
		$sqlData['_uid'] = $uid;
		$result = MailDB::instance()->read($sqlComm, $sqlData);
		return $result;
	}


}



