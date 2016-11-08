<?php
/**
 * 页面功能简述： 前端会员管理
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
 * 更新日期：2016-7-3
 *
 */

namespace Home\Controller;

use Think\Verify;

use Home\Controller\EmptyController;
class MemberController extends EmptyController{
	public function login(){
		if(IS_POST){
			$data=I('post.');
			$return='';
			if (empty($data['account'])){
				$return =array(
						'status'=>0,
						'data'=>'Please check your account'
				);
			}
			if (empty($data['password'])){
				$return =array(
						'status'=>0,
						'data'=>'Please check your password'
				);
			}
			if (empty($return)){
				$data['password']=md5(md5($data['password']));
				$user=M('member')->field('isable','nickname',true)->where(array('nickname'=>$data['account'], 'email'=>$data['account'],'_logic'=>'or'))->find();
				if($user && $user['password'] == $data['password']){
					$_SESSION['member']['SIGNIN_AUTHKEY']='ALLOW_IN';
					$_SESSION['member']['uid']=$user['id'];
					$_SESSION['member']['username']=$user['nickname'];
					$_SESSION['member']['email']=$user['email'];
					$newData=array('id'=>$user['id'],'logintimes'=>$user['logintimes']+1);
					M('member')->save($newData);
					$return =array(
							'status'=>1,
							'data'=>'Login successfully ! The system is going to home…'
					);
				}else{
					$return =array(
							'status'=>0,
							'data'=>'Please check your account or password !'
					);
				}
			}
			$this->ajaxReturn($return,'json');
			exit;
		}
        $pageinfo=array(
				'pagetitle'=>'Member login',
				'description'=>'To login our website, you can get more service provided.',
				'breadcrumb'=>array('login')
				);
		$this->pageinfo=$pageinfo;
		$this->display();
	}
	public function exitSign(){
		session('member',null);
		$this->redirect('login');
	}
	public function regist(){
		if (IS_POST){
			$data=I('post.');
			$pass=true;
			if(strlen($data['nickname'])<5 || strlen($data['nickname'])>40){
				$pass=false;
				$error='Please check your nickname';
			}
			if(!preg_match("/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $data['email'])){
				$pass=false;
				$error='Please check your email';
			}
			if (strlen($data['pwd'])<6 || strlen($data['pwd'])>16){
				$pass=false;
				$error='Please check your password';
			}
			if ($pass){
				$Verify = new Verify();
				if($Verify->check($data['captcha'], 1)){
					$data['isable']=1;
					$data['password']=md5(md5($data['pwd']));
					unset($data['repwd']);
					unset($data['captcha']);
					unset($data['pwd']);
					if ($newID=M('member')->add($data)){
						$return=array(
								'status'=>1,
								'data'=>'Regist successfully, page is redirecting…'
						);
					}else{
						$return=array(
								'status'=>0,
								'data'=>'Sorry ! The system is busy, try agin later !'
						);
					}
				}else{
					$return=array(
							'status'=>0,
							'data'=>'Incorrect Verify Code'
					);
				}
			}else{
				$return=array(
						'status'=>0,
						'data'=>$error
						);
			}
			$this->ajaxReturn($return,'json');
			exit;
		}
		$pageinfo=array(
				'pagetitle'=>'Member Registe',
				'description'=>'To regist our website, you can get more service provided.',
				'breadcrumb'=>array('regist')
				);
		$this->pageinfo=$pageinfo;
		$this->display();
	}
	/**
	 * 验证码获取
	 *
	 * 采用TP默认验证码类
	 */
	public function captcha(){
		$config =    array(
				'fontSize'    =>   13,    // 验证码字体大小
				'length'      =>    4,     // 验证码位数
				'imageW'=>100,
				'imageH'=>45,
		);
		$Verify = new Verify($config);
		$Verify->entry(1);
	}
}