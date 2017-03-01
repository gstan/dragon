<?php
namespace Lib;
/**
 * 日志类，负责记录各种日志
 * author gstan
 * email 474703907@qq.com
 */

class Log {

	private $logfile; //日志的详细文件名
	private $logdir;//日志的目录

	public static function instance($filename = 'error') {
		static $singletons = array();
		!isset($singletons[$filename]) && $singletons[$filename] = new Log($filename);
		return $singletons[$filename];
		
	}

	public function __construct($fiename) {
		try{
			$this->logdir = LOG_PATH .	$filename  . '/';
			if ($filename != "error") {
				$this->logfile = $this->logdir . $filename . "." . date("YmdH");
			}
			else {
				$this->logfile = $this->logdir . $filename ;	
			}
			//如果还没存在这个日志,创建这个日志的目录
			if (!is_dir($this->logdir)) {
				 system("mkdir -p " . $this->logdir . ";chmod -R 777 " . $this->logdir);
			}
		}
		catch(Exception $e) {
			throw $e;	
		}
	}
	/**
	 * 日志写入
	 */
	public function write($str, $level = LOG_NORMAL) {
		//判断日志等级,输出堆栈信息
		if ($level == LOG_WARNING) {
			$trace = debug_backtrace();
			foreach($traces as $trace)
			{
				if(isset($trace['file'],$trace['line'])) {
					$msg.="\nin ".$trace['file'].' ('.$trace['line'].')';
				}
			}
			$str .= $msg;
		}
		@file_put_contents($this->logfile, $str, FILE_APPEND);
		//如果需要日志收集
		if (LOG_COLLECT) {
			
		}
	}

}
