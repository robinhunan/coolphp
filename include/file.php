<?php

/** 文件操作类
 * @author: yubing.zhu
 */

class file {
    /**
     * 
     * @desc 保存字符串到文件
     * @param  $filename  字符串
     * @param  $data 要写入的数据。类型可以是 string，array 或者是 stream 资源
     * @param  $flags 可以是 FILE_USE_INCLUDE_PATH，FILE_APPEND 和／或 LOCK_EX（获得一个独占锁定
     * @return boolean 
     */

    public static function save($filename, $data, $flags = null) {
        is_dir(dirname($filename)) || mkdir(dirname($filename), 0755, true);
        return file_put_contents($filename, $data, $flags);
    }


    /**
     * 返回路径有数字+下划线+字母组合的文件名或者路径,防止非法路径
     * 
     * @param string $filename 
     * @return string
     */
    public static function safe($filename) {
        $arr = explode('/', str_replace(array('\\', '..'), array('/', ''), $filename));
        foreach ($arr as $k => $v) {
            if (!preg_match("/^[a-z0-9\._\-]+$/i", $v)) {
                unset($arr[$k]);
            }
        }
        return implode('/', $arr);
    }
    /**
     * 连根删除,很危险的操作!
     */
    public static function del($dir) {
        $files = glob($dir . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (in_array(substr($file, -1), array('/', '\\'))) {
                self::del($file);
            } else {
                unlink($file);
            }
        }

        if (is_dir($dir)) {
            rmdir($dir);
        }
    }
}
