<?php
namespace Dragon;
/**
 * dragon base file
 * author gstan 
 * email 474703907@qq.com
 * date 2013-02-04
 */
use Lib\Log;
use Lib\TimeHelper;

class Dragon {
	
	
	private static $map = array();
	private static $smarty = NULL;

	public static function start() {
		//设定错误和异常处理
	//	register_shutdown_function(array("Dragon\\Dragon", 'fatal'));
	//	set_error_handler(array("Dragon\\Dragon", 'error'));
		//注册自动加载函数
		spl_autoload_register(array("Dragon\\Dragon", 'autoload'));
		session_start();
		//开始计算程序运行时间
		$timeHelper = new TimeHelper();
		$timeHelper->start();
		//运行
		Application::run();
		$timeHelper->stop();
	}

    // 致命错误捕获
    public static function fatal() {
        if ($e = error_get_last()) {
            self::error($e['type'],$e['message'],$e['file'],$e['line']);
        }
    }
    /**
     * 自定义错误处理
     * @access public
     * @param int $errno 错误类型
     * @param string $errstr 错误信息
     * @param string $errfile 错误文件
     * @param int $errline 错误行数
     * @return void
     */
    public static function error($errno, $errstr, $errfile, $errline) {
      switch ($errno) {
          case E_ERROR:
          case E_PARSE:
          case E_CORE_ERROR:
          case E_COMPILE_ERROR:
          case E_USER_ERROR:
            $errorStr = "$errstr ".$errfile." 第 $errline 行.";
            if(LOG_RECORD) Log::instance()->write($errorStr, LOG_FATAL);
            break;
          case E_STRICT:
          case E_USER_WARNING:
          case E_USER_NOTICE:
          default:
            $errorStr = "[$errno] $errstr ".$errfile." 第 $errline 行.";
            if(LOG_RECORD) Log::instance()->write($errorStr, LOG_WARING);
            break;
      }
    }

	
	public static function  autoload($classname) {
		//采用命名空间的
		$path = "";
		$namespace = explode("\\", $classname);
		$class = array_pop($namespace);
		//构造路径
		$path  = implode('/', $namespace);
		$path = ROOT_PATH . "/" .  $path . "/";
		//假设是smarty
		if (strpos($class, 'Smarty') !== false) {
			if (isset(self::$smarty[$classname])) {
				return true;
			}
			$_class = strtolower($class);
			if (substr($_class, 0, 16) === 'smarty_internal_' || $_class == 'smarty_security') {
				require(SMARTY_SYSPLUGINS_DIR . $_class . '.php');
			} 
			else {
				require(LIB_PATH . "smarty/Smarty.class.php");
			}
			self::$smarty[$classname] = 1;
		}
		else{
			if (isset(self::$map[$classname])) {
				return true;
			}
			require($path . $class . ".class.php");
			self::$map[$classname] = 1;
		}
	}
}

