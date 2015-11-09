<?php
/**
* 基于数据表,操作基本类
* @athor: yubingzhu
*/

abstract class table {
    protected $db;
    protected $hash=0;
    protected $table;
    protected $fields=array();
    protected $dbKey ='db';

    final public function __get($name){
	if (!property_exists($this, $name)) {
	    return NULL;
	}
	else if (!is_null($this->$name)){
		if ($name == 'db') {
			$this->db->table($this->table,$this->fields);
		}
	    return $this->$name;
	}
	$funName = 'get'. ucfirst($name);
	if (method_exists($this, $funName)){
	    $this->$funName();
	}
	return $this->$name;
    }
    protected function getDb(){
		$db = pool::db($this->dbKey,$this->hash);
		$db->table($this->table,$this->fields);
		return $this->db = $db;
    }
    /*
     *数据插入，修改删除前，检查数据类型,
     * 如果数据表字段设置允许空，传入的值为空，强制设置成null,
     * 如果数据表字段默认值为数字，传入值为空，转换成数字
     * @param $strict =true 执行严格检查，数据字段格式不正确返回错误信息
     */
    public function checkData($data, &$err=null){
	return $data;
    }


    public function setTableName($strTableName) {
	    $this->table = $strTableName;
	    if (is_object($this->db)) {
		    $this->db->table = $strTableName;
	    }
    }
 }
