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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_about`
--

LOCK TABLES `ft_about` WRITE;
/*!40000 ALTER TABLE `ft_about` DISABLE KEYS */;
INSERT INTO `ft_about` VALUES (1,'about us page','company','',1,'&lt;div class=&quot;content&quot;&gt;\n	&lt;p&gt;\n		Over our 25 year history, we’ve grown considerably and these \nyears of experience mean our hats are produced to the highest quality \nand at great prices. We have the widest collection of hats available in \nthe UK and with a large UK stock holding and speedy next day delivery \nyour new hats will be with you in no time\n	&lt;/p&gt;\n	&lt;p&gt;\n		The majority of our styles are offered in mixed colours and sizes\n to give your customers a wider choice and offer the maximum comfort. \nOur range of straw trilbys is perfect if your customers are off to the \nbeach, and don’t forget our waterproof bush hats and wellies in case the\n weather takes a turn for the worse. Whether you are a wedding boutique,\n tourist shop or sell online our range of occasion hats, Peru hats and \nLondon baseball caps are sure to be a hit. We offer both summer hats and\n winter hats, for men, women and children. Our novelty animal hats are \nsure to please your younger customers, and our trapper hats will keep \neveryone warm this winter. From sun hats to felt hats, tweed flat caps \nto fancy dress hats, our range spans them all!\n	&lt;/p&gt;\n	&lt;p&gt;\n		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do \neiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad \nminim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip \nex ea commodo consequat. Duis aute irure dolor in reprehenderit in \nvoluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur \nsint occaecat cupidatat non proident, sunt in culpa qui officia deserunt\n mollit anim id est laborum Lorem ipsum dolor sit amet, consectetur \nadipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore \nmagna aliqua.The fashion industry is a product of the modern age. Prior \nto the mid-19th century, most clothing was custom-made. It was handmade \nfor individuals, either as home production or on order from dressmakers \nand tailors excepteur sint occaecat cupidatat non proident.\n	&lt;/p&gt;\n&lt;/div&gt;');
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
INSERT INTO `ft_adminuser` VALUES (1,'bililovy','思阳','bililovy@163.com','1d6b0268d4733d4dc22dc8bcb29d67c4',1448106868,8,1439719314,0);
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_attribute`
--

LOCK TABLES `ft_attribute` WRITE;
/*!40000 ALTER TABLE `ft_attribute` DISABLE KEYS */;
INSERT INTO `ft_attribute` VALUES (1,1,'color',3,'red|white|yellow|red&amp;white',1),(2,4,'color',3,'red|white|red&amp;white|yellow',1),(3,5,'color',3,'whitejian|baowen',2),(4,7,'color',3,'blue|zongse|pink',3),(5,9,'color',3,'zongse|huangse|blcak',10),(6,8,'color',3,'blank|white',10),(7,10,'style',3,'xiuxian|lvyou',10),(8,4,'size',3,'S|M|L|XL|XXL',10),(9,5,'size',3,'S|M|L|XL|XXL',10),(10,6,'color',3,'red|black',10);
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_category`
--

LOCK TABLES `ft_category` WRITE;
/*!40000 ALTER TABLE `ft_category` DISABLE KEYS */;
INSERT INTO `ft_category` VALUES (1,'Clothes','keywords winter ','descriton winter',0,1,1,1),(2,'Hats','keywords hat','dewcription hat',0,2,1,1),(3,'Shoes','shoes descriotion','cate dfjkr fasldjf sdalfj fasdfsdf',0,3,1,1),(4,'Summer Used','keyeofjsalj',' lfsdj wjfsldfj sadfjas ',1,4,1,1),(5,'Winter Used','faskdf ','jflasjdf saldfjsa dflsadjfsadfdsafs ',1,5,1,1),(6,'Bu Liao','faslfj sd','jfasdljf asdljfd saf',2,10,1,1),(7,'Xian Rong','fasldfj sal','qjfljasldfj asldjkf asdf',2,10,1,1),(8,'DanXie','fsadfdsafsdafsad','fsadfsadfasfadfs',3,10,1,1),(9,'PiXie','fsafsdfsdaf','sdafsdfsdfsdfsd',3,10,1,1),(10,'LvYouXie','fasfsadfsadf','sdfsadfsadfsdafsdf',3,10,1,1);
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_companyintro`
--

LOCK TABLES `ft_companyintro` WRITE;
/*!40000 ALTER TABLE `ft_companyintro` DISABLE KEYS */;
INSERT INTO `ft_companyintro` VALUES (1,'company intro','这是关键词，用逗号隔开，前端优化时户籍用到','这里的描述是利于其他搜索引擎去抓取的，主要描述你这个页面是干什么的',1,'&lt;p style=&quot;text-indent:2em;&quot;&gt;\n	The clothing Co., Ltd. of Jiahe of one of Weihai, is a large-scale \nclothes enterprise incorporating designing and developing, producing \nprocessing, foreign trade into an organic whole, have under its command \nWeihai piece Jiahe Clothing Co., Ltd., Weihai space cut clothing Co., \nLtd. and Heze Prefecture Shandong one professional production units such\n as Dress Co., Ltd.,etc., the head office covers an area of 86580 square\n meters, have a construction area of 25000 square meters now. The total \nvalue of the assets is more than 150 million yuan, there are more than \n2500 workers now, have 3500 sets of production equipment clothes (set) \nof the international most advanced level, the annual production capacity\n reaches 50 million (set), annual output is 100 million dollars, the \ncompany mainly produces all kinds of medium-to-high grade knitted \ndresses, the products are sold to Japan, South Korea, Europe, South and \nNorth America etc, have established steady and close joint-venture, \ntrade relations with large quantities of foreign businessmen, enjoy \nhigher business reputation in the world\n&lt;/p&gt;');
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
INSERT INTO `ft_focus` VALUES (4,'focus title two for the website','useed for it','/assets/library/uploads/image/focus/564aa5f57e69a.jpg','./Application/../assets/library/uploads/image/focus/564aa5f57e69a.jpg','http://www.sina.com.cn',1,5),(3,'focus title for the website that used by','focus shortt','/assets/library/uploads/image/focus/564aa5326578a.jpg','./Application/../assets/library/uploads/image/focus/564aa5326578a.jpg','http://www.taobao.com',1,10),(5,'focus 5 for taht fdsk','flsdjffsdlfj','/assets/library/uploads/image/focus/564aa620d7272.jpg','./Application/../assets/library/uploads/image/focus/564aa620d7272.jpg','',1,1),(6,'fsdfdssfjslfdsklfjljasdfldsfkjl','fsdlfjsdlfjs','/assets/library/uploads/image/focus/564aa6a512063.jpg','./Application/../assets/library/uploads/image/focus/564aa6a512063.jpg','',0,10),(7,'erueiwrewoifsldfsklj','fdsfdsf','/assets/library/uploads/image/focus/564aa639e52cb.jpg','./Application/../assets/library/uploads/image/focus/564aa639e52cb.jpg','',1,10),(8,'vcvcxvcxvkljfksld','fskldfjcvxlc','/assets/library/uploads/image/focus/564aa64c250bd.png','./Application/../assets/library/uploads/image/focus/564aa64c250bd.png','',1,10);
/*!40000 ALTER TABLE `ft_focus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ft_goods`
--

DROP TABLE IF EXISTS `ft_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '��Ʒ������id',
  `cateid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '��Ʒ������Ʒ����id��ȡֵecs_category��cat_id',
  `goodsname` varchar(70) NOT NULL DEFAULT '',
  `click` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '��Ʒ�����',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '�г��ۼ�',
  `keywords` varchar(100) NOT NULL COMMENT '��Ʒ�ؼ��֣�������Ʒҳ�Ĺؼ����У�Ϊ����������¼��',
  `description` varchar(200) NOT NULL COMMENT '��Ʒ�ļ������',
  `goodsdetail` text NOT NULL COMMENT '��Ʒ����ϸ����',
  `goodsimg` varchar(150) NOT NULL DEFAULT '' COMMENT '��Ʒ����ͼ',
  `isnew` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '�ò�Ʒ�Ƿ�Ϊ��Ʒ��0Ϊ�� 1 ��',
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '�Ƿ���ʾ��Ʒ 0 ����ʾ 1 ��ʾ Ĭ��1',
  `isrecommend` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '�ò�Ʒ�Ƿ��Ƽ� 1 �� 0 ��',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '��Ʒ������ʱ��',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `sortorder` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT 'Ӧ������Ʒ����ʾ˳�򣬲����ð������ûʵ�ָù���',
  PRIMARY KEY (`id`),
  KEY `cateid` (`cateid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_goods`
--

LOCK TABLES `ft_goods` WRITE;
/*!40000 ALTER TABLE `ft_goods` DISABLE KEYS */;
INSERT INTO `ft_goods` VALUES (1,4,'summer clother fot fsafljdsf sdlfjsd g kh  khk khhkjhk khj hkjhkjh kh ',84,154.00,'fasfsdafsadfsdafds','fsdfsdafsdafdsfsdafsdafsadfsdfsdfsad','&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;','/assets/library/uploads/image/goods/20151122/5651b844da83d.jpg',1,1,0,1448196178,1448207189,50),(2,4,'summer clother fsadfsdfjfljsdf sfsdafsadfsdafdas',3,1650.00,'fasfsdfsd','fsdafsdfasdfsafsafsdffasfsdfsdafdsafsdaf','&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;','/assets/library/uploads/image/goods/20151122/5651b86f224a6.jpg',1,1,1,1448196224,0,50),(3,4,'goods  jfkds jkui keek fdkiin kdfjka fsda ',59,1524.00,'fvsfddsfsadfsdaf','sdfsdfsdfsadfsadfasfsadf','&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;&amp;nbsp;&amp;nbsp;&amp;nbsp; $this-&amp;gt;error(\'数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！\',\'\',10);&lt;br /&gt;\n&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp; &amp;nbsp;exit;','/assets/library/uploads/image/goods/20151122/5651b88f0243c.jpg',1,1,0,1448196271,0,50),(4,4,'dfas fslkj jklfj lkjflsjoiure fskdjf lfsajds lfj f',0,154.00,'fasdfsdfdsa','fsdfasfsafsadfsd','fasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaf','/assets/library/uploads/image/goods/20151122/5651b8c1eae8f.jpg',1,1,0,1448196315,0,50),(5,5,'fsa foogo eii fdkuy fdskje kd ',15,145.00,'fasfsd','fsfsdfsdfdfsdfsdfdsfsd','fasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaf','/assets/library/uploads/image/goods/20151122/5651b8e4a3dc8.jpg',1,1,1,1448196349,1448202732,50),(6,5,'tfee ditjei fkdeu ljdlj reyajgf aljdfuji fds',0,1547.00,'fasdfsdfsaf','sadfsdafsadfsdafadsfds','fasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaffasdfsdaf','/assets/library/uploads/image/goods/20151122/5651b909a51c5.jpg',1,1,1,1448196390,0,50),(7,7,'hat formn flkf ljsfsysdfjsfjsdklf sadfj ',45,154.00,'fasfsdvxvsdfsdf','sfsfsdafasdfsfasfsadfsad','fasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfa','/assets/library/uploads/image/goods/20151122/5651b936e576a.jpg',1,1,1,1448196434,0,40),(8,7,'fdssdfsdafsfsdaf',16,48.00,'fasfsdfdasfasdf','sdfsadfsadfsdafsadf','fasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfafasdfsadfa','/assets/library/uploads/image/goods/20151122/5651b96ee8ee5.jpg',1,1,1,1448196476,0,50),(9,7,'hat flsdj lfsajf sdfjaslfjs dfjaskf jsdlkjfaksdfjasldkj ',0,84.00,'fasfsdfasfasdfasdf','fasfsadfsadfsdfdsfdsa','fsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdf','/assets/library/uploads/image/goods/20151122/5651b98e016e5.jpg',1,1,1,1448196516,0,50),(10,7,'fsafsd rtre fwere wrea sfsdf',67,184.00,'fsafsdfdsf','sdfsdfsdfsdfsdfs','fsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdf','/assets/library/uploads/image/goods/20151122/5651b9b05b443.jpg',1,1,1,1448196547,0,50),(11,6,'fsda rjlh oi idfh jtlj hj kda fsd',65,154.00,'fasfsdfsvxc','dvxvxcvxcvxcvxcvcx','fsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdf','/assets/library/uploads/image/goods/20151122/5651b9cb0e7d9.jpg',1,1,1,1448196606,0,50),(12,9,'shoes fsljj fsljf slfjsdlfjsdl fsdljsdf ',85,254.00,'fsafsd','fsfsdfvxcvxcvxxcvxvcxv','fsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdffsdfsdfsdf','/assets/library/uploads/image/goods/20151122/5651ba17b5d24.jpg',1,1,1,1448196651,0,50),(13,8,'fs dafsdf s dfs fsfsd fsdfs ',13,158.00,'fsadfsdf','fasdfsdafsdf','fsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsd','/assets/library/uploads/image/goods/20151122/5651ba364f771.jpg',1,1,0,1448196681,0,50),(14,10,'fsfsd fsdfdsfd fsf gddhn gdbgdf  gsljg gd',0,184.00,'asfsd','fhjgjkgjgjghjghjnvbv','fsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsd','/assets/library/uploads/image/goods/20151122/5651ba544a44b.jpg',1,1,0,1448196710,0,50),(15,8,'df sa fsd fsf sdfffsfsd vbcbc xcv d',0,847.00,'fsafsdds','vxczvzxvxzcvxczvxzcv','fsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsdfsdafsasadfsd','/assets/library/uploads/image/goods/20151122/5651ba734321f.jpg',1,1,0,1448196745,0,50),(16,6,'fdsfvxv xcvfs sfsdf sfadf s',0,964.00,'fsafsd','fsdcxvxcvxcvv','vxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvc','/assets/library/uploads/image/goods/20151122/5651ba98547ef.jpg',1,1,1,1448196816,0,50),(17,5,'fsadfdsfvxc',0,35.00,'vzxvxczv','vzxcvcxvxvxzcvx','vxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvcvxcvxcvvxcvxcvxcvxcvvxczvc','/assets/library/uploads/image/goods/20151122/5651badb7d791.jpg',1,1,0,1448196851,0,50);
/*!40000 ALTER TABLE `ft_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ft_goodsalbum`
--

DROP TABLE IF EXISTS `ft_goodsalbum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ft_goodsalbum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '��Ʒ�������id',
  `goodsid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ͼƬ������Ʒ��id',
  `imgpath` varchar(150) NOT NULL COMMENT 'ʵ��ͼƬurl',
  `imgrealpath` varchar(150) NOT NULL COMMENT 'ʵ��ͼƬ��ʵ��ַ',
  `iscover` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goodsid`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_goodsalbum`
--

LOCK TABLES `ft_goodsalbum` WRITE;
/*!40000 ALTER TABLE `ft_goodsalbum` DISABLE KEYS */;
INSERT INTO `ft_goodsalbum` VALUES (1,1,'/assets/library/uploads/image/goods/20151122/5651b844da83d.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651b844da83d.jpg',1),(2,2,'/assets/library/uploads/image/goods/20151122/5651b86f224a6.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651b86f224a6.jpg',1),(3,3,'/assets/library/uploads/image/goods/20151122/5651b88f0243c.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651b88f0243c.jpg',1),(4,4,'/assets/library/uploads/image/goods/20151122/5651b8c1eae8f.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651b8c1eae8f.jpg',1),(5,5,'/assets/library/uploads/image/goods/20151122/5651b8e4a3dc8.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651b8e4a3dc8.jpg',1),(6,6,'/assets/library/uploads/image/goods/20151122/5651b909a51c5.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651b909a51c5.jpg',1),(7,7,'/assets/library/uploads/image/goods/20151122/5651b936e576a.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651b936e576a.jpg',1),(9,8,'/assets/library/uploads/image/goods/20151122/5651b96ee8ee5.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651b96ee8ee5.jpg',1),(10,9,'/assets/library/uploads/image/goods/20151122/5651b98e016e5.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651b98e016e5.jpg',1),(11,10,'/assets/library/uploads/image/goods/20151122/5651b9b05b443.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651b9b05b443.jpg',1),(12,11,'/assets/library/uploads/image/goods/20151122/5651b9cb0e7d9.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651b9cb0e7d9.jpg',1),(13,12,'/assets/library/uploads/image/goods/20151122/5651ba17b5d24.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651ba17b5d24.jpg',1),(14,13,'/assets/library/uploads/image/goods/20151122/5651ba364f771.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651ba364f771.jpg',1),(15,14,'/assets/library/uploads/image/goods/20151122/5651ba544a44b.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651ba544a44b.jpg',1),(16,15,'/assets/library/uploads/image/goods/20151122/5651ba734321f.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651ba734321f.jpg',1),(17,16,'/assets/library/uploads/image/goods/20151122/5651ba98547ef.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651ba98547ef.jpg',1),(18,17,'/assets/library/uploads/image/goods/20151122/5651badb7d791.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651badb7d791.jpg',1),(19,1,'/assets/library/uploads/image/goods/20151122/5651e353ed6e9.jpg','./Application/../assets/library/uploads/image/goods/20151122/5651e353ed6e9.jpg',0);
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
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `cateid` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `goodsid` (`goodsid`),
  KEY `attrid` (`attrid`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_goodsattr`
--

LOCK TABLES `ft_goodsattr` WRITE;
/*!40000 ALTER TABLE `ft_goodsattr` DISABLE KEYS */;
INSERT INTO `ft_goodsattr` VALUES (1,1,2,'red|',1448207189,4),(2,1,8,'S|M|L|',1448207189,4),(3,2,2,'white|',1448196224,4),(4,2,8,'S|M|L|',1448196224,4),(5,3,2,'red&amp;white|',1448196271,4),(6,3,8,'L|XL|XXL|',1448196271,4),(7,4,2,'yellow|',1448196315,4),(8,4,8,'S|M|L|',1448196315,4),(9,5,3,'whitejian|',1448202732,5),(10,5,9,'S|M|L|XL|',1448202732,5),(11,6,3,'white&amp;red|',1448196390,5),(12,6,9,'S|M|L|',1448196390,5),(13,7,4,'blue|',1448196434,7),(14,8,4,'zongse|',1448196476,7),(15,9,4,'zongse|',1448196516,7),(16,10,4,'pink|',1448196547,7),(17,11,10,'red|',1448196606,6),(18,12,5,'zongse|',1448196651,9),(19,13,6,'blank|',1448196681,8),(20,14,7,'xiuxian|',1448196710,10),(21,15,6,'blank|',1448196745,8),(22,16,10,'black|',1448196816,6),(23,17,3,'baowen|',1448196851,5),(24,17,9,'S|M|L|',1448196851,5);
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
UNLOCK TABLES;

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
  `title` varchar(55) NOT NULL DEFAULT '',
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_news`
--

LOCK TABLES `ft_news` WRITE;
/*!40000 ALTER TABLE `ft_news` DISABLE KEYS */;
INSERT INTO `ft_news` VALUES (1,'this is a news for the website','kyword,fiekfk,dfjdjosdf','./Application/../assets/library/uploads/image/news/cover/20151117/564a90d31ca50.jpg','/assets/library/uploads/image/news/cover/20151117/564a90d31ca50.jpg','flsjfslfjoisdufosdfjsdlfsdjfosufsodaijfsdaflskdjfsadjfosidafjsdafsdflkjsdaf ','Trueskin',352,1447727348,1,2,'thisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;\nthisis on&lt;br /&gt;'),(2,'I am a news for the website that you want to say','keywords ,fsdj fldsj lfsdkjfls djflsdk ','./Application/../assets/library/uploads/image/news/cover/20151122/56516cd059673.jpg','/assets/library/uploads/image/news/cover/20151122/56516cd059673.jpg','descriptionf dslafjds fjdslafjasd lfjsldajfsd alfjsad fasdlkfjsad ','bililoyv',152,1448176879,1,40,'fsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjsfsadfsdfdsfsdalfjs');
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_onesignalpage`
--

LOCK TABLES `ft_onesignalpage` WRITE;
/*!40000 ALTER TABLE `ft_onesignalpage` DISABLE KEYS */;
INSERT INTO `ft_onesignalpage` VALUES (3,'fag questions','keywords for the page','page description fdsakjf sdlfjsakfj asdlfjsdakf jaslkjf ',1,5,'fsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd fsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd &lt;br /&gt;\nfsdfjsklajfasd fsdfjsklajfasd &lt;br /&gt;'),(4,'page signal','fsldjf flsdafj ','jflsadjf sadlfjsdlkfj sadlfjds lkfj ',1,5,'gdsfgdfgdjsdlfjsdalkfjas dflajsdfkljsadfljasdfljs adfjlasdf asdfj &lt;br /&gt;');
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
  `email` varchar(100) NOT NULL DEFAULT '',
  `logo` varchar(150) NOT NULL DEFAULT '',
  `logorealpath` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ft_sysconfig`
--

LOCK TABLES `ft_sysconfig` WRITE;
/*!40000 ALTER TABLE `ft_sysconfig` DISABLE KEYS */;
INSERT INTO `ft_sysconfig` VALUES (1,'Wang Peng Technology Co.;Ltd--By Wusiyang -[pengtech]','关键词,百度,公司,中英文都可以，逗号隔开','这是网站描述，可以帮助搜索引擎收录你得网站，可以添加简单的网站介绍或者其他跟公司相关的东西，这里的只是在首页显示，这个很重要，强烈建议填写','13798885858#02884885757#38574474#13525547474','02887444747#081677484744','蜀ICP备：091555474-1号','四川省成都市武侯区一环路南三段80号信都大厦A座4F万应网络科技有限公司','版权所有©请勿盗版','email@emial.cn','/assets/library/uploads/image/logo/564f2c4b5ee1e.png','./Application/../assets/library/uploads/image/logo/564f2c4b5ee1e.png');
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

-- Dump completed on 2015-11-23  0:13:43
