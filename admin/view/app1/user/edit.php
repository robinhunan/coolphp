<?php include APP_PATH.'view/head.inc.php'?>

<div class="admin-con-right">
  <form>
    <div class="navi">
      <div class="l"><a href="#" class="h add"><span class="fa fa-edit"></span>&nbsp;修改</a> <a href="?c=app1_user" class="fa fa-arrow-left">返回管理页面</a> </div>
      <div class="C"></div>
    </div>
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb tpa"  >
      <tr class="nav">
        <td height="26"  colspan="2">基本信息</td>
      </tr>
      
	<tr class='tr h30'>
		<td class='ltit'>用户名</td><td><input name='loginName' value='<?=$row["loginName"]?>' type='text'></td>
	</tr>
	<tr class='tr h30'>
		<td class='ltit'>密码</td><td><input name='loginPass' value='<?=$row["loginPass"]?>' type='text'></td>
	</tr>
	<tr class='tr h30'>
		<td class='ltit'>昵称</td><td><input name='nickName' value='<?=$row["nickName"]?>' type='text'></td>
	</tr>
	<tr class='tr h30'>
		<td class='ltit'>性别</td><td><input name='sex' value='<?=$row["sex"]?>' type='text'></td>
	</tr>
	<tr class='tr h30'>
		<td class='ltit'>生日</td><td><input name='birthday' value='<?=$row["birthday"]?>' type='text'></td>
	</tr>
	<tr class='tr h30'>
		<td class='ltit'>省份</td><td><input name='province' value='<?=$row["province"]?>' type='text'></td>
	</tr>
	<tr class='tr h30'>
		<td class='ltit'>城市</td><td><input name='city' value='<?=$row["city"]?>' type='text'></td>
	</tr>
	<tr class='tr h30'>
		<td class='ltit'>城市</td><td><input name='mobile' value='<?=$row["mobile"]?>' type='text'></td>
	</tr>
	<tr class='tr h30'>
		<td class='ltit'>注册邮箱</td><td><input name='email' value='<?=$row["email"]?>' type='text'></td>
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
	ajaxData("?c=app1_user&a=update&id=<?=$row['id']?>",$(this).serialize(),function (data){
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