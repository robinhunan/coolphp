<?php include APP_PATH.'view/head.inc.php'?>
<div class="admin-con-right">
  <div class="navi">
    <div class="l"><a href="?c=manager" class="admin h"><span class="fa fa-list"></span>&nbsp;列表管理</a> <a href="?c=manager&a=add" class="fa fa-plus">添加</a> </div>
    <div class="C"></div>
  </div>
  <div class="trh2 tb">
    <form>
    <input type="hidden" name="c" value="manager" />
  &nbsp;搜&nbsp;索&nbsp;:
 <select name="field">
 <option value="userName">用户名</option>

 </select>
 <input type="text" value="<?=$key?>" name="key" />
 <button class="button fa fa-search" type="submit">搜索</button>
  </form>
  </div>

  <form action="?c=manager" method="post">
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb"  >
      <tr class="nav h30">
        <td width='60' align="left" class="tdl ">ID </td>
       <td>用户名</td>

        <td width="80">操作</td>
      </tr>
      <?php foreach((array)$rows AS $k=>$v){?>
      <tr class="tr h30" >
        <td>
          <?=$v['id']?>
         </td>
        
		<td>
			<?=$v["userName"]?>
		</td>
        <td>
          <a href='?c=manager&a=edit&id=<?=$v['id']?>' class="fa fa-edit">修改</a>
          <a href='javascript:;' data-id='<?=$v['id']?>' class="fa fa-remove red">删除</a>
        </td>
      </tr>
      <?php }?>
    </table>
     <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb">
           <tr class="nav tc">
            <td  align="right">
                <?=$nav?>&nbsp;
            </td>
          </tr>
     </table>
  </form>
</div>
<script>
   $('form').find('.fa-remove').click(function(){
			var id = $(this).data('id');
			if(confirm('你确认要删除这条记录?!')){
				$.getJSON('?c=manager&a=delete&id='+id,function(){
					layer.msg('删除成功！',{icon:1,time:1500},function(){window.location.reload(true)});
				})
			}
	});
</script>
<?php include APP_PATH.'view/foot.inc.php'?>