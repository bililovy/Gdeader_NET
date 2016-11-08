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

            if(!preg_match("/^(?:\w+\.?)*\w+@(?:\w+\.)*\w+$/i", $data['account'])){
                echo '<script type="text/javascript">window.parent.promptTips(\'Incorrect Email Address, Please check your account,  !\',3000,1);</script>';
                exit;
            }
            if (strlen($data['password'])<6 || strlen($data['password'])>20){
                echo '<script type="text/javascript">window.parent.promptTips(\'Please check your password !\',3000,2);</script>';
                exit;
            }

				$data['password']=md5(md5($data['password']));
				$user=M('member')->field('isable','nickname',true)->where(array( 'email'=>$data['account']))->find();

            if($user && $user['password'] == $data['password']){
					$_SESSION['member']['SIGNIN_AUTHKEY']='ALLOW_IN';
					$_SESSION['member']['uid']=$user['id'];
					$_SESSION['member']['username']=$user['nickname'];
					$_SESSION['member']['email']=$user['email'];
					$newData=array('id'=>$user['id'],'logintimes'=>$user['logintimes']+1);
					M('member')->save($newData);

                    echo '<script type="text/javascript">window.parent.promptTips(\'Login successfully ! The system is going to home…\',3000,0,true);</script>';
                    exit;

				}else{
                    echo '<script type="text/javascript">window.parent.promptTips(\'Please check your account or password !\',3000,0);</script>';
                    exit;

				}
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
			if(strlen($data['nickname'])<5 || strlen($data['nickname'])>40){

                echo '<script type="text/javascript">window.parent.promptTips(\'Please check your nickname\',3000,1);</script>';
				exit;
			}
			if(!preg_match("/^(?:\w+\.?)*\w+@(?:\w+\.)*\w+$/i", $data['email'])){
                echo '<script type="text/javascript">window.parent.promptTips(\'Please check your email !\',3000,2);</script>';
                exit;
			}
			if (strlen($data['pwd'])<6 || strlen($data['pwd'])>20){
                echo '<script type="text/javascript">window.parent.promptTips(\'Please check your password, it should be 6-20 charts !\',3000,3);</script>';
                exit;
			}
			if ($data['repass'] !== $data['pwd']){
                echo '<script type="text/javascript">window.parent.promptTips(\'The confirm password is not the same with the last one !\',3000,4);</script>';
                exit;
			}
				$Verify = new Verify();
				if($Verify->check($data['captcha'], 1)){
				    if(M('member')->where(array('email'=>$data['email']))->count()>0){
                        echo '<script type="text/javascript">window.parent.promptTips(\'Whoopse! The email has existed, change another one please !\',5000);</script>';
                        exit;
                    }
					$data['isable']=1;
					$data['password']=md5(md5($data['pwd']));
					unset($data['repwd']);
					unset($data['captcha']);
					unset($data['pwd']);
					if ($newID=M('member')->add($data)){

                        echo '<script type="text/javascript">window.parent.promptTips(\'Regist successfully, page is redirecting… !\',1500,0,true);</script>';
                        exit;
					}else{
                        echo '<script type="text/javascript">window.parent.promptTips(\'Sorry ! The system is busy, try agin later !\',3000);</script>';
                        exit;
					}
				}else{
                    echo '<script type="text/javascript">window.parent.promptTips(\'Incorrect Verify Code !\',3000,5);</script>';
                    exit;
				}
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
				'fontSize'    =>   23,    // 验证码字体大小
				'length'      =>    6,     // 验证码位数
				'imageW'=>300,
				'imageH'=>40,
		);
		$Verify = new Verify($config);
		$Verify->entry(1);
	}
}