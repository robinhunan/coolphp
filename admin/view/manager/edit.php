<?php include APP_PATH.'view/head.inc.php'?>

<div class="admin-con-right">
  <form>
    <div class="navi">
      <div class="l"><a href="#" class="h add"><span class="fa fa-edit"></span>&nbsp;修改</a> <a href="?c=manager" class="fa fa-arrow-left">返回管理页面</a> </div>
      <div class="C"></div>
    </div>
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb tpa"  >
      <tr class="nav">
        <td height="26"  colspan="2">基本信息</td>
      </tr>
      
	<tr class='tr h30'>
		<td class='ltit'>用户名</td><td><input name='userName' value='<?=$row["userName"]?>' type='text'></td>
	</tr>
	<tr class='tr h30'>
		<td class='ltit'>密码</td><td><input name='userPass' value='' type='password'></td>
	</tr>
      <tr class="nav h30">
        <td  colspan="2" align="center">
		<button type="submit" class="button fa fa-save">保存</button>
		<button type="button" class="button fa fa-arrow-left" onclick="history.go(-1)">返回</button>
		</td>
      </tr>
    </table>
  </form>
</div>
<script>
$('form').submit(function(){
	ajaxData("?c=manager&a=update&id=<?=$row['id']?>",$(this).serialize(),function (data){
		 if(data.code>0){
			layer.msg('更新成功',{icon:1,time:1500},function(){location.href = document.referrer;});
		 } else {
			layer.alert(data.msg);
		 }
	})
	return false;
})
</script>
<?php include APP_PATH.'view/foot.inc.php'?>