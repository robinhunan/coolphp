<?php
/**
* @author yubing
* 路由解析模式
*  如果使用路由模式nginx需要增加如下配置
*
    if (!-f $request_filename){
                 rewrite ^/([a-z0-9\-_]+)/([a-z0-9\-_]+)/(.*)$ /index.php?c=$1&a=$2&path=$3 last;
    }
* 
*/

class route {
	private $path;
	private $parse;
		
	public static function getInstance(){
		static $instance;
		if(!isset($instance)){
			$instance =new self();
		}
		return $instance;
	}
	
	/* 需要解析的url路由和规则
	 * $parse 分成两部分第一部分表示变量名，第二部分获取数据类型，默认按照正则表达式获取
	 * 注意路径一定要对应上获取规则，多余的路径会被舍弃
	*/
	public function setPath($path,$parse){
		$this->path = !empty($path) ? $path : $_SERVER['REQUEST_URI'];
		$this->parse = $parse;
		return $this;
	}
	/* 获取解析后的结果*/
	public function getVar(){
		$src = explode('/',trim($this->path,'/'));
		$dst = explode('/',trim($this->parse,'/'));
		$res = array();
		foreach ($dst as $k=>$v){
			list($key,$rule) =explode(':',$v,2);
			if (!empty($rule)){
				$res[$key] = $this->parsePart($src[$k],$rule);
			} else {
				$res[$key]=$src[$k];
			}
		}
		return $res;
	}
	
	private function parsePart($path,$rule){
		switch ($rule){
			case 'int':
				$res = intval($path);
				break;
			case 'alumn':
				$res = preg_filter('/[^a-z0-9A-Z\-_]/','',$path);
				break;
			default:
				$res = preg_match("/$rule/",$path,$match) ? $match[0] : '';
				break;
		}
		return $res;
	}
	/**
	 * 解析的路由规则按照key和value填充到$_GET
	 */
	public function fillGet(){
		foreach($this->getVar() as $k=>$v){
			$_GET[$k]=$v;
		}
		return $this;
	}
	
}
/*
route::getInstance()->setPath('/app1_user/home/2.htm/','c:/a:/id:[0-9]+')->fillGet();
var_dump($_GET);
*/


