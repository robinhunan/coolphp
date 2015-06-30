<HTML>
<head>
<meta charset="UTF-8">
<title>列表页</title>
<link rel="stylesheet" type="text/css" href="../images/admin/main.css" />
<script type="text/javascript" src="../js/common.js"></script>
</head>
<body>
<div>
  <div class="navi">
    <div class="l"><a href="?mod=manager" class="admin h">列表管理</a> <a href="?mod=manager&act=add">添加</a> </div>
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
 <input type="hidden" name="mod" value="manager" />  
  </form>
  </div>

  <form act="?mod=manager" method="post">
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb tpa"  >
      <tr class="nav h30">
        <td width='10%' align="left" class="tdl ">ID </td>
       <td>用户名</td>
<td>密码</td>

        <td width="10%">操作</td>
      </tr>
      <?php foreach((array)$rows AS $k=>$v){?>  
      <?php $tr = $k%2 ? 'tr' : 'tr2';?>
      <tr class="{$tr} h30" >
        <td>
         <input type="checkbox"  name="ids[]" value="{$v['id']}" onclick="setStatus('ids[]','idsAll')"><?php echo $v['id'];?>
         </td>
        <td>{$v['userName']}</td>
<td>{$v['userPass']}</td>

        <td><a href='?mod=manager&act=edit&id={$v['id']}'>修改</a>&nbsp;|&nbsp;<a href='javascript:ask("?mod=manager&act=delete&ids[]={$v['id']}")'>删除</a></td>
      </tr>
      <?php }?>
    </table>
     <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb h30">
           <tr class="nav tc">
            <td><input type="checkbox"  id="idsAll" onchange="checkAll(this,'ids[]');">
              全选 
              批量操作:
              <select name="act"  id="type" >
                <option value="delete">删除</option>
              </select>
              <input type="submit" class="bt" id="submit" onClick="javascript:if(document.getElementById('type').value=='delete') return confirm('确定要删除？？');" value="确定"></td>
            <td  align="right">
                {$nav}&nbsp;
            </td>
          </tr>
     </table>
  </form>
</div>
</body>
</html>