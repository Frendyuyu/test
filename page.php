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

$_CUR = 'page';
require (dirname(__FILE__) . '/include/init.php');
$smarty->assign('cur', $_CUR);

// 验证并获取合法的ID，如果不合法将其设定为-1
$id = $firewall->get_legal_id('page', $_REQUEST['id'], $_REQUEST['unique_id']);
if ($id == -1)
    $dou->dou_msg($GLOBALS['_LANG']['page_wrong'], ROOT_URL);
    
// 获取单页面信息
$page = $dou->get_row('page', '*', "id = '$id'");

// 多语言
$page = $dou->lang_box($page, 'page', 'page_name, content, keywords, description');

// 获取上级单页面信息
$top_id = $page['parent_id'] == 0 ? $id : $page['parent_id'];
$top = $dou->get_row('page', '*', "id = '$top_id'");
$top['url'] = $dou->rewrite_url('page', $top_id);

// 多语言
$top = $dou->lang_box($top, 'page', 'page_name, content, keywords, description');

// 可视化编辑
$editor_code = $check->is_number($_REQUEST['editor_code']) ? $_REQUEST['editor_code'] : '';
if ($page['mode'] == 'visualize' && $editor_code == $page['editor_code'])
    $smarty->assign('editor_mode', true);

// 扩展数据模块
if ($_OPEN['data']) {
    include_once (ROOT_PATH . 'include/data.class.php');
    $dou_data = new Data();
    $smarty->assign('data', $dou_data->get_data('page', $id));
}

// 赋值给模板-meta和title信息
$smarty->assign('page_title', $dou->page_title('page', '', $page['page_name']));
$smarty->assign('keywords', $page['keywords']);
$smarty->assign('description', $page['description']);

// 赋值给模板-导航栏
$smarty->assign('nav_top_list', $dou->get_nav('top'));
$smarty->assign('nav_middle_list', $dou->get_nav('middle', '0', 'page', $id));
$smarty->assign('nav_bottom_list', $dou->get_nav('bottom'));

// 赋值给模板-数据
$smarty->assign('ur_here', $dou->ur_here('page', '', $page['page_name']));
$smarty->assign('page_list', $dou->get_page_list($top_id, $id));
$smarty->assign('top', $top);
$smarty->assign('page', $page);
if ($top_id == $id)
    $smarty->assign("top_cur", 'top_cur');

if (file_exists(ROOT_PATH . "theme/$_CFG[site_theme]/" . $page['unique_id'] . '.dwt')) {
    // 自定义单页模板
    $smarty->display($page['unique_id'] . '.dwt');
} else {
    $smarty->display('page.dwt');
}

?>