<?php
/**
* http 操作类
* @author: yubingzhu
*/
class http
{
	
	protected $_config = array('timeout'=>10);
	protected $_cookies = '';
	protected $_heads = array();
	
	private function __construct() {
		
	}
	
	static public function getInstance(){
		static $instance;
		if (!isset($instance)){
			$instance = new static();
		}
		return $instance;
	}
	
	/**
	* 设置cookies
	*
	* @param Array $cookie $cookie['uin']=4093845;
	* @return $this
	*/
	public function setCookie($cookie)   {
		if (!is_array($cookie)) {
			$this->_cookies .=$cookie;
		} else {
			foreach($cookie as $k=>$v) {
				$this->_cookies .= "$k=$v;";
			}
		}
		return $this;
	}
	
	/**
	* 设置请求头
	*
	* @param Array $headMap, $head['Host'] = 'www.example.com'
	* @return $this
	*/
	public function setHeader($headMap)    {
		if (!is_array($headMap)) {
			return $this;
		}
		$this->_heads = array_merge($this->_heads, $headMap);
		return $this;
	}
	
	/**
	* 设置基本配置
	* 只接受如下配置
	* timeout:超时时间
	* $this->setConfig(['proxy'=>'tcp://127.0.0.1:8888']); 设置代理
	* @param array $config
	* @return $this
	*/
	public function setConfig($config)    {
		$this->_config = array_merge($this->_config, $config);
		return $this;
	}
	

	
	/**
	* 获取执行状况信息
	*/
	public function getInfo($opt=null)    {
		return $opt==null ? curl_getinfo($this->ch) : curl_getinfo($this->ch,$opt);
	}
	
	/**
	* 获取http返回码
	*/
	public function getCode() {
		return $this->getInfo(CURLINFO_HTTP_CODE);
	}
	
	/**
	* 获取错误信息
	*/
	public function getError()    {
		return curl_error($this->ch);
	}
	
	/**
	* 请求 支持get和post两种方式
	*
	* @param string $url http://www.soso.com
	* @param  string $postdata post数据 设置该参数则使用post方法,否则使用get方法
	* @return data on succ, false on fail
	*/
	public function request($url, $postdata = '',$useHeader=FALSE)    {
		if ('' === $url) {
			return false;
		}
		
		$this->ch = curl_init();
		if (false === $this->ch) {
			return false;
		}
		
		curl_setopt($this->ch, CURLOPT_URL, $url);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
		foreach($this->_config as $k=>$v) {
			switch ($k) {
				case 'proxy':
				curl_setopt($this->ch, CURLOPT_PROXY, $v);
				break;
				case 'timeout':
				curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $v);
				curl_setopt($this->ch, CURLOPT_TIMEOUT, $v);
				break;
				default:
				is_long($k) && curl_setopt($this->ch,$k,$v);
				break;
			}
		}
		if ($this->_heads) {
			$header = array();
			foreach($this->_heads as $k=>$v){
				$header[] = "$k: $v";
			}
			curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);
		}
		
		if ($this->_cookies) {
			curl_setopt($this->ch, CURLOPT_COOKIE, $this->_cookies);
		}
		
		if ($postdata) {
			curl_setopt($this->ch, CURLOPT_POST, 1);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $postdata);
		} else {
			curl_setopt($this->ch, CURLOPT_HTTPGET, 1);
		}
		//返回http 头信息
		if($useHeader!==FALSE){
			curl_setopt($this->ch,CURLOPT_HEADER,1);
		}
		if(strncasecmp($url,'https',5)==0){
		    curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		    curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		}
		$response = curl_exec($this->ch);
		
		return $response;
	}
	
	public function __destruct(){
		if ($this->ch !=null) {
			curl_close($this->ch);
		}
	}
}
/*
$config['timeout'] = 1;
//$header['Host'] = 'www.soso.com';
$header['User-Agent']='Mozilla/5.0 (Windows NT 5.1; rv:19.0) Gecko/20100101 Firefox/19.0';
$cookie['uin'] = 40930845;
$cookie['skey'] = '@xdf803380';


echo $html = http::getInstance()->setConfig($config)->setCookie($cookie)->setHeader($header)
->request('http://www.soso.com/q?w=test');

$url ='http://weixin.sogou.com/weixin?type=2&ie=utf8&query=%E7%9F%A5%E8%AF%86%E4%BA%A7%E6%9D%83&tsn=1&ft=&et=&interation=&wxid=&usip=';
$header['User-Agent']='Mozilla/5.0 (Windows NT 5.1; rv:19.0) Gecko/20100101 Firefox/19.0';
$header['Referer']='http://weixin.sogou.com/weixin?type=2&ie=utf8&query=%E7%9B%B4%E9%94%80';
$html =  http::getInstance()->setHeader($header)->request($url);
echo $html;

*/



