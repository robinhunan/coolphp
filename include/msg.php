<?php
 /**
* 消息提示类
* @author zhuyubing
*/
 class msg
 {

	/**
	 *输出json数据,传入参数为数组array('code'=>,'msg'=>'','data'=>'');
	 */
	public static function json($code=0, $msg='',$data=[])
	{
		//ob_end_clean();
		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json; charset=utf-8');
		if(is_numeric($code)){
			$code=array("code"=>$code,"msg"=>$msg,'data'=>$data);
		}
		if(!empty($_GET['callback'])){ //处理jsonp输出格式
			printf('%s(%s)',htmlspecialchars($_GET['callback']),json_encode($code,256));
		}else {
			echo json_encode($code,256);
		}
		die();
	}
}

