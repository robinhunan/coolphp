{include file="admin/head.inc.php"}
        
<div class="companyInfo-con-right">
  <form action="?c=app1_user&a=update&id={$row['id']}"  method="post">
    <div class="navi">
      <div class="l"><a href="#" class="h add"><span class="iconfont">&#xe604;</span>&nbsp;修改</a> <a href="?c=app1_user">返回管理页面</a> </div>
      <div class="C"></div>
    </div>
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb tpa"  >
      <tr class="nav">
        <td height="26"  colspan="2">基本信息</td>
      </tr>
      <tr class='tr h30'>
<td  class='ltit'>用户名</td>
<td><input name='loginName' value="{$row['loginName']}" type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>密码</td>
<td><input name='loginPass' value="{$row['loginPass']}" type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>昵称</td>
<td><input name='nickName' value="{$row['nickName']}" type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>性别</td>
<td><input name='sex' value="{$row['sex']}" type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>生日</td>
<td><input name='birthday' value="{$row['birthday']}" type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>省份</td>
<td><input name='province' value="{$row['province']}" type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>城市</td>
<td><input name='city' value="{$row['city']}" type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>城市</td>
<td><input name='mobile' value="{$row['mobile']}" type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>注册邮箱</td>
<td><input name='email' value="{$row['email']}" type='text'></td>
</tr>
 
      <tr class="nav h30">
        <td  colspan="2" align="center"><input type="submit" class="bt" value=" 保 存 "></td>
      </tr>
    </table>
  </form>
</div>
{include file="admin/foot.inc.php"}