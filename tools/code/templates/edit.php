<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="utf-8">
<title>修改页</title>
<link rel="stylesheet" type="text/css" href="static/common/main.css" />
<script type="text/javascript" src="static/common/common.js"></script>
</head>
<body>
<div>
  <form action="?c=__table__&a=update&id={$row['id']}"  method="post">
    <div class="navi">
      <div class="l"><a href="#" class="h add">修改</a> <a href="?c=__table__">返回管理页面</a> </div>
      <div class="C"></div>
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
</body>
</html>