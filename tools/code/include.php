<?php
/**
* @author:
*/
include_once(SYS_PATH.'include/table.php');

class __table__ extends table {
	
	public  function  __construct(){
		$this->table = '__table__';
		$this->fields = array(__fields__);
	}
}