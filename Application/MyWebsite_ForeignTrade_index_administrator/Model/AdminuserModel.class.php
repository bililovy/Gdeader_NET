<?php
/**
 * 页面功能简述： 后台管理员操作表
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
namespace MyWebsite_ForeignTrade_index_administrator\Model;
use Think\Model;

class AdminuserModel extends Model{
	/**
	 * 定制验证规则
	 */
	protected $_validate=array(
			array('username', '/^[a-zA-Z]{1}([a-zA-Z0-9]){4,19}$/', '请输入正确的用户名，以字母开头'),
			array('username', '', '用户名已经存在，请更换！', 0, 'unique'),
			array('captcha', '5', '请输入右侧验证码', 0, 'length'),
			array('truename', '/^[\x{4e00}-\x{9fa5}]{2,12}$/iu', '姓名为2-12个汉字，不能带其他字符'),
			array('email', 'email', '邮箱格式错误'),
			array('email', '', '邮箱已经存在，请更换！',0,'unique'),
			);
	/**
	 * 登录验证方法
	 */
	public function checkSign($data=''){
		if (empty($data)){
			return false;
		}
		$user=$this->field('id,password,logintimes,lastlogintime,lastloginip, roledesc, truename')->where(array('username'=>$data['username']))->find();
		if ($user && $user['password']==$data['password']){
			return $user;
		}else{
			return false;
		}		
	}
	/**
	 * 登陆后更新部分用户表数据
	 */
	public function loginUpdate($data=''){
		if (empty($data)){
			return false;
		}
		if ($this->save($data)){
			return true;
		}else{
			return false;
		}
	}
}




















