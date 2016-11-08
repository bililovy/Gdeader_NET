<?php
$CommonConf= array(
	//'配置项'=>'配置值'
		'TMPL_FILE_DEPR'        =>  '/', //模板文件CONTROLLER_NAME与ACTION_NAME之间的分割符
		'TMPL_VAR_IDENTIFY'     =>  'array',//配置模版只解析数组
 		'URL_CASE_INSENSITIVE'  =>  false,  // 默认false 表示URL区分大小写 true则表示不区分大小写
		'DEFAULT_TIMEZONE'      =>  'PRC',  // 默认时区
		'MODULE_ALLOW_LIST'    =>    array('Home','Admin'),
		'URL_MODULE_MAP'    =>array('admin'=>'MyWebsite_ForeignTrade_index_administrator'),
		'DEFAULT_MODULE'        =>  'Home',  // 默认模块
		'URL_MODEL'=>2,
		'SITE_UPLOAD_ROOT_PATH'=> APP_PATH .'../assets/library/uploads',
		'TMPL_PARSE_STRING'=>array(
				'__COMMON__'=>'/assets/common',
				'__IMG__'=>'/assets/images/default',
				'__JS__'=>'/assets/js/default',
				'__CSS__'=>'/assets/css/default',
                '__PLUGINS__'=>'/assets/plugins/',
				'__ADMIN_IMG__'=>'/assets/images/backstage',
				'__ADMIN_JS__'=>'/assets/js/backstage',
				'__ADMIN_CSS__'=>'/assets/css/backstage'
		),
);
$dbconfig=require_once APP_PATH . '../WebConfig/data.inc.config.php';
return array_merge($dbconfig, $CommonConf);