<HTML>
<head>
<meta charset="utf-8">
<title>修改页</title>
<link rel="stylesheet" type="text/css" href="../images/admin/main.css" />
<script type="text/javascript" src="../js/common.js"></script>
</head>
<body>
<div>
  <form action="?mod=manager&act=update&id={$row['id']}"  method="post">
    <div class="navi">
      <div class="l"><a href="#" class="h add">修改</a> <a href="?mod=manager">返回管理页面</a> </div>
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
</body>
</html>