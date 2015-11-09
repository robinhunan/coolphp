<?php                    
/**
 * 数据库操作类
 * @author: yubing
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

	/**
	 * 初始化一个数据库实例
	 * @param string $configKey  数据库配置项
	 * @param int $index //索引值,根据这个值获取计算数据源 'db'=>[0,1,2]
	 * @return db
	 */
	public function __construct($configKey = 'db', $index =0)
	{
		$config = config::$$configKey; // config::db
		$dsn = $config['dsn'][$index]; // $index在第几台服务器
		$this->config = array(
			'dsn' => $dsn,
			'user'=> $config['user'],
			'pass'=> $config['pass'],
			'options' => $config['options'],
		);	
		parent::__construct($this->config['dsn'], $this->config['user'], $this->config['pass'], $this->config['options']);
	}

	//重建连接
	public function reConnect()
	{
		$attr = array();
		foreach ($this as $k => $v) {
			$attr[$k] = $v;
		}
		parent::__construct($this->config['dsn'], $this->config['user'], $this->config['pass'], $this->config['options']);
		foreach ($attr as $k => $v) {
			$this->$k = $v;
		}
	}

	/**
	 * 插入数据
	 * @param array $data   
	 */
	public function insert($data = array())
	{
		$this->sql = sprintf('INSERT INTO %s SET %s', $this->table, implode(',', $this->joinKeyVal($data)));
		if (!$this->query($this->sql)) {
			$this->msg = $this->errorInfo(); 
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
		$res = $sth->fetchColumn(0); 
		return (int)$res;
	}

	/**
	 * @param $sql
	 * @param int $type
	 * @param int $returnType 1 默认（sql错误时返回空数组，没查到数据时返回false） ，2 （sql错误时返回 false，没查到数据时返回空数组）
	 * @return array|bool|mixed
	 * @auth zhangjie
	 */
	public function row($sql,$type=PDO::FETCH_ASSOC, $returnType = 1)
	{
		$this->sql = $sql;
		$sth = $this->query($this->sql);
		if (!$sth) {
			$this->msg = $this->errorInfo();
			return $returnType == 1 ? array() : false;
		}
		$res = $sth->fetch($type);
		return ($returnType == 1 || !empty($res)) ? $res : array();
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
			$this->sql = sprintf('%s LIMIT %d,%d', $this->sql, $start, ($size>1000?1000:$size));
		}
		$sth = $this->query($this->sql);
		if (!$sth) {
			$this->msg = $this->errorInfo();
			return array();
		}
		return $sth->fetchAll($type);
	}

	/**
	 * 更新数据
	 * @param array $data    
	 * 返回受影响的行数/出错返回false
	 */
	public function update($data = array())
	{
		$this->sql = sprintf('UPDATE %s SET %s %s' , $this->table, implode(',' , $this->joinKeyVal($data)) , $this->condition());
		return $this->exec($this->sql); 
	}

	/**
	 * 根据查询条件返回一条记录
	 * @param int $returnType 参见 $this->row() 注释
	 * @return array|mixed
	 */
	public function find($returnType = 1)
	{
		$this->sql = 'SELECT '.$this->select.' FROM '.$this->table . $this->condition();
		return $this->row($this->sql, PDO::FETCH_ASSOC, $returnType);
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
		if($ret===false){
			$this->msg = $this->errorInfo();
		}
		return $ret!==false;
	}

	/**
	 * 设置各种查询条件
	 * @param mixed $input
	 */
	public function where($input)
	{
		if (is_string($input)) {
			$this->where[] = $input;
		} else if (is_array($input)){
			$this->where = array_merge($this->where, $this->joinKeyVal($input));
		}
		return $this;
	}

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
		$this->fields = $fields;
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
	 */
	public function joinKeyVal($data)
	{
		$arr = array();
		foreach ($data as $k=>$v) {
			if (!empty($k)) {
				if (is_null($v)) {
					array_push($arr, sprintf('`%s`=NULL',$k));
				} else {
					array_push($arr, sprintf('`%s`=%s',$k,$this->quote($v)));
				}
			}
		}
		return $arr;
	}

	/**
	 * 给字符串,添加',方便插入数据，防止sql注入
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
		$errInfo['sql'] = $this->sql;
		return $errInfo;
	}
    
}

/*

include_once 'config.php';
$db = pool::db('dbBbs');
$sql  = 'select * from manager';
$rows = $db->rows($sql,0,20);
echo '<pre>';
print_r($rows);
 */