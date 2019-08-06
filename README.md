简单可扩展mvc框架



    使用教程 ： 
          把代码检出到网站目录
	  导入tools的cool.sql  示例到数据库
                 通过浏览器访问： /tools/index.php 选择对应的表生成对应的程序代码
       
	  代码生成后，通过网站目录 /admin/?c=***&a=index 访问***替换成对应的表名(控制文件)，如果业务复杂，业务名称通过"_"分隔，既数据库表名单词使用_分开 。


    目录说明：（推荐网站根目录配置到对应的项目根目录）
	    / 总项目入口
		www/  前端页面模块 
		admin/  后台管理模块	
		include/ 所有项目公用代码库（也可以说是公用model层,数据操作层）
		data/  临时目录，缓存目录，log目录
		tools/ 工具目录，此目录不用上线，或者放在web界面无法访问的地方，仅供开发使用 
		tools/cronttab/ 定时计划目录
		static／ 静态资源目录，｛css，image，js｝上线后，通过静态服务器指向
     
  访问界面http://localhost/admin/ 默认用户名/密码 admin/admin






-----------------------------------------------------------------------

     启用路由模式(对前端或者2c项目需要)
       （1）需要配置nginx或者apache，将请求文件映射到index.php
       nginx 配置如下：
       
        if (!-f $request_filename){
                 rewrite ^/([a-z0-9\-_]+)/([a-z0-9\-_]+)/(.*)$ /index.php?c=$1&a=$2&path=$3 last;
        }
	(2）在控制层文件，增加路由解析代码，下面的例子将变量解析到$_GET 数组中,参数c:/a:/id:[0-9]+ 中：前的表示key，：后的表示对应的值，如果：后有正则表达式，按照正则表达提取数据
	       route::getInstance()->setPath('/app1_user/home/2.htm/','c:/a:/id:[0-9]+')->fillGet();
	

