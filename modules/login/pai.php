<?php
namespace Modules\Login;

use Dragon\CModule;

class LoginAction extends CModule{
	private $plateA = array();//A出的牌
	private $plateB = array();//B出的牌
	private $preA = array();//A可能的牌
	private $preB = array(); //B可能的牌
	private $my = array();//我的牌
	private $all = array(
					'3'=> 4,
					'4' => 4,
					'5' => 4,
					'6' => 4,
					'7' => 4,
					'8' => 4,
					'9' => 4,
					'10' => 4, 
					'J' => 4,
					'Q' => 4,
					'K' => 4,
					'A' => 4,
					'2' => 4,
					'@' => 1,
					'*' => 1
			);
	public function __construct($args = '') {
		parent::__construct();
	}
	public function run() {
		$this->my = explode(",", trim($_POST['my_pai']));
		$this->plateA = explode(",", trim($_POST['a_pai']));
		$this->plateB = explode(",", $_POST['b_pai']);
		//取除我的牌
		foreach($this->my  as $key => $value) {
			if ($this->all[$value] == 1) {
				unset($this->all[$value]);
			}
			else {
				$this->all[$value] = $this->all[$value]-1;
			}
		}
		//
		$this->preA = $this->preB = $this->all;
		//排除a的牌，没出一次牌，判断一次
		//判断出的是什么牌
		$num = count($a);
		switch($num) {
			case 1 : 
				$this->assign_one();		
				break;
			case 2 :
				$this->assign_two();
				break;
			case 3 :
				$this->assign_three();
				 break;
		}
		$this->setTplName('/lib/framework/test.html');
		$this->render();
	
	}
	//处理3张牌，只有3张一样的
	private function assign_three(){
		$pai = $a[0];
		if ($all[$pai] == 3) {
			unset($all[$pai]);
		}
		else {
			$all[$pai] = $all[$pai] - 3;
		}
		return $all;
	}
	//处理2张牌的情况，只可能是对子或者对王
	private function assign_two() {
		if (!empty($this->plateA)) {
			if ($this->plateA[0] != $this->plateA[1]) {
				unset($this->preA[$this->plateA[0]]);
				unset($this->preA[$this->plateA[1]]);
			}
			elseif ($this->preA[$this->plateA[0]] == 2){
				unset($this->preA[$this->plateA[0]]);
			}
			else {
				$this->preA[$this->plateA[0]] = $this->preA[$this->plateA[0]] - 2;
			}
		}
		if (!empty($this->plateB)) {
			if ($this->plateB[0] != $this->plateB[1]) {
				unset($this->preB[$this->plateB[0]]);
				unset($this->preB[$this->plateB[1]]);
			}
			elseif ($this->preB[$this->plateB[0]] == 2){
				unset($this->preB[$this->plateB[0]]);
			}
			else {
				$this->preB[$this->plateB[0]] = $this->preB[$this->plateB[0]] - 2;
			}
		}
	
	}
	//处理一张牌的情况,看谁出牌
	private function assign_one() {
		if (!empty($this->plateA)) {
			if ($this->preA[$this->plateA[0]] == 1) {
				unset($this->preA[$this->plateA[0]]);
			}
			else {
				$this->preA[$this->plateA[0]] = $this->preA[$this->plateA[0]] - 1;
			}
		}
		if (!empty($this->plateB)) {
			if ($this->preB[$this->plateB[0]] == 1) {
				unset($this->preB[$this->plateB[0]]);
			}
			else {
				$this->preB[$this->plateB[0]] = $this->preB[$this->plateB[0]] - 1;
			}
		}
	}


}
