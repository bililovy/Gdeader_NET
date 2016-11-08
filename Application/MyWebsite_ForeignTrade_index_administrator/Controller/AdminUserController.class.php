<?php
/**
 * 程序版本：JB_Version1.0
 *
 * 开发日期：2015-8-17
 *
 * 开发版权：© 蜗牛兄弟网络科技有限公司
 *
 * 版权申明：此程序仅供成都金标装饰有限公司使用，不得转让和出售，一经发现，将追究其责任
 *
 * 开发申明：蜗牛兄弟 你 不是一个人在战斗。
 *
 *                           商场如战场，枪林弹雨中，双拳终将难敌四手。天时地利终须人和。
 *
 *                           我们是蜗牛兄弟，你成功路上的最佳推手。成功一直在你身边，只需您珍重把握。
 *
 *                           你， 不是一个人在战斗！
 *
 * 程序说明：管理员控制中心
 */
namespace MyWebsite_ForeignTrade_index_administrator\Controller;

use MyWebsite_ForeignTrade_index_administrator\Controller\PrivilegeController;
use MyWebsite_ForeignTrade_index_administrator\Model\AdminuserModel;

class AdminUserController extends PrivilegeController {
	/**
	 * 管理员列表
	 */
	public function index() {
		/*
		 * $count= M('brand')->where(array('isdelete'=>0))->count(); $page = new
		 * PageClass($count,6,$_GET['p'],'?p={page}');//用于静态或者伪静态
		 * $limit=$page->page_limit.",".$page->myde_size; $this->page= $page->
		 * myde_write();
		 */	
		import ( 'Extensions.Page', COMMON_PATH );
		$adminuserdb = new AdminuserModel ();
		$count = $adminuserdb->count ();
		$order='addtime DESC';
		$page = new \Page ( $count, 8, $_GET ['p'], '?p={page}' );
		$limit = $page->page_limit . "," . $page->myde_size;
		$users = $adminuserdb->field ( 'headrealpath,password,lastlogintime', true )->limit ( $limit )->order($order)->select ();
		$this->adminusers = $users;
		$this->page = $page->myde_write ();
		$this->display ( 'adminuser_list' );
	}
	/**
	 * 添加管理员账户
	 */
	public function add(){
		if (IS_POST){
			$data=I('post.');
			$usermodel=new AdminuserModel();
			if($usermodel->create($data,1)){
				$data['addtime']=time();
				$data['password']=md5($data['password']);
				if($newid=$usermodel->add($data)){
					$return=array(
							'data'=>'新增成功！',
							'redirecturl'=>U('index'),
							'status'=>1
					);
				}else{
					$return=array(
							'data'=>'系统繁忙，管理员新增失败，请稍后再试！',
							'status'=>0
					);
				}
			}else{
				$return=array(
						'data'=>$usermodel->getError(),
						'status'=>0
				);
			}
			$this->ajaxReturn($return, 'json');
		}else{
			$this->display('adminuser_add');
		}
	}
	/**
	 * 更新管理员信息
	 * 包括 更新信息 更新密码 删除管理员
	 */
	public function update() {
		if (IS_POST) {
			$data = I ( 'post.' );
			$data ['id'] = intval ( $data ['adminid'] );
			unset ( $data ['adminid'] );
			if (empty ( $data ['id'] ) || $data ['id'] <= 0 || empty ( $data ['handway'] )) {
				$return = array (
						'data' => '执行操作参数缺失，请刷新页面重试！',
						'status' => 0 
				);
				$this->ajaxReturn ( $return, 'json' );
				exit ();
			}
			$adminuser = new AdminuserModel ();
			$return = '';
			switch ($data ['handway']) {
				case 'getinfo' :
					$where ['id'] = $data ['id'];
					$user = $adminuser->field ( 'truename, username, email, canbedelete' )->where ( $where )->find ();
					if ($user && ! empty ( $user )) {
						$user ['adminid'] = $data ['id'];
						$this->user = $user;
						$this->handway = 'getinfo';
						$html = $this->fetch ( 'promptDialog' );
						$return = array (
								'data' => $html,
								'status' => 1 
						);
					} else {
						$return = array (
								'data' => '未查询到管理员信息，请稍后刷新页面重试！',
								'status' => 0 
						);
					}
					break;
				case 'getpwd' :
					$where ['id'] = $data ['id'];
					$user = $adminuser->field ( 'truename' )->where ( $where )->find ();
					if ($user && ! empty ( $user )) {
						$user ['adminid'] = $data ['id'];
						$this->user = $user;
						$this->handway = 'getpwd';
						$html = $this->fetch ( 'promptDialog' );
						$return = array (
								'data' => $html,
								'status' => 1 
						);
					} else {
						$return = array (
								'data' => '未查询到管理员信息，请稍后刷新页面重试！',
								'status' => 0 
						);
					}
					break;
				case 'delete' :
					unset ( $data ['handway'] );
					if ($adminuser->count () > 1) {
						$user = $adminuser->field ( 'canbedelete' )->find ( $data ['id'] );
						if (intval ( $user ['canbedelete'] ) == 0) {
							$return = array (
									'data' => '当前管理员被锁定，无法直接删除。请解锁后方可删除！',
									'status' => 0 
							);
						} else if (intval ($data['id'])==1){
							$return = array (
									'data' => '系统超级管理员不能被删除！',
									'status' => 0
							);
						}else {
							if ($adminuser->delete ( $data ['id'] )) {
								$islogout=0;
								if($data['id'] == intval(session('userid'))){
									logout();
									$islogout=1;							
								}
								$return = array (
											'data' => '删除成功！',
											'islogout'=>$islogout,
											'status' => 1
									);
							} else {
								$return = array (
										'data' => '系统繁忙，管理员删除失败!',
										'status' => 0 
								);
							}
						}
					} else {
						$return = array (
								'data' => '本次管理员删除失败，至少保留一个管理员账户!',
								'status' => 0 
						);
					}
					break;
				case 'setinfo' :
					unset ( $data ['handway'] );
					if ($adminuser->create ( $data, 2 )) {
						if ($adminuser->save ( $data )) {
							$return = array (
									'data' => '更新成功',
									'status' => 1 
							);
						} else {
							$return = array (
									'data' => '更新失败，可能由于你未做任何修改或稍后再试！',
									'status' => 0 
							);
						}
					} else {
						$return = array (
								'data' => $adminuser->getError (),
								'status' => 0 
						);
					}
					break;
				case 'setpwd':
					if ($adminuser->create($data)){
						unset($data['handway']);
						$where=array('id'=>$data['id'], 'password'=>md5(md5($data['oripassword'])));
						if($adminuser->where($where)->count()>0){
							$newdata['id']=$data['id'];
							$newdata['password']=md5(md5($data['password']));
							if ($adminuser->save($newdata)){
								$return=array(
										'data'=>'密码重置成功！',
										'status'=>1
								);
							}else{
								$return=array(
										'data'=>'密码更改失败，可能由于新旧密码相同或稍后再试！',
										'status'=>0
								);
							}
						}else{
							$return=array(
									'data'=>'初始密码不正确，请确认后重试！',
									'status'=>0
							);
						}
					}else{
						$return=array(
								'data'=>$adminuser->getError(),
								'status'=>0
						);
					}
				break;
				default:
				$return=array(
						'data'=>'系统无法找到你要操作的请求，请刷新页面重试！',
						'status'=>0
				);
			}
			if(!empty($return)){
				$this->ajaxReturn($return, 'json');
			}
		}else{
			$this->error('操作请求被拒绝，请通过正确途径访问！');
		}
	}
}