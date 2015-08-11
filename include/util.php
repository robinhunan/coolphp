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
        return is_array($input) ? array_map(null, $input) : !get_magic_quotes_gpc() ? str_replace(array("%3C",'<',"%3E",'>','"',"'"),array('&lt','&lt;','&gt;','&gt;','&quot;','&#39;'),$input) : str_replace(array("%3C",'<',"%3E",'>','"',"'"), array('&lt','&lt;','&gt;','&gt;','&quot;','&#39;'),@stripslashes($input));
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
}
