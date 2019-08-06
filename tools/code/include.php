<?php
/**
 *公用类
* @author:
*/

class __table__  {

	public function checkData($data,&$err=null){
		foreach ($data as $k=>$v){
			switch($k){
				default:
					$arr[$k]=$v;
				break;
			}
		}
		return $arr;
	}
}