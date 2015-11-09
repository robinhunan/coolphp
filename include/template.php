<?php
/**
*  PHP Template functions
* @author yubing
*/
class template{
    public static function inc($tplFile) {
        $tplDir   =  SYS_PATH . 'templates/';
        $parsedDir    = SYS_PATH . 'data/tpl/';
        $parsedFile  = $parsedDir .$tplFile .'.php';
	//echo $tplDir. $tplFile;
        if (@filemtime($parsedFile) < filemtime($tplDir. $tplFile)) {
            if (!($str=file_get_contents($tplDir . $tplFile))) {
                exit("read tpl $tplFile error");
            }
            $str = self::_parseTag($str);            
            is_dir(dirname($parsedFile)) || mkdir(dirname($parsedFile), 0755, true);
            file_put_contents($parsedFile,$str);
        }
        return $parsedFile;
        
    }
    /**
     * @desc parse_tag template file
     */
    private static function _parseTag($str){
        $str = preg_replace('/\{\s*include file=["\']?([a-zA-Z0-9\/\\_.]+)[\'"]?\s*\}/i', "<?php include template::inc('\\1');?>", $str);
        
        $str = preg_replace(array('/<!--\s*if\s*(\[|\()(.+?)(\]|\))\s*{\s*-->/is',
        '/<!--\s*elseif(\[|\()(.+?)(\]|\))\s*{\s*-->/is',
        '/<!--\s*else\s*{\s*-->/is',
        '/<!--\s*}\s*-->/',
		'/<!--\s*foreach\s*\((.*)\s*(as)\s*(.+)\s*\)\s*{\s*-->/i',
        '/\{\$([a-zA-Z0-9_\'\"\[\]$]+)\}/',
        '/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/',
        '/\{echo (.*)\}/',
        '/<\?=\s*/',
        ),
        array('<?php if(\\2){?>',
        '<?php }elseif(\\2){?>',
        '<?php }else{?>',
        '<?php }?>',
        '<?php foreach((array)\\1 AS \\3){?>',
        '<?php echo $\\1;?>',
        '<?php echo \\1;?>',
        '<?php echo \\1;?>',
        '<?php echo ',
        ),
        $str);
        
        return $str;
    }
}
