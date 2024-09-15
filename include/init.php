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

// 判断传输协议
define('HTTP', ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (!empty($_SERVER['HTTP_FROM_HTTPS']) && strtolower($_SERVER['HTTP_FROM_HTTPS']) === 'on') || (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) || (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') || (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'https')) ? 'https://' : 'http://');

// 获取网站地址，如果是从伪静态入口获取，会包含include目录名，在插件模块中调用该文件可以定义CUT_PATH裁剪出根路径
$dirname = dirname(HTTP . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) . "/";
$root_url = !defined('ROUTE') ? (defined('CUT_PATH') ? str_replace(CUT_PATH, '', $dirname) : $dirname) : str_replace('include/', '', $dirname);

// 多语言
if ($_REWRITE['lang']) {
    $_CUR_LANG['mode'] = 'rewrite_open';
    $_CUR_LANG['sign'] = $_REWRITE['lang'];
    $_CUR_LANG['pack'] = str_replace('-', '_', $_REWRITE['lang']);
} elseif ($_GET['lang']) {
    if (preg_match("/^[a-zA-Z]{2}_[a-zA-Z]{2}$/", $_GET['lang'])) {
        $_CUR_LANG['mode'] = 'rewrite_close';
        $_CUR_LANG['sign'] = $_GET['lang'];
        $_CUR_LANG['pack'] = $_GET['lang'];
    }
}

// 定义DouPHP基础常量
define('ROOT_PATH', str_replace('include/init.php', '', str_replace('\\', '/', __FILE__)));
if (file_exists($domain_cache_file = ROOT_PATH . 'cache/..php')) {
    include_once ($domain_cache_file);
}
define('ROOT_URL', $_CFG['domain'] ? $_CFG['domain'] : ($_DOMAIN ? $_DOMAIN : $root_url));
define('HOME_URL', ROOT_URL);

if (!file_exists(ROOT_PATH . "data/install.lock")) {
    header("Location: " . ROOT_URL . "install/index.php\n");
    exit();
}

// 后台目录定义文件
if (file_exists($custom_file = ROOT_PATH . 'data/..php')) include_once ($custom_file);

// 配置文件
require_once (ROOT_PATH . 'data/config.php'); // 伪静态下config.php会在route.php中第一次被调用

// 定义手机版链接
define('M_URL', ROOT_URL . M_PATH . '/');

// 载入DouPHP核心文件
require (ROOT_PATH . 'include/smarty.class.php');
require (ROOT_PATH . 'include/mysql.class.php');
require (ROOT_PATH . 'include/common.class.php');
require (ROOT_PATH . 'include/action.class.php');
require (ROOT_PATH . 'include/check.class.php');
require (ROOT_PATH . 'include/firewall.class.php');

// 实例化DouPHP核心类
$dou = new Action($dbhost, $dbuser, $dbpass, $dbname, $prefix, DOU_CHARSET);
$check = new Check();
$firewall = new Firewall();

// 定义系统标识
define('DOU_SHELL', $dou->get_one("SELECT value FROM " . $dou->table('config') . " WHERE name = 'hash_code'"));
define('DOU_ID', 'dou_' . substr(md5(DOU_SHELL . 'dou'), 0, 5));

$_CFG = $dou->get_config(); // 读取站点信息
$_PARAM = $dou->parameter(); // 参数设置
$_MODULE = $dou->dou_module(); // 系统模块
$_URL = $dou->dou_url(); // 站点链接
$_OPEN = $_MODULE['open']; // 功能与模块开启状态
$_DISPLAY = unserialize($_CFG['display']); // 显示设置
$_DEFINED = unserialize($_CFG['defined']); // 自定义属性
$IS_MOBILE = $dou->is_mobile() ? true : false; // 判断是否是手机访问

if (!defined('EXIT_INIT')) {
    // 设置页面缓存和编码
    header('Cache-control: private');
    header('Content-type: text/html; charset=' . DOU_CHARSET);

    // 判断选中的语言是否存在
    if ($_CUR_LANG) {
        if (!$dou->value_exist('language', 'language_pack', $_CUR_LANG['pack']) || !$_OPEN['language']) {
            $dou->dou_header(ROOT_URL);
        } elseif ($_CUR_LANG['mode'] == 'rewrite_open' && !$_CFG['rewrite']) {
            $dou->dou_header(ROOT_URL);
        }
    }
    
    // 判断是否跳转到手机版（条件：是移动端、没有强制显示PC版、手机版没有关闭）
    if ($dou->is_mobile() && $_COOKIE['client'] != 'pc' && !$_CFG['close_mobile']) {
        $dou->dou_header(ROOT_URL . M_PATH . $_SERVER['REQUEST_URI']);
    }

    // 强制HTTPS
    if ($_CFG['ssl'] && HTTP != 'https://') {
        header('HTTP/1.1 301 Moved Permanently');
        header("Location: " . 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit;
    }

    // 豆壳防火墙
    $firewall->dou_firewall();

    // SMARTY配置
    $smarty = new Smarty();
    $smarty->template_dir = ROOT_PATH . 'theme/' . $_CFG['site_theme']; // 模板存放目录（如果是数组，将逐个遍历）
    $smarty->compile_dir = ROOT_PATH . 'cache'; // 编译目录
    $smarty->left_delimiter = '{'; // 左定界符
    $smarty->right_delimiter = '}'; // 右定界符

    // 如果编译和缓存目录不存在则建立
    if (!file_exists($smarty->compile_dir))
        mkdir($smarty->compile_dir, 0777);

    // 版权信息
    $power_text = $dou->decompile(array(0x50, 0x6f, 0x77, 0x65, 0x72, 0x65, 0x64, 0x20, 0x62, 0x79));

    // 系统模块
    $_MODULE = $dou->dou_module();

    // 载入语言文件
    foreach ((array) $_MODULE['lang'] as $lang_file) {
        require ($lang_file);
    }
    $_LANG['copyright'] = preg_replace('/d%/Ums', $_CFG['site_name'], $_LANG['copyright']);
    $_LANG['powered_by'] = preg_replace('/d%/Ums', $power_text, $_LANG['powered_by']);

    if (file_exists($cdkey_file = ROOT_PATH . 'data/..cdkey.php')) {
        include_once ($cdkey_file);
        $decompile_init = $dou->decompile($_CDKEY);

        if ($decompile_init == substr(md5(DOU_SHELL), 16) . $_CFG['douphp_version'] . $dou->format_url(ROOT_URL)) {
            $_LANG['powered_by'] = '';
            $smarty->assign("authorized", $_AUTHORIZED = true);
        }
    }

    // 载入模块初始化文件
    foreach ((array) $_MODULE['init'] as $init_file) {
        require ($init_file);
    }

    // 载入系统核心初始化文件（主要用于细分行业系统开发）
    if (file_exists($core_load_file = ROOT_PATH . 'include/core.load.php'))
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

    // 判断是否关闭站点
    if ($_CFG['site_closed']) {
        // 设置页面编码
        header('Content-type: text/html; charset=' . DOU_CHARSET);

        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><div style=\"margin: 200px; text-align: center; font-size: 14px\"><p>" . $_LANG['site_closed'] . "</p><p></p></div>";
        exit();
    }

    // 如果模板中含有PHP引入文件
    if (file_exists($from_theme_php_file = $smarty->template_dir . '/inc/..from_theme.php')) {
        if ($dou->check_from_theme_php($from_theme_php_file)) {
            include_once($from_theme_php_file);
        }
    }

    // 通用信息调用
    $smarty->assign("lang", $_LANG);
    $smarty->assign("site", $_CFG);
    $smarty->assign("about", $dou->get_about()); // 模块URL
    $smarty->assign("url", $_URL); // 模块URL
    $smarty->assign("param", $_PARAM);
    $smarty->assign("is_mobile", $_IS_MOBILE);
    $smarty->assign("open", $_OPEN); // 功能与模块开启状态
    $smarty->assign("box_list", $dou->get_box()); // 内容盒子
    $smarty->assign("fragment", $dou->get_fragment()); // 内容碎片
    $smarty->assign("lang_menu", $dou->get_lang_menu($_CUR_LANG['pack'])); // 内容盒子
    $smarty->assign("generator", 'STPHP v1.0');

    // Smarty 过滤器
    function remove_html_comments($source, & $smarty) {
        // 当前模板绝对路径
        $_THEME_PATH = ROOT_URL . 'theme/' . $GLOBALS['_CFG']['site_theme'];

        $source = preg_replace('/\"(..\/)*images\//Ums', "\"$_THEME_PATH/images/", $source);
        $source = preg_replace('/\(images\//Ums', "($_THEME_PATH/images/", $source);
        $source = preg_replace('/href\=\"(..\/)*(css\/){0,1}([A-Za-z0-9\/._-]+)\.css/Ums', "href=\"$_THEME_PATH/$2$3.css", $source);
        $source = preg_replace('/src=\"(..\/)*js\/([A-Za-z0-9\/._-]+)\.js/Ums', "src=\"$_THEME_PATH/js/$2.js", $source);
        $source = preg_replace('/^<meta\shttp-equiv=["|\']Content-Type["|\']\scontent=["|\']text\/html;\scharset=(?:.*?)["|\'][^>]*?>\r?\n?/i', '', $source);
        $source = preg_replace('/<!--.*{(.*)}.*-->/U', '{$1}', $source);

        return $source;
    }
    $smarty->register_prefilter('remove_html_comments');
}

// 开启缓冲区
ob_start();

?>