{include file="admin/head.inc.php"}
<div class="companyInfo-con-right">
  <form action="?c=__table__&a=insert" id="form" method="post">
    <div class="navi">
      <div class="l"><a href="#" class="h add"><span class="iconfont">&#xe604;</span>&nbsp;添加</a> <a href="?c=__table__">返回管理页面</a> </div>
    </div>
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb tpa"  >
      <tr class="nav">
        <td height="26"  colspan="2">基本信息</td>
      </tr>
      __fields__   
      <tr class="nav h30">
        <td  colspan="2" align="center"><input type="submit" class="bt" value=" 保 存 "></td>
      </tr>
    </table>
  </form>
</div>
{include file="admin/foot.inc.php"}