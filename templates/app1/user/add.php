<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="utf-8">
<title>增加页</title>
<link rel="stylesheet" type="text/css" href="static/common/main.css" />
<script type="text/javascript" src="static/common/common.js"></script>
</head>
<body> 
  <form action="?c=app1_user&a=insert" id="form" method="post">
    <div class="navi">
      <div class="l"><a href="#" class="h add">添加</a> <a href="?c=app1_user">返回管理页面</a> </div>
      <div class="C"></div>
    </div>
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb tpa"  >
      <tr class="nav">
        <td height="26"  colspan="2">基本信息</td>
      </tr>
      <tr class='tr h30'>
<td  class='ltit'>用户名</td>
<td><input name='name' type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>手机号</td>
<td><input name='mobile' type='text'></td>
</tr>
   
      <tr class="nav h30">
        <td  colspan="2" align="center"><input type="submit" class="bt" value=" 保 存 "></td>
      </tr>
    </table>
  </form>
</body>
</html>