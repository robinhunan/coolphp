<?php

//应用入口文件

//包含通用的配置文件
include_once('../include/config.php');
include_once SYS_PATH.'include/string.php';

$control = get($_GET,'c','app1_user');
$action  = get($_GET,'a','home');
try {
	//包含控制层文件
	include_once SYS_PATH.'controller/'.str_replace('_','/',string::filter($control)).'.php';
	$name = 'c_'.$control;
	$c = new $name;
	method_exists($c,$action) && $c->$action();
} catch (Exception $e) {
	print $e->getMessage();
	exit();
}
