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
	//页面跳转信息 msg::info(['type'=>'err','url'=>'','content'=>'保持状态']);
	public static function info($info){
		$type = $info['type']!='ok'?':(':':)';
		$url  = !$info['url']?$_SERVER['HTTP_REFERER']:$info['url'];
		$str =<<<EOT
		<!DOCTYPE html>
		<html>
		<head>
		<meta charset="utf-8" />
		<title>提示：{$info['title']}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<style type="text/css">
		html,body{ padding: 0; margin: 0; }
		body{ background: #fff; color: #333; font-size: 16px; }
		.system-message{ padding-left: 24px;padding-bottom: 48px; }
		.system-message h1{ font-size: 60px; font-weight: normal; line-height: 60px; margin-bottom: 12px; }
		.system-message .jump{ padding-top: 10px}
		.system-message .jump a{ color: #f50;}
		.system-message .content{ line-height: 1.8em; font-size: 24px }
		</style>
		</head>
		<body>
		<div class="system-message">
		<h1>{$type}</h1>
		<p class="content">{$info['content']}</p>
		<p class="jump">
		页面自动 <a id="href" href="{$url}">跳转</a> 等待时间： <b id="wait">3</b>
		</p>
		</div>
		<script type="text/javascript">
		(function(){
		var wait = document.getElementById('wait'),href = document.getElementById('href').href;
		var interval = setInterval(function(){
			var time = --wait.innerHTML;
			if(time == 0) {
				location.href = href;
				clearInterval(interval);
			};
		}, 1000);
		})();
		</script>
		</body>
		</html>
EOT;

		/****/
		echo $str;
		exit(0);
	}

}