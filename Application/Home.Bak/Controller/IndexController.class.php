<?php
namespace Home\Controller;


use Home\Controller\EmptyController;

class IndexController extends EmptyController {
    public function index(){
   		//获取焦点图
   		unset($where);
   		unset($field);
   		$field='title,cover,linkurl';
   		$where['isshow']=1;
   		$order='sortorder ASC, id DESC';
   		$limit=5;
   		$focuses=M('focus')->field($field)->where($where)->order($order)->limit($limit)->select();
//    		$cartCount=M('wishlist')->where(array('uid'=>$_SESSION['member']['uid']))->count();
   		//获取促销活动
   		unset($field);
   		unset($where);
   		unset($limit);

   		//获取公司简介
   		$introduction=M('companyintro')->field('content')->where(array('isshow'=>1))->find();   		
		//获取热门的商品
		$hotGoods=M('goods')->field('id, goodsname,goodslink,goodsimg,price')->where(array('isshow'=>1,'isnew'=>1))->order('click DESC')->limit(12)->select();
		//获取被推荐的商品
		$recommendGoods=M('goods')->field('id, goodsname,goodslink,goodsimg,click,price')->where(array('isrecommend'=>1,'isshow'=>1))->order('addtime DESC')->limit(3)->select();
		//------页面信息---//
		$pageinfo=array(
				'pagetitle'=>'',
				);
		$this->pageinfo=$pageinfo;
		//------页面信息---//
		
		//获取提问类型
		$this->msgtypes=M('msgtype')->field('id,typename')->order('sortorder')->select();
   		$this->focuses=$focuses;
   		$this->hots=$hotGoods;
   		$this->recommends=$recommendGoods;
   		$this->introduction=htmlspecialchars_decode($introduction['content']);
		$this->display('index');	
    }

}