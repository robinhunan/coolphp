<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="UTF-8">
<title>列表页</title>
<link rel="stylesheet" type="text/css" href="static/css/base.css" />
<link rel="stylesheet" type="text/css" href="static/css/admin.css" />
<script type="text/javascript" src="static/js/common.js"></script>
</head>
<body>

<!--top-->
<div class="company-info-top">
    <div class="companyInfoLogo"><img src="http://mat1.gtimg.com/www/images/qq2012/qqlogo.png" /></div>
    <ul class="company-list">
        <li class="files"><a href="#">消息中心</a><span>12</span></li>
        <li class="files notice"><a href="#">公告</a><span>0</span></li>
		
    </ul>
</div>
<!-- top end -->
<div class="clear"></div>
<!--nav-->
<div class="company-info-nav">
    <div class="info-nav">
        <ul class="info-nav-list">
        	
            <li><a href="#" target="_self" >成交助手</a></li>
            <li><a href="#" target="_self">网商助手</a></li>
        </ul>
        <ul class="login-info">
                            <li class="hello">
                <span class="welcome">测试商家</span><span>&nbsp;</span>
                <span class="hello2"><a class="col" href="#">[退出]</a></span></li>
                
            <li class="fr">
                <a href="#">会员中心</a>
            </li>

        </ul>
    </div>
</div>
<div class="clear"></div>
<!--end top-->
	<!--信息-->
	<ul class="companyInfo-list">
		<li><a href="index.html" class="activee">咨询助手</a>></li>
		<li>欢迎页</li>
	</ul>
        
  
	<!--内容-->
	<div class="companyInfo-con">

<!--公共左-->
		<div class="companyInfo-left">
	<ul class="companyInfo-con-left">
        <li class="topMargin"><a href="javascript:void(0)">咨询助手</a></li>
        		<li class="list-type">
             <a href="javascript:;" target="_self" class="list-type-b">咨询管理</a>
             <img alt="" src="admin/images/two/sj.png" />
             			<ol class="secondary-list" >
							<li><a href="#" target="_self">微信助手</a></li>
							<li><a href="#" target="_self">微商助手</a></li>
							<li><a href="#" target="_self">咨询助手</a></li>
	            		 </ol>
	         		</li>
				<li class="list-type">
             <a href="javascript:;" target="_self" class="list-type-b">在线咨询统计</a>
             <img alt="" src="admin/images/two/sj.png">
             			<ol class="secondary-list" >
             		            <li ><a href="#">经销商统计</a></li>
	            			</ol>
	         		</li>
		    </ul>
    
    <div class="hot-line">
        <p>统一服务热线</p>
		<p class="phone-fore" style="font-size: 24px;line-height: 45px;">400-888-8888</p>
		<p>服务时间:9:00至18:00</p>
    </div>

    </div>
    
<!--公共左  end-->      
        
<div class="companyInfo-con-right">
  <div class="navi">
    <div class="l"><a href="?c=app1_user" class="admin h">列表管理</a> <a href="?c=app1_user&a=add">添加</a> </div>
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
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb tpa"  >
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
      <?php $tr = $k%2 ? 'tr' : 'tr2';?>
      <tr class="{$tr} h30" >
        <td>
          <?php echo $v['id'];?>
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

        <td><a href='?c=app1_user&a=edit&id={$v['id']}'>修改</a>&nbsp;|&nbsp;<a href='javascript:ask("?c=app1_user&a=delete&ids[]={$v['id']}")'>删除</a></td>
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
</body>
</html>