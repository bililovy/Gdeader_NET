<?php
/**
 * 页面功能简述： 网站后端主页
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

class IndexController extends PrivilegeController {
	
	private $_TotalWebSpace='1000';//M为单位
	
	private $_TotalSqlSpace='50'; // M为单位

    public function index(){
    	
    	//网站名字
    	$DB=M('onesignalpage');
    	$signalpages=$DB->field('id,title')->order('sortorder ASC')->select();
    	$this->signalpages =$signalpages;
    	/***BEGIN 网站基本信息获取**/ 
        $this->GetWebConfig('webname');
    	$pageinfo=array(
    			'pagetitle'=>$this->_config['webname']
    			);
    	/***END 网站基本信息获取**/
    	$this->pageinfo=$pageinfo;
		$this->display('index');
    }
    public function main(){
    	$this->helloword = helloword();
   		 /***BEGIN 网站基本信息获取**/ 
        $this->GetWebConfig('webname');
    	$pageinfo=array(
    			'pagetitle'=>$this->_config['webname']
    			);
    	/***END 网站基本信息获取**/     
    	 $this->logininfo=session('login_infos');
    	$this->pageinfo=$pageinfo;
    	$this->display('main');
    }
    /**
     * 获取网站空间信息
     */
    public function DoGet(){
    	if(IS_POST ){
    		$type=I('type','');
    		$return=$this->getSpaceData($type);
    		$this->ajaxReturn($return, 'json');
    	}else{
    		$this->error('非法请求类型，系统已经拒绝！','',5);
    	}
    }
    /**
     * 获取空间信息
     * @param unknown $type
     * @param number $intervaltime
     */
    protected function getSpaceData($type, $intervaltime = 600) {
    	$filepath = '';
    	switch ($type) {
    		case 'sql' :
    			$filepath = APP_PATH . 'Common/Prober/sqlspace.prober';
    			break;
    		case 'space' :
    			$filepath = APP_PATH . 'Common/Prober/webspace.prober';
    			break;
    		case 'clearSizeCache' :
    			// 清理文件缓存 if(false !== removedir()){
    			if ($this->removeCache ( APP_PATH . 'Common/Prober/' )) {
    				$result = array ('status' => 1, 'message' => '缓存文件清理成功' );
    			} else {
    				$result = array ('status' => 0, 'message' => '系统繁忙，缓存清理失败，请稍后再次尝试！' );
    			}
    			break;
    		default :
    			$result = array ('status' => 0, 'message' => '系统无法识别当前请求，请刷新页面再次尝试！' );
    	}
    	if (! empty ( $filepath )) {
    		$now = time ();
    		if (file_exists ( $filepath ) && ($now - filemtime ( $filepath ) <= $intervaltime) && is_readable ( $filepath )) {
    			$result = unserialize ( file_get_contents ( $filepath ) );
    			$result ['left'] = $intervaltime - ($now - filemtime ( $filepath ));
    		} else {
				$total = ($type=='space') ? $this->_TotalWebSpace : $this->_TotalSqlSpace;
				$used= ($type=='space') ? $this->getSpaceUsedSize() : $this->getSqlUsedSize();
				$percent= self::convertUnit($used)/$total;				 
				$result=$this->getFormatInfo($total,$used,$percent);
    			$result['status']=1;
    			if(!is_dir(dirname($filepath))){
    				self::makedirs(dirname($filepath));
    			}
    			file_put_contents($filepath, serialize($result));
    			}
    	}
    	return $result;
    }
    
    /**
     * 获取当前网站的数据库使用量
     */
    private function getSqlUsedSize() {
    	$db = M ();
    	$data = $db->query ( 'SHOW TABLE STATUS' );
    	$size = 0;
    	foreach ( $data as $val ) {
    		$size += $val ["data_length"] + $val ["index_length"];
    	}
    	return $size;
    }
    /**
     * 获取当前网站的空间使用量
     */
    private function getSpaceUsedSize() {
    	$websiteroot = APP_PATH . '../';
    	return self::CalcDirectorySize ( $websiteroot );
    }
    /**
     * 单位转换
     *
     * @param $size number
     *            传入要转换的数字，
     * @param $fromunit string
     *            原来的单位 b kb mb gb tb
     * @param $tounit string
     *            转换后的单位 b kb mb gb tb
     * @return 转换后的单位 传入单位不区分大小写
     */
    private static function convertUnit($size = 0, $tounit = 'mb', $fromunit = 'b') {
    	$fromunit = strtolower ( $fromunit );
    	$tounit = strtolower ( $tounit );
    	$calcu = array ('b' => array ('b' => array ('m' => 1 ), 'kb' => array ('d' => pow ( 1024, 1 ) ), 'mb' => array ('d' => pow ( 1024, 2 ) ), 'gb' => array ('d' => pow ( 1024, 3 ) ), 'tb' => array ('d' => pow ( 1024, 4 ) ) ), 'kb' => array ('b' => array ('m' => pow ( 1024, 1 ) ), 'kb' => array ('m' => 1 ), 'mb' => array ('d' => pow ( 1024, 1 ) ), 'gb' => array ('d' => pow ( 1024, 2 ) ), 'tb' => array ('d' => pow ( 1024, 3 ) ) ), 'mb' => array ('b' => array ('m' => pow ( 1024, 2 ) ), 'kb' => array ('m' => pow ( 1024, 1 ) ), 'mb' => array ('m' => 1 ), 'gb' => array ('d' => pow ( 1024, 1 ) ), 'tb' => array ('d' => pow ( 1024, 2 ) ) ), 'gb' => array ('b' => array ('m' => pow ( 1024, 3 ) ), 'kb' => array ('m' => pow ( 1024, 2 ) ), 'mb' => array ('m' => pow ( 1024, 1 ) ), 'gb' => array ('m' => 1 ), 'tb' => array ('d' => pow ( 1024, 1 ) ) ), 'tb' => array ('b' => array ('m' => pow ( 1024, 4 ) ), 'kb' => array ('m' => pow ( 1024, 3 ) ), 'mb' => array ('m' => pow ( 1024, 2 ) ), 'gb' => array ('m' => pow ( 1024, 1 ) ), 'tb' => array ('m' => 1 ) ) );
    	$supportunit = array ('b', 'kb', 'mb', 'gb', 'tb' );
    	if (! in_array ( $fromunit, $supportunit ) || ! in_array ( $tounit, $supportunit )) {
    		// 单位不支持
    		return false;
    	}
    	$calcRule = $calcu [$fromunit] [$tounit];
    	if (! is_array ( $calcRule )) {
    		// 系统未找到计算规则
    		return false;
    	}
    	foreach ( $calcRule as $char => $val ) {
    		if ($char == 'm') {
    			$calcuChar = '*';
    		} else if ($char == 'd') {
    			$calcuChar = '/';
    		}
    		$step = $val;
    	}
    	$result = eval ( "return $size$calcuChar$step;" );
    	return round ( $result, 2 );
    }
    private static function getFormatInfo($total = 0, $used = 0, $percent = 0) {
    	$additional = '';
    	if ($percent <= 0.5) {
    		// 使用率在50%一下 用绿色
    		$fontcolor = '2E7C0A';
    		$additional = '<span style="margin-left: 8px;">（<i class="fa fa-check-circle" style="font-size: 14px;font-weight:bold;margin: 0 5px;"></i>储存空间还很充足，请放心使用！）</span>';
    	} else if ($percent > 0.5 && $percent <= 0.6) {
    		// 使用率在50%-60%间 用警告颜色
    		$fontcolor = '83A215';
    		$additional = '<span style="margin-left: 8px;">（<i class="fa fa-check-circle" style="font-size: 14px;font-weight:bold;margin: 0 5px;"></i>储存空间还有足够剩余，请放心使用！）</span>';
    	} else if ($percent > 0.6 && $percent <= 0.7) {
    		// 使用率在60%-70%间 用警告颜色
    		$fontcolor = '8B8B0D';
    		$additional = '<span style="margin-left: 8px;">（<i class="fa fa-warning" style="font-size: 14px;font-weight:bold;margin: 0 5px;"></i>储存空间已经剩余不多，请随时留意，避免给您带来不便！）</span>';
    	} else if ($percent > 0.7 && $percent <= 0.8) {
    		// 使用率在70%-80%间 用警告颜色
    		$fontcolor = 'C19D05';
    		$additional = '<span style="margin-left: 8px;">（<i class="fa fa-warning" style="font-size: 14px;font-weight:bold;margin: 0 5px;"></i>储存空间已经剩余不多，请随时留意，避免给您带来不便！）</span>';
    	} else if ($percent > 0.8 && $percent <= 0.9) {
    		// 使用率在80%-90%间 用警告颜色
    		$fontcolor = 'D18600';
    		$additional = '<span style="margin-left: 8px;">（<i class="fa fa-warning" style="font-size: 14px;font-weight:bold;margin: 0 5px;"></i>储存空间已经剩余不多，请随时留意，避免给您带来不便！）</span>';
    	} else if ($percent > 0.9 && $percent <= 0.95) {
    		// 使用率在90%-95%间 用警告颜色
    		$fontcolor = 'D14300';
    		$additional = '<span style="margin-left: 8px;">（<i class="fa fa-warning" style="font-size: 14px;font-weight:bold;margin: 0 5px;"></i>储存空间即将用完，为防止系统功能限制，请随时关注剩余量！）</span>';
    	} else if ($percent > 0.95 && $percent < 1) {
    		// 使用率在98%以上 使用达到警戒线
    		$fontcolor = 'B21F0A';
    		$additional = '<span style="margin-left: 8px;">（<i class="fa fa-warning" style="font-size: 14px;font-weight:bold;margin: 0 5px;"></i>储存空间已接近顶峰，请及时升级空间，否则系统部分功能将受到限制！）</span>';
    	} else {
    		// 使用完毕，提示满额信息
    		$percent = 1;
    		$fontcolor = 'F00';
    		$additional = '<span style="margin-left: 8px;">（<i class="fa fa-times-circle" style="font-size: 16px;font-weight:bold;margin: 0 5px;"></i>此储存空间已经用完，请及时升级空间，否则系统部分功能将受到限制！）</span>';
    	}
    	$result = array ('fc' => $fontcolor, 'total' => '<span  style="color: #' . $fontcolor . ';"><b>' . self::convertUnit ( $total, 'mb', 'mb' ) . ' MB</b>' . $additional . '</span>', 'used' => '<b style="color: #' . $fontcolor . ';">' . self::convertUnit ( $used, 'mb', 'b' ) . ' MB</b>', 'percent' => $percent );
    	return $result;
    }
    /**
     * 计算网站空间大小
     * 返回数据单位为
     */
    private static function CalcDirectorySize($DirectoryPath) {
    	//计算空间时，排除系统框架目录
    	$exceptDirecAndFile=array('WINSYSTEM');
    	$sizeResult = 0;
    	$handle = opendir ( $DirectoryPath );
    	while ( false !== ($FolderOrFile = readdir ( $handle )) ) {
    		if ($FolderOrFile != "." && $FolderOrFile != ".." && !in_array($FolderOrFile, $exceptDirecAndFile)) {
    			if (is_dir ( "$DirectoryPath/$FolderOrFile" )) {
    				$sizeResult += self::CalcDirectorySize ( "$DirectoryPath/$FolderOrFile" );
    			} else {
    				$sizeResult += filesize ( "$DirectoryPath/$FolderOrFile" );
    			}
    		}
    	}
    	closedir ( $handle );
    	return $sizeResult;
    }
    /**
     * 清理空间缓存文件
     */
    private function removeCache($filepath) {
    	if (false !== rm_dir ($filepath)) {
    		return true;
    	} else {
    		return false;
    	}
    }
    /**
     * 递归创建目录
     */
    protected static function makedirs($dirpath, $mode = 0755) {
    	if (is_dir ( $dirpath ) || @mkdir ( $dirpath, $mode ))
    		return true;
    	if (! self::makedirs ( dirname ( $dirpath ), $mode ))
    		return false;
    	return @mkdir ( $dirpath, $mode );
    }
}