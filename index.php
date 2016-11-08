<?php
/**
 * 页面功能简述： 网站前端访问入口
 *
 * 开发负责人：吴思阳    联系邮箱：1985277517@qq.com  联系QQ: 1985277517
 *
 * 合同协议：成都万应网络科技有限公司（http://www.cdwinning.com）是成都高质量的网络应用开发、网站建设、wap/微信开发科技公司，
 *              公司原则是：尽心、尽责、尽全力。为每位客户打造放心的业务合作关系。公司要求所有开发人员按照客户提供的要求给客户开发高质
 *              量、高稳定性、高体验度的程序。万应科技，有求必应！
 *
 * 技术申明：成都万应网络科技有限公司（简称本公司）在程序上部署版权探针程序，程序解释权归本公司所有。
 *         程序使用版权归合同签署者（简称使用人），未经同意，使用人不得将此程序源码转让和出售。
 *         如果发现以上行为，将进行网站下线或程序删除等操作。
 *
 * 更新日期：2015-11-02
 *
 */
// 检测PHP环境
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
    $version = '5.3.0+';
    include_once('./assets/library/html/errorpage/notfound.tpl');
    exit;
}
const SYSTEM_VERSION = 'LX V1.0.3';
include_once './WebConfig/const.php';
//定义程序唯一使用编码 项目使用时，请勿删掉下面一行代码，否则程序将无法运行！
// 定义应用目录
define('APP_DEBUG', false);
define('APP_PATH', './Application/');
//定义缓存目录
define('RUNTIME_PATH', './Runtime~/');
//生成默认目录控制文件
define('DIR_SECURE_FINENAME', 'index.html');
//生成控制文件数据
define('DIR_SECURE_CONTENT',
    '<!DOCTYPE html><html><head><title>此目录禁止非法访问</title><meta http-equiv="content-type" content="text/html;charset=utf-8" /></head><body style="width: 100%;height: 100%;margin: 0;padding: 0;overflow: hidden;"><div class="frameset" style="overflow: hidden"><iframe src="/assets/Library/html/errorpage/403forbidden.html" scrolling="no" style="overflow: hidden; width: 100%;border: none;margin: 0; padding: 0;" id="errorFrame"></iframe></div></body></html>');
// 引入ThinkPHP入口文件
require_once './CoreDriver/CoreDriver.php';
