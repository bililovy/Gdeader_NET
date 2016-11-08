-- MySQL dump 10.13  Distrib 5.5.24, for Win32 (x86)
--
-- Host: localhost    Database: foreigntrade
-- ------------------------------------------------------
-- Server version	5.5.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ft_about`
--

DROP TABLE IF EXISTS `ft_about`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_about` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL DEFAULT '',
  `keywords` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(200) NOT NULL DEFAULT '',
  `isshow` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_about`
--

LOCK TABLES `ft_about` WRITE;
/*!40000 ALTER TABLE `ft_about` DISABLE KEYS */;
/*!40000 ALTER TABLE `ft_about` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ft_adminuser`
--

DROP TABLE IF EXISTS `ft_adminuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_adminuser` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `truename` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `lastlogintime` int(10) unsigned NOT NULL DEFAULT '0',
  `logintimes` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `canbedelete` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_adminuser`
--

LOCK TABLES `ft_adminuser` WRITE;
/*!40000 ALTER TABLE `ft_adminuser` DISABLE KEYS */;
INSERT INTO `ft_adminuser` VALUES (1,'bililovy','思阳','bililovy@163.com','1d6b0268d4733d4dc22dc8bcb29d67c4',1447930859,5,1439719314,0);
/*!40000 ALTER TABLE `ft_adminuser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ft_attribute`
--

DROP TABLE IF EXISTS `ft_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_attribute` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID号',
  `cateid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品类型，同ecs_goods_type的cat_id',
  `attrname` varchar(20) NOT NULL COMMENT '属性名称',
  `attrinputtype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '当添加商品时，该属性的添加类别；0，为手工输入；1，为单选框；2，复选框  3为多行文本输入',
  `attrvalues` text NOT NULL COMMENT '该字段的值',
  `sortorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '属性显示的顺序，数字越大越靠前，如果数字一样则按id顺序',
  PRIMARY KEY (`id`),
  KEY `cateid` (`cateid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_attribute`
--

LOCK TABLES `ft_attribute` WRITE;
/*!40000 ALTER TABLE `ft_attribute` DISABLE KEYS */;
INSERT INTO `ft_attribute` VALUES (3,2,'color',2,'red|black|orange|pink',10),(2,1,'cailiao',1,'niupi|buliao|shuijing',5),(4,2,'used',1,'chuan|dai|chi|he',10),(5,2,'season',3,'spring|summer|autumn|winter',1),(6,2,'usage',4,'',10);
/*!40000 ALTER TABLE `ft_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ft_category`
--

DROP TABLE IF EXISTS `ft_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_category` (
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_category`
--

LOCK TABLES `ft_category` WRITE;
/*!40000 ALTER TABLE `ft_category` DISABLE KEYS */;
INSERT INTO `ft_category` VALUES (1,'TOP_ONE','this is , keywords ','flsjf descirpfsdlfj fsdlkajfsdlf oldsajf sdlkjf ',0,2,0,1),(2,'TOP_TWO','fdsfljsd.fjdlsj,fsdljfsdl .','fsldjflsdfj sdflsdfjsdoijf sdfjlsdkfj ldsjflsd fsldfjsda fjsdlkjfds fsdjfls fsd',0,1,0,1),(3,'TOP_THREE','fsldfj ','flsdjf sdlfjds lfsdlfj ds',0,10,1,1),(4,'LEVEL_TWO_1','dslfjsdlf q','lfdslfjdslfjsd f',1,10,1,1),(5,'LEVEL_TWO_2','fsdfjsdlfj','flsdjflsdjfldskfj',1,10,1,1),(6,'LEVEL_TWO_3','fsdkfljsdlfj','fjsldjflsjflsfjslf',1,10,0,0),(7,'LEVEL_TTTTT_1','fsdlfjsdlfj','qlffsdfsdfsdfdsfsf',4,10,1,1),(8,'LEVEL_+TTT_2','fslfjsdfj','lfjsdlfjlsdfjsldkfdsf',2,10,1,1),(9,'LEVEL_fsdfjsdlf_e','1fsadflsdjf','qfsdljfldjsflsdjfdsfsfsaf',3,10,1,1),(10,'3333333333','fsdafsdafdsfsfl','jflsdjfasfsdaf',7,10,1,1),(11,'33333333333','fdsafsdafsdf','fwfdsdfsdafsdaf',8,10,1,1),(12,'fsdfsdfdsf','','fsdafdsfs',8,10,1,1);
/*!40000 ALTER TABLE `ft_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ft_companyintro`
--

DROP TABLE IF EXISTS `ft_companyintro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_companyintro` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL DEFAULT '',
  `keywords` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(200) NOT NULL DEFAULT '',
  `isshow` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_companyintro`
--

LOCK TABLES `ft_companyintro` WRITE;
/*!40000 ALTER TABLE `ft_companyintro` DISABLE KEYS */;
INSERT INTO `ft_companyintro` VALUES (1,'company introduction','keywords, forkey,uskey,yeskey','description for the page ',1,'I know something for fsdlfjsdlfjdslfjsdlfjsldfjdslkf&lt;br /&gt;'),(2,'company introduction','keywords, forkey,uskey,yeskey','description for the page ',1,'I know something for fsdlfjsdlfjdslfjsdlfjsldfjdslkf&lt;br /&gt;');
/*!40000 ALTER TABLE `ft_companyintro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ft_focus`
--

DROP TABLE IF EXISTS `ft_focus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_focus`
--

LOCK TABLES `ft_focus` WRITE;
/*!40000 ALTER TABLE `ft_focus` DISABLE KEYS */;
INSERT INTO `ft_focus` VALUES (4,'focus title two for the website','useed for it','/assets/library/uploads/image/focus/564aa5f57e69a.jpg','./Application/../assets/library/uploads/image/focus/564aa5f57e69a.jpg','http://www.sina.com.cn',0,5),(3,'focus title for the website that used by','focus shortt','/assets/library/uploads/image/focus/564aa5326578a.jpg','./Application/../assets/library/uploads/image/focus/564aa5326578a.jpg','http://www.taobao.com',1,10),(5,'focus 5 for taht fdsk','flsdjffsdlfj','/assets/library/uploads/image/focus/564aa620d7272.jpg','./Application/../assets/library/uploads/image/focus/564aa620d7272.jpg','',1,1),(6,'fsdfdssfjslfdsklfjljasdfldsfkjl','fsdlfjsdlfjs','/assets/library/uploads/image/focus/564aa6a512063.jpg','./Application/../assets/library/uploads/image/focus/564aa6a512063.jpg','',0,10),(7,'erueiwrewoifsldfsklj','fdsfdsf','/assets/library/uploads/image/focus/564aa639e52cb.jpg','./Application/../assets/library/uploads/image/focus/564aa639e52cb.jpg','',1,10),(8,'vcvcxvcxvkljfksld','fskldfjcvxlc','/assets/library/uploads/image/focus/564aa64c250bd.png','./Application/../assets/library/uploads/image/focus/564aa64c250bd.png','',1,10);
/*!40000 ALTER TABLE `ft_focus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ft_goods`
--

DROP TABLE IF EXISTS `ft_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品的自增id',
  `cateid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品所属商品分类id，取值ecs_category的cat_id',
  `goodsname` varchar(50) NOT NULL COMMENT '商品的名称',
  `click` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品点击数',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场售价',
  `keywords` varchar(100) NOT NULL COMMENT '商品关键字，放在商品页的关键字中，为搜索引擎收录用',
  `description` varchar(200) NOT NULL COMMENT '商品的简短描述',
  `goodsdetail` text NOT NULL COMMENT '商品的详细描述',
  `goodsimg` varchar(150) NOT NULL DEFAULT '' COMMENT '商品封面图',
  `isnew` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '该产品是否为新品，0为否 1 是',
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示商品 0 不显示 1 显示 默认1',
  `isrecommend` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '该产品是否被推荐 1 是 0 否',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品的添加时间',
  `sortorder` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '应该是商品的显示顺序，不过该版程序中没实现该功能',
  PRIMARY KEY (`id`),
  KEY `cateid` (`cateid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_goods`
--

LOCK TABLES `ft_goods` WRITE;
/*!40000 ALTER TABLE `ft_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `ft_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ft_goodsalbum`
--

DROP TABLE IF EXISTS `ft_goodsalbum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_goodsalbum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品相册自增id',
  `goodsid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '图片属于商品的id',
  `imgpath` varchar(150) NOT NULL COMMENT '实际图片url',
  `imgrealpath` varchar(150) NOT NULL COMMENT '实际图片真实地址',
  `iscover` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goodsid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_goodsalbum`
--

LOCK TABLES `ft_goodsalbum` WRITE;
/*!40000 ALTER TABLE `ft_goodsalbum` DISABLE KEYS */;
INSERT INTO `ft_goodsalbum` VALUES (16,0,'/assets/library/uploads/image/goods/20151119/564d5bcbc6314.jpg','./Application/../assets/library/uploads/image/goods/20151119/564d5bcbc6314.jpg',0,0),(17,0,'/assets/library/uploads/image/goods/20151119/564d6a491c4f4.jpg','./Application/../assets/library/uploads/image/goods/20151119/564d6a491c4f4.jpg',0,0),(18,0,'/assets/library/uploads/image/goods/20151119/564d6a4ba4936.jpg','./Application/../assets/library/uploads/image/goods/20151119/564d6a4ba4936.jpg',0,0),(26,0,'/assets/library/uploads/image/goods/20151119/564d818b74db5.jpg','./Application/../assets/library/uploads/image/goods/20151119/564d818b74db5.jpg',0,0),(24,0,'/assets/library/uploads/image/goods/20151119/564d6fdb672ff.jpg','./Application/../assets/library/uploads/image/goods/20151119/564d6fdb672ff.jpg',0,0),(14,0,'/assets/library/uploads/image/goods/20151119/564d5bc289073.jpg','./Application/../assets/library/uploads/image/goods/20151119/564d5bc289073.jpg',0,0),(27,0,'/assets/library/uploads/image/goods/20151119/564d8706a8ad8.jpg','./Application/../assets/library/uploads/image/goods/20151119/564d8706a8ad8.jpg',0,0),(21,0,'/assets/library/uploads/image/goods/20151119/564d6a5da0ad3.jpg','./Application/../assets/library/uploads/image/goods/20151119/564d6a5da0ad3.jpg',0,0),(22,0,'/assets/library/uploads/image/goods/20151119/564d6a608fa0b.jpg','./Application/../assets/library/uploads/image/goods/20151119/564d6a608fa0b.jpg',0,0),(23,0,'/assets/library/uploads/image/goods/20151119/564d6a626c025.jpg','./Application/../assets/library/uploads/image/goods/20151119/564d6a626c025.jpg',0,0);
/*!40000 ALTER TABLE `ft_goodsalbum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ft_goodsattr`
--

DROP TABLE IF EXISTS `ft_goodsattr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_goodsattr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID号',
  `goodsid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '该具体属性属于的商品，取值于ecs_goods的goods_id',
  `attrid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '该具体属性属于的属性类型的id，取自ecs_attribute 的attr_id',
  `attrvalue` text NOT NULL COMMENT '该具体属性的值',
  PRIMARY KEY (`id`),
  KEY `goodsid` (`goodsid`),
  KEY `attrid` (`attrid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_goodsattr`
--

LOCK TABLES `ft_goodsattr` WRITE;
/*!40000 ALTER TABLE `ft_goodsattr` DISABLE KEYS */;
/*!40000 ALTER TABLE `ft_goodsattr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ft_message`
--

DROP TABLE IF EXISTS `ft_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(20) NOT NULL DEFAULT '',
  `email` char(60) NOT NULL DEFAULT '',
  `message` varchar(255) NOT NULL DEFAULT '',
  `msgtype` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `ishandled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_message`
--

LOCK TABLES `ft_message` WRITE;
/*!40000 ALTER TABLE `ft_message` DISABLE KEYS */;
INSERT INTO `ft_message` VALUES (2,'Wanrre','bililovy@qq.com','I want a product for me, please get it to me at 6.00',2,1447739684,1),(3,'Margin','bililovy@qq.com','I want a product for me, please get it to me at 6.00',2,1447739684,0),(4,'Myttee','bililovy@qq.com','I want a product for me, please get it to me at 6.00',2,1447739684,0),(5,'Lovyyd','bililovy@qq.com','I want a product for me, please get it to me at 6.00',2,1447739684,0),(6,'Biiluuu','bililovy@qq.com','Yes for it, It\'s very good for you.',2,1447739684,1);
/*!40000 ALTER TABLE `ft_message` ENABLE KEYS */;
UNLOCK TABLES; */;

--
-- Table structure for table `ft_msgtype`
--

DROP TABLE IF EXISTS `ft_msgtype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_msgtype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typename` varchar(20) NOT NULL DEFAULT '',
  `sortorder` tinyint(4) NOT NULL DEFAULT '10',
  `addtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_msgtype`
--

LOCK TABLES `ft_msgtype` WRITE;
/*!40000 ALTER TABLE `ft_msgtype` DISABLE KEYS */;
INSERT INTO `ft_msgtype` VALUES (3,'questions',2,1447748857),(2,'FAQ',1,1447747940);
/*!40000 ALTER TABLE `ft_msgtype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ft_news`
--

DROP TABLE IF EXISTS `ft_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_news` (
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_news`
--

LOCK TABLES `ft_news` WRITE;
/*!40000 ALTER TABLE `ft_news` DISABLE KEYS */;
INSERT INTO `ft_news` VALUES (1,'this is a news for the website','kyword,fiekfk,dfjdjosdf','./Application/../assets/library/uploads/image/news/cover/20151117/564a90d31ca50.jpg','/assets/library/uploads/image/news/cover/20151117/564a90d31ca50.jpg','flsjfslfjoisdufosdfjsdlfsdjfosufsodaijfsdaflskdjfsadjfosidafjsdafsdflkjsdaf ','Trueskin',352,1447727348,1,2,'thisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;');
/*!40000 ALTER TABLE `ft_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ft_onesignalpage`
--

DROP TABLE IF EXISTS `ft_onesignalpage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_onesignalpage` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL DEFAULT '',
  `keywords` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(200) NOT NULL DEFAULT '',
  `isshow` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `sortorder` tinyint(3) unsigned NOT NULL DEFAULT '5',
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_onesignalpage`
--

LOCK TABLES `ft_onesignalpage` WRITE;
/*!40000 ALTER TABLE `ft_onesignalpage` DISABLE KEYS */;
/*!40000 ALTER TABLE `ft_onesignalpage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ft_socialtools`
--

DROP TABLE IF EXISTS `ft_socialtools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_socialtools` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `toolname` varchar(20) NOT NULL DEFAULT '',
  `iconrealpath` varchar(150) NOT NULL DEFAULT '',
  `icon` varchar(150) NOT NULL DEFAULT '',
  `account` varchar(30) NOT NULL DEFAULT '',
  `isopened` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `toolname` (`toolname`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_socialtools`
--

LOCK TABLES `ft_socialtools` WRITE;
/*!40000 ALTER TABLE `ft_socialtools` DISABLE KEYS */;
INSERT INTO `ft_socialtools` VALUES (1,'twitter','','fa-twitter','wangpeng',0),(2,'youtube','','fa-youtube','pengge',0),(3,'facebook','','fa-facebook','facepeng',1),(4,'skype','','fa-skype','',0),(5,'instagram','','fa-instagram','',0),(6,'whatsapp','','fa-whatsapp','',0),(7,'vine','','fa-vine','',0),(8,'linkedin','','fa-linkedin','',0),(9,'googleplus','','fa-google-plus','',0),(10,'wechat','','fa-wechat','',0),(11,'tumblr','','fa-tumblr','',0),(12,'flickr','','fa-flickr','',0);
/*!40000 ALTER TABLE `ft_socialtools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ft_sysconfig`
--

DROP TABLE IF EXISTS `ft_sysconfig`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_sysconfig` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `webname` varchar(100) NOT NULL DEFAULT '',
  `keywords` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL DEFAULT '',
  `tels` varchar(120) NOT NULL DEFAULT '',
  `faxes` varchar(120) NOT NULL DEFAULT '',
  `icp` varchar(60) NOT NULL DEFAULT '',
  `address` varchar(150) NOT NULL DEFAULT '',
  `copyright` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_sysconfig`
--

LOCK TABLES `ft_sysconfig` WRITE;
/*!40000 ALTER TABLE `ft_sysconfig` DISABLE KEYS */;
/*!40000 ALTER TABLE `ft_sysconfig` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-19 19:11:20
