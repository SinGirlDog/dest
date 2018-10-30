DROP TABLE IF EXISTS `dede_plus_mymsg`;
CREATE TABLE `dede_plus_mymsg` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM DEFAULT CHARSET=utf8;
/*需要支持mysql4.0语法，所以使用TYPE=MyISAM*/
