<?php
/**
*  管理页
* @author:
*/
include_once SYS_PATH.'include/manager.php';
class c_manager{
	
	function insert(){
		$manager = new manager();
		$res = $manager->db->insert($_POST);
		if ($res === false) {
			msg::info('back',$manager->db->msg,'error');
		} else {
			msg::info('?c=manager');
		}
	}
	
	function delete(){
		$manager = new manager();
		$ids  = implode(',',util::convert($_REQUEST['ids']));
		$manager->db->where(sprintf('id in (%s)',$ids));
		$res = $manager->db->delete();
		if ($res === false) {
			msg::info('back',$manager->db->msg,'error');
		} else {
			msg::info('?c=manager');
		}
	}
	
	function update(){
		$manager = new manager();
		$manager->db->where('id='.(int)$_GET['id']);
		$res = $manager->db->update($_POST);
		if ($res === false) {
			msg::info('back',$manager->db->msg,'error');
		} else {
			msg::info('?c=manager');
		}
	
	}
	function add(){
		include template::inc("manager/add.php");
	}
	
	function edit(){
		$manager = new manager();
		$manager->db->where('id='.(int)$_GET['id']);
		$row = $manager->db->find();
		include template::inc("manager/edit.php");
	}
	
	function home(){
		$manager = new manager();
		$url = "?mod=index&page=_page_";
		if ($key=get($_GET,'key')) {
			$where = util::convert($_GET['field']).' like "%'.util::convert($key).'%"';
			$manager->db->where($where);
			$url = sprintf('%s&fields=%s&key=%s',$url,$_GET['field'],$key);
		}
		if ($cnt = $manager->db->count() ) {
			$o = array('size'=>20);
			//每页显示的记录数
			$pages = new pages($cnt,$o);
			$sql = sprintf("select * from %s %s order by id desc", $manager->db->table, $manager->db->condition());
			$rows = $manager->db->rows($sql,$pages->start,$o['size']);
			$nav = $pages->show();
		}
		include template::inc("manager/index.php");
	}

}
