<?php include APP_PATH.'view/head.inc.php'?>
<div class="admin-con-right">
  <form action="?c=__table__&a=insert" id="form" method="post">
    <div class="navi">
      <div class="l"><a href="#" class="h add"><span class="fa fa-plus"></span>&nbsp;添加</a> <a href="?c=__table__" class="fa fa-arrow-left">返回管理页面</a> </div>
    </div>
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb tpa"  >
      <tr class="nav">
        <td height="26"  colspan="2">基本信息</td>
      </tr>
      __fields__
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
	ajaxData("?c=__table__&a=insert",$(this).serialize(),function (data){
		 if(data.code>0){
			layer.msg('添加成功',{icon:1,time:1500},function(){window.location.href = document.referrer;});
		 } else {
			layer.alert(data.msg);
		 }
	})
	return false;
})
</script>
<?php include APP_PATH.'view/foot.inc.php'?>