{include file="admin/head.inc.php"}
<div class="companyInfo-con-right">
  <div class="navi">
    <div class="l"><a href="?c=manager" class="admin h">列表管理</a> <a href="?c=manager&a=add">添加</a> </div>
    <div class="C"></div>
  </div>
  <div class="trh2 tb">   
  <form>  
  &nbsp;搜&nbsp;索&nbsp;:
  <input type="text" value="{$key}" name="key" />
 <select name="field">
 <option value="userName">用户名</option>
<option value="userPass">密码</option>

 </select>
 <input class="bt" type="submit" value="&nbsp;搜&nbsp;索&nbsp;" />
 <input type="hidden" name="c" value="manager" />  
  </form>
  </div>

  <form action="?c=manager" method="post">
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb"  >
      <tr class="nav h30">
        <td width='10%' align="left" class="tdl ">ID </td>
       <td>用户名</td>
<td>密码</td>

        <td width="10%">操作</td>
      </tr>
      <?php foreach((array)$rows AS $k=>$v){?> 
      <tr class="tr h30" >
        <td>
          {$v[id]}
         </td>
        <td>{$v['userName']}</td>
<td>{$v['userPass']}</td>

        <td><a href='?c=manager&a=edit&id={$v[id]}'>修改</a>&nbsp;|&nbsp;<a href='javascript:ask("?c=manager&a=delete&ids[]={$v[id]}")'>删除</a></td>
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