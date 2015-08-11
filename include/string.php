<?php
/*
* 字符串操作类
* @author yubing
*/

class string {
          
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
	public static function len($string) {
		if (function_exists('mb_strlen')){
			return mb_strlen($string);
		}
		// 将字符串分解为单元
		preg_match_all("/./us", $string, $match);
		// 返回单元个数
		return count($match[0]);
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
	/**
	* 过滤不安全字符
	*/
	public static function filter($string){
		return preg_replace('/[^a-z0-9\/\.\_\-]/i','',str_replace('..','',$string));
	}
}
//echo string::html('设置向导');