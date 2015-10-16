{include file="admin/head.inc.php"}
<div class="companyInfo-con-right">
  <div class="navi">
    <div class="l"><a href="?c=__table__" class="admin h">列表管理</a> <a href="?c=__table__&a=add">添加</a> </div>
    <div class="C"></div>
  </div>
  <div class="trh2 tb">   
  <form>  
  &nbsp;搜&nbsp;索&nbsp;:
  <input type="text" value="{$key}" name="key" />
 <select name="field">
 __option__
 </select>
 <input class="bt" type="submit" value="&nbsp;搜&nbsp;索&nbsp;" />
 <input type="hidden" name="c" value="__table__" />  
  </form>
  </div>

  <form action="?c=__table__" method="post">
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb"  >
      <tr class="nav h30">
        <td width='10%' align="left" class="tdl ">ID </td>
       __field_name__
        <td width="10%">操作</td>
      </tr>
      <?php foreach((array)$rows AS $k=>$v){?> 
      <tr class="tr h30" >
        <td>
          {$v[id]}
         </td>
        __fields__
        <td><a href='?c=__table__&a=edit&id={$v[id]}'>修改</a>&nbsp;|&nbsp;<a href='javascript:ask("?c=__table__&a=delete&ids[]={$v[id]}")'>删除</a></td>
      </tr>
      <?php }?>
    </table>
     <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb h30">
           <tr class="nav tc">
            <td  align="right">
                {$nav}&nbsp;
            </td>
          </tr>
     </table>
  </form>
</div>
{include file="admin/foot.inc.php"}