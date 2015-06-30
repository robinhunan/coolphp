<?php
/**
*  管理页
* @author:
*/
include_once SYS_PATH.'include/__ds_table__.php';
class c___table__{
	
	function insert(){
		$__table__ = new __table__();
		$res = $__table__->db->insert($_POST);
		if ($res ==false) {
			msg::info('back',$__table__->db->msg,'error');
		} else {
			msg::info('?c=__table__');
		}
	}
	
	function delete(){
		$__table__ = new __table__();
		$ids  = implode(',',util::convert($_REQUEST['ids']));
		$__table__->db->where(sprintf('id in (%s)',$ids));
		$res = $__table__->db->delete();
		if ($res ==false) {
			msg::info('back',$__table__->db->msg,'error');
		} else {
			msg::info('?c=__table__');
		}
	}
	
	function update(){
		$__table__ = new __table__();
		$__table__->db->where('id='.(int)$_GET['id']);
		$res = $__table__->db->update($_POST);
		if ($res ==false) {
			msg::info('back',$__table__->db->msg,'error');
		} else {
			msg::info('?c=__table__');
		}
	
	}
	function add(){
		include template::inc("__ds_table__/add.php");
	}
	
	function edit(){
		$__table__ = new __table__();
		$__table__->db->where('id='.(int)$_GET['id']);
		$row = $__table__->db->find();
		include template::inc("__ds_table__/edit.php");
	}
	
	function home(){
		$__table__ = new __table__();
		$url = "?mod=index&page=_page_";
		if ($key=get($_GET,'key')) {
			$where = util::convert($_GET['field']).' like "%'.util::convert($key).'%"';
			$__table__->db->where($where);
			$url = sprintf('%s&fields=%s&key=%s',$url,$_GET['field'],$key);
		}
		if ($cnt = $__table__->db->count() ) {
			$o = array('size'=>20);
			//每页显示的记录数
			$pages = new pages($cnt,$o);
			$sql = sprintf("select * from %s %s order by id desc", $__table__->db->table, $__table__->db->condition());
			$rows = $__table__->db->rows($sql,$pages->start,$o['size']);
			$nav = $pages->show();
		}
		include template::inc("__ds_table__/index.php");
	}

}
