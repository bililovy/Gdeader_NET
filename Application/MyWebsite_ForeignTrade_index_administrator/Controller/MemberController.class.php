<?php 
/**
 * 程序版本：JB_Version1.0
 *
 * 开发日期：2015-8-21
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
 * 程序说明：公司部门管理控制
 */
namespace MyWebsite_ForeignTrade_index_administrator\Controller;
use MyWebsite_ForeignTrade_index_administrator\Controller\PrivilegeController;

class MemberController extends PrivilegeController{
	
	/**
	 * 设计师列表
	 */
	public function index(){		
		$this->display('member_list');
	}
	/**
	 * 新增设计师操作
	 */
	public function add(){
		if(IS_POST){
			$data=I('post.');		
			if (empty($data['navname'])){
				$return =array(
						'status'=>0,
						'data'=>'表单还有错误，请检查后重试！'
						);
				$this->ajaxReturn($return,'json');
				exit;
			}
			$navDB= M('navigator');
			if ($newID= $navDB->add($data)){
				$return=array(
						'status'=>1,
						'data'=>''
						);
			}else {
				$return =array(
						'status'=>0,
						'data'=>'网络繁忙，请稍候再试！'
						);
			}
			$this->ajaxReturn($return,'json');
			exit;
		}
		$this->display('member_add');
	}
	
	/**
	 * 更新设计师信息
	 */
	public function update(){
		if (IS_POST){
			$data=I('post.');
			$data['id']=intval($data['id']);
			if ($data['id']<=0){
				$return=array(
						'data'=>'系统检测到当前操作缺少必需参数，请重新刷新页面后重新尝试！',
						'status'=>0
						);
				$this->ajaxReturn($return, 'json');
				exit;
			}
			if(''===$data['head']){
				if (session('head') && !empty($_SESSION['head'])){
					$data['head'] =session('head');
				}else{
					$data['head']='/Assets/Library/uploads/head/default.jpg';
				}
			}
			if(session('headrealpath') && !empty($_SESSION['headrealpath'])){
				$realpath=M('designer')->field('headrealpath')->where(array('id'=>$data['id']))->find();
				$data['headrealpath'] =session('headrealpath');
			}
			if ($newID=M('designer')->save($data)){
				if (!empty($realpath['headrealpath'])) @unlink($realpath['headrealpath']);
				session('headrealpath', null);
				session('head', null);
				$return=array(
						'data'=>'更新成功',
						'redirecturl'=>U('designer'),
						'status'=>1
				);
			}else{
				$return=array(
						'data'=>'信息更新失败，可能由于你没做任何修改，如有修改，请稍候再次尝试！',
						'status'=>0
				);
			}
			$this->ajaxReturn($return, 'json');
			exit;
		}
		$designerid=I('did', '', 'intval');
		if ($designer=M('designer')->field('addtime', true)->where(array('id'=>$designerid))->find()){
			$this->designer=$designer;
			$this->departments=M('department')->field('id, name')->order('sortorder')->select();
		}else{
			$this->error('参数读取错误，系统根据当前提交信息，未获取到可用信息，请返回稍后刷新页面再次尝试');
			exit;
		}
		$this->display('member_edit');
	}
	/**
	 * 删除设计师
	 */
	public function delete(){
		if (IS_POST){
			$did=I('id', '', 'intval');		
			if ($did>0){
				if (M('navigagor')->delete($did)){				
					$return=array(
							'data'=>'成功删除',
							'status'=>1
							);
				}else{
					$return= array(
							'data'=>'系统繁忙，删除操作失败，请稍后再试！',
							'status'=>0
					);
				}
			}else{
				$return= array(
						'data'=>'系统未检测到操作所需必需参数，请刷新页面重试！',
						'status'=>0
						);
			}
			$this->ajaxReturn($return, 'json');
		}else{
			$this->error('检测到你当前为不合法请求，系统拒绝此次访问，请通过合法途径访问');
		}
	}
	/**
	 * 封面图片上传
	 */
	public function headUpload(){
		if(	session('head') && session('headrealpath')){
			unlink(session('headrealpath'));
			session('head',null);
			session('headrealpath', null);
		}
		import("Extensions.UploadFile", COMMON_PATH);
		//导入上传类
		$upload = new \UploadFile();
		//设置上传文件大小
		$upload->maxSize = 4194304; //最大4M
		//设置上传文件类型
		$upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
		//设置附件上传目录
		$nowdate= date('Ymd', time());
		$upload->savePath = SITE_UPLOAD_ROOT_PATH . 'head/';
		//设置上传文件规则
		$upload->saveRule ='uniqid';
		//删除原图
		$upload->thumbRemoveOrigin = true;
		if (!$upload->upload()) {
			//捕获上传异常
			$return =array(
					'data' =>$upload->getErrorMsg(),
					'status' => 0
			);
		} else {
			//取得成功上传的文件信息
			$uploadList = $upload->getUploadFileInfo();
			$domain=C('DOMAIN');
			if(!empty($domain)){
				$domain='http://'. $domain;
			}
			$path=$domain .'/Assets/Library/uploads/head/' .$uploadList[0]['savename'];
			$realpath=$upload->savePath . $uploadList[0]['savename'];
			session('head', $path);
			session('headrealpath', $realpath);
			$return =array(
					'data' =>$path,
					'status' => 1
			);
		}
		header('Content-Type:text/html; charset=utf-8');
		exit(json_encode($return));
	}
	
}