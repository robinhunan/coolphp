<?php
/**
* @author: zhuyubing
* 在浏览器中访问 tools/index.php?dsn=web&table=
 能生成对应的数据库操作代码，省得手工写
*/


define('APP_PATH',__DIR__.'/');
include('../include/config.php');

//判断身份信息
$manager= new manager();
$info = $manager->getLoginInfo();
if(!$info[2]){
	exit('<h3>请先登录!</h3><script>setTimeout(()=>{location.href="../www/?c=manager"},3000)</script>');
}

$dsnName = $_GET['dsn']?:'web';
$table =$_GET['table']?:'manager'; //默认表名
$db = pool::db($dsnName);

if('generate'==$_GET['act']){
    /** 生成校验函数内字符串 */
    foreach ( $db->query('show full COLUMNS from '.$table) as $row) {
	$type = strpos($row['Type'],'(')!==false ? substr($row['Type'],0,strpos($row['Type'],'(') ) : $row['Type'];
	$emptyV= $row['Default']!=null
	    ? "'".$row['Default'] ."'": (in_array($type,array('tinyint','smallint','mediumint','int','bigint','decimal','float','double','enum')) ? 'null':"''");
	$checkData .=sprintf("\r\n\t\tcase '%s':\r\n\t\t\t\$arr[\$k]=empty(\$v)?%s:\$v;\r\n\t\tbreak;",$row['Field'], $emptyV );
    }
    // 生成基本类
    $fields = implode(',' , array_keys($_POST['field']) );
    $ds_table = str_replace('_','/',$table);
    $mod=SYS_PATH.'include/'.$ds_table.'.php';
    $str = file_get_contents(SYS_PATH.'tools/code/include.php');

    $str = str_replace(array('__dsnName__','__table__','__ds_table__','__fields__','__checkData__'),array($dsnName,$table,$ds_table,$fields,$checkData),$str,$checkData);
    file::save($mod,$str);

    //生成表通用类
    $mod=SYS_PATH.'admin/controller/'.$ds_table.'.php';
    $str = file_get_contents(SYS_PATH.'tools/code/controller.php');
    $str = str_replace(array('__table__','__ds_table__'),array($table,$ds_table),$str);
    file::save($mod,$str);


    //根据模板生产增删改查代码
	$option = '';
    foreach($_POST['search'] as $key=>$val){
        $name = $_POST['field'][$key];
        $option.=sprintf('<option value="%s">%s</option>'."\n",$key,$name);
    }
    foreach( array('index','add','edit') as $v){
        $field_name=$fields=$tr='';
        $str = file_get_contents(SYS_PATH.'tools/code/templates/'.$v.'.php');
        $mod =SYS_PATH.'admin/view/'.$ds_table.'/'.$v.'.php';
        if('index'==$v){ //搜索和列表页
            foreach ($_POST[$v] as $k2=>$v2){
                $field_name.=sprintf("<td>%s</td>\n",$_POST['field'][$k2]);
                $fields.=sprintf("\n\t\t<td>\n\t\t\t%s\n\t\t</td>",'<?=$v["'.$k2.'"]?>');
            }
            $str = str_replace(
                     array('__table__','__ds_table__','__option__','__field_name__','__fields__'),
                     array($table,$ds_table,$option,$field_name,$fields),$str);
        }else if ('add'==$v){ //添加页
            $tr = $tr=='tr' ? 'tr2' : 'tr';
            foreach ($_POST[$v] as $key=>$val){
             $fields .=sprintf("\n\t<tr class='%s h30'>\n\t\t<td  class='ltit'>%s</td>\t\n<td><input name='%s' type='text'>\t\n</td>\n\t</tr>",$tr,$_POST["field"][$key],$key);
            }
            $str = str_replace(
                     array('__table__','__ds_table__','__fields__'),
                     array($table,$ds_table,$fields),$str);
        }
        else if ('edit'==$v){ //编辑页
            $tr = $tr=='tr' ? 'tr2' : 'tr';
            foreach ($_POST[$v] as $key=>$val){
                $fields .= sprintf("\n\t<tr class='%s h30'>\n\t\t<td class='ltit'>%s</td><td><input name='%s' value='%s' type='text'></td>\n\t</tr>",$tr,$_POST["field"][$key],$key,'<?=$row["'.$key.'"]?>');
            }
            $str = str_replace(
                     array('__table__','__ds_table__','__fields__'),
                     array($table,$ds_table, $fields),$str);
        }
        file::save($mod,$str);
    }
    msg::json(1);
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
include APP_PATH.'view/index.php';

