<?php
/**
* @author yubing
* 系统配置文件
*/
   
/**
 * 定义系统根目录,请不要在这里加自定义函数            
 */
!defined('SYS_PATH') && define('SYS_PATH',realpath(dirname(__FILE__).'/../').'/');
include_once (SYS_PATH.'include/pool.php');


/**
 * 自动加载对象
 * 如果有libaray下面还有目录，用_分开，类名前面加目录名用_分开
 */
function loadClass($className){
	$fn = SYS_PATH. 'include/'. str_replace('_','/',strtolower($className)).'.php';
	if(is_file($fn)){
		include_once($fn);
	}
}
spl_autoload_register('loadClass');
/**
*  获取一个数组中某个key的值，如果没有返回默认值
* 
* @param array $arr   //数组名
* @param string $key  //索引值
* @param mixed $default 
* 如 get($_POST,'page',1);
*/
function get($arr,$key,$default=null){
      return !isset($arr[$key]) ? $default : $arr[$key];                                 
}
/**
 * 配置参数监护器
 * 
 * @package library
 */
class config
{
	/**
	 * 配置参数
	 */
	const KEY="i5%e()|',\"idi&UH";
	static  $db = array (
		'dsn'=>array('mysql:host=localhost;port=3306;dbname=test;charset=utf8'),
		'user'=>'root',
		'pass'=>'',
		'options'=>array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "UTF8"',
			PDO::ATTR_TIMEOUT => 5,
		),
	);
	static  $dbBbs = array (
		'dsn'=>array('mysql:host=localhost;port=3306;dbname=test;charset=utf8'),
		'user'=>'root',
		'pass'=>'',
		//'options'=>array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "UTF8"'),
	);
	
	static $memcacheServers  = array(
		array('localhost', 11211),
		array('localhost', 11212),
	);

}

