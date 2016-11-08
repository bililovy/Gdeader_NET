<?php
// 系统框架版本
const WINSYS_VERSION = 'WinFrame Beta 1.1.0';
define('WINSYS_CORE', WINSYS_ROOT . 'CoreDriver/BasedONFrame/');
define('WINSYS_COMMON', WINSYS_ROOT . 'Common/');
if (isset ($_COOKIE [ 'winsystemrunplat' ]) && ! empty ($_COOKIE [ 'winsystemrunplat' ])) {
    $platinfo = $_COOKIE [ 'winsystemrunplat' ];
} else {
    $os = explode(' ', php_uname());
    // 当前运行服务器系统信息
    $platinfo = $os [ 0 ] . ' ' . $os [ 2 ];
    setcookie('winsystemrunplat', $platinfo, time() + 36000, '/');
}
define('SYSTEM_OS', $platinfo);
if (isset ($_COOKIE [ 'winsystemgetdbversion' ]) && ! empty ($_COOKIE [ 'winsystemgetdbversion' ])) {
    $mysqlversion = $_COOKIE [ 'winsystemgetdbversion' ];
} else {
    $db = include_once './WebConfig/data.inc.config.php';
    $link = mysql_connect($db [ 'DB_HOST' ] . ':' . $db [ 'DB_PORT' ], $db [ 'DB_USER' ], $db [ 'DB_PWD' ]);
    if ($link) {
        $mysqlversion = mysql_get_server_info();
        setcookie('winsystemgetdbversion', $mysqlversion, time() + 36000, '/');
    } else {
        $mysqlversion = '暂无法获取';
    }
}
define('SQL_VERSION', 'MySQL ' . $mysqlversion);