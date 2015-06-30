<?php

//应用入口文件

//包含通用的配置文件
include_once('./include/config.php');
include_once SYS_PATH.'include/string.php';

$control = isset($_GET['c']) ? string::filter($_GET['c']) : 'app1_user';
$action  = isset($_GET['a']) ? string::filter($_GET['a']) : 'home';
try {
	include_once SYS_PATH.str_replace('_','/',$control).'.php';
	$name = 'c_'.$control;
	$c = new $name;
	$c->$action();
} catch (Exception $e) {
	print $e->getMessage();
	exit();
}
