<?php
/**
* @author:
*/
include_once(SYS_PATH.'include/table.php');

class app1_user extends table {
	
	public  function  __construct(){
		$this->table = 'app1_user';
		$this->fields = array('id','name','mobile');
	}
}