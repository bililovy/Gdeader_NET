<?php 
/**
 * 页面功能简述： 联系我们和关于我们设置
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

class CompanyinfoController extends PrivilegeController{
	/**
	 * 操作 企业简介模块
	 */
	public function Intro(){		
	$DB=M('companyintro');
		if(IS_POST){
			$data=I('post.');
			if($DB->where(array('id'=>$data['id']))->count()>0){
				if ($DB->save($data)){
					$return =array(
						'data'=>'更新成功！',
						'status'=>1
					);
				}else{
					$return =array(
							'data'=>'更新操作失败，请确认是否修改过数据并再次尝试！',
							'status'=>0
					);
				}
			}else{
				//新增数据
				if($newID=$DB->add($data)){
					$return =array(
							'data'=>'成功设置数据！',
							'status'=>1
					);
				}else{
					$return =array(
							'data'=>'网络繁忙，数据写入失败，请稍后再试！',
							'status'=>0
					);
				}
			}
			$this->ajaxReturn($return, 'json');
		}else{
			//显示首页
			$pageinfo=$DB->order('id DESC')->find();
			$this->pageinfo=$pageinfo;
			$this->sessionid=session_id();
			$this->display('com_introduction');
		}	
	}
	/**
	 * 操作关于我们板块
	 */
	public function about(){
		$DB=M('about');
		if(IS_POST){
			$data=I('post.');
			if($DB->where(array('id'=>$data['id']))->count()>0){
				if ($DB->save($data)){
					$return =array(
						'data'=>'更新成功！',
						'status'=>1
					);
				}else{
					$return =array(
							'data'=>'更新操作失败，请确认是否修改过数据并再次尝试！',
							'status'=>0
					);
				}
			}else{
				//新增数据
				if($newID=$DB->add($data)){
					$return =array(
							'data'=>'成功设置数据！',
							'status'=>1
					);
				}else{
					$return =array(
							'data'=>'网络繁忙，数据写入失败，请稍后再试！',
							'status'=>0
					);
				}
			}
			$this->ajaxReturn($return, 'json');
		}else{
			//显示首页
			$pageinfo=$DB->order('id DESC')->find();
			$this->pageinfo=$pageinfo;
			$this->sessionid=session_id();
			$this->display('about');
		}	
	}
	
	/**
	 * 编辑器内容上传
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
	
		$upload->savePath = C('SITE_UPLOAD_ROOT_PATH') . '/image/cominfo/' . $nowdate . '/';
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
			$path='/assets/library/uploads/image/cominfo/' . $nowdate . '/' .$uploadList[0]['savename'];
			$return =array(
					'url' =>$path,
					'error' => 0
			);
		}
		$this->ajaxReturn($return);
	}
}