<?php
/**
 * 页面功能简述： 网站前端访问入口
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

return array(
		//'配置项'=>'配置值'
		'SHOW_PAGE_TRACE'=>false,
		'DEFAULT_CONTROLLER'    =>  'Index',
		'URL_HTML_SUFFIX'=>'html',
		//默认错误跳转对应的模板文件
		'TMPL_ACTION_ERROR' => 'Error:handleError',
        'URL_ROUTER_ON' => TRUE,
        'URL_ROUTE_RULES' => array(
            '/^pro(\d+)\-[\w\-]*$/' => 'Goods/gdetail?gid=:1',
            '/^cat(\d+)\-[\w\-]*$/' => 'Goods/goodaCate?cid=:1',
            '/^s(\d+)\-[\w\-]*$/' => 'Signal/directPage?sid=:1'
        )
);