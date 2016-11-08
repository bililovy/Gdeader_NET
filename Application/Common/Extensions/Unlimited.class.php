<?php 
/**
 * 页面功能简述： 无限极分类 
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
 * 更新日期：2015-11-21
 * 
 */
class Unlimited{
	/**
	 * 返回一维数组
	 * @param unknown_type $cate
	 * @param unknown_type $html
	 * @param unknown_type $pid
	 * @param unknown_type $level
	 */
	static public function UnlimitedForLevel($cate, $html='--', $pid=0, $level=0){
		$arr=array();
		foreach($cate as $v){
			if ($v['parentid']==$pid){
				$v['level']=$level+1;
				$v['html']= str_repeat($html, $level);
				$arr[]=$v;
				$arr=array_merge($arr, self::UnlimitedForLevel($cate, $html, $v['id'], $level+1));
			}
		}
		return $arr;
	}
	/**
	 * 返回多维数组
	 * @param unknown_type $cate
	 * @param unknown_type $pid
	 * @return Ambigous <multitype:, multitype:unknown >
	 */
	static public function UnlimitedForLayer($cate, $pid=0){
		$arr=array();
		foreach ($cate as $v){
			if($v['parentid']==$pid){
				$arr[]=$v;
				$arr=array_merge($arr, self::UnlimitedForLayer($cate, $v['id']));
			}
		}
		return $arr;
	}
	/**
	 * 通过子分类id找到所有父分类
	 * @param unknown_type $cate
	 * @param unknown_type $cid
	 * @return Ambigous <multitype:, multitype:unknown >
	 */
	static public function UnlimitedForParents($cate, $cid){
		$arr=array();
		foreach($cate as $v){
			if ($v['id']==$cid){
				$arr[]=$v['catename'];
				$arr=array_merge($arr, self::UnlimitedForParents($cate, $v['pid']));
			}
		}
		return $arr;
	}
	/**
	 * 返回上下级分明的多维数组  适用于多级导航
	 * @param unknown_type $cate
	 * @param unknown_type $pid
	 * @return Ambigous <multitype:, multitype:unknown >
	 */
	static public function UnlimitedForLayerNav($cate, $pid=0){
		$arr=array();
		foreach ($cate as $v){
			if($v['parentid']==$pid){
				$v['childs']=self::UnlimitedForLayerNav($cate, $v['id']);
				$arr[]=$v;
			}
		}
		return $arr;
	}
}