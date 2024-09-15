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
define('IN_DOUCO', true);

// 载入语言文件
require (dirname(__FILE__) . '/include/init.php');

// rec操作项的初始化
$rec = $check->is_rec($_REQUEST['rec']) ? $_REQUEST['rec'] : 'default';

// 定义缓存路径.卸载模块使用
$cache_dir = ROOT_PATH . 'cache/';

$smarty->assign('rec', $rec);
$smarty->assign('cur', 'module');

/**
 * +----------------------------------------------------------
 * 扩展列表
 * +----------------------------------------------------------
 */
if ($rec == 'default') {
    $smarty->assign('ur_here', $_LANG['module']);

    $smarty->assign('get', urlencode(serialize($_GET)));
    $smarty->assign('localsite', $dou->dou_localsite('module'));

    $smarty->display('module.htm');
} 

/**
 * +----------------------------------------------------------
 * 安装本地模块
 * +----------------------------------------------------------
 */
if ($rec == 'install_local') {
    $smarty->assign('ur_here', $_LANG['module']);
    
    // 载入待删除模块
    $zipfile_list = glob($cache_dir . '*.zip');
    if (is_array($zipfile_list)) {
        foreach ($zipfile_list as $zipfile) {
            $install_list[] = preg_replace('/.zip/i', '', basename($zipfile));
        }
    }

    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    $smarty->assign('install_list', $install_list);

    $smarty->display('module.htm');
}

/**
 * +----------------------------------------------------------
 * 模板卸载页面
 * +----------------------------------------------------------
 */
if ($rec == 'uninstall') {
    $smarty->assign('ur_here', $_LANG['module']);
    
    // 如果存在模块锁则不能卸载
    if (!file_exists(ROOT_PATH . 'data/module.lock'))
        $uninstall_list = $_MODULE['all'];

    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());

    $smarty->assign('uninstall_list', $uninstall_list);
    $smarty->display('module.htm');
} 

/**
 * +----------------------------------------------------------
 * 卸载模块
 * +----------------------------------------------------------
 */
if ($rec == 'del') {
    // 载入扩展功能
    include_once (ROOT_PATH . ADMIN_PATH . '/include/cloud.class.php');
    $dou_cloud = new Cloud('cache');

    // CSRF防御令牌验证
    $firewall->check_token($_GET['token']);
    
    // 模块ID正确，且模块锁不存在
    if ($check->is_extend_id($extend_id = $_REQUEST['extend_id']) && !file_exists(ROOT_PATH . 'data/module.lock')) {
        $module_installed_file = ROOT_PATH . 'data/installed/' . $extend_id . '.installed.php'; // 模块目录
        if (file_exists($module_installed_file)) {
            $dou_cloud->clear_module($extend_id);
            $dou_cloud->change_updatedate('module', $extend_id, true); // 删除更新时间记录
            @unlink($module_installed_file);
            $dou->create_admin_log($_LANG['module_uninstall_success'] . ': ' . $extend_id);
            
            $dou->dou_header('module.php?rec=uninstall');
        } else {
            $dou->dou_msg($_LANG['module_uninstall_install_file_wrong'], 'module.php?rec=uninstall');
        }
    } else {
        $dou->dou_msg($_LANG['module_uninstall_wrong'], 'module.php?rec=uninstall');
    }
}

?>