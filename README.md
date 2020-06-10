简单可扩展mvc框架



    使用教程 ： 
         1. 把代码检出到网站目录
	 2. 创建coolphp数据库,导入tools下的cool.sql到数据库
	 3. 修改include/config.php下的数据库配置文件
	    	static  $web = array (
		'dsn'=>'mysql:host=127.0.0.1;port=3306;dbname=coolphp', //pdo格式数据库连接信息
		'user'=>'root', //数据库用户名
        	'pass'=>'',  //数据库密码
         4. 通过浏览器访问： http://localhost/coolphp/tools/index.php 选择对应的表生成程序代码
       
	 代码生成后，通过网站目录 /admin/?c=***&a=index 访问***替换成对应的数据库表名(控制文件)
	 如果业务复杂，业务名称通过"_"分隔，既数据库表名单词使用_分开。
         访问界面http://localhost/coolphp/admin/ 
            默认用户名/密码 admin/admin



      目录说明：（推荐网站根目录配置到对应的项目根目录）
	    / 总项目入口
		www/  前端页面模块 
		admin/  后台管理模块	
		include/ 所有项目公用代码库（也可以说是公用model层,数据操作层）
		data/  临时目录，缓存目录，log目录
		tools/ 工具目录，此目录不用上线，或者放在web界面无法访问的地方，仅供开发使用 
		tools/cronttab/ 定时计划目录
		static／ 静态资源目录，｛css，image，js｝上线后，通过静态服务器指向
	        vendor/ 目录用来存放,composer代码


