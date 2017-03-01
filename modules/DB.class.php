<?php
namespace Dragon;
/**
 * 数据库操作的基类
 */
use Lib\Log;
class DB {
	const MASTER  = 0;
	const SLAVE   = 1;
	
	private $connection = array();
	private $config;
	private $last_sth;
	private $in_transaction = false;//是否为是事务
	private $database;

	public static function instance($in_transaction = false) {
		static $singleton  = array();
		$class = get_called_class();
		$database = $class::_DATABASE_;
		if ($in_transaction){
			$this->in_transaction = $in_transaction;
		}
		!isset($singleton[$database]) && $singleton[$database] = new DB($database);
		return $singleton[$database];
	}

	public function __construct($database) {
		$this->config = $GLOBALS[$database];
		$this->database = $database;
	}
	//写操作
	public function write($sql, $param) {
		$sth = $this->prepare($sql, $param, self::MASTER);
		$success = $this->catchError($sth);
		$this->last_sth = $sth;

		if ($success === FALSE) {
			return FALSE;
		}
		return $this->getAffectedRows();
	}
	//读操作
	public function read($sql, $param = array(), $from_master = false, $hash_key = '') {
		$type = $from_master ?  self::MASTER : self::SLAVE;
		$sth = $this->prepare($sql, $param, $type);
		$success = $this->catchError($sth);
		$result = array();
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			if (isset($hash_key) && !empty($hash_key)) {
				$result[$row[$hash_key]]= $row;
			}
			else {
				$result[]= $row;
			}
		}
		$sth->closeCursor();
		return $result;
	}

	private function prepare($sql, $param, $type) {
		$connection = $this->getConnection($type);
		$sth = $connection->prepare($sql, array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE));
		//绑定变量
		if (!empty($param)) {
			foreach ($param AS $key => $value) {
				if (strpos($key, '_') === 0) {
					$sth->bindValue(":{$key}", $value, PDO::PARAM_INT);
				}
				else {
					$sth->bindValue(":{$key}", $value, PDO::PARAM_STR);
				}
			}
		}
		$sth->execute();
		return $sth;
	}
	//获得数据库连接,长连接，开始构成连接池
	private function getConnection($type) {
		if (!empty($this->connection[$type])) {
			$num = count($this->connection[$type]);
			$key = rand(0, $num-1);
			return $this->connection[$type][$key];
		}
		switch($type) {
			case self::MASTER:
				$conf = $this->config['master'];			
				break;
			case self::SLAVE:
			default:
				$rand = array_rand($this->config['slaves']);
				$conf = $this->config['slaves'][$rand];
				break;
		}
		//跑出异常
		for ($i = 0; $i < CONNECT_POOL; $i++ ) {
			try {
				$this->connection[$type][$i] = new PDO($conf['HOST'], $this->database , $conf['USER'], $conf['PASS'], $conf['PORT']);
				$this->connection[$type][$i]->exec("SET NAMES utf8");
			}
			catch(\PDOException $e) {
				$error = 'first:' . $type . '_' . $i . '_' .  json_encode($conf) . $e->getMessage() . "\n";
				Log::instance(LOG_DB)->write($error);
				//是否需要重连机制，暂时不出来
			}
		}
		//随即返回一个
		$key = rand(0, CONNECT_POOL-1);
		return $this->connection[$type][$key];
	}

	private function catchError($sth, $sql = '', $params = '') {
		list($sql_state, $error_code, $error_message) = $sth->errorInfo();
		if ($sql_state == '00000') {
			return TRUE;
		}

		// rollback if in a transaction
		$this->rollback();
		return False;
	}

	private function rollback() {
		if ($this->in_transaction) {
			$connection = $this->getConnection(self::MASTER);
			$connection->rollback();
			$this->in_transaction = FALSE;
		}
	}

	public function getAffectedRows() {
		return $this->last_sth->rowCount();
	}
}


