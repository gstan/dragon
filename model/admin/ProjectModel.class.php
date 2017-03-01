<?php
namespace Model\Admin;

use Model\Helper\MailDB;

/**
 * 方案相关的操作
 */

class ProjectModel {

	private $table = "t_mail_project";

	//获得方案的基本信息

	public function getProjectInfo($start = 0, $limit = 20, $colum = "*") {
		$sqlComm = "select {$colum} from  {$this->table} order by pid desc limit {$start}, {$limit}";
		$sqlData = array();
		$result = MailDB::instance()->read($sqlComm, $sqlData);
		//处理对应的数据
		if (empty($result)) return false;
		foreach($result as $key => &$value) {
			$value['sendtime'] =  $value['sendtime'] ? date('Y-m-d H:i:s', $value['sendtime']) : '';
			$value['last_sendtime'] = $value['last_sendtime'] ? date('Y-m-d H:i:s', $value['last_sendtime']) : '';
			$value['opens_rate'] = precent($value['opens'], $value['sendnum']);
			$value['peropens_rate'] = precent($value['peropens'], $value['sendnum']); 
			$value['transfer_rate'] = precent($value['transfer'], $value['sendnum']);
			$value['pertransfer_rate'] = precent($value['pertransfer'], $value['sendnum']);
		}
		return $result;
	}




}
