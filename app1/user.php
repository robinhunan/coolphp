<?php
/**
*  管理页
* @author:
*/
include_once SYS_PATH.'include/app1/user.php';
class c_app1_user{
	
	function insert(){
		$app1_user = new app1_user();
		$res = $app1_user->db->insert($_POST);
		if ($res ==false) {
			msg::info('back',$app1_user->db->msg,'error');
		} else {
			msg::info('?c=app1_user');
		}
	}
	
	function delete(){
		$app1_user = new app1_user();
		$ids  = implode(',',util::convert($_REQUEST['ids']));
		$app1_user->db->where(sprintf('id in (%s)',$ids));
		$res = $app1_user->db->delete();
		if ($res ==false) {
			msg::info('back',$app1_user->db->msg,'error');
		} else {
			msg::info('?c=app1_user');
		}
	}
	
	function update(){
		$app1_user = new app1_user();
		$app1_user->db->where('id='.(int)$_GET['id']);
		$res = $app1_user->db->update($_POST);
		if ($res ==false) {
			msg::info('back',$app1_user->db->msg,'error');
		} else {
			msg::info('?c=app1_user');
		}
	
	}
	function add(){
		include template::inc("app1/user/add.php");
	}
	
	function edit(){
		$app1_user = new app1_user();
		$app1_user->db->where('id='.(int)$_GET['id']);
		$row = $app1_user->db->find();
		include template::inc("app1/user/edit.php");
	}
	
	function home(){
		$app1_user = new app1_user();
		$url = "?mod=index&page=_page_";
		if ($key=get($_GET,'key')) {
			$where = util::convert($_GET['field']).' like "%'.util::convert($key).'%"';
			$app1_user->db->where($where);
			$url = sprintf('%s&fields=%s&key=%s',$url,$_GET['field'],$key);
		}
		if ($cnt = $app1_user->db->count() ) {
			$o = array('size'=>20);
			//每页显示的记录数
			$pages = new pages($cnt,$o);
			$sql = sprintf("select * from %s %s order by id desc", $app1_user->db->table, $app1_user->db->condition());
			$rows = $app1_user->db->rows($sql,$pages->start,$o['size']);
			$nav = $pages->show();
		}
		include template::inc("app1/user/index.php");
	}

}
