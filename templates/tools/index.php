<HTML>
<head>
<meta charset="UTF-8">
<title>代码生成</title>
<link rel="stylesheet" type="text/css" href="../static/common/main.css" />
<script type="text/javascript" src="../static/common/common.js"></script>
</head>
<script type="text/javascript">
function changeTable(table){
    location.href="?table="+table;
}
</script>
<body>

<div>
  <div class="navi">
    <div class="l"><a href="?table={$table}" class="admin h">代码生成</a> </div>
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
 <!-- onsubmit="return confirm('你确定要重新生成代码吗?')" -->
  <form action="?table={$table}&act=generate" method="post">
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb tpa"  >
      <tr class="nav h30">
        <td width='20%' align="left" >字段名 </td>
        <td width="24%">中文字段名</td>       
        <td>添加</td>
        <td>修改</td>
        <td>搜索</td>
        <td>列表</td>
      </tr>
      <?php foreach((array)$rows AS $k=>$v){
          $tr = $k%2 ? 'tr' : 'tr2';
          $checked = $k!=0 ? 'checked="checked"' : ''; 
      ?>
      <tr class="{$tr} h30" >
        <td >{$v['Field']}</td>
        <td>
         <input type="text" name="field[{$v['Field']}]" value="<?php echo $v['Comment']?$v['Comment']:$v['Field']?>" />
         </td>         
        <td ><input type="checkbox" {$checked} name="add[{$v['Field']}]" /></td>  
        <td ><input type="checkbox" {$checked} name="edit[{$v['Field']}]" /></td> 
        <td ><input type="checkbox" {$checked} name="search[{$v['Field']}]" /></td> 
        <td ><input type="checkbox" {$checked} name="index[{$v['Field']}]" /></td>   
      </tr>
      <?php }?>  
       <tr> <td colspan=6 align="center"> <input  type="submit" class="bt" id="submit" value=" 确 定 "  /></td></tr>
    </table>
  </form>
</div>
</body>
</html>
