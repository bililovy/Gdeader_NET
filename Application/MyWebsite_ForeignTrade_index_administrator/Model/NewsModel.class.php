<?php 
/**
 * 程序版本：JB_Version1.0
 *
 * 开发日期：2015-8-19
 *
 * 开发版权：© 蜗牛兄弟网络科技有限公司
 *
 * 版权申明：此程序仅供成都金标装饰有限公司使用，不得转让和出售，一经发现，将追究其责任
 *
 * 开发申明：蜗牛兄弟 你 不是一个人在战斗。
 *
 *                           商场如战场，枪林弹雨中，双拳终将难敌四手。天时地利终须人和。
 *
 *                           我们是蜗牛兄弟，你成功路上的最佳推手。成功一直在你身边，只需您珍重把握。
 *
 *                           你， 不是一个人在战斗！
 *
 * 程序说明：新闻数据表模型控制
 */
namespace MyWebsite_ForeignTrade_index_administrator\Model;
use Think\Model;

class NewsModel extends Model{
	/**
	 * 验证字段
	 */
	protected $_validate=array(
			array('title','require','新闻标题必须填写'),
			array('keywords','0,100','关键词格式不正确，关键词最多为100个字符',0,'length'),
			array('description','0,200','新闻导读格式不正确，新闻导读最多为200个字符',0,'length'),
			array('sortorder','/^\d+/','新闻排序值必须为正整数'),
			array('click','/^\d+/','新闻浏览次数值必须为正整数'),
			array('content','require','新闻内容不能为空，请填写后再提交！')
			);
}