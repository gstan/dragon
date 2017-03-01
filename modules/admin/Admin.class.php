<?php
/** 后台的基类
 *
 */
namespace Modules\Admin;

use Dragon\CModule;
use Model\Login\LoginModel;
use Model\Admin\LoveModel;
use Model\Admin\ProjectModel;

class Admin  extends CModule {
	private static $user_id;
	private $pageSize = 20;
	private $page ;
	public function __construct($args = '') {
		parent::__construct();
		if (!empty($args)) {
			$this->args = $args;
		}
		//判断是否用户登陆
		self::$user_id = $_SESSION['uid'];
		//处理没有登陆
		$nologin =   $this->_nologin();
		if ($nologin) return false;
		//获得上次登陆时间
		$helper = new LoginModel();
		$time = $helper->getInfoByUid(self::$user_id, 'lastlogin');
		$logintime = tdate($time[0]['lastlogin']);
		$this->setTplParam('logintime', $logintime);
		$this->setTplParam('username', $_SESSION['user']);
	}
	private function _nologin() {
		if (!empty(self::$user_id)) {
			return false;
		}
		$this->setTplName('lib/framework/login.html');
		$this->render();
		return true;
	}

	public function run() {
		if (empty(self::$user_id)) return false;
		//登陆后的行为
		//获得常用操作
		$helper = new LoveModel();
		$action = $helper->getUserAction(self::$user_id);
		//方案数据
		$this->page = (int) $_POST['page'] ;
		$pHelper = new ProjectModel();
		$data = $pHelper->getProjectInfo($this->page*$this->pageSize, $this->pageSize);
		$this->setTplParam('data', $data);
		$this->setTplParam('action', $action);
		$this->setTplName("web/project/mail_list.tpl");
		$this->render();
		return true;
	}
}
