<?php
/**
 * 页面功能简述： 前端产品控制中心
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
 * 更新日期：2015-11-22
 *
 */
namespace Home\Controller;

use Home\Controller\EmptyController;

class GoodsController extends EmptyController{
	/**
	 * 产品列表控制
	 */
    public function index() {
        $cid=I('cid',0,'intval');
		$_SESSION['act']['do']=I('do','');
		$_SESSION['act']['s']=I('s','');
		$_SESSION['act']['click']=I('click','');
		$_SESSION['act']['pop']=I('pop','');
		$_SESSION['act']['price']=I('price','');
        if ($cid>0){
        $cateinfo=M('category')->field('catename')->where(array('id'=>$cid))->find();
        $catename=preg_replace("/[^0-9a-zA-Z\-]+/ui",'-', trim(strtolower(htmlspecialchars_decode($cateinfo['catename']))));
		header('HTTP/1.1 301 Moved Permanently');
        header('location:/cat'.$cid.'-'.$catename.'.'. C('URL_HTML_SUFFIX'));
        exit;
        }else{
            $this->error('Access Denyed By the Server, Missing  Some Parameters!','',5);
        }
    }
	public function goodaCate(){
        $cid=I('cid',0,'intval');
        if ($cid>0){
            $type=isset($_SESSION['act']['do'])?$_SESSION['act']['do']:'';
            $sort=isset($_SESSION['act']['s']) ?$_SESSION['act']['s']:'';
            $click=isset($_SESSION['act']['click'])?$_SESSION['act']['click']:'';
            $pop=isset($_SESSION['act']['pop']) ?$_SESSION['act']['pop']:'';
            $price=isset($_SESSION['act']['price'])?$_SESSION['act']['price']:'';
			//获取当前分类的信息 作为 页面信息
			$cateinfo=M('category')->field('id,description,keywords, catename,parentid')->where(array('id'=>$cid))->find();
            $relatecates=M('category')->field('id,catename')->where(array('parentid'=>$cateinfo['parentid']))->select();
            $catids=array($cid);
			$subcates=M('category')->field('id')->where(array('parentid'=>$cid))->select();
            if($subcates){
                foreach($subcates as $cat){
                    $catids[]=$cat['id'];
                }
            }
            $field='id,goodsname, goodslink,goodsimg,price,click';
            $where='cateid IN ('. implode(',',$catids) .' )';
            $limit =9;
            if ($sort==2){
				//按hot成都
				if($click==1)	$order='click DESC';
				else $order='click ASC';
			}else if($sort==3){
				//按商品收藏数量排序
				if($pop==1) $order='wishlist DESC';
				else $order='wishlist ASC';
			}else if ($sort==4){
				//按价格
				if($price==1) $order='price DESC';
				else $order='price ASC';
			}else{
				//默认排序
				$order='sortorder';
			}
            $goods =M('goods')->field($field)->where($where)->order($order)->limit($limit)->select();
			//------页面信息---//
            $bread = $this->getBreadCrumb($cid,$cateinfo['catename']);
			$pageinfo=array(
					'pagetitle'=>$cateinfo['catename'],
					'description'=>$cateinfo['description'],
					'keywords'=>$cateinfo['keywords'],
					'breadcrumb'=>$bread
			);
			$this->pageinfo=$pageinfo;
			//------页面信息---//

			//-------BEGIN 载入分页类---//
			import ( 'Extensions.Pagin', COMMON_PATH );
			// 			$count=M('goods')->where($where)->count();
			$count=M('goods')->where($where)->count();
			$page = new \Page ( $count, 12, $_GET ['p'], '?p={page}' );
			$limit = $page->page_limit . "," . $page->myde_size;
			//-------END 载入分页类---//

			$goods =M('goods')->field($field)->where($where)->order($order)->limit($limit)->select();
			$this->page=$page->myde_write(false,false,false,true, true,true,'Previous','Next');
			$this->page2=$page->myde_write(false,false,false,false, false,false,'Previous','Next','up_pagenation');
			$this->goods=$goods;
			$this->relatecates=$relatecates;
			$this->catename=$cateinfo['catename'];
			$this->s=$sort;
			$this->sale= $click ==1 ? 2 : 1;
			$this->pop= $pop ==1 ? 2 : 1;
			$this->price= $price ==1 ? 2 : 1;
			$this->curcateid=$cid;
			$this->display('category');
        }else{
            $this->error('Access Denyed By the Server, Missing  Some Parameters!','',5);
        }
	}

/* 	public function getBreadCrumb($id,$now){
		$bread=array();
		$uplevel=M('category')->field('id,catename,parentid')->where('id=' .$id)->find();
		if ($uplevel['parentid'] !=0)
			$this->getBreadCrumb($uplevel['parentid'],$now);
		if ($uplevel) $bread[]=$uplevel;
		if(empty($bread))
			$bread=$now;
		else
			$bread=array_merge($bread,$now);
		$res=array();
		foreach($bread as $val){
			if(is_array($val)) $res[U('index',array('cid'=>$val['id'],'justfrom'=>'catelist'))]=$val['catename'];
			else $res[]=$val;
		}
		return $res;
	} */
	public function getBreadCrumb($id,$now){
		static $bread=array();
		$uplevel=M('category')->field('id,catename,parentid')->where('id=' .$id)->find();
		array_unshift($bread,$uplevel);
		if ($uplevel['parentid'] !=0){
			$this->getBreadCrumb($uplevel['parentid'],$now);
		}
		$bread['cu']=$now;
		$res=array();
		foreach($bread as $val){			if(!is_null($val)){
			if(is_array($val)) $res[U('index',array('cid'=>$val['id'],'justfrom'=>'catelist'))]=$val['catename'];
			else $res[]=$val;						}
		}
		$res=array_unique($res);
		return $res;
	}

	static protected function filter_array_unique($array)//写的比较好
	{
		$out = array();
		foreach ($array as $key=>$value) {
			if (!in_array($value, $out))
			{
				$out[$key] = $value;
			}
		}
		return $out;
	}

	static protected function arrayChange($a){
		$arr2=array();
		foreach($a as $v){
			if(is_array($v)){
				self::arrayChange($v);
			}
			$arr2=array_merge($arr2, $v);
		}
		return $arr2;
	}

	/**
	 * 通过分类id找到下级
	 */
	static private function GetSubByCate($cid=0){
		$cateids=array();
		$subcate=M('category')->field('id')->where(array('parentid'=>$cid))->select();
		if ($subcate){
			foreach($subcate as  $sub){
				$cateids[]=$sub['id'];
				$cateids=array_merge($cateids, self::GetSubByCate($sub['id']));
			}
		}
		return $cateids;
	}
    public function detail() {
		$gid=I('gid',0,'intval');
        $goodsinfo=M('goods')->field('goodsname')->where(array('id'=>$gid))->find();
        $goodsinfo['goodsname']=preg_replace("/[^0-9a-zA-Z\-]+/ui",'-', trim(strtolower(htmlspecialchars_decode($goodsinfo['goodsname']))));
		header('HTTP/1.1 301 Moved Permanently');
		header('location:/pro'. $gid.'-'.htmlspecialchars_decode($goodsinfo['goodsname'].'.'.C('URL_HTML_SUFFIX')));
        exit;
    }
	/**
	 * 产品详情
	 */
	public function gdetail(){
		$gid=I('gid',0,'intval');
		$where='a.id=%d AND a.cateid=b.id';
		if ($goodsExists=M()->table('__GOODS__ as a, __CATEGORY__ as b')->field('a.cateid,a.goodsname, a.goodsimg, a.goodslink, a.keywords, a.description, a.click, a.price, a.goodsdetail, b.catename')->where($where,$gid)->find()){
			$goodsExists['id']=$gid;
			//点击量自增1
			M('goods')->where(array('id'=>$gid))->setInc('click',1);
			//获取产品相册
			$goodsalbums= M('goodsalbum')->field('imgrealpath', true)->where(array('goodsid'=>$gid))->select();
			$goodsattr=M()->table('__ATTRIBUTE__ as a, __GOODSATTR__ as b')->field('a.attrname,b.attrvalue')->where('a.id=b.attrid AND b.goodsid='. $gid)->order('a.sortorder')->select();
			foreach($goodsattr as $key=>$val){
				if (strpos($val['attrvalue'],'|')!==false){
					$goodsattr[$key]['attrvalue']=array_empty_filter(explode('|', $val['attrvalue']));
				}
			}
			//推荐产品
			$recommends=M('goods')->field('id,goodsname,goodslink, price, goodsimg')->where(array('isshow'=>1, 'isrecommend'=>1, 'id'=>array('NEQ', $gid)))->order('sortorder')->limit(12)->select();
				$ids=array();
				foreach($recommends as $v){
					$ids[]=$v['id'];
				}
				$ids[]=$gid;
			$popGoods=M('goods')->field('id,goodsname,goodslink, goodsimg')->where(array('isshow'=>1, 'id'=>array('not in', $ids)))->order('wishlist')->limit(8)->select();

			$goodsExists['goodsdetail']=htmlspecialchars_decode($goodsExists['goodsdetail']);

			//------页面信息---//
			$bread=$this->getBreadCrumb($goodsExists['cateid'],$goodsExists['goodsname']);
			$pageinfo=array(
					'pagetitle'=>$goodsExists['goodsname'],
					'keywords'=>$goodsExists['keywords'],
					'description'=>$goodsExists['description'],
					'breadcrumb'=>$bread
			);
			$this->pageinfo=$pageinfo;
			//------页面信息---//

			$this->goods=$goodsExists;
			$this->goodsattr=$goodsattr;
			$this->popular=$popGoods;
			$this->recommends=$recommends;
			$this->goodsalbums=$goodsalbums;
			$this->display('goods_detail');
		}else{
			$this->error('Access Denyed By The Server, Because A Problem Has Occured By Your Accessing !','',5);
		}
	}
	public function wishlist(){
		if (IS_POST){
			$gid=I('gid','','intval');
			$uid=session('member.uid');
			if ($gid>0 && $uid>0){
				if (M('wishlist')->where(array('uid'=>$uid,'gid'=>$gid))->delete()){
					 //商品表的收藏数减去1
					 M('goods')->where(array('id'=>$gid))->setDec('wishlist',1);
					$return =array(
							'status'=>1,
							'data'=>'successful ！'
							);
				}else{
					$return =array(
							'status'=>0,
							'data'=>'System is busy, please try again later ！'
							);
				}
			}else{
				$return =array(
						'status'=>0,
						'data'=>'Something occured, please refresh the page and try again ！'
						);
			}
			$this->ajaxReturn($return,'json');
			exit;
		}
		if (session('member')){
			$uid=session('member.uid');
			$field='b.id,b.goodsimg,b.goodsname,b.goodslink,b.price';
			$where='a.gid=b.id AND a.uid='. $uid;
			$order='a.addtime DESC';
			$wishlists=M()->table('__WISHLIST__ as a, __GOODS__ as b')->field($field)->where($where)->order($order)->select();
		}else{
			$wishlists='unlogin';
		}
		//找出推荐商品
		//获取被推荐的商品
		$recommendGoods=M('goods')->field('id, goodsname,goodslink,goodsimg,click,price')->where(array('isrecommend'=>1,'isshow'=>1))->order('click DESC')->limit(15)->select();

		$pageinfo=array(
				'pagetitle'=>'Shopping Cart',
				'breadcrumb'=>array('wishlist')
				);
		$this->wishlists=$wishlists;
		$this->recommends=$recommendGoods;
		$this->pageinfo=$pageinfo;
		$this->display();
	}

	public function ajaxGetCartList(){
		if ( !IS_POST || ! IS_AJAX){
			$this->error('Access Denyed By The Server, Because A Problem Has Occured By Your Accessing !','',5);
			exit;
		}
		$cartlist=null;
		$totalPrice='0.00';
		$count=0;
		if(session('member.uid')){
			$uid=session('member.uid');
			$field='b.goodsimg,b.goodsname, b.price,b.id, b.goodslink';
			$where='a.gid=b.id AND a.uid='.$uid;
			$order='a.id DESC';
			$limit=4;
			$cartCount=M('wishlist')->where(array('uid'=>$uid))->count();
			$cartlist=M()->table('__WISHLIST__ as a, __GOODS__ as b')->field($field)->where($where)->order($order)->limit($limit)->select();
		}
		if ($cartlist){
			foreach($cartlist as $goods){
				$totalPrice +=$goods['price'];
			}
			$count=count($cartlist);
			$totalPrice=$totalPrice;
		}
		$this->cartlist=$cartlist;
		$this->totalPrice=$totalPrice;
		$this->count=$count;
		$html=$this->fetch('Public/cartlist');
		$this->ajaxReturn(array('data'=>$html));
	}

	/**
	 * ajax加入购物车
	 */
	public function ajaxCart(){
		if ( !IS_POST || ! IS_AJAX){
				$this->error('Access Denyed By The Server, Because A Problem Has Occured By Your Accessing !','',5);
			exit;
		}
		if (session('member')){
			$data['gid']=I('gid','','intval');
			$data['uid']=session('member.uid');
			if ($data['gid']> 0 && $data['uid']>0){
				$wishDB=M('wishlist');
				if ($wishDB->where(array('gid'=>$data['gid'], 'uid'=>$data['uid']))->count()>0){
					$return =array(
							'status'=>2,
							'data'=>'Existed !'
					);
				}else{
					$data['addtime']=time();
					if($newID=$wishDB->add($data)){
						$count=$wishDB->where(array('uid'=>$data['uid']))->count();
						M('goods')->where(array('id'=>$data['gid']))->setInc('wishlist',1);
						$return =array(
								'status'=>1,
								'data'=>'Added !',
								'count'=>$count
						);
					}else{
						$return =array(
								'status'=>0,
								'data'=>'Failed !'
						);
					}
				}
			}else{
				$return =array(
						'status'=>0,
						'data'=>'Param Error !'
				);
			}
		}else{
			$return =array(
					'status'=>3,
					'url'=>U('Member/login'),
					'data'=>'Please Login !'
			);
		}

		$this->ajaxReturn($return,'json');
	}
}