<?php
/**
* @author:
*/
include_once(SYS_PATH.'include/table.php');

class app1_user extends table {
	
	public  function  __construct(){
		$this->dbKey = 'web';
		$this->table = 'app1_user';
		$this->fields = array('id','loginName','loginPass','nickName','sex','birthday','province','city','mobile','email');
	}
}