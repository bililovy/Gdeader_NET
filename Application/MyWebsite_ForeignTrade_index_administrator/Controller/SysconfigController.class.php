<?php
/**
 * 页面功能简述： 系统配置
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

class SysconfigController extends PrivilegeController{

	public function index(){
		$sysDB=M('sysconfig');
		if(IS_POST){
			$data=I('post.');
			if(empty($data['webname'])){
				$return=array(
						'data'=>'请填写网站名称！',
						'status'=>0
				);
				$this->ajaxReturn($return, 'json');
				exit;
			}
			if($sysconf=$sysDB->field('id,logorealpath')->find()){
				if(session('coverrealpath')) $data['logorealpath'] = session('coverrealpath');
				$data['id']=$sysconf['id'];
				if($sysDB->save($data)){
					if(session('coverrealpath')){
						@unlink($sysconf['logorealpath']);
						session('cover', null);
						session('coverrealpath', null);
					}
					$return=array(
							'data'=>'数据更新成功',
							'status'=>1
					);
				}else{
					$return=array(
							'data'=>'数据更新不成功，请确认数据是否有修改，稍后再次尝试！',
							'status'=>0
					);
				}
			}else{
				if($sysDB->add($data)){
					session('cover', null);
					session('coverrealpath', null);
					$return=array(
							'data'=>'配置成功',
							'status'=>1
					);
				}else{
					$return=array(
							'data'=>'数据添加失败',
							'status'=>0
					);
				}
			}
			$this->ajaxReturn($return , 'json');
			exit;
		}
		$sysconfig=$sysDB->find();
		$this->sysconfig=$sysconfig;
		$this->display('sysconfig');
	}

	/**
	 * 社交媒体设置
	 */
	public function socialMedia(){
		$socialMedias=M('socialtools');
		if(IS_POST){
			$data=I('post.');
			$exepArr=array();
			$updateData=array();
			foreach($data['isopened'] as $key=>$val){
				if(1==$val){
					if(empty($data['account'][$key])){
						$exepArr[]=$data['toolname'][$key];
					}
				}
				$updateData[$key]['toolname']=$data['toolname'][$key];
				$updateData[$key]['isopened']=$val;
				$updateData[$key]['account']=$data['account'][$key];
			}
			if(empty($exepArr)){
				foreach($updateData as $val){
					$socialMedias->where(array('toolname'=>$val['toolname']))->save($val);
				}
				$this->success('更改成功，请点击返回！','',3);
				exit;
			}else{
				$explist=implode(',', $exepArr);
				$this->error('<b style="color: #EAC127;">'.$explist.'</b>设置了“开启”，因此这'.count($exepArr).'个社交账户不能为空，请返回重新设置！',U('socialMedia'),10);
			}
			exit;
		}
		$medias=$socialMedias->where(true)->select();

		$this->medias=$medias;
		$this->display('social_list');
	}
	/**
	 * 清除缓存
	 */
	public function clearCache(){
		if(IS_POST){
			$clear=I('clear','');
			switch($clear){
				case 'ALLCACHE':
					if(rm_dir(RUNTIME_PATH)){
						$return =array(
								'data'=>'缓存清理成功！',
								'status'=>1
						);
					}else{
						$return =array(
								'data'=>'系统繁忙，请稍后再试！',
								'status'=>0
						);
					}
					break;
				default:
					$return =array(
					'data'=>'系统无法识别此次请求，请刷新页面再次尝试！',
					'status'=>0
					);
			}
			$this->ajaxReturn($return,'json');
		}else{
			$this->error('访问不合法，系统拒绝此次访问，请通过正确途径访问！','',6);
		}
	}

	/**
	 * 焦点图
	 */
	public function imgUpload(){
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
		$upload->savePath = C('SITE_UPLOAD_ROOT_PATH') . '/image/logo/';
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
			$path='/assets/library/uploads/image/logo/' .$uploadList[0]['savename'];
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

	public function navs(){
 		$navs=M('navigator')->order('sortorder')->select();
//  		$this->navs=$navs;
 		$this->navs=$this->unlimitedTree($navs);
//  		$navs=$this->unlimitedTree($navs);
//  		dump($navs);
 		$this->display();
	}

	protected function unlimitedTree($arr=array(), $pid=0){
		$tree=array();
		foreach ($arr as $v){
			if ($v['pid']== $pid){
				$v['childs']=$this->unlimitedTree($arr, $v['id']);
				$tree[]=$v;
			}
		}
		return $tree;
	}
	public function navAdd(){
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
		}else{
			$this->error('检测到你当前为不合法请求，系统拒绝此次访问，请通过合法途径访问');
		}
	}
    public function navEdit(){
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
                if ($newID= $navDB->save($data)){
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
            }else{
                $this->error('检测到你当前为不合法请求，系统拒绝此次访问，请通过合法途径访问');
            }
     }
	public function ajaxGetCate(){
		if (IS_POST && IS_AJAX){
			$cates=M('category')->field('id, catename')->where(array('isshow'=>1))->order('sortorder')->select();
			$html='<option value="">选择商品分类</option>';
			if ($cates){
				foreach($cates as $val){
					$html.='<option value="'.$val['id'].'">'.$val['catename'].'</option>';
				}
			}else{
				$html='<option value="">暂无可用分类</option>';
			}
			$return =array(
					'status'=>1,
					'data'=>$html
			);
			$this->ajaxReturn($return,'json');
		}else{
			$this->error('检测到你当前为不合法请求，系统拒绝此次访问，请通过合法途径访问');
		}
	}

	/**
	 * 导航删除
	 */
	public function navDelete(){
		if(IS_POST){
			$cid=I('id',0,'intval');
			if($cid>0){
					if(M('navigator')->where(array('pid'=>$cid))->count()>0){
						$return=array(
								'data'=>'该导航下还有下级，无法直接删除，要删除，请先删除所有下级导航！',
								'status'=>0
						);
					}else{
						//执行操作
						if(M('navigator')->delete($cid)){
							$return=array(
									'data'=>'删除成功',
									'status'=>1
							);
						}else{
							$return=array(
									'data'=>'系统繁忙，删除失败',
									'status'=>0
							);
						}
					}

			}else{
				$return=array(
						'data'=>'系统无法识别操作参数，请刷新重试！',
						'status'=>0
				);
			}
			$this->ajaxReturn($return, 'json');
		}else{
			$this->error('系统拒绝此访问，请通过合法途径访问页面!','',3);
		}
	}
	public function ajaxGetGoods(){
		if (IS_POST && IS_AJAX){
			$cid=I('cid',0,'intval');
			$goods=M('goods')->field('id, goodsname, goodslink')->where(array('isshow'=>1,'cateid'=>$cid))->order('sortorder')->select();
			$html='<option value="">所有商品</option>';
			if ($goods){
				foreach($goods as $val){
					if(!empty($val['goodslink']))
						$html.='<option value="'.$val['goodslink'].'">'.$val['goodsname'].'</option>';
					else
						$html.='<option value="'.$val['id'].'">'.$val['goodsname'].'</option>';
				}
			}else{
				$html.='<option value="">暂无商品</option>';
			}
			$return =array(
					'status'=>1,
					'data'=>$html
			);
			$this->ajaxReturn($return,'json');
		}else{
			$this->error('检测到你当前为不合法请求，系统拒绝此次访问，请通过合法途径访问');
		}
	}
	public function ajaxChangeShow(){
		if (! IS_POST){
			$this->error('检测到你当前为不合法请求，系统拒绝此次访问，请通过合法途径访问');
			exit;
		}
		$data=I('post.');
		if ($data['id']>0){
			if (M('navigator')->save($data)){
				$return =array(
						'status'=>1,
						'data'=>'成功更改'
				);
			}else {
				$return =array(
						'status'=>0,
						'data'=>'网络繁忙，请稍后再试！'
				);
			}
		}else{
			$return =array(
					'status'=>0,
					'data'=>'操作参数无效，请刷新页面重新尝试！'
					);
		}
		$this->ajaxReturn($return,'json');
	}

}