<?php
/**
 * 数据库操作类
 * @author: zhuyubing
 */
class cooldb extends PDO
{
	private $config;
	public $table;   //当前操作的数据表名字
	protected $fields;
	private $where = array();
	private $select = '*';
	public $sql;
	public $msg;
	private $stmt; //PDOStatement实例
	private $param = array();

	/**
	 * 初始化一个数据库实例
	 * @param string $configKey  数据库配置项
	 * @param int $index //索引值,根据这个值获取计算数据源 'db'=>[0,1,2]
	 * @return db
	 */
	public function __construct($configKey = 'db')
	{
		$this->config = $config = config::$$configKey;
		parent::__construct($config['dsn'], $config['user'], $config['pass'], $config['options']);
	}

	//重建连接
	public function reConnect()
	{
		$confit = $this->config;
		parent::__construct($config['dsn'], $config['user'], $config['pass'], $config['options']);
	}

	/**
	 * 插入数据
	 * @param array $data
	 */
	public function insert($data = array())
	{
		$this->sql = sprintf('INSERT INTO %s SET %s', $this->table, implode(',', $this->joinKeyVal($data,true)));
		if (!$this->query($this->sql)) {
			return false;
		}
		return $this->lastInsertId();
	}

	/**
	 * 插入数据，当出现key重复时更新数据
	 * INSERT ... tbl_name SET ... ON DUPLICATE KEY UPDATE ...
	 * @param array $insertData 不存在记录时的新增数据
	 * @param array $updateData 存在记录时的更新数据
	 * @return int 新增记录id
	 */
	public function insertDuplicate(array $insertData, array $updateData)
	{
		$this->sql = sprintf('INSERT INTO %s SET %s ON DUPLICATE KEY UPDATE %s', $this->table,
			implode(',', $this->joinKeyVal($insertData)), implode(',', $this->joinKeyVal($updateData)));
		if (!$this->query($this->sql)) {
			return false;
		}
		return $this->lastInsertId();
	}

	/**
	 * 计算有多少条记录
	 */
	public function count($strCountSql='count(*)')
	{
		$this->sql = sprintf('SELECT %s FROM %s %s', $strCountSql, $this->table, $this->condition());
		$sth = $this->query($this->sql);
		if(!$sth){
			return 0;
		}
		$res = $sth->fetchColumn(0);
		return (int)$res;
	}

	/**
	 * @param $sql
	 * @param int $type
	 */
	public function row($sql,$type=PDO::FETCH_ASSOC)
	{
		$this->sql = $sql;
		$sth = $this->query($this->sql);
		if (!$sth) {
			return false;
		}
		return $sth->fetch($type);
	}

	public function rows($sql, $start=0, $size=0, $orderBy='', $groupBy='', $type=PDO::FETCH_ASSOC)
	{
		$this->sql = $sql;
		if ($groupBy) {
			$this->sql = sprintf('%s GROUP BY %s', $this->sql, $groupBy);
		}
		if ($orderBy) {
			$this->sql = sprintf('%s ORDER BY %s', $this->sql, $orderBy);
		}
		if ($size > 0) {
			$this->sql = sprintf('%s LIMIT %d,%d', $this->sql, $start, $size);
		}
		$sth = $this->query($this->sql);
		if (!$sth) {
			return array();
		}
		return $sth->fetchAll($type)?:[];
	}

	/**
	 * 更新数据
	 * @param array $data
	 * 返回受影响的行数/出错返回false
	 */
	public function update($data = array(),$returnCnt=0)
	{
		$this->sql = sprintf('UPDATE %s SET %s %s' , $this->table, implode(',' , $this->joinKeyVal($data)) , $this->condition());
		if($returnCnt==1){
			$stmt = $this->prepare($this->sql);
			$stmt->execute();
			return $stmt->rowCount();
		}
		else {
			return $this->exec($this->sql);
		}
	}

	/**
	 * 根据查询条件返回一条记录
	 * @return array|mixed
	 */
	public function find()
	{
		$this->sql = 'SELECT '.$this->select.' FROM '.$this->table . $this->condition();
		return $this->row($this->sql, PDO::FETCH_ASSOC);
	}

	//根据字段名，从cache获取记录，默认先查找cache,是否强制刷新
	function cache($field,$v,$refresh=0){
		if(empty($v)||empty($field)){
			return [];
		}
		$key = join([$field,$v]);
		if($refresh==0){
			$row = pool::cache('db')->hget($this->table,$key);
			if(!empty($row)){
				return json_decode($row,true);
			}
		}
		$sql = sprintf('select * from %s where `%s`=%s',$this->table,$field,$this->quote($v));
		if($row=$this->row($sql)){
			pool::cache('db')->hset($this->table,$key,json_encode($row,256));
		}
		return $row;
	}
	/**
	 * 根据查询条件返回多条记录
	 */
	public function findAll($offset=0, $limit=0, $orderBy='', $groupBy='')
	{
		$this->sql = 'SELECT '.$this->select.' FROM '.$this->table . $this->condition();
		return $this->rows($this->sql, $offset, $limit, $orderBy, $groupBy);
	}

	/**
	 * 删除数据
	 */
	public function delete()
	{
		$this->sql = 'DELETE FROM '.$this->table. $this->condition();
		$ret = $this->exec($this->sql);
		return $ret!==false;
	}

	/**
	 * 设置各种查询条件
	 * @param mixed $input
	 */
	public function where($input)
	{
		if (is_string($input)&&!empty($input)) {
			$this->where[] = $input;
		} else if (is_array($input)){
			foreach($input as $k=>$v){
				if(is_numeric($k)){
					$this->where[]=$v;
				} else {
					$this->where[] = sprintf('`%s`=%s',$k,$this->quote($v));
				}
			}
		}
		return $this;
	}
    //获取sql的查询条件
	public function condition()
	{
		return count($this->where) ? ' WHERE '.implode(' AND ',$this->where) : '';
	}

	public function select($fields)
	{
		if (is_array($fields) && $fields) {
			$this->select = '`'.implode('`,`', $fields).'`';
		} else {
			$this->select = $fields;
		}
		return $this;
	}

	/**
	 * 设置数据表名称，值
	 * @param bool $name
	 * @param mixed $fields
	 */
	public function table($name,$fields=array())
	{
		$this->table = $name;
		$this->select = "*";
		$this->fields = $fields;
        $this->where = [];
		return $this;
	}

	public function reset()
	{
		$this->sql = '';
		$this->select = '*';
		$this->where = array();
		return $this;
	}

	/**
	 * @param array $data
	 * 拼接key valure 数组为 = 连接的数据
	 * $noEmpty不使用空数据
	 */
	public function joinKeyVal($data,$noEmpty=false)
	{
		$arr = array();
		foreach ($data?:[] as $k=>$v) {
			if (!empty($k)) {
				if (strlen($v)==0&&$noEmpty==false){
					array_push($arr, sprintf('`%s`=NULL',$k));
				} else {
					array_push($arr, sprintf('`%s`=%s',$k,$this->quote($v)));
				}
			}
		}
		return $arr;
	}

	/**
	 * 给字符串,添加'
	 */
	public static function q($v)
	{
		return "'".  str_replace(array("\\","'"),array('',"\\'"),trim($v,"'")) . "'";
	}

	//当发生错误 STATE[HY000] CODE[2006] MSG[MySQL server has gone away]
	//时重建连接，检测到此错误时，调用方可以重试查询
	public function errorInfo()
	{
		$errInfo = parent::errorInfo();
		if ($errInfo[0]=='HY000' && $errInfo[1]==2006) {
			$this->reConnect();
		}
		if($this->stmt instanceof PDOStatement){ //绑定参数的方式执行sql出错
			$errInfo = $this->stmt->errorInfo();
			$errInfo['param'] = $this->param;
		}
		$errInfo['sql'] = $this->sql;
		return $errInfo;
	}


	/**
	 * 执行一条SQL语句并返回影响的行数，执行成功可能也返回0，执行失败则返回false
	 * @param $sql
	 * @param array $param
	 * @return bool|int
	 */
	public function execute($sql, $param = array())
	{
		$this->msg = null;
		$stmt = $this->prepareStatement($sql, $param);
		if ($stmt->execute()) {
			return intval($stmt->rowCount());
		} else {
			$this->msg = $this->errorInfo();
			//重试
			if ($this->msg[0]=='HY000' && $this->msg[1]==2006) {
				$stmt = $this->prepareStatement($sql, $param);
				if ($stmt->execute()) {
					$this->msg = null;
					return intval($stmt->rowCount());
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}

	/**
	 * 返回一个PDOStatement实例
	 * @param $sql string，SQL语句，可以带占位符
	 * @param array $param
	 * @return bool|PDOStatement
	 */
	private function prepareStatement($sql, $param = array()) {
		try {
			$this->msg = null;
			$this->sql = $sql;
			$this->param = $param;
			$stmt = $this->prepare($sql);
			foreach ($param as $k => $v) {
				if (is_string($k) && substr($k,0,5) == ':INT_') {
					$stmt->bindValue($k, $v, PDO::PARAM_INT);
				} elseif (is_int($k)) {
					$stmt->bindValue($k+1, $v, PDO::PARAM_STR);
				} else {
					$stmt->bindValue($k, $v, PDO::PARAM_STR);
				}
			}
			$this->stmt = $stmt;
			return $stmt;
		} catch (Exception $e) {
			$this->msg = $this->errorInfo();
			//重试
			if ($this->msg[0]=='HY000' && $this->msg[1]==2006) {
				try {
					$stmt = $this->prepare($sql);
					foreach ($param as $k => $v) {
						if (is_string($k) && substr($k,0,5) == ':INT_') {
							$stmt->bindValue($k, $v, PDO::PARAM_INT);
						} elseif (is_int($k)) {
							$stmt->bindValue($k+1, $v, PDO::PARAM_STR);
						} else {
							$stmt->bindValue($k, $v, PDO::PARAM_STR);
						}
					}
					$this->stmt = $stmt;
					$this->msg = null;
					return $stmt;
				} catch (Exception $e) {
					return false;
				}
			} else {
				return false;
			}
		}
	}
}

/*
include_once 'config.php';
$db = pool::db('db');
//$db->query('set names utf8') ;
$sql  = 'select * from user';
$rows = $db->rows($sql,0,20);
echo '<pre>';
print_r($rows);
*/
