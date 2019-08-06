<?php
/**
*  系统控制层入口
* @author:
*/
class c_manager{
	
	
	//登录界面
	function login(){
		include APP_PATH.'view/manager/login.php';
	}
	//处理登录
	function login2(){
		$manager = new manager();
		$row = $manager->db->where(array('userName'=>$_POST['userName'],'userPass'=>md5($_POST['userPass'])))->find();
		if($row){
			$arr = array(0=>$row['id'],1=>time(),2=>$row['userName']);
			$manager->setLoginInfo($arr);
			msg::json(1);
		} else {
			msg::json(-1,'用户名或者密码错误');
		}
	}

}
