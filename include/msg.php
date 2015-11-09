<?php
 /**
* 消息提示类
* @author yubing
*/
 class msg
 {
	/**
	** 掷出信息
	** @ info : 信息内容
	** @ url  : 重定向url
	**/
	public static function info($url = 'none', $info='', $type='ok', $second = 2, $title = "提示信息")
	{
		$info = empty($info) ? '操作成功!' : (is_string($info)?$info:json_encode($info));
		include_once template::inc('msg.html');
		exit;
	}

	public static function json($code=0, $msg='OK', $data=array())
	{
		header('Content-Type: application/json');
		if (is_array($code)) {
			exit(json_encode($code));
		} else {
			exit(json_encode(array('code'=>$code, 'msg'=>$msg, 'data'=>$data)));
		}
	}
}
 
