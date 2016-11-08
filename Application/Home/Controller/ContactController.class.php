<?php
/**
 * 页面功能简述：联系我们控制器
 * 
 * 开发负责人：吴思阳    联系邮箱：1985277517@qq.com  联系QQ: 1985277517  
 * 
 * 合同协议：成都万应网络科技有限公司（http://www.cduwin.com）是成都高质量的网络应用开发、网站建设、wap/微信开发科技公司，
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

class ContactController extends EmptyController{
	/**
	 * 联系我们页面
	 */
	public function index(){
		//获取提问类型
		$this->msgtypes=M('msgtype')->field('id,typename')->order('sortorder')->select();
		//------页面信息---//
		$pageinfo=array(
				'pagetitle'=>'Contact us'
		);
		$this->pageinfo=$pageinfo;
		//------页面信息---//
		$this->display('contact');
	}
	public function mapApi(){
		$this->display('mapApi');
	}
	/**
	 * 前端留言处理
	 * 
	 */
	public function message(){
		if(IS_POST){
			$data=I('post.');
			if(empty($data['uname']) || empty($data['email']) || empty($data['msgtype']) || strlen($data['message'])<10){
				$return =array(
						'data'=>'Please complete the form and try again !',
						'status'=>0
				);
			}else{
				if(isset($data['from']) && empty($data['from']) && $data['from']==='contact'){
					$data['subject']='Message From Contact Page';
				}else if (isset($data['from']) && empty($data['from']) && $data['from']==='index'){
					$data['subject']='Message From Index Page';
				}
				unset($data['from']);
				$data['addtime']=time();
				$data['ishandled']=0;
				if ($newID=M('message')->add($data)){
					$return =array(
							'data'=>'Send Success !',
							'status'=>1
					);
				}else{
					$return =array(
							'data'=>'Net Busy, please try again later !',
							'status'=>0
					);
				}
			}
			$this->ajaxReturn($return, 'json');
		}else{
			$this->error('Access Denyed By the Server Because a Problem Occured By Your Incorrect Access !');
		}	
	}

}