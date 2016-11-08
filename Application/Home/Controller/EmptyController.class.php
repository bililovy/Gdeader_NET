<?php 
/**
 * 程序版本：JB_Version1.0
 *
 * 开发日期：2015-08-11
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
 * 程序说明：前端空操作文件
 */
namespace Home\Controller;

use Common\Controller\WebCommonController;

class EmptyController extends WebCommonController{
	public function _empty(){
		/***BEGIN 网站基本信息获取**/
		$configs=$this->GetWebConfig(array('keywords','description'));
		$pageinfo=array(
				'pagetitle'=>'哎呀…您访问的页面不存在',
				'keywords'=>$configs['keywords'],
				'description'=>$configs['description']
		);
		/***END 网站基本信息获取**/
		$this->pageinfo=$pageinfo;
		$this->display(  'Error' . ":404");
	}
	public function index(){
			/***BEGIN 网站基本信息获取**/
		$configs=$this->GetWebConfig(array('keywords','description'));
		$pageinfo=array(
				'pagetitle'=>'哎呀…您访问的页面不存在',
				'keywords'=>$configs['keywords'],
				'description'=>$configs['description']
		);
		/***END 网站基本信息获取**/
		$this->pageinfo=$pageinfo;
		$this->display(  'Error' . ":404");
	}
}
