<?php 
/**
 * 页面功能简述： 焦点图配置控制
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
 * 更新日期：2015-11-17
 * 
 */
namespace MyWebsite_ForeignTrade_index_administrator\Controller;

use MyWebsite_ForeignTrade_index_administrator\Controller\PrivilegeController;

class FocusController extends PrivilegeController{
	/**
	 * 系统首页焦点图
	 */
	public function index(){
		$focusDB=M('focus');
		import ( 'Extensions.Page', COMMON_PATH );
		$count= $focusDB->count();
		$page=new \Page($count,8,$_GET['p'],'?p={page}');
		$limit=$page->page_limit.",".$page->myde_size;
		$order='sortorder';
		$focuses=$focusDB->order($order)->limit($limit)->select();
		$this->focuses=$focuses;
		$this->page=$page->myde_write();
		$this->display('focus_list');
	}
	/**
	 * 系统焦点图添加
	 *
	 */
	public function focusadd(){
		if (IS_POST){
			$data=I('post.', '');
			if ($data){
				$focusDB=M('focus');
				if(session('coverrealpath') && !empty($_SESSION['coverrealpath'])){
					$data['coverrealpath']=session('coverrealpath');
				}
				if (empty($data['cover'])){
					if (session('cover') && !empty($_SESSION['cover'])){
						$data['cover'] =session('cover');
					}else{
						$data['cover']='/assets/common/images/icons/default_focus.jpg';
					}
				}
				if($data['isshow']==1){
					if ($focusDB->where(array('isshow'=>1))->count()>=5)	$data['isshow']=0;
				}
				if ($newid=$focusDB->add($data)){
					session('coverrealpath', null);
					session('cover', null);
					$return=array(
							'data'=>'焦点图添加成功',
							'redirecturl'=>U('index'),
							'status'=>1
					);
				}else{
					$return =array(
							'data'=>'网络繁忙，焦点图片添加失败，请重新尝试！',
							'status'=>0
					);
				}
			}else{
				$return =array(
						'data'=>'系统没有检测到你提交的信息，添加失败，请稍后重新刷新页面再次尝试添加！',
						'status'=>0
				);
			}
			$this->ajaxReturn($return ,'json');
			exit;
		}
		$this->display('focus_add');
	}
	/**
	 * 更新焦点图信息
	 */
	public function focusUpdate(){
		if (IS_POST){
			$data=I('post.');
			$focusDB=M('focus');
			if(session('coverrealpath') && !empty($_SESSION['coverrealpath'])){
				$realpath=$focusDB->field('coverrealpath')->find($data['id']);		
				$data['coverrealpath']=session('coverrealpath');
			}
			if (empty($data['cover'])){
				if (session('cover') && !empty($_SESSION['cover'])){
					$data['cover'] =session('cover');
				}else{
					$data['cover']='/assets/common/images/icons/default_focus.jpg';
				}
			}
			if($data['isshow']==1){
				if (! $focusDB->where(array('isshow'=>1, 'id'=>$data['id']))->find()){
					if ($focusDB->where(array('isshow'=>1))->count()>=5){
						$return=array(
								'data'=>'焦点图启用数量最多为5个，当前焦点图启用的数量已达到最大，如需启用此焦点图，请先取消一个其他焦点图的启用。',
								'status'=>0
						);
						$this->ajaxReturn($return ,'json');
						exit;
					}
				}
			}
			if ($focusDB->save($data)){		
				@unlink($realpath['coverrealpath']);
				session('coverrealpath', null);
				session('cover', null);
				$return=array(
						'data'=>'焦点图更新成功',
						'status'=>1
				);
			}else{
				$return =array(
						'data'=>'焦点图更新失败，可能因为你没做任何数据修改，<br />如果有修改数据，请稍后刷新页面重新尝试！',
						'status'=>0
				);
			}
			$this->ajaxReturn($return ,'json');
			exit;
		}
		$focusid=I('fid', '0', 'intval');
		if ($focusid>0){
			$focus=M('focus')->find($focusid);
			if ($focus){
				$this->focus=$focus;
				$this->display('focus_edit');
			}else{
				$this->error('请求错误，系统未找到当前编号的焦点图信息，请返回之前页面，刷新页面再次尝试！', '', 10);
			}
		}else{
			$this->error('系统未检测到此操作所必需的参数，请刷新之前页面后重新尝试!', '',8);
		}
	}
	/**
	 * 更新其他信息
	 */
	public function focusModify(){
		if (IS_POST){
			$data=I('post.');
			if (intval($data['id'])>0){
				$focusDB=M('focus');
				switch($data['handway']){
					case 'updateshow':
						unset($data['handway']);
						if ($data['isshow']==1){
							if ($focusDB->where(array('isshow'=>1))->count()>=5){
								$return=array(
										'data'=>'焦点图可用数量最多为5个，当前焦点图启用的数量已达到最大，如需启用此焦点图，请先取消一个其他焦点图的启用。',
										'status'=>0
								);
								$this->ajaxReturn($return ,'json');
								exit;
							}
						}
						if ($focusDB->save($data)){
							$return=array(
									'data'=>'焦点图启用成功',
									'status'=>1
							);
						}else{
							$return=array(
									'data'=>'网络繁忙，焦点图启用失败，请稍候重试！',
									'status'=>0
							);
						}
						break;
					case 'delete' :
						$id=intval($data['id']);
						unset($data);
						$realpath=$focusDB->field('coverrealpath')->find($id);
						if ($focusDB->delete($id)){
							@unlink($realpath['coverrealpath']);
							$return =array(
									'data'=>U('focus'),
									'status'=>1
							);
						}else{
							$return =array(
									'data'=>'系统繁忙，焦点图删除失败，请稍候再试！',
									'status'=>0
							);
						}
						break;
					default:
						$return =array(
						'data'=>'系统无法识别你的此次请求，可能由于网络原因导致参数出错，请刷新页面重新尝试！',
						'status'=>0
						);
				}
			}else{
				$return =array(
						'data'=>'系统未检测到当前操作所需的必需参数，请刷新页面重新尝试！',
						'status'=>0
				);
			}
			$this->ajaxReturn($return ,'json');
			exit;
		}else{
			$this->error('系统拒绝本次请求，请通过合法途径访问！','', 5);
		}
	}
	/**
	 * 焦点图
	 */
	public function coverUpload(){
		if(	session('cover') && session('coverrealpath')){
			unlink(session('coverrealpath'));
			session('cover',null);
			session('coverrealpath', null);
		}
		import("Extensions.UploadFile", COMMON_PATH);
		//导入上传类
		$upload = new \UploadFile();
		//设置上传文件大小
		$upload->maxSize = 4194304; //最大4M
		//设置上传文件类型
		$upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
		//设置附件上传目录		
		$upload->savePath = C('SITE_UPLOAD_ROOT_PATH') . '/image/focus/';
		if(!is_dir($upload->savePath)){
			mk_dir($upload->savePath);
		}
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
			$path='/assets/library/uploads/image/focus/' .$uploadList[0]['savename'];
			$realpath=$upload->savePath . $uploadList[0]['savename'];
			session('cover', $path);
			session('coverrealpath', $realpath);
			$return =array(
					'data' =>$path,
					'status' => 1
			);
		}
		header('Content-Type:text/html; charset=utf-8');
		exit(json_encode($return));
	}
}