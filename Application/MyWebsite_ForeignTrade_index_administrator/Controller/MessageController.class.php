<?php 
/**
 * 页面功能简述： 留言系统
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

class MessageController extends PrivilegeController{
	/**
	 * 载入留言列表
	 */
	public function index(){
		$this->guestmsg();
	}
	/**
	 * 客户留言板
	 */
	public function guestmsg(){
		$curcond= I('cond','all');
		$curtype=I('msgtype',0,'intval');
		$where ='';
		if($curcond==='unread'){
			$where['ishandled']=0;
			$curcond=0;
		}else if('read'===$curcond){
			$where['ishandled']=1;
			$curcond=1;
		}
		if($curtype>0){
			$where['msgtype']=$curtype;
		}
		import ( 'Extensions.Page', COMMON_PATH );
		$msgDB = M('message');
		$order='addtime DESC';		
		$count = $msgDB->where($where)->count();
		$page = new \Page ( $count, 10, $_GET ['p'], '?p={page}' );
		$limit = $page->page_limit . "," . $page->myde_size;
		$messages=$msgDB->field()->where($where)->order($order)->limit($limit)->select();
		$msgtypes=M('msgtype')->select();
		$this->msgtypes=$msgtypes;
		$this->messages=$messages;
		//dump($messages);die;
		$this->curmsgtype=$curtype;
		$this->cond=$curcond;
		$this->page=$page->myde_write();
		$this->display('guestmessage');
	}
	/**
	 * 客户留言表更新操作
	 * 包含删除和标记等
	 */
	public function guestupdate(){
		if (IS_POST){
			$data=I('post.', '');
			if (!empty($data) && intval($data['msgid'])>0 && !empty($data['handway'])){
					switch($data['handway']){
						case 'delmsg':
							$msgid=intval($data['msgid']);
							unset($data);
							if (M('message')->delete($msgid)){
								$return =array(
										'data'=>'删除成功！',
										'status'=>1
								);
							}else{
								$return =array(
										'data'=>'网络繁忙，留言删除失败，请稍候再试！',
										'status'=>0
								);
							}						
						break;
						case 'signread':							
							$data['id']=$data['msgid'];
							$data['ishandled']=1;
							unset($data['handway']);
							unset($data['msgid']);
							if (M('message')->save($data)){
								$return =array(
										'data'=>'标记成功！',
										'status'=>1
								);
							}else{
								$return =array(
										'data'=>'网络繁忙，标记失败，请稍后再试！',
										'status'=>0
								);
							}
						break;
						default :
							$return =array(
									'data'=>'系统无法识别当前操作请求，请刷新页面并重新执行当前操作！',
									'status'=>0
							);							
					}
			}else{
				$return =array(
						'data'=>'系统未检测到当前操作的必需条件，操作终止，请刷新页面重新尝试！',
						'status'=>0
				);
			}
			$this->ajaxReturn($return, 'json');
		}else{
			$this->error('系统检测到当前请求不合法，请通过合法途径访问此页面！', '', 6);
		}
	}
	
	/**
	 * 留言分类设置
	 */
	public function msgtype(){
		$DB=M('msgtype');
		if(IS_POST){
			$data=I('post.','');
			if(!empty($data)){
				switch($data['handway']){
					case 'add':
						unset($data['handway']);
						$data['addtime']=time();
						if($newID=$DB->add($data)){
							$return=array(
									'data'=>'成功添加一个分类',
									'status'=>1
									);
						}else{
							$return=array(
									'data'=>'系统繁忙，分类添加失败',
									'status'=>0
							);
						}
					break;
					case 'update':
						unset($data['handway']);
						if($DB->save($data)){
							$return=array(
									'data'=>'成功更新分类信息',
									'status'=>1
							);
						}else{
							$return=array(
									'data'=>'更新失败，请确认是否有内容修改并再次尝试！',
									'status'=>0
							);
						}
					break;
					case 'delete':
						unset($data['handway']);
						if(M('message')->where(array('msgtype'=>$data['id']))->count()>0){
							$return=array(
									'data'=>'当前分类下还有留言，无法删除，您可以先删除此分类下的留言后，方可删除此分类！',
									'status'=>0
							);
							$this->ajaxReturn($return, 'json');
							exit;
						}
						if($DB->delete($data['id'])){
							$return=array(
									'data'=>'成功删除一条分类',
									'status'=>1
							);
						}else{
							$return=array(
									'data'=>'网络繁忙，删除失败！',
									'status'=>0
							);
						}
					break;
					default:
						$return=array(
								'data'=>'系统无法识别当前的请求操作，请刷新页面重新尝试！',
								'status'=>0
						);
				}
			}else{
				$return =array(
					'data'=>'系统无法获取数据信息，请刷新后重新尝试！',
					'status'=>0		
				);
			}
			$this->ajaxReturn($return, 'json');
		}else{
			$msgtypes=$DB->order('sortorder, addtime DESC')->select();	
			if(is_array($msgtypes)){
				foreach($msgtypes as $key=>$val){
					$msgtypes[$key]['msgnum']=M('message')->where(array('msgtype'=>$val['id']))->count();
				}				
			}		
			$this->msgtypes=$msgtypes;
			$this->display('msgtype_set');
		}
	}
}