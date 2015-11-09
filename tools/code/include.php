<?php
/**
 *公用类
* @author:
*/
include_once(SYS_PATH.'include/table.php');

class __table__ extends table {
	
	public  function  __construct(){
		$this->dbKey = '__dsnName__';
		$this->table = '__table__';
	}
	
	public function checkData($data,&$err=null){
		foreach ($data as $k=>$v){
		switch($k){//__checkData__
		}
		}
		return $arr;
	}
}