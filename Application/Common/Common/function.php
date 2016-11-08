<?php 
/**
 * 页面功能简述： 公共函数库
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
/**
 * 后台显示上午下午 
 */
function helloword(){
	$h=date('G');
	if ($h>=0 && $h<=8){
		return '凌晨';
	}else if ($h>8 && $h<12){
		return '上午';
	}else if ($h==12){
		return '中午';
	}else if ($h>=13 && $h<=18){
		return '下午';
	}else if ($h>18 && $h<=23){
		return '晚上';
	}
}

/**
 * 递归创建文件目录
 */
function mk_dir($dir, $mode = 0755)
{
	if (is_dir($dir) || @mkdir($dir,$mode)) return true;
	if (!mk_dir(dirname($dir),$mode)) return false;
	return @mkdir($dir,$mode);
}
/**
 * 递归删除目录
 * @param e $path 要删除的目录
 */
function rm_dir($path){
	//给定的目录不是一个文件夹
	if(!is_dir($path)){
		return null;
	}

	$fh = opendir($path);
	while(($row = readdir($fh)) !== false){
		//过滤掉虚拟目录
		if($row == '.' || $row == '..'){
			continue;
		}

		if(!is_dir($path.'/'.$row)){
			unlink($path.'/'.$row);
		}
		rm_dir($path.'/'.$row);

	}
	//关闭目录句柄，否则出Permission denied
	closedir($fh);
	//删除文件之后再删除自身
	if(!rmdir($path)){
		echo $path.'无权限删除<br>';
	}
	return true;
}

/*
 +----------------------------------------------------------
* 产生随机字串， 可用来自动生成密码，验证码，表单令牌等
* 默认长度6位 字母和数字混合 支持中文
+----------------------------------------------------------
* @param string $len 长度
* @param string $type 字串类型
* 0 字母 1 数字 其它 混合
* @param string $addChars 额外字符
+----------------------------------------------------------
* @return string
+----------------------------------------------------------
*/
function rand_string($len = 6 , $addChars = '',  $type = 0) {
	$str = '';
	switch ($type) {
		case 0 :
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
			break;
		case 1 :
			$chars = str_repeat('0123456789', 3);
			break;
		case 2 :
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
			break;
		case 3 :
			$chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
		default :
			// 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
			$chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars;
			break;
	}
	if ($len > 10) { //位数过长重复字符串一定次数
		$chars = $type == 1 ? str_repeat($chars, $len) : str_repeat($chars, 5);
	}
	if ($type != 4) {
		$chars = str_shuffle($chars);
		$str = substr($chars, 0, $len);
	} else {
		// 中文随机字
		for ($i = 0; $i < $len; $i++) {
			$str .= substr($chars, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 1);
		}
	}
	return $str;
}
/**
 * 关键词转换
 * @param string $keywords 传入字符串
 * @param bool 设置是否要转为数组，默认false不转成数组
 */
function convert_keywords($keywords='', $setArray=false){
	$keywords=str_replace("-",",",$keywords);
	$keywords=str_replace("，",",",$keywords);
	$keywords=str_replace(", ",",",$keywords);
	$keywords=str_replace(".",",",$keywords);
	$keywords=str_replace("。",",",$keywords);
	//$keywords=str_replace(" ",",",$keywords);
	$keywords=str_replace("|",",",$keywords);
	$keywords=str_replace("、",",",$keywords);
	$keywords=str_replace(",,",",",$keywords);
	$keywords=str_replace("<","",$keywords);
	$keywords=str_replace(">","",$keywords);
	if ($setArray) return explode(",",trim($keywords));
	else return trim($keywords);
}

/**
 * 清除数组中的空值
 * 可用多维数组
 * @param $arr 目标数组  $trim 是否清除空格
 */
function array_empty_filter(&$arr, $trim = true) {
	if (!is_array($arr)) return false;
	foreach($arr as $key => $value){
		if (is_array($value)) {
			array_empty_filter($arr[$key]);
		} else {
			$value = ($trim == true) ? trim($value) : $value;
			if ($value == "") {
				unset($arr[$key]);
			} else {
				$arr[$key] = $value;
			}
		}
	}
	return $arr;
}
/**
 * 获得树状列表--数组版
 *  @param $data 目标数组  $pid 上级id
 */
function getTree($data, $pid=0){
	if(!is_array($data)) return false;
	$tree = '';
	foreach($data as $k => $v)
	{
		if($v['parentid'] == $pid)
		{         //父亲找到儿子
			$v['children'] = getTree($data, $v['id']);
			$tree[] = $v;
		}
	}
	return $tree;
}

/**
 * 获得树状列表--string版
 *  @param $data 目标数组  $pid 上级id $level 当前级别数 $separatechar 分隔符 默认‘’ 既用系统自带的
 */
function getTreeString($data,$pid=0,$level=0,$separatechar='&nbsp;&nbsp;'){		
	if(!is_array($data)) return false;
		$tree = array();
		foreach($data as $v){
			if($v['parentid'] == $pid){
				$v['level'] = $level + 1;
				$v['separatechar'] =($level==0) ? '' : str_repeat($separatechar, $level) .'└' ;
				$tree[] = $v;
				$tree = array_merge($tree, getTreeString($data,$v['id'],$level+1,$separatechar));
			}
		}
		return $tree;
	}
