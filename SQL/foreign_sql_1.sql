create table ft_sysconfig(
`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `webname` varchar(100) NOT NULL DEFAULT '',
  `keywords` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL DEFAULT '',
  `tels` varchar(120) NOT NULL DEFAULT '',
  `faxes` varchar(120)  NOT NULL DEFAULT '',
  `icp` varchar(60) NOT NULL DEFAULT '',
  `address` varchar(150) NOT NULL DEFAULT '',
  `copyright` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) engine=myisam charset=utf8;

DROP TABLE IF EXISTS ft_socialtools;
create table ft_socialtools(
`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
`toolname` varchar(20) NOT NULL DEFAULT '',
`iconrealpath` varchar(150) NOT NULL DEFAULT '',
`icon` varchar(150) NOT NULL DEFAULT '',
`account` varchar(30) NOT NULL DEFAULT '',
`isopened` TINYINT UNSIGNED  NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE(`toolname`)
) ENGINE=MyISAM charset utf8;

INSERT INTO ft_socialtools VALUES
(null, 'twitter', '','fa-twitter', '',0),
(null, 'youtube', '','fa-youtube', '',0),
(null, 'facebook', '','fa-facebook', '',0),
(null, 'skype', '','fa-skype', '',0),
(null, 'instagram', '','fa-instagram', '',0),
(null, 'whatsapp', '','fa-whatsapp', '',0),
(null, 'vine', '','fa-vine', '',0),
(null, 'linkedin', '','fa-linkedin', '',0),
(null, 'googleplus', '','fa-google-plus', '',0),
(null, 'wechat', '','fa-wechat', '',0),
(null, 'tumblr', '','fa-tumblr', '',0),
(null, 'flickr', '','fa-flickr', '',0);

DROP TABLE IF EXISTS ft_onesignalpage;
create table ft_onesignalpage(
`id` smallint unsigned NOT NULL AUTO_INCREMENT,
`title` varchar(40) NOT NULL DEFAULT '',
`keywords` varchar(100) NOT NULL DEFAULT '',
`description` varchar(200) NOT NULL DEFAULT '',
`isshow` tinyint unsigned NOT NULL DEFAULT 1,
`sortorder` TINYINT UNSIGNED  NOT NULL DEFAULT 5,
`content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM charset utf8;


DROP TABLE IF EXISTS ft_about;
create table ft_about(
`id` smallint unsigned NOT NULL AUTO_INCREMENT,
`title` varchar(40) NOT NULL DEFAULT '',
`keywords` varchar(100) NOT NULL DEFAULT '',
`description` varchar(200) NOT NULL DEFAULT '',
`isshow` tinyint unsigned NOT NULL DEFAULT 1,
`content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM charset utf8;

DROP TABLE IF EXISTS ft_companyintro;
create table ft_companyintro(
`id` smallint unsigned NOT NULL AUTO_INCREMENT,
`title` varchar(40) NOT NULL DEFAULT '',
`keywords` varchar(100) NOT NULL DEFAULT '',
`description` varchar(200) NOT NULL DEFAULT '',
`isshow` tinyint unsigned NOT NULL DEFAULT 1,
`content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM charset utf8;

DROP TABLE IF EXISTS ft_news;
CREATE TABLE IF NOT EXISTS `ft_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL DEFAULT '',
  `keywords` varchar(100) NOT NULL DEFAULT '',
  `coverrealpath` varchar(150) NOT NULL DEFAULT '',
  `cover` varchar(150) NOT NULL DEFAULT '',
  `description` varchar(200) NOT NULL DEFAULT '',
  `author` varchar(12) NOT NULL DEFAULT '',
  `click` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `sortorder` int(11) NOT NULL DEFAULT '10',
  `content` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ft_focus`;
CREATE TABLE `ft_focus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL DEFAULT '',
  `focusname` varchar(12) NOT NULL DEFAULT '',
  `cover` varchar(150) NOT NULL DEFAULT '',
  `coverrealpath` varchar(150) NOT NULL DEFAULT '',
  `linkurl` varchar(150) NOT NULL DEFAULT '',
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `sortorder` int(10) NOT NULL DEFAULT '5',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ft_message`;
CREATE TABLE `ft_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(20) NOT NULL DEFAULT '',
  `email` char(60) NOT NULL DEFAULT '',
  `message` varchar(255) NOT NULL DEFAULT '',
  `msgtype` tinyint unsigned NOT NULL DEFAULT 0,
  `addtime` int(10) unsigned NOT NULL DEFAULT 0,
  `ishandled` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ft_message VALUES
(null,'questions');

DROP TABLE IF EXISTS `ft_goodsalbum`;
CREATE TABLE IF NOT EXISTS `ft_goodsalbum` (
`id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '商品相册自增id',
`goodsid` int unsigned NOT NULL DEFAULT '0' COMMENT '图片属于商品的id',
`imgpath` varchar(150) NOT NULL COMMENT '实际图片url',
`imgrealpath` varchar(150) NOT NULL COMMENT '实际图片真实地址',
`iscover` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
`updatetime` int unsigned not null default 0,
PRIMARY KEY (`id`),
KEY `goods_id` (`goodsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ft_goods`;
CREATE TABLE IF NOT EXISTS `ft_goods` (
`id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '商品的自增id',
`catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品所属商品分类id，取值ecs_category的cat_id',
`goodsname` varchar(40) NOT NULL COMMENT '商品的名称',
`click` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品点击数',
`price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场售价',
`keywords` varchar(100) NOT NULL COMMENT '商品关键字，放在商品页的关键字中，为搜索引擎收录用',
`description` varchar(200) NOT NULL COMMENT '商品的简短描述',
`goodsdetail` text NOT NULL COMMENT '商品的详细描述',
`goodsimg` varchar(150) NOT NULL DEFAULT '' comment '商品封面图',
`isnew` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '该产品是否为新品，0为否 1 是',
`isshow` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示商品 0 不显示 1 显示 默认1',
`isrecommend` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '该产品是否被推荐 1 是 0 否',
`addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品的添加时间',
`sortorder` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '应该是商品的显示顺序，不过该版程序中没实现该功能',
PRIMARY KEY (`id`),
KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ft_category`;
CREATE TABLE IF NOT EXISTS `ft_category` (
`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID号',
`catename` varchar(60) NOT NULL COMMENT '分类名称',
`keywords` varchar(100) NOT NULL COMMENT '分类的关键字，可能是为了搜索',
`description` varchar(200) NOT NULL COMMENT '分类描述',
`parentid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '该分类的父id，取值于该表的cat_id字段',
`sortorder` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '该分类在页面显示的顺序，数字越大顺序越靠后；同数字，id在前的先显示',
`showinnav` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示在导航栏，0，不；1，显示在导航栏',
`isshow` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否在前台页面显示，1，显示；0，不显示',
PRIMARY KEY (`id`),
KEY `parentid` (`parentid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;


DROP TABLE IF EXISTS `ft_attribute`;
CREATE TABLE IF NOT EXISTS `ft_attribute` (
`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID号',
`cateid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品类型，同ecs_goods_type的cat_id',
`attrname` varchar(20) NOT NULL COMMENT '属性名称',
`attrinputtype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '当添加商品时，该属性的添加类别；0，为手工输入；1，为单选框；2，复选框  3为多行文本输入',
`attrvalues` text NOT NULL COMMENT '该字段的值',
`sortorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '属性显示的顺序，数字越大越靠前，如果数字一样则按id顺序',
PRIMARY KEY (`id`),
KEY `cateid` (`cateid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `ft_goodsattr` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID号',
`goodsid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '该具体属性属于的商品，取值于ecs_goods的goods_id',
`attrid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '该具体属性属于的属性类型的id，取自ecs_attribute 的attr_id',
`attrvalue` text NOT NULL COMMENT '该具体属性的值',
PRIMARY KEY (`id`),
KEY `goodsid` (`goodsid`),
KEY `attrid` (`attrid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;