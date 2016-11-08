<?php 
/**
 * 页面功能简述： 产品搜索控制
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
namespace  Home\Controller;

use Home\Controller\EmptyController;

class SearchController extends EmptyController{
	/**
	 * 默认 控制
	 */
	public function index(){
		$this->error('Error Handle ! Please search something!','',3);
	}
	/**
	 * 搜索入口
	 */
	public function sq (){
		$q=empty($this->_searchkey) ? I('q','') : $this->_searchkey;
		if(!empty($q)){
			$where='locate("'.$q.'",`goodsname`)>0';
			$count=M('goods')->where($where)->count();
			//-------------------引入分页类;			
			import ( 'Extensions.Pagin', COMMON_PATH );
			$page = new \Page ( $count, 15, $_GET ['p'], '?p={page}&q='.$q );
			$limit = $page->page_limit . "," . $page->myde_size;
			//-------------------引入分页类;
			$results=M('goods')->field('id,goodsname,price,goodslink, click, description,goodsimg')->where($where)->order('sortorder, addtime DESC')->limit($limit)->select();
		}else{
			$results=false;
		}		

		//----- 页面信息获取---//
		$pageinfo=array(
				'pagetitle'=>'Product Search',
				'breadcrumb'=>array('search for : '. $q)
		);
		$this->pageinfo=$pageinfo;
		//----- 页面信息获取---//
		$this->searchs=$results;
		$this->page=$page->myde_write(false,false,false,true,true,true,'prev','next');
		$this->news=M('news')->field('id,title')->where(array('isshow'=>1))->order('click DESC')->limit(5)->select();
		$this->display('search');
	}
}