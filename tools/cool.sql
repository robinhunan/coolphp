--
-- 表的结构 `manager`
--

CREATE TABLE IF NOT EXISTS `manager` (
  `id` smallint(6) NOT NULL auto_increment,
  `userName` varchar(64) NOT NULL COMMENT '用户名',
  `userPass` varchar(64) NOT NULL COMMENT '密码',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- 导出表中的数据 `manager`
--

INSERT INTO `manager` (`id`, `userName`, `userPass`) VALUES
(1, 'admin', 'admin');
-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` smallint(6) NOT NULL auto_increment,
  `loginName` varchar(20) NOT NULL COMMENT '用户名',
  `loginPass` varchar(32) NOT NULL COMMENT '密码',
  `nickName` varchar(20) NOT NULL COMMENT '昵称',
  `sex` enum('男','女','保密') NOT NULL default '保密' COMMENT '性别',
  `birthday` int(11) NOT NULL COMMENT '生日',
  `province` varchar(10) NOT NULL COMMENT '省份',
  `city` varchar(64) NOT NULL COMMENT '城市',
  `mobile` bigint(20) unsigned NOT NULL COMMENT '城市',
  `email` varchar(255) NOT NULL COMMENT '注册邮箱',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `loginName` (`loginName`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
