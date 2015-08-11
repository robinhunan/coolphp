<?php
/**
* @author: yubing
* 在浏览器中访问 http://localhost/tools/index.php
 能生成对应的数据库操作代码，省得手工写
*/
include_once('../include/config.php');

$dsnName = get($_GET,'dsn','db');
$table = get($_GET,'table');
$db = pool::db($dsnName);

if('generate'==get($_GET,'act')){
    // 生成基本类
    $fields = implode(',' , util::quote(array_keys($_POST['field'])) );
    $ds_table = str_replace('_','/',$table);
    $mod=SYS_PATH.'include/'.$ds_table.'.php';
    $str = file_get_contents(SYS_PATH.'tools/code/include.php');
    $str = str_replace(array('__table__','__ds_table__','__fields__'),array($table,$ds_table,$fields),$str);
    file::save($mod,$str);
    
    //生成表管理类
    $mod=SYS_PATH.'controller/'.$ds_table.'.php';
    $str = file_get_contents(SYS_PATH.'tools/code/modules.php');
    $str = str_replace(array('__table__','__ds_table__'),array($table,$ds_table),$str);
    file::save($mod,$str);
    
    
    //模板处理  
	$option = '';
    foreach($_POST['search'] as $key=>$val){
        $name = $_POST['field'][$key];
        $option.=sprintf('<option value="%s">%s</option>'."\n",$key,$name);
    }
    foreach( array('index','add','edit') as $v){ 
        $field_name=$fields=$tr='';
        $str = file_get_contents(SYS_PATH.'tools/code/templates/'.$v.'.php');
        $mod =SYS_PATH.'templates/'.$ds_table.'/'.$v.'.php';
        if('index'==$v){ //搜索和列表页
            foreach ($_POST[$v] as $k2=>$v2){
                $field_name.=sprintf("<td>%s</td>\n",$_POST['field'][$k2]);
                $fields.=sprintf('<td>{$v[\'%s\']}</td>'."\n",$k2);
            }
            $str = str_replace(
                     array('__table__','__ds_table__','__option__','__field_name__','__fields__'),
                     array($table,$ds_table,$option,$field_name,$fields),$str);
        }else if ('add'==$v){ //添加页
            $tr = $tr=='tr' ? 'tr2' : 'tr';
            foreach ($_POST[$v] as $key=>$val){ 
             $fields .= "<tr class='$tr h30'>\n<td  class='ltit'>{$_POST['field'][$key]}</td>\n<td><input name='{$key}' type='text'></td>\n</tr>\n";
            }
            $str = str_replace(
                     array('__table__','__ds_table__','__fields__'),
                     array($table,$ds_table,$fields),$str);
        }
        else if ('edit'==$v){ //编辑页
            $tr = $tr=='tr' ? 'tr2' : 'tr';
            foreach ($_POST[$v] as $key=>$val){ 
                $fields .= "<tr class='$tr h30'>\n<td  class='ltit'>{$_POST['field'][$key]}</td>\n<td><input name='{$key}' value=\"{\$row['{$key}']}\" type='text'></td>\n</tr>\n";
            }
            $str = str_replace(
                     array('__table__','__ds_table__','__fields__'),
                     array($table,$ds_table, $fields),$str);
        }
        file::save($mod,$str);
    }
}

/** 显示所有的数据表 **/
foreach ( $db->query('show tables') as $row) {
    $tables[] = $row[0];
}
$table = in_array($table,$tables) ? $table : $tables[0];
     
/** 显示一个表中的所有字段 */
foreach ( $db->query('show full COLUMNS from '.$table) as $row) {
    $rows[] = $row;
}
include template::inc('tools/index.php');