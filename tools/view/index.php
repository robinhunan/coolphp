<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>代码生成</title>
<link rel="stylesheet" type="text/css" href="../static/css/base.css" />
<link rel="stylesheet" type="text/css" href="../static/css/admin.css" />
<script src="../static/js/jquery.min.js"></script>
<script type="text/javascript" src="../static/js/common.js"></script>
<style>
   input{vertical-align:middle;margin: 0 5px;}
</style>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>
<script type="text/javascript">
function changeTable(table){
    location.href="?dsn=<?=$dsnName?>&table="+table;
}
</script>
<body>

<div style="max-width: 990px;margin: 0 auto;">
  <div class="navi">
    <div class="l"><a href="?dsn=<?=$dsnName?>&table=<?=$table?>" class="admin h">代码生成</a> </div>
    <div class="C"></div>
  </div>
  <div class="trh2">
    请选择表名:
     <select name="table" onchange="changeTable(this.value)" >
        <?php foreach ($tables as $v) {
            $sel = $v==$table ? ' selected' :'';
            echo  "<option value='$v' $sel>$v</option>\n";
        }
        ?>
     </select>
  </div>
  <form action="" method="post">
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb tpa"  >
      <tr class="nav h30">
        <td width='20%' align="left" >字段名 </td>
        <td width="24%">中文字段名</td>
        <td><input type="checkbox" name="checkAll" data-id="add" />添加</td>
        <td><input type="checkbox" name="checkAll" data-id="edit" />修改</td>
        <td><input type="checkbox" name="checkAll" data-id="search" />搜索</td>
        <td><input type="checkbox" name="checkAll" data-id="index" />列表</td>
      </tr>
      <?php foreach((array)$rows AS $k=>$v){
          $tr = $k%2 ? 'tr' : 'tr2';
          $checked = $k!=0 ? 'checked="checked"' : '';
      ?>
      <tr class="<?=$tr?> h30" >
        <td ><?=$v['Field']?></td>
        <td>
         <input type="text" name="field[<?=$v['Field']?>]" value="<?php echo $v['Comment']?$v['Comment']:$v['Field']?>" />
         </td>
        <td ><input type="checkbox" <?=$checked?> name="add[<?=$v['Field']?>]" /></td>
        <td ><input type="checkbox" <?=$checked?> name="edit[<?=$v['Field']?>]" /></td>
        <td ><input type="checkbox" <?=$checked?> name="search[<?=$v['Field']?>]" /></td>
        <td ><input type="checkbox" <?=$checked?> name="index[<?=$v['Field']?>]" /></td>
      </tr>
      <?php }?>
       <tr> <td colspan=6 align="center" class="h30"> <input  type="submit" class="bt" value=" 确 定 "  /></td></tr>
    </table>
  </form>
</div>
<script>
    $('input[name="checkAll"]').click(function(){
        var id=$(this).data('id');
        var checked = !!$(this).attr('checked');
        console.log(id,checked)
        $('input[name*='+id+']').attr('checked',checked);
    });
	$('form').submit(function(){
		ajaxData("?dsn=<?=$dsnName?>&table=<?=$table?>&act=generate",$(this).serialize(),function (data){
			 if(data.code>0){
				layer.msg('生成代码成功',{icon:1,time:1500});
			 } else {
				layer.alert(data.msg);
			 }
		})
	return false;
	})
</script>
</body>
</html>