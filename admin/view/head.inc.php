<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title><?=$title?></title>
<link rel="stylesheet" type="text/css" href="../static/css/admin.css" />
<link rel="stylesheet" type="text/css" href="//cdn.bootcdn.net/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="../static/css/base.css" />
<script type="text/javascript"  src="../static/js/jquery.min.js"></script>
<script type="text/javascript"  src="../static/?js/common.js;js/admin.js;js/validate.js;js/jquery-ui-datepicker.js"></script>
<link rel="shortcut icon" href="/favicon.ico" />
</head>
<body>
<!--nav-->

<div class="admin-info-nav">
    <div class="info-nav">
        <ul class="info-nav-list">

            <li ><a href="/" target="_blank" >首页</a></li>
            <li><a href="/">后台</a></li>
        </ul>
        <ul class="login-info R">
                 <li class="hello">
                <span class="fa fa-user">欢迎您</span><span><?php global $loginInfo; echo $loginInfo[2];?>，&nbsp;</span>
                <span ><a class="col fa fa-sign-out" href="?c=manager&a=logout">安全退出</a></span></li>

        </ul>
    </div>
</div>
<div class="C"></div>
<!--end top-->

	<!--信息-->
	<ul class="admin-list">
		<li>当前位置：<a href="/" class="fa fa-home">&nbsp;主页</a>&nbsp;>&nbsp;后台</li>
	</ul>


	<!--内容-->
	<div class="admin-con">

<!--公共左-->
    <div class="admin-left">
	<ul class="admin-con-left">
        <li class="left-main"><span class="fa fa-list-alt"></span>&nbsp;导航</li>
             <li class="list-type">
                 <a href="javascript:;" class="list-type-b"><span class="fa fa-angle-double-down"></span>用户管理</a>
				 <ol class="secondary-list" >
				    <li><a href="?c=app1_user">用户管理</a></li>

				 </ol>
	     </li>



	    <li class="list-type">
                    <a href="javascript:;" class="list-type-b"><span class="fa fa-angle-double-down"></span>系统管理</a>
		    <ol class="secondary-list" >
			   <li><a href="?c=manager">管理员</a></li>
			    <li><a href="../tools/" target="tools">代码生成</a></li>
		    </ol>
	    </li>
	</ul>

    </div>

<!--公共左  end-->
