<?php
/**
* @author:
*/
include_once(SYS_PATH.'include/table.php');

class manager extends table {
	
	public  function  __construct(){
		$this->dbKey = 'web';
		$this->table = 'manager';
		$this->fields = array('id','userName','userPass');
	}
}