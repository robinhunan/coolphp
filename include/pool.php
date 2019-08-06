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
	    static $_cache;
	    if (!isset($_cache)){
		    $_cache = new Memcached();
		    $_cache->addServers(config::$memcacheServers);

	    }
	    return $_cache;
	}

	/**
	* 数据库链接池
	*/
	public static function db($name='web', $checkConnection=false)
	{
		static $_db;
		if (is_null($_db[$name])) {
			$_db[$name] = new cooldb($name);
		} elseif ($checkConnection) {
			$serverInfo = $_db[$name]->getAttribute(PDO::ATTR_SERVER_INFO);
			if (strpos(strval($serverInfo), 'Uptime') === false) {
				$_db[$name] = new cooldb($name);
			}
		}
		return $_db[$name];
	}

}
