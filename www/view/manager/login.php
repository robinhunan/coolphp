<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<title>&#31995;&#32479;登&#24405;</title>
<link rel="stylesheet" type="text/css" href="../static/css/base.css" />
<link rel="stylesheet" type="text/css" href="../static/css/admin.css" />
<link rel="stylesheet" type="text/css" href="//libs.baidu.com/fontawesome/4.4.0/css/font-awesome.min.css" />
<script src="//libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>
<script src="../static/js/common.js"></script>
<style>
	.tb td {  height:40px;}
</style>
</head>
<body>
<form action="" method="post" style="margin-top:200px;">
  <table width="400" border="0"  cellpadding="0" cellspacing="1" class="tb" style="margin:0 auto;">
    <tr class="nav">
      <td colspan="2" align="center"><h3>&#31995;&#32479;登&#24405;</h3></td>
    </tr>

    <tr class="tr2">
      <td  align="right" width="70"><b>用户名：</b></td>
      <td ><input name="userName" placeholder="请输入用户名" type="text"  maxlength="20"></td>

    </tr>
       <tr class="tr">
      <td  align="right"><b>密&nbsp;&nbsp;&#30721;：</b></td>
      <td><input name="userPass" type="password" placeholder="请输入登录密码"  size="25" maxlength="20"></td>
    </tr>

    <tr class="tr2">
      <td  colspan="2" align="center" > <button class="button fa fa-key" type="submit">确定</button> </td>
    </tr>

  </table>
 </form>
<script>
	$('form').submit(function() {

		ajaxData("?c=manager&a=login2", $('form').serialize(),
		function(data) {
			if (data.code > 0) {
				layer.msg('登录成功！',{time:1000,icon:1},function() {
					location.href = '../admin/';
				})
			} else {
				layer.alert(data.msg);
			}
		});
		return false;
	})
</script>
</body>
</html>