{include file="admin/head.inc.php"}
<div class="companyInfo-con-right">
  <div class="navi">
    <div class="l"><a href="?c=app1_user" class="admin h"><span class="iconfont">&#xe60c;</span>&nbsp;列表管理</a> <a href="?c=app1_user&a=add">添加</a> </div>
    <div class="C"></div>
  </div>
  <div class="trh2 tb">   
  <form>  
  &nbsp;搜&nbsp;索&nbsp;:
  <input type="text" value="{$key}" name="key" />
 <select name="field">
 <option value="loginName">用户名</option>
<option value="loginPass">密码</option>
<option value="nickName">昵称</option>
<option value="sex">性别</option>
<option value="birthday">生日</option>
<option value="province">省份</option>
<option value="city">城市</option>
<option value="mobile">城市</option>
<option value="email">注册邮箱</option>

 </select>
 <input class="bt" type="submit" value="&nbsp;搜&nbsp;索&nbsp;" />
 <input type="hidden" name="c" value="app1_user" />  
  </form>
  </div>

  <form action="?c=app1_user" method="post">
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb"  >
      <tr class="nav h30">
        <td width='10%' align="left" class="tdl ">ID </td>
       <td>用户名</td>
<td>密码</td>
<td>昵称</td>
<td>性别</td>
<td>生日</td>
<td>省份</td>
<td>城市</td>
<td>城市</td>
<td>注册邮箱</td>

        <td width="10%">操作</td>
      </tr>
      <?php foreach((array)$rows AS $k=>$v){?> 
      <tr class="tr h30" >
        <td>
          {$v[id]}
         </td>
        <td>{$v['loginName']}</td>
<td>{$v['loginPass']}</td>
<td>{$v['nickName']}</td>
<td>{$v['sex']}</td>
<td>{$v['birthday']}</td>
<td>{$v['province']}</td>
<td>{$v['city']}</td>
<td>{$v['mobile']}</td>
<td>{$v['email']}</td>

        <td><a href='?c=app1_user&a=edit&id={$v[id]}'>修改</a>&nbsp;|&nbsp;<a href='javascript:ask("?c=app1_user&a=delete&ids[]={$v[id]}")'>删除</a></td>
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