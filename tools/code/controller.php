<?php
/**
*  系统控制层入口
* @author:
*/
class c___table__{

	function insert(){
		$__table__ = new __table__();
		$arr = $__table__->checkData($_POST,$err);
		if ($err!=null){
		    msg::json(-1,$err);
		}
		$db = pool::db();
		$res = $db->table('__table__')->insert($arr);
		if ($res === false) {
			msg::json(-1,$db->msg);
		} else {
			msg::json(1);
		}
	}

	function delete(){
		$__table__ = new __table__();
		$id=(int)$_GET['id'];
		$where  = array('id'=>$id);
		$res = $db->table('__table__')->where($where)->delete();
		if ($res === false) {
			msg::json(-1,$db->msg);
		} else {
			msg::json(1);
		}
	}

	function update(){
		$id=(int)$_GET['id'];
		$where  = array('id'=>$id);
		$__table__ = new __table__();
		$db = pool::db();
		$arr = $__table__->checkData($_POST,$err);
		if ($err!=null){
		    msg::json(-1,$err);
		}
		$res = $db->table('__table__')->where($where)->update($arr);
		if ($res === false) {
			msg::json(-1,$db->msg);
		} else {
			msg::json(1);
		}

	}
	function add(){
		$db = pool::db();
		include APP_PATH.("view/__ds_table__/add.php");
	}

	function edit(){
		$id=(int)$_GET['id'];
		$where  = array('id'=>$id);
		$__table__ = new __table__();
		$db = pool::db()->table('__table__');
		$row = $db->where($where)->find();
		include APP_PATH.("view/__ds_table__/edit.php");
	}

	function index(){
		$__table__ = new __table__();
		$db = pool::db()->table('__table__');
		$url = "?mod=__table__&page=_page_";
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
		include APP_PATH.("view/__ds_table__/index.php");
	}

}
