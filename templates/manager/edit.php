{include file="admin/head.inc.php"}
        
<div class="companyInfo-con-right">
  <form action="?c=manager&a=update&id={$row['id']}"  method="post">
    <div class="navi">
      <div class="l"><a href="#" class="h add"><span class="iconfont">&#xe604;</span>&nbsp;修改</a> <a href="?c=manager">返回管理页面</a> </div>
      <div class="C"></div>
    </div>
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb tpa"  >
      <tr class="nav">
        <td height="26"  colspan="2">基本信息</td>
      </tr>
      <tr class='tr h30'>
<td  class='ltit'>用户名</td>
<td><input name='userName' value="{$row['userName']}" type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>密码</td>
<td><input name='userPass' value="{$row['userPass']}" type='text'></td>
</tr>
 
      <tr class="nav h30">
        <td  colspan="2" align="center"><input type="submit" class="bt" value=" 保 存 "></td>
      </tr>
    </table>
  </form>
</div>
{include file="admin/foot.inc.php"}