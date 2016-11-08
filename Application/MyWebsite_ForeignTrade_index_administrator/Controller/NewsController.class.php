<?php 
/**
 * 页面功能简述： 新闻管理系统
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
use MyWebsite_ForeignTrade_index_administrator\Model\NewsModel;
use MyWebsite_ForeignTrade_index_administrator\Controller\PrivilegeController;

class NewsController extends PrivilegeController{
	/**
	 * 展示新闻列表
	 */
	public function index(){
		/*
		 * $count= M('brand')->where(array('isdelete'=>0))->count(); $page = new
		* PageClass($count,6,$_GET['p'],'?p={page}');//用于静态或者伪静态
		* $limit=$page->page_limit.",".$page->myde_size; $this->page= $page->
		* myde_write();
		*/
		$newsdb=M('news');
		import ( 'Extensions.Page', COMMON_PATH );
		$count= $newsdb->count();
		$page=new \Page($count,10,$_GET['p'],'?p={page}');
		$limit=$page->page_limit.",".$page->myde_size;
		$news=$newsdb->field('id,title,isshow,addtime,author, click,cover, sortorder')->order('addtime DESC')->limit($limit)->select();
		$this->news=$news;
		$this->page =$page->myde_write();
		$this->display('news_list');
	}
	/**
	 * 添加新闻
	 */
	public function add(){
		if(IS_POST){			
			$data=I('post.');
			$newsmodel=new NewsModel();
			if ($newsmodel->create($data,1)){
				if(isset($_SESSION['coverrealpath']) && !empty($_SESSION['coverrealpath'])) $data['coverrealpath'] =session('coverrealpath');
				if(empty($data['cover']) || !isset($data['cover'])){
					if(isset($_SESSION['cover']) && !empty($_SESSION['cover'])){
						$data['cover'] =session('cover');
					}else{
						$data['cover']='/assets/common/images/icons/news_no_img.jpg';
					}
				}
				$data['addtime']=time();
				if($newid=$newsmodel->add($data)){
					session('cover', null);
					session('coverrealpath', null);
					$return =array(
							'data'=>'添加成功',
							'redirecturl'=>U('News/index'),
							'status'=>1
					);
				}else{
					$return =array(
						'data'=>'对不起，系统繁忙，新闻添加失败，请稍后再重试！',
						'status'=>0
						);
				}				
			}else{
				$return =array(
						'data'=>$newsmodel->getError(),
						'status'=>0
				);
			}
			$this->ajaxReturn($return);
			exit;
		}
		$this->sessionid=session_id();
		$this->display('news_add');
	}
	
	/**
	 * 更新新闻信息
	 * 
	 */
	public function update(){
		if (IS_POST){
			$data= I('post.');
			$data['id']=intval($data['id']);
			if ($data['id']<=0 || empty($data['handway'])){
				$return=array(
						'data'=>'系统操作所需参数缺失，请刷新页面重试！',
						'status'=>0
						);
				exit;
			}
			switch($data['handway']){
				case 'updateshow' :
					unset($data['handway']);
					if(M('news')->save($data)){
						$return=array(
								'data'=>'更新成功',
								'status'=>1
						);
					}else{
						$return=array(
								'data'=>'系统繁忙，更新操作失败，请稍后尝试！',
								'status'=>0
						);
					}
				break;
				case 'updateinfo':
					unset($data['handway']);
					if(isset($_SESSION['coverrealpath']) && !empty($_SESSION['coverrealpath'])){
						$realpath=M('news')->field('coverrealpath')->where(array('id'=>$data['id']))->find();
						$data['coverrealpath'] =session('coverrealpath');
					}
					if(empty($data['cover']) || !isset($data['cover'])){
						if(isset($_SESSION['cover']) && !empty($_SESSION['cover'])){
							$data['cover'] =session('cover');
						}else{
							$data['cover']='/assets/common/images/icons/news_no_img.jpg';
						}
					}
					if(M('news')->save($data)){
						if (!empty($realpath['coverrealpath'])) @unlink($realpath['coverrealpath']);
						session('cover', null);
						session('coverrealpath', null);
						$return=array(
								'data'=>'更新成功',
								'status'=>1
						);
					}else{
						$return=array(
								'data'=>'更新操作失败，您可能没有修改任何内容或请稍后尝试！',
								'status'=>0
						);
					}
				break;
				default: 
					$return=array(
							'data'=>'系统无法识别您的操作，请刷新页面重新尝试！',
							'status'=>0
					);
			}
			$this->ajaxReturn($return);
		}else{
			$nid=I('id', '', 'intval');
			if ($nid>0){
				$new=M('news')->find($nid);
				if ($new){
					$this->sessionid=session_id();
					$this->new=$new;
					$this->display('news_edit');
				}else{					
				$this->error('系统未查询到此条新闻信息，请重新尝试！');
				exit;
				}
			}else{
				$this->error('该操作所需参数缺失，请刷新页面重试！');
				exit;
			}
		}
	}
	/**
	 * 彻底删除
	 */
	public function delete(){
		if(IS_POST){
			$id=I('id', '','intval');
			if ($id>0){
				if (M('news')->delete($id)){
					$return=array(
							'data'=>U('News/index'),
							'status'=>1
					);
				}else{
					$return=array(
							'data'=>'系统繁忙，删除失败，请稍后重试！',
							'status'=>0
					);
				}
			}else{
				$return=array(
						'data'=>'系统操作缺少必需参数，请刷新重试！',
						'status'=>0
				);
			}
			$this->ajaxReturn($return);
		}else{
			$this->error('系统拒绝通过此方式直接访问本页面，请通过正确途径访问！');
		}
	}
	
	/**
	 * 封面上传
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
		$nowdate= date('Ymd', time());				
		$upload->savePath = C('SITE_UPLOAD_ROOT_PATH') . '/image/news/cover/' . $nowdate . '/';
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
			$path='/assets/library/uploads/image/news/cover/' . $nowdate .'/' .$uploadList[0]['savename'];
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
	
	/**
	 * 新闻内容图片上传控制
	 */
	public function contentIMGUpload(){
		import("Extensions.UploadFile", COMMON_PATH);
		 //导入上传类
		$upload = new \UploadFile();
		 //设置上传文件大小
		$upload->maxSize = 4194304; //最大4M
		 //设置上传文件类型
		$upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
		 //设置附件上传目录
		 $nowdate= date('Ymd', time());
		$upload->savePath = C('SITE_UPLOAD_ROOT_PATH') . '/image/news/' . $nowdate . '/';
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
		   	$path='/assets/library/uploads/image/news/' . $nowdate . '/' .$uploadList[0]['savename'];
		   	$return =array(
		   			'url' =>$path,
		   			'error' => 0
		   	);
		 }
		 $this->ajaxReturn($return);
	}
}