<?php
/**
 * DouPHP
 * --------------------------------------------------------------------------------------------------
 * 版权所有 2013-2024 漳州豆壳网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.douphp.com
 * --------------------------------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在遵守授权协议前提下对程序代码进行修改和使用；不允许对程序代码以任何形式任何目的的再发布。
 * 授权协议: http://www.douphp.com/license.html
 * --------------------------------------------------------------------------------------------------
 * Author: DouCo Co.,Ltd.
 * Release Date: 2023-01-13
 */
if (!defined('IN_DOUCO')) {
    die('Hacking attempt');
}

// 开启SESSION
session_start();

// 显示除了E_NOTICE(提示)和E_WARNING(警告)外的所有错误
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

// 关闭 set_magic_quotes_runtime
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
   set_magic_quotes_runtime(0);
} else {
   ini_set('magic_quotes_runtime', 0);
}

// 调整时区
if (version_compare(PHP_VERSION, '5.1', '>=')) date_default_timezone_set('PRC'); 

// 网站后台标记
define('IS_ADMIN', true);

// 后台目录定义文件
if (file_exists($custom_file = '../data/..php')) include_once ($custom_file);

// 载入配置文件
include_once ('../data/config.php');

// 判断传输协议
define('HTTP', ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (!empty($_SERVER['HTTP_FROM_HTTPS']) && strtolower($_SERVER['HTTP_FROM_HTTPS']) === 'on') || (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) || (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') || (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'https')) ? 'https://' : 'http://');

// 定义DouPHP基础常量
define('ROOT_PATH', str_replace(ADMIN_PATH . '/include/init.php', '', str_replace('\\', '/', __FILE__)));
define('ROOT_URL', preg_replace('/' . ADMIN_PATH . '\//Ums', '', dirname(HTTP . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) . "/"));
define('SITE_URL', ROOT_URL);
define('M_URL', ROOT_URL . M_PATH . '/');

if (!file_exists(ROOT_PATH . "data/install.lock")) {
    header("Location: ../install/index.php\n");
    exit();
}

// 载入DouPHP核心文件
require (ROOT_PATH . 'include/smarty.class.php');
require (ROOT_PATH . 'include/mysql.class.php');
require (ROOT_PATH . 'include/common.class.php');
require (ROOT_PATH . ADMIN_PATH . '/include/manager.class.php');
require (ROOT_PATH . ADMIN_PATH . '/include/action.class.php');
require (ROOT_PATH . 'include/check.class.php');
require (ROOT_PATH . 'include/firewall.class.php');

// 实例化DouPHP核心类
$dou = new Action($dbhost, $dbuser, $dbpass, $dbname, $prefix, DOU_CHARSET);
$check = new Check();
$firewall = new Firewall();

// 定义系统标识
define('DOU_SHELL', $dou->get_one("SELECT value FROM " . $dou->table('config') . " WHERE name = 'hash_code'"));
define('DOU_ID', 'admin_' . substr(md5(DOU_SHELL . 'admin'), 0, 5));

// 豆壳防火墙
$firewall->dou_firewall();

// 设置页面缓存和编码
header('content-type: text/html; charset=' . DOU_CHARSET);
header('Expires: Fri, 14 Mar 1980 20:53:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

// 开启缓冲区
ob_start();

// SMARTY配置
$smarty = new smarty();
$smarty->template_dir = ROOT_PATH . ADMIN_PATH . '/templates'; // 模板存放目录
$smarty->compile_dir = ROOT_PATH . 'cache/' . ADMIN_PATH; // 编译目录
$smarty->left_delimiter = '{'; // 左定界符
$smarty->right_delimiter = '}'; // 右定界符
                                
// 如果编译和缓存目录不存在则建立
if (!file_exists($smarty->compile_dir))
    mkdir($smarty->compile_dir, 0777);

// 验证管理员
$smarty->assign("user", $_USER = $dou->admin_check($_SESSION[DOU_ID]['user_id'], $_SESSION[DOU_ID]['shell']));

$smarty->assign("site", $_CFG = $dou->get_config()); // 读取站点信息
$smarty->assign("param", $_PARAM = $dou->parameter()); // 参数设置
$smarty->assign("setting", $_SETTING = $dou->read_setting()); // 模板配置信息

// 系统模块
$_MODULE = $dou->dou_module();

// 载入语言文件
foreach ($_MODULE['lang'] as $lang_file) {
    require ($lang_file); // 载入系统语言文件
}

// 载入系统核心初始化文件（主要用于细分行业系统开发）
if (file_exists($core_load_file = ROOT_PATH . ADMIN_PATH . '/include/core.load.php'))
    require ($core_load_file);

// 如果存在自定义类则载入
if (file_exists($other_class_file = ROOT_PATH . 'include/other.class.php')) {
    require ($other_class_file);
    $other = new Other();
}
    
// 短信服务
if (file_exists($sms_class_file = ROOT_PATH . 'include/sms.class.php')) {
    require ($sms_class_file);
    $sms = new Sms();
    $smarty->assign('sms_captcha', $sms_captcha = true);
}

if (file_exists($cdkey_file = ROOT_PATH . 'data/..cdkey.php')) {
    include_once ($cdkey_file);
    $decompile_init = $dou->decompile($_CDKEY);

    if ($decompile_init == substr(md5(DOU_SHELL), 16) . $_CFG['douphp_version'] . $dou->format_url(ROOT_URL)) {
        $smarty->assign("authorized", $_AUTHORIZED = true);
        
        if ($_PARTNER_AUTHORIZED) {
            $smarty->assign("partner_authorize", true);
            $_LANG['home'] = preg_replace('/DouPHP /Ums', '', $_LANG['home']);
            $_LANG['login'] = preg_replace('/DouPHP /Ums', '', $_LANG['login']);
            
            if ($_CFG['pure_mode'])
                $smarty->assign("pure_mode", $_PURE_MODE = true);
        }
    }
}

// 工作空间
$smarty->assign("workspace", $dou->dou_workspace());

// 通用信息调用
$smarty->assign("lang", $_LANG);
$smarty->assign("open", $_OPEN = $_MODULE['open']); // 功能与模块开启状态

// 显示与自定义
$_DISPLAY = unserialize($_CFG['display']); // 显示设置
$_DEFINED = unserialize($_CFG['defined']); // 自定义属性

// 提示HTTPS
if ($_CFG['ssl'] && HTTP != 'https://') {
    $smarty->assign("cue_open_ssl", true);
    $smarty->assign("ssl_url", 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
}

// Smarty 过滤器
function remove_html_comments($source, & $smarty) {
    return $source = preg_replace('/<!--.*{(.*)}.*-->/U', '{$1}', $source);
}
$smarty->register_prefilter('remove_html_comments');

?>