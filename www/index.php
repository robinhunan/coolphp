<?php

//应用入口文件
define('APP_PATH',__DIR__.'/');
//包含通用的配置文件
include('../include/config.php');

$control = $_GET['c']?:'manager';
$action  = $_GET['a']?:'index';
try {
	//包含控制层文件
	include APP_PATH.'controller/'.str_replace('_','/',cstring::filter($control)).'.php';
	$name = 'c_'.$control;
	$c = new $name;
	$c->$action();
} catch (Exception $e) {
	print $e->getMessage();
	exit();
}