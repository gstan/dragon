<?php
namespace Dragon;
/**
 * url路由转发
 * author gstan
 * date 2013-02-005
 * email 474703907@qq.com
 */
use Dragon\CModule;

class Dispatcher {

	private $url;
	private $modules;
	private $action;
	private $path;

	/**
     * 单例模式
	 */
	public static function instance() {
		static $singleton = NULL;
		!isset($singleton) && $singleton = new Dispatcher();
		return $singleton;
	}
	
	public function __construct() {
		$this->url =  $_SERVER['REQUEST_URI'];
	}

	public function dispatch() {
		$this->url = preg_replace("/(.+)(\?.*)/i", "\\1", $this->url);	
		$args = explode("/", $this->url);
		$this->modules = isset($args[1]) ? $args[1] : NULL;
		//如果不存在的连接都到默认的连接
		$this->path = MODULES_PATH . $this->modules;
		if (!is_dir($this->path)) {
			$this->modules = DEFAULT_MODULES;
			$this->path = MODULES_PATH . $this->modules;
		}
		$this->action = isset($args[2]) ? $args[2] : NULL;
		if (empty($this->action)) {
			$this->action = $this->modules;
		}
		//默认执行run函数
		$func = DEFAULT_METHOD;
		$tmpaction = ucwords($this->action);
		$this->action = "Modules\\" .  ucwords($this->modules) . "\\" . $tmpaction;
		$file = $this->path . "/" . $tmpaction . ".class.php";
		if (!file_exists($file)) {
			$this->action = "Dragon\\CModule";
		}
		//其他参数
		$num = count($args);
		$otherargs = array();
		if ($num > 3) {
			$otherargs = array_shift($args);
			$otherargs = array_shift($otherargs);
		}
		$class = new $this->action($otherargs);
		$class->$func();
	}
}
