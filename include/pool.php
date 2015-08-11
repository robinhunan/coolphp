<?php
/**
 * 资源连接池
 * @author yubing
 */
class pool
{
        /**
	 * memcache 链接池
	 * */
	public static function cache(){
	    static $cache;
	    if (!isset($cache)){
		    $cache = new Memcached();
		    $cache->addServers(config::$memcacheServers);
		    
	    }
	    return $cache;
	}
    
	/**
	* 数据库链接池
	*/
	public static function db($config='db', $hash=0, $checkConnection=false)
	{
		static $db;
		$conf = config::$$config;
		$index = abs($hash) % count($conf['dsn']);
		//重新初始化数据库连接
		if (!isset($db[$config]) || !is_a($db[$config][$index], 'PDO')) {
			$db[$config][$index] = new cooldb($config,$hash);
		} elseif ($checkConnection) {
			$serverInfo = $db[$config][$index]->getAttribute(PDO::ATTR_SERVER_INFO);
			if (strpos(strval($serverInfo), 'Uptime') === false) {
				$db[$config][$index] = new cooldb($config,$hash);
			}
		}
		return $db[$config][$index];
	}
    
}
