<?php
/**
 * 页面功能简述： 网站共用控制器
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
 * 更新日期：2015-11-16
 *
 */
namespace Common\Controller;
use Think\Controller;
class WebCommonController extends Controller {
	protected  $_config=null;
	protected $_searchkey='';
	protected $_socialtools=null;
	protected function _initialize(){
			if(preg_match('/Home/u', __CONTROLLER__) ){
			$this->GetWebConfig('',false,true);
			$this->GetSocialTools('',0,true);
			$this->getNavList();
			$this->getSignalPage();
			$this->getGoodsCates();
			$this->getWishlistCount();
			$q=I('q','');
			$this->_searchkey=$q;
			$this->searchkey=$q;
		}
	}
	/**
	 * 获取网站配置
	 *
	 * @param  $field 配置字段
	 * @param $except 是否是排除这些字段 默认不是
	 * @param $assign 是否直接分配到模版 默认否 是则直接分配到模版并返回结果
	 */
		protected function GetWebConfig($field='', $except=false, $assign=false){
			//缓存至文件 缓存时间1天
			$filename=md5('sysconfig').'.cache';
			$sys_config_runtime_file=RUNTIME_PATH .'UserCache/'.$filename;
			$cache_interval=86400;
			if(! is_dir(dirname(filemtime($sys_config_runtime_file)))){
				mk_dir(dirname($sys_config_runtime_file));
			}
			if(!file_exists($sys_config_runtime_file) || time()- filemtime($sys_config_runtime_file) > $cache_interval){
				//重新获取最新信息
				if(is_array($field)) $field =implode(',', $field);
					if($except){
						$configs=M('sysconfig')->field($field,true)->find();
					}else{
						$configs=M('sysconfig')->field($field)->find();
					}
				@$fp=fopen($sys_config_runtime_file, 'w');
				fwrite($fp,serialize($configs));
				fclose();
			}else{
				//读取缓存文件
				$configs=unserialize(file_get_contents($sys_config_runtime_file));
			}
			$splitArr=array('tels','faxes');
			if($assign){
				foreach($configs as $key=> & $val){
					if($key==='keywords'){
						$val=convert_keywords($val);
					}
					if(in_array($key,$splitArr) && strpos($val, ',') !==false ){
						$val=explode(',', $val);
					}
					$this->$key=$val;
				}
			}
			$this->_config= $configs;
		}
		/**
		 * 社交账户提取
		 * @param unknown_type $field 要提取的社交媒体字段
		 * @param unknown_type $num 要提取的社交媒体数量
		 * @param unknown_type $assign 是否直接分配到前端 默认不分配
		 */
		protected function GetSocialTools($field='',$num=0, $assign=false){
			//缓存至文件 缓存时间1小时
			$filename=md5('socialTools').'.cache';
			$sys_config_runtime_file=RUNTIME_PATH .'UserCache/'.$filename;
			$cache_interval=3600;
			if(! is_dir(dirname(filemtime($sys_config_runtime_file))))
				mk_dir(dirname($sys_config_runtime_file));
			if(!file_exists($sys_config_runtime_file) || time()- filemtime($sys_config_runtime_file) > $cache_interval){
				//重新获取最新信息
				if(is_array($field)) $field =implode(',', $field);
				if($num<=0){
					$limit='';
				}else{ $limit=$num;
				}
				$tools=M('socialtools')->field($field)->where(array('isopened'=>1))->limit($limit)->select();
				@$fp=fopen($sys_config_runtime_file, 'w');
				fwrite($fp,serialize($tools));
				fclose();
			}else{
				//读取缓存文件
				$tools=unserialize(file_get_contents($sys_config_runtime_file));
			}
			if($assign){
				$this->socialtools=$tools;
			}
			$this->_socialtools= $tools;
		}

		protected function getGoodsCates(){
			//缓存至文件 缓存时间1小时
			$filename=md5('goodsCate').'.cache';
			$sys_config_runtime_file=RUNTIME_PATH .'UserCache/'.$filename;
			$cache_interval=3600;
			if(! is_dir(dirname(filemtime($sys_config_runtime_file))))
				mk_dir(dirname($sys_config_runtime_file));
			if(!file_exists($sys_config_runtime_file) || time()- filemtime($sys_config_runtime_file) > $cache_interval){
				//重新获取最新信息
				$cates=M('category')->field('id, catename')->where('isshow=1 AND parentid=0')->order('sortorder')->select();
				@$fp=fopen($sys_config_runtime_file, 'w');
				fwrite($fp,serialize($cates));
				fclose();
			}else{
				//读取缓存文件
				$cates=unserialize(file_get_contents($sys_config_runtime_file));
			}

			$this->goods_cates= $cates;
		}
		/**
		 * 获取购物车总数缓存
		 */
		protected function getWishlistCount(){
			if (session('member')){
				$count=M('wishlist')->where(array('uid'=>session('member.uid')))->count();
				$member['count']=$count;
			}else{
				$member=false;
			}
			$this->member=$member;
		}
		protected function getNavList(){
			//缓存至文件 缓存时间0.5小时
			$filename=md5('navs').'.cache';
			$sys_config_runtime_file=RUNTIME_PATH .'UserCache/'.$filename;
			$cache_interval=10;
			if(! is_dir(dirname(filemtime($sys_config_runtime_file))))
				mk_dir(dirname($sys_config_runtime_file));
			if(!file_exists($sys_config_runtime_file) || time()- filemtime($sys_config_runtime_file) > $cache_interval){
				//重新获取最新信息
				//获取顶部导航
				$navs=M('navigator')->where(array('isshow'=>1))->select();
				$navs=$this->unlimitedTree($navs);
				@$fp=fopen($sys_config_runtime_file, 'w');
				fwrite($fp,serialize($navs));
				fclose();
			}else{
				//读取缓存文件
				$navs=unserialize(file_get_contents($sys_config_runtime_file));
			}
			$this->navs=$navs;
	}
		protected function getSignalPage(){
			$limit=5;
			$this->signalpages=M('onesignalpage')->field('content,sortorder',true)->where(array('isshow'=>1))->order('sortorder')->limit($limit)->select();
		}
		protected function unlimitedTree($arr=array(), $pid=0){
			$tree=array();
			foreach ($arr as $v){
				if ($v['pid']== $pid){
					$v['childs']=$this->unlimitedTree($arr, $v['id']);
					$tree[]=$v;
				}
			}
			return $tree;
		}
}
