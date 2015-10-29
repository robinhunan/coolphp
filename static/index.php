<?php

//css，js文件合并，只能合并static目录下面的文件
// @author: yubing
error_reporting(0);
ob_start();
include_once '../include/string.php';
$files = explode(';',trim($_SERVER['QUERY_STRING'],';') );

strpos($_SERVER['QUERY_STRING'],'.css')!==false && header('Content-Type: text/css');
$a = array();
foreach($files as $fn){
        
	$fn = string::filter($fn);
	$a[] = "\n/* -- $fn ---*/";
	//判断要合并的文件是否存在
	if (!file_exists($fn)){
		//get_cfg_var('jjr.online') || header("HTTP/1.1 404 ".$fn);
	} else{
		$a[]=file_get_contents($fn);
	}
}
$s=implode('',$a);
//header('Last-Modified: Wed, 28 Oct 2015 07:26:35 GMT');
//header(sprintf('ETag: "%x"',crc32($s)) );

echo $s;
	

