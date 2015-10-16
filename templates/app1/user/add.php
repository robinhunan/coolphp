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
  <form action="?c=app1_user&a=insert" id="form" method="post">
    <div class="navi">
      <div class="l"><a href="#" class="h add">添加</a> <a href="?c=app1_user">返回管理页面</a> </div>
    </div>
    <table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb tpa"  >
      <tr class="nav">
        <td height="26"  colspan="2">基本信息</td>
      </tr>
      <tr class='tr h30'>
<td  class='ltit'>用户名</td>
<td><input name='loginName' type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>密码</td>
<td><input name='loginPass' type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>昵称</td>
<td><input name='nickName' type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>性别</td>
<td><input name='sex' type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>生日</td>
<td><input name='birthday' type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>省份</td>
<td><input name='province' type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>城市</td>
<td><input name='city' type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>城市</td>
<td><input name='mobile' type='text'></td>
</tr>
<tr class='tr h30'>
<td  class='ltit'>注册邮箱</td>
<td><input name='email' type='text'></td>
</tr>
   
      <tr class="nav h30">
        <td  colspan="2" align="center"><input type="submit" class="bt" value=" 保 存 "></td>
      </tr>
    </table>
  </form>
</div>
</body>
</html>