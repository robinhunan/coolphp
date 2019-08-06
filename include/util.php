<?php
/** 基础函数库
* @author: yubing
*/
class util {    
    
    /**
     * 
     * 获取客户端IP
     * @return string ip
     */
    public static function getClientIp() {
        $ip=false;
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) {
                array_unshift($ips, $ip);
                $ip = FALSE;
            }
            for ($i = 0; $i < count($ips); $i++) {
                if (!preg_match('~^(10|172|192.168).~', $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return $ip ? $ip : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
    }
    /**
     * 对特殊字符串或者数组进行转义,防止xss,sql注入
     *@param 转义的字符串或者数组
     */
    public static function convert($input) {
        return is_array($input) ? array_map(null, $input) : str_replace(array('<','>','"',"'",';'),array('&lt','&gt;','&quot;','&#39;',','),$input);
    }
    /*
     * 对字符串或者数组用单引号括起来,方便数据库插入操作
     * 
     * @param bool $convert true/false 是否转义
     */
    public static function quote($input,$convert=true) {
        if ($convert == true) {
            $input = util::convert($input);
        }
        if (is_array($input)) {
            foreach($input as $k=>$v) {
                $input[$k]= util::quote($v,$convert);
            }
        } else {
            $input = "'$input'";
        }
        return $input;
    }
    /*
	* 设置网页过期时间
	*/
	public static function expire ($modTime,$maxAge=120){
	    $sinceTime = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']); //上次修改时间
	    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $modTime) . ' GMT');
	    header('Expires: ' . gmdate('D, d M Y H:i:s', ($_SERVER['REQUEST_TIME']+$maxAge)). ' GMT');
	    header('Cache-Control:  max-age='.$maxAge);
	    header('ETag: '.$modTime);
	    header('Date: ' . gmdate('D, d M Y H:i:s', $_SERVER['REQUEST_TIME']). ' GMT');
	    if(!$modTime){
		header('HTTP/1.1 404 Not Found');
		exit;
	    }
	    //没有修改直接返回304
	    if ($modTime==$sinceTime) {
		    header('HTTP/1.1 304 Not Modified');
		    exit;
	    }
	}
	//输出控制台调试信息
	public static function debug(){
		printf('<script type="text/javascript">console.log(%s)</script>',
			 func_num_args()>1?json_encode(func_get_args(),256):json_encode(func_get_arg(0),256)
			);
	}
}
