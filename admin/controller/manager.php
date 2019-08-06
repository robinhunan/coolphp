<?php
/**
*  系统控制层入口
* @author:
*/
class c_manager{

	function insert(){
		$manager = new manager();
		$db = pool::db()->table('manager');
		$arr = $manager->checkData($_POST,$err);
		if ($err!=null){
		    msg::json(-1,$err);
		}
		$arr['userPass']=md5($arr['userPass']);
		$res = $db->insert($arr);
		if ($res === false) {
			msg::json(-1,$db->msg);
		} else {
			msg::json(1);
		}
	}

	function delete(){
		$manager = new manager();
		$db = pool::db();
		$id=(int)$_GET['id'];
		$where  = array('id'=>$id);
		$db->table('manager')->where($where);
		$res = $db->delete();
		if ($res === false) {
			msg::json(-1,$db->msg);
		} else {
			msg::json(1);
		}
	}

	function logout(){
		setcookie('_mkey',null,0,'/');
		echo '<script>location.href="../www/?c=manager"</script>';
	}

	function update(){
		$id=(int)$_GET['id'];
		$where  = array('id'=>$id);
		$manager = new manager();
		$db = pool::db();
		$db->table('manager')->where($where);
		$arr = $manager->checkData($_POST,$err);
		if ($err!=null){
		    msg::json(-1,$err);
		}
		$arr['userPass']=md5($arr['userPass']);
		$res = $db->update($arr);
		if ($res === false) {
			msg::json(-1,$db->msg);
		} else {
			msg::json(1);
		}

	}
	function add(){
		$db = pool::db();
		include APP_PATH.("view/manager/add.php");
	}

	function edit(){
		$id=(int)$_GET['id'];
		$where  = array('id'=>$id);
		$manager = new manager();
		$db = pool::db()->table('manager');
		$db->where($where);
		$row = $db->find();
		include APP_PATH.("view/manager/edit.php");
	}

	function index(){
		$manager = new manager();
		$db = pool::db()->table('manager');
		$url = "?mod=manager&page=_page_";
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
		include APP_PATH.("view/manager/index.php");
	}

}
