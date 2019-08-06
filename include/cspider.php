<?php
/**
* 爬虫类
*/
class cspider{
	// Xml 转 数组, 包括根键，忽略空元素和属性
	public static function toArray( $xml ){
		$reg = "/<(\\w+)[^>]*?>([\\x00-\\xFF]*?)<\\/\\1>/";
		if(preg_match_all($reg, $xml, $matches)){
			$count = count($matches[0]);
			$arr = array();
			for($i = 0; $i < $count; $i++){
				$key= $matches[1][$i];
				$val = cspider::toArray( $matches[2][$i] );  // 递归
				if(array_key_exists($key, $arr)){
					if(is_array($arr[$key])){
						if(!array_key_exists(0,$arr[$key])){
							$arr[$key] = array($arr[$key]);
						}
					}else{
						$arr[$key] = array($arr[$key]);
					}
					$arr[$key][] = $val;
				}else{
					$arr[$key] = $val;
				}
			}
			return $arr;
		}else{
			return $xml;
		}
	}
	/**
     * Get the absolute path of a uri
     * */
	public static function  absolutePath($relativeUri, $currentUri, $baseUri=''){
		 if (filter_var($relativeUri, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED)) {
            // URL is already absolute
            return $relativeUri;
        }

        //return the current uri if the relativeUri is an anchor
        if (strpos($relativeUri, '#') === 0) {
            return $currentUri;
        }

        //Bug #34
        if (strpos($relativeUri, 'tel:') === 0) {
            return $relativeUri;
        }

        //Return the current uri if the relativeURI is empty.
        if ($relativeUri == '') {
            return $currentUri;
        }

        $relativeUri_parts = parse_url($relativeUri);

        if (false === $relativeUri_parts) {
            return $relativeUri;
        }

        if (isset($relativeUri_parts['scheme']) && !in_array($relativeUri_parts['scheme'], array('http', 'https'))) {
            return $relativeUri;
        }
		if($baseUri==''){
			$baseUri = substr($currentUri,0,strrpos($currentUri,'/')+1);
		}
        $new_base_url = $baseUri;
        $base_url_parts = parse_url($baseUri);

        if (substr($relativeUri, 0, 2) == '//' && isset($base_url_parts['host'])) {
            //Handle protocol agnostic urls
            $protocol = 'http';
            if (isset($base_url_parts['scheme'])) {
                //make the protocol the same as the baseUri
                $protocol = $base_url_parts['scheme'];
            }
            return $protocol . ':' . $relativeUri;
        }

        if (substr($baseUri, -1) != '/') {
            $path = pathinfo($base_url_parts['path']);
            $new_base_url = substr($new_base_url, 0, strlen($new_base_url)-strlen($path['basename']));
        }

        if (substr($relativeUri, 0, 1) == '/') {
            $new_base_url = $base_url_parts['scheme'].'://'.$base_url_parts['host'];
        }

        $absoluteUri = $new_base_url.$relativeUri;

        //Take off the query string and only apply the following code to the rest of the uri.
        $query = '';
        if (isset($relativeUri_parts['query'])) {
            $query = '?' . $relativeUri_parts['query'];
            $absoluteUri = substr($absoluteUri, 0, strlen($absoluteUri) - strlen($query));
        }

        //convert /./file to /file
        $absoluteUri = str_replace('/./', '/', $absoluteUri);

        // Convert /dir1/../dir2/ into /dir2/
        while (preg_match('/\/[^\/\.]+\/\.\.\//', $absoluteUri)) {
            $absoluteUri = preg_replace('/\/[^\/\.]+\/\.\.\//', '/', $absoluteUri);
        }

        //Re-attach the query and return the full url.
        return $absoluteUri . $query;
	}
		//将字符串中的路径转换为url格式,$curUrl为当前网址
	public static function fixSrc($str,$curUrl){
		$base = substr($curUrl,0,strrpos($curUrl,'/')).'/';
		$host = substr($curUrl,0,strpos($curUrl,'/',8)).'/';
		$schema = substr($curUrl,0,strpos($curUrl,'/'));
		return str_ireplace(["src='//",'src="//',"src='./","src=\"./","src='/",'src="/'],
			     ["src='$schema//","src=\"$schema//","src='$base","src=\"$base","src='$host","src=\"$host"],$str);
	}
	//将字符串中的路径转换为url格式,$curUrl为当前网址
	public static function fixHref($str,$curUrl){
		$base = substr($curUrl,0,strrpos($curUrl,'/')).'/';
		$host = substr($curUrl,0,strpos($curUrl,'/',8)).'/';
		$schema = substr($curUrl,0,strpos($curUrl,'/'));
		return str_ireplace(["href='//",'href="//',"href='./","href=\"./","href='/",'href="/'],
			     ["href='$schema//","href=\"$schema//","href='$base","href=\"$base","href='$host","href=\"$host"],$str);
	}
	/**
	 * 将图片转换成全路径
	 * @curUri 当前网页的uri
	 * @start 图片来源地址data-src或者src
	 **/
	public static function fixImg($html,$curUri,$start='src'){
		$pos = stripos($html,'<img');
		if($pos===false){
				return $html;
		}
		$a=$b=[];
		$str = $html;
		while($pos){
				$str = substr($str,$pos);
				list($s,$str)=explode('>',$str,2);
				$p = "#$start=['\"]([^'\"\s>]+)['\"]#i";
				preg_match($p,$s,$m);
				$url = $m[1];
				$url = cspider::absolutePath($url,$curUri);
				$a[]=$s;
				$b[]="<img src=\"$url\"";
				$pos=stripos($str,'<img');
		}
		return str_replace($a,$b,$html);
	}
}
