<?php
/**
 * 页面功能简述： 网站后端登录控制器
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

namespace MyWebsite_ForeignTrade_index_administrator\Controller;
use Think\Verify;
use MyWebsite_ForeignTrade_index_administrator\Controller\EmptyController;
use MyWebsite_ForeignTrade_index_administrator\Model\AdminuserModel;

class SignController extends EmptyController{
	/**
	 * 登录跳转方法
	 * 
	 * login函数做跳转，到index
	 */
	public function login(){
		$this->redirect('index');
	}
	/**
	 * 登录执行方法
	 */
	public function index(){
		//判断数据处理方式 		
		if(IS_POST){
			$data['username']=I('username', '');
			$data['password']=I('password', '', 'md5');
			$data['captcha']=I('captcha', '');
			$userdb=new AdminuserModel();
				$Verify = new Verify();
				if($Verify->check($data['captcha'], 1)){
					if ($userinfo=$userdb->checkSign($data)){
						$logininfo=array(
								'username'=> $data['username'],
								'truename' =>$userinfo['truename'],
								'userid' =>$userinfo['id'],
								'adminrole' =>$this->getRole ( $userinfo ['id'] ),
								'roledesc'=>$userinfo['roledesc'],
								'logintimes' =>$userinfo['logintimes']+1,
								'lastloginip' => ($userinfo ['lastloginip'] == '') ? '未登录过本系统' : $userinfo ['lastloginip'],
								'lastlogintime' => ($userinfo['lastlogintime']==0) ? '未登陆过本系统' : date('Y年m月d日 H:i' ,$userinfo['lastlogintime']), 
								);
						session('ADMIN_AUTH_KEY', 'ALLOW_IN'); 						
						session ( 'login_infos', $logininfo );
						//更新部分数据
						$newdata=array(
								'lastlogintime'=>time(),
								'logintimes'=>$userinfo['logintimes']+1,
								'lastloginip' =>$this->getRealIp(),
								'id'=>$userinfo['id'],
								);
						$userdb->loginUpdate($newdata);
						$return =array(
								'data'=>U('Index/index'),
								'status'=>1
								);
					}else{
						 $return=array(
								'data'=>'用户名或密码错误',
								'status'=>0
								); 						
					}
				}else{
					$return=array(
							'data'=>'验证码错误',
							'status'=>2
							);
				}
			$this->ajaxReturn($return, 'json');
		}else{
			if(session('ADMIN_AUTH_KEY') !=='ALLOW_IN' || !isset($_SESSION['username'])){
				$this->logined=false;
			}else{
				$this->logined=true;
			}		
			/***BEGIN 网站基本信息获取**/
			$config=$this->GetWebConfig(array('webname'));
			$pageinfo=array(
					'pagetitle'=>$config['webname']
			);
			/***END 网站基本信息获取**/
			$this->pageinfo=$pageinfo;
			$this->display('login');
		}		
	}
	
	private function getRealIp() {
		$ip = '';
		if (! empty ( $_SERVER ["HTTP_CLIENT_IP"] )) {
			$ip = $_SERVER ["HTTP_CLIENT_IP"];
		}
		if (! empty ( $_SERVER ['HTTP_X_FORWARDED_FOR'] )) {
			$ips = explode ( ", ", $_SERVER ['HTTP_X_FORWARDED_FOR'] );
			if ($ip) {
				array_unshift ( $ips, $ip );
				$ip = false;
			}
			for($i = 0; $i < count ( $ips ); $i ++) {
				if (! eregi ( "^(10│172.16│192.168).", $ips [$i] )) {
					$ip = $ips [$i];
					break;
				}
			}
		}
		return ($ip ? $ip : $_SERVER ['REMOTE_ADDR']);
	}
	
	/**
	 * 验证码获取
	 * 
	 * 采用TP默认验证码类
	 */
	public function captcha(){
		$config =    array(
				'fontSize'    =>    18,    // 验证码字体大小
				'length'      =>    5,     // 验证码位数
				'imageW'=>155, 
				'imageH'=>40, 
		);
		$Verify = new Verify($config);
		$Verify->entry(1);
	}
	
	public function exitsign(){
		//清掉记录数据并跳回登录首页
		logout();
		$this->redirect('Index/index');
	}
	/**
	 * 获取管理员角色名称
	 */
	private function getRole($id = 1) {
		if ($id <=0){
			return '未知用户组';
		}else if ( $id==1){
			return '系统超级管理员';
		}else{
			// 去检查角色
			$rolename = '网站管理员';
		}
		return $rolename;
	}
}