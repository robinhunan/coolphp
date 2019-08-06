<?php
/**
 *公用类
* @author:
*/

class manager  {

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
	//获取用户信息
	public function getLoginInfo(){
		if(!empty($_COOKIE['_mkey'])){
			$s = cstring::decrypt($_COOKIE['_mkey'],config::KEY);
			return explode('|',$s);
		}
		return array();
	}
	//设置用户信息, 用户ID|所属企业|状态
	public function setLoginInfo($arr){
		$s=cstring::encrypt(implode('|',$arr),config::KEY);
		setcookie('_mkey',$s,$_SERVER['REQUEST_TIME']+86400,'/');
	}
}