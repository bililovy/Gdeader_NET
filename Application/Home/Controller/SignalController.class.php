<?php
/**
 * 页面功能简述： 自定义单页入口
 *
 * 开发负责人：吴思阳    联系邮箱：1985277517@qq.com  联系QQ: 1985277517
 *
 * 合同协议：成都万应网络科技有限公司（http://www.cdwinning.com）是成都高质量的网络应用开发、网站建设、wap/微信开发科技公司，
 * 		      公司原则是：尽心、尽责、尽全力。为每位客户打造放心的业务合作关系。公司要求所有开发人员按照客户提供的要求给客户开发高质
 * 		      量、高稳定性、高体验度的程序。万应科技，有求必应！
 *
 * 技术申明：成都万应网络科技有限公司（简称本公司）在程序上部署版权探针程序，程序解释权归本公司所有。
 *         程序使用版权归合同签署者（简称使用人），未经同意，使用人不得将此程序源码转让和出售。
 *         如果发现以上行为，将进行网站下线或程序删除等操作。
 *
 * 更新日期：2015-11-23
 *
 */
namespace Home\Controller;

use Home\Controller\EmptyController;

class SignalController extends EmptyController{
	/**
	 * 单页管理
	 */
	public function index(){
		$this->page();
	}
    public function page() {
        $sid = I('sid',0,'intval');
        if($pageinfo=M('onesignalpage')->field('title')->where(array('id'=>$sid))->find()) {
            $pagename= preg_replace("/[^0-9a-zA-Z\-]+/ui",'-', htmlspecialchars_decode($pageinfo['title']));
            header('location:/s'. $sid.'-'.htmlspecialchars_decode($pagename.'.'.C('URL_HTML_SUFFIX')));
            exit;
        }else{
            $this->error('Access Denyed By The Server, Because A Problem Has Occured By Your Accessing !','',5);
        }
    }
	/**
	 * 展示单页
	 */
	public function directPage(){
		$sid = I('sid',0,'intval');
		if ($signalpage=M('onesignalpage')->field('sortorder', true)->where(array('id'=>$sid))->find()){
			$signalpage['content']=htmlspecialchars_decode($signalpage['content']);

			//----- 页面信息获取---//
			$pageinfo=array(
					'pagetitle'=>$signalpage['title'],
					'keywords'=>$signalpage['keywords'],
					'description'=>$signalpage['description'],
					'author'=>'signalpage',
					'breadcrumb'=>array($signalpage['title'])
					);
			$this->pageinfo=$pageinfo;
			//----- 页面信息获取---//
			$this->signalinfo=$signalpage;
			$this->display('signalpage');
		}else{
			$this->error('Access Denyed By The Server, Because A Problem Has Occured By Your Accessing !','',5);
		}
	}
}