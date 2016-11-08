<?php
/**
 * 页面功能简述： 单页管理系统
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

use MyWebsite_ForeignTrade_index_administrator\Controller\PrivilegeController;

class SignalpageController extends PrivilegeController{
	public function add(){
		if (IS_POST){
			$DB=M('onesignalpage');
			if($DB->count()>15){
				$return =array(
						'data'=>'当前系统最多能定义15个单页面，已达到最大数量，无法再增加。确需增加，请先删除之前的某些单页面后再次尝试！',
						'status'=>0
				);
				$this->ajaxReturn($return , 'json');
				exit;
			}
			$data=I('post.');
			if(empty($data['title'])){
				$return =array(
						'data'=>'请填入页面标题',
						'status'=>0
				);
			$this->ajaxReturn($return , 'json');
			exit;
			}
			if($newid=$DB->add($data)){
				$return =array(
						'data'=>'单页设置成功',
						'redirecturl'=>U('pageSet', array('pageid'=>$newid,'justfrom'=>'addsignalpage')),
						'status'=>1
				);	
			}else{
				$return =array(
						'data'=>'系统繁忙，但也设置失败',
						'status'=>0
				);
			}
			$this->ajaxReturn($return, 'json');
			exit;
		}
		$this->sessionid=session_id();
		$this->display('page_add');
	}
	
	/**
	 * 单页查看
	 */
	public function pageSet(){
		$pageid=I('pageid',0,'intval');
		$DB=M('onesignalpage');
		$pageExist=$DB->where(array('id'=>$pageid))->count();
		if($pageExist<=0){
			$this->error('系统无法获取当前查看的单页信息,可能已经删除，请确认操作无误并重新再次尝试！',U('add'),8);
			exit;
		}else{
			$pageinfo=$DB->where(array('id'=>$pageid))->find();
			$this->pageinfo=$pageinfo;
			$this->sessionid=session_id();
			$this->display('page_info');
		}
	}
	/**
	 * 对单页进行更新和删除操作
	 */
	public function update(){
		$data=I('post.');	
			if($data['id']>0){		
				$DB=M('onesignalpage');
				switch($data['handleway']){
					case 'update': 
						unset($data['handleway']);
						if($effects=$DB->save($data)){
							$return =array(
									'data'=>'成功更新数据！',
									'status'=>1
							);
						}else{
							$return =array(
									'data'=>'更新失败，请确认是否修改了数据，如有修改，请再次尝试！',
									'status'=>0
							);
						}
					break;
					case 'delete':
						unset($data['handleway']);
						if($effect=$DB->delete($data['id'])){
							$return =array(
									'data'=>'删除成功！',
									'redirecturl'=>U('add'),
									'status'=>1
							);
						}else{
							$return =array(
									'data'=>'目前系统繁忙，删除失败，请稍后重试！',
									'status'=>0
							);
						}
					break;
					default:
						$return =array(
								'data'=>'系统无法识别此次操作请求，请刷新页面重新尝试！',
								'status'=>0
						);						
				}	
			}else{
				$return =array(
						'data'=>'此次请求参数发生错误，请刷新页面再次尝试！！',
						'status'=>0
				);
			}		
			$this->ajaxReturn($return, 'json');
	}
	/**
	 * 页面主体内容图片上传
	 */
	public function contentUpload(){
		import("Extensions.UploadFile", COMMON_PATH);
		//导入上传类
		$upload = new \UploadFile();
		//设置上传文件大小
		$upload->maxSize = 4194304; //最大4M
		//设置上传文件类型
		$upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
		//设置附件上传目录
		$nowdate= date('Ymd', time());
		
		$upload->savePath = C('SITE_UPLOAD_ROOT_PATH') . '/image/signalpage/' . $nowdate . '/';
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
					'url' =>$upload->getErrorMsg(),
					'error' => 1
			);
		} else {
			//取得成功上传的文件信息
			$uploadList = $upload->getUploadFileInfo();		
			$path='/assets/library/uploads/image/signalpage/' . $nowdate . '/' .$uploadList[0]['savename'];
			$return =array(
					'url' =>$path,
					'error' => 0
			);
		}
		$this->ajaxReturn($return);
	}
}