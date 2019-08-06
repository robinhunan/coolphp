<?php
/*
* 字符串操作类
* @author zhuyubing
*/

class cstring {

    /**
     *
     * 截取中文字符串
     * @param string $src
     * @param int $len
     * @return string $return string
     */
    public static function cut($string, $length = 80, $etc = null, $charset='UTF-8'){
        $str_length = strlen($string);
        //字符串的字节数
        if ($str_length < $length) {
            return $string;
        }
        if (function_exists('mb_strimwidth')) {
            return mb_strimwidth($string, 0, $length * 2, $etc, $charset);
        }
    }
	//only for utf-8
	public static function len($string,$char='utf-8') {
		if (function_exists('mb_strlen')){
			return mb_strlen($string,$char);
		}
		// 将字符串分解为单元
		preg_match_all("/./us", $string, $match);
		// 返回单元个数
		return count($match[0]);
	}
    /*
    * 截取两个字符串中间的字符串
    * $str 原始字符串
    * $a 开始字符串
    * $b 结束字符串
    */
    public static function cutByStr($str,$a,$b=null){
		$pos = strpos($str,$a);
		if($pos===false){
			return '';
		}
		$str=substr($str, $pos+strlen($a)) ;
		if(is_string($b)){
			$pos2=strpos($str,$b);
			return $pos2!==false ? substr($str,0,$pos2) : $str;
		}
		return $str;
    }
    /*
    * 配对截取,需要先用substr截取到$a开始的str作为参数
    * $str 原始字符串
    * $a 开始字符串<div 不用闭合
    * $b 结束字符串</div>
    */
    public static function cutByPair($str,$a,$b){
		if(($i=strpos($str,$a))===false){
			return $str;
		}
		$str=substr($str,strpos($str,'>',$i)+1);//找到第一个标签结束的地方
		$start=1;
		for($i=0;$i<strlen($str);$i++){
			if(substr($str,$i,strlen($a))==$a){
				$start++;
			}
			if(substr($str,$i,strlen($b))==$b){
				$start--;
			}
			if($start<=0){
				break;
			}
		}
		return substr($str,0,$i);
    }
    /**
     * 根据传入的key解密字符串
     *
     */
    static function  decrypt($string, $key) {
        $result = '';
        $string = base64_decode($string);

        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result .= $char;
        }
        return $result;
    }
    /**
     * 根据传入的key加密字符串
     * @return string
     */
    static function encrypt($string, $key) {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }
        return base64_encode($result);
    }

    /**
    * 汉字转换成html 实体,将字符转换后,在各种浏览器中显示,而不会变成乱码
    */
    public static function html($str, $charset='UTF-8') {
	$output = '';
        $str = iconv($charset, 'UTF-16', $str);
        for ($i = 0; $i < strlen($str); $i++,$i++) {
        $code = ord($str{$i}) * 256 + ord($str{$i + 1});
            if ($code < 128) {
                $output .= chr($code);
            } else if ($code != 65279) {
                $output .= "&#".$code.";";
            }
        }
        return $output;
    }
    /**
	*  将html实体代码，转换成utf-8编码
	*/
    public static function decodeHtml($str){
	    return json_decode(preg_replace_callback('/&#(\d{5});/', create_function('$dec', 'return \'\\u\'.dechex($dec[1]);'), '"'.$str.'"'));
	}
	//字符串安全处理
	public static function safe($string){
	    return is_array($string) ? array_map(array(__CLASS__,'safe'), $string) : str_replace(array( '&', '"', "'", '<', '>', ';'), '', $string);
	}
	/**
	* 过滤不安全字符
	*/
	public static function filter($string){
		return preg_replace('/[^a-z0-9\.\_\-]/i','',$string);
	}
	//将字符串转换为时间戳
	public static function toTime($str){
	    $s=preg_replace('#[^0-9\s:\-]#','',str_replace(['年','月','日'],['-','-',' '],$str));
	    return strtotime($s);
	}
}
//echo $a= cstring::cutByStr("aa<p><p><p>1</p></p><p>23</p>45</p>#####<p>$$$$</p>",'<p>','</p>');
//echo $a;
//echo cstring::html('设置向导');
