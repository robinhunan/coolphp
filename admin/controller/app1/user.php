<?php
/**
*  系统控制层入口
* @author:
*/
class c_app1_user{

	function insert(){
		$app1_user = new app1_user();
		$arr = $app1_user->checkData($_POST,$err);
		if ($err!=null){
		    msg::json(-1,$err);
		}
		$db = pool::db();
		$res = $db->table('app1_user')->insert($arr);
		if ($res === false) {
			msg::json(-1,$db->msg);
		} else {
			msg::json(1);
		}
	}

	function delete(){
		$app1_user = new app1_user();
		$id=(int)$_GET['id'];
		$where  = array('id'=>$id);
		$res = $db->table('app1_user')->where($where)->delete();
		if ($res === false) {
			msg::json(-1,$db->msg);
		} else {
			msg::json(1);
		}
	}

	function update(){
		$id=(int)$_GET['id'];
		$where  = array('id'=>$id);
		$app1_user = new app1_user();
		$db = pool::db();
		$arr = $app1_user->checkData($_POST,$err);
		if ($err!=null){
		    msg::json(-1,$err);
		}
		$res = $db->table('app1_user')->where($where)->update($arr);
		if ($res === false) {
			msg::json(-1,$db->msg);
		} else {
			msg::json(1);
		}

	}
	function add(){
		$db = pool::db();
		include APP_PATH.("view/app1/user/add.php");
	}

	function edit(){
		$id=(int)$_GET['id'];
		$where  = array('id'=>$id);
		$app1_user = new app1_user();
		$db = pool::db()->table('app1_user');
		$row = $db->where($where)->find();
		include APP_PATH.("view/app1/user/edit.php");
	}

	function index(){
		$app1_user = new app1_user();
		$db = pool::db()->table('app1_user');
		$url = "?mod=app1_user&page=_page_";
		if (!empty($_GET['key'])) {
			$where = sprintf("`%s` like '%%s%'",cstring::safe($_GET['field']),util::convert($key));
			$db->where($where);
			$url = sprintf('%s&fields=%s&key=%s',$url,$_GET['field'],$key);
		}
		if ($cnt = $db->count() ) {
			$o = array('size'=>20);
			//每页显示的记录数
			$pages = new pages($cnt,$o);
			$sql = sprintf("select * from %s %s order by id desc", $db->table, $db->condition());
			$rows = $db->rows($sql,$pages->start,$o['size']);
			$nav = $pages->show();
		}
		include APP_PATH.("view/app1/user/index.php");
	}

}
