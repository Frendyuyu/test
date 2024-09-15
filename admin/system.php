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

require (dirname(__FILE__) . '/include/init.php');

// 图片上传
include_once (ROOT_PATH . 'include/file.class.php');
$file = new File('theme/' . $_CFG['site_theme'] . '/images/', '', 'jpg,jpeg,gif,png,ico'); // 实例化类文件(文件上传路径，结尾加斜杠)

// rec操作项的初始化
$rec = $check->is_rec($_REQUEST['rec']) ? $_REQUEST['rec'] : 'default';

// 赋值给模板
$smarty->assign('cur', 'system');
$smarty->assign('light', $check->is_rec($_REQUEST['light']) ? $_REQUEST['light'] : '');

/**
 * +----------------------------------------------------------
 * 系统设置
 * +----------------------------------------------------------
 */
if ($rec == 'default') {
    $smarty->assign('ur_here', $_LANG['system']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['system_developer'],
            'href' => 'system.php?dou' 
    ));
 
    // 开发者模式开关
    if ($_REQUEST['dou'] == 'open') {
        $dou->query("UPDATE " . $dou->table('config') . " SET value = '1' WHERE name = 'developer'");
        $dou->dou_header('system.php');
    } elseif ($_REQUEST['dou'] == 'close') {
        $dou->query("UPDATE " . $dou->table('config') . " SET value = '0' WHERE name = 'developer'");
        $dou->dou_header('system.php');
    }
    
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    
    if (isset($_REQUEST['dou'])) {
        $tab_list = array('developer');
    } else {
        $tab_list = array('main', 'customer', 'display', 'defined', 'mail');
     
        // 载入当前细分系统的配置信息
        if ($dou->get_one("SELECT value FROM " . $dou->table('config') . " WHERE tab = 'system_param' AND name = 'core'")) {
            $tab_list_new[] = 'system_param';
            array_splice($tab_list, 1, 0, $tab_list_new);
        }
    }
    
    // 生成设置项
    foreach ($tab_list as $tab) {
        $cfg[] = array (
                "name" => $tab,
                "lang" => $_LANG['system_' . $tab],
                "list" => $dou->get_cfg_list($tab)
        );
    }
 
    // 参数设置-无分类的
    $parameter_system_list = $dou->fn_query("SELECT * FROM " . $dou->table('parameter') . " WHERE `group` = 'system' ORDER BY sort ASC, id ASC");
 
    // 参数设置-在线客服
    $parameter_customer_list = $dou->fn_query("SELECT * FROM " . $dou->table('parameter') . " WHERE `group` = 'customer' ORDER BY sort ASC, id ASC");
 
    // 短信模块
    if (file_exists($sms_class_file = ROOT_PATH . 'include/sms.class.php'))
        $smarty->assign('sms_tab', true);
 
    // 赋值给模板
    $smarty->assign('cfg', $cfg);
    $smarty->assign('parameter_system_list', $parameter_system_list);
    $smarty->assign('parameter_customer_list', $parameter_customer_list);
    $smarty->assign('lang_list', $dou->get_lang_list());
    
    if (isset($_REQUEST['dou'])) { // 开发者设置
        // 开发者纯净模式
        $smarty->assign('cfg_pure_mode', $dou->get_row('config', '*', "name = 'pure_mode'"));
        
        $smarty->display('system_developer.htm');
    } else { // 常规设置
        $smarty->display('system.htm');
    }
}

/**
 * +----------------------------------------------------------
 * 系统设置数据更新
 * +----------------------------------------------------------
 */
if ($rec == 'update') {
    // 验证系统语言选择
    if (!preg_match("/^[a-z_]+$/", $_POST['language']) && $_REQUEST['tab'] != 'developer')
        $dou->dou_msg($_LANG['language_wrong'], 'system.php');
    
    // 站点LOGO
    if ($_FILES['site_logo']['name'] != "") {
        $site_logo = $file->upload('site_logo', 'logo'); // 上传的文件域
        $_POST['site_logo'] = $site_logo;
    }
    
    // 站点LOGO.另一个
    if ($_FILES['site_logo_other']['name'] != "") {
        $site_logo_other = $file->upload('site_logo_other', 'logo_other'); // 上传的文件域
        $_POST['site_logo_other'] = $site_logo_other;
    }
    
    // 上传favicon
    if ($_FILES['site_favicon']['name'] != "") {
        $site_favicon = $file->upload('site_favicon', 'favicon', ROOT_PATH); // 上传的文件域
        $_POST['site_favicon'] = $site_favicon;
    }
    
    // 上传微信二维码
    if ($_FILES['weixin_img']['name'] != "") {
        $weixin_img = $file->upload('weixin_img', 'weixin', ROOT_PATH . 'images/upload/'); // 上传的文件域
        $_POST['weixin_img'] = $weixin_img;
    }
 
    // 站点网址
    if (!$check->is_domain($_POST['domain']))
        $_POST['domain'] = '';
    
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token']);
    
    foreach ($_POST as $name => $value) {
        // 参数设置
        if (strpos($name, '_parameter_') === 0) {
            $name = str_replace('_parameter_', '', $name);
            $dou->query("UPDATE " . $dou->table('parameter') . " SET value = '$value' WHERE name = '$name'");
        }
     
        // 数组
        if (is_array($value))
            $value = serialize($value);
     
        $dou->query("UPDATE " . $dou->table('config') . " SET value = '$value' WHERE name = '$name'");
    }
    
    $dou->create_admin_log($_LANG['system'] . ': ' . $_LANG['edit_succes']);
    $dou->dou_msg($_LANG['edit_succes'], 'system.php');
}

?>