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

// rec操作项的初始化
$rec = $check->is_rec($_REQUEST['rec']) ? $_REQUEST['rec'] : 'default';

// 图片上传
include_once (ROOT_PATH . 'include/file.class.php');
$file = new File('images/page/'); // 实例化类文件(文件上传路径，结尾加斜杠)

// 扩展数据模块
if ($_OPEN['data']) {
    include_once (ROOT_PATH . 'include/data.class.php');
    $dou_data = new Data();
}

$smarty->assign('rec', $rec);
$smarty->assign('cur', 'page');

/**
 * +----------------------------------------------------------
 * 单页面列表
 * +----------------------------------------------------------
 */
if ($rec == 'default') {
    $smarty->assign('ur_here', $_LANG['page_list']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['page_add'],
            'href' => 'page.php?rec=add' 
    ));
    
    // 赋值给模板
    $smarty->assign('page_list', $dou->get_page_nolevel());
    
    $smarty->display('page.htm');
} 

/**
 * +----------------------------------------------------------
 * 单页面添加
 * +----------------------------------------------------------
 */
elseif ($rec == 'add') {
    $smarty->assign('ur_here', $_LANG['page_add']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['page_list'],
            'href' => 'page.php' 
    ));
    
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    
    // 赋值给模板
    $smarty->assign('form_action', 'insert');
    $smarty->assign('item_id', $dou->auto_id('page'));
    $smarty->assign('page_list', $dou->get_page_nolevel());
    $smarty->assign('btn_lang', $dou->btn_lang('page', '', 'page_name, content, keywords, description'));
    
    $smarty->display('page.htm');
} 

elseif ($rec == 'insert') {
    if (empty($_POST['page_name']))
        $dou->dou_msg($_LANG['page_name'] . $_LANG['is_empty']);
    
    if (!$check->is_unique_id($_POST['unique_id']))
        $dou->dou_msg($_LANG['unique_id_wrong']);

    if ($dou->value_exist('page', 'unique_id', $_POST['unique_id']))
        $dou->dou_msg($_LANG['unique_id_existed']);
 
    // 可视化编辑模式，生成一个随机编辑码
    $editor_code = $_POST['mode'] == 'visualize' ? $dou->rand_editor_code() : '';
        
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token']);
    
    $sql = "INSERT INTO " . $dou->table('page') . " (id, unique_id, parent_id, page_name, content ,keywords, description, editor_code, mode)" . " VALUES (NULL, '$_POST[unique_id]', '$_POST[parent_id]', '$_POST[page_name]', '$_POST[content]', '$_POST[keywords]', '$_POST[description]', '$editor_code', '$_POST[mode]')";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['page_add'] . ': ' . $_POST[page_name]);
    $dou->dou_msg($_LANG['page_add_succes'], 'page.php');
} 

/**
 * +----------------------------------------------------------
 * 单页面编辑
 * +----------------------------------------------------------
 */
elseif ($rec == 'edit') {
    $smarty->assign('ur_here', $_LANG['page_edit']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['page_list'],
            'href' => 'page.php' 
    ));
    
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : '';
    
    $page = $dou->get_row('page', '*', "id = '$id'");
    $page['editor_url'] = $dou->param($dou->rewrite_url('page', $id) . '&editor_code=' . $page['editor_code']);
    
    // 扩展数据模块
    if ($_OPEN['data'])
        $smarty->assign('data', $dou_data->get_data('page', $id));
 
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    
    // 赋值给模板
    $smarty->assign('form_action', 'update');
    $smarty->assign('page_list', $dou->get_page_nolevel(0, 0, $id));
    $smarty->assign('item_id', $id);
    $smarty->assign('item_content', $page['content']);
    $smarty->assign('page', $page);
    $smarty->assign('btn_lang', $dou->btn_lang('page', $id, 'page_name, content, keywords, description'));
    
    $smarty->display('page.htm');
} 

elseif ($rec == 'update') {
    // 验证并获取合法的ID
    $id = $check->is_number($_POST['id']) ? $_POST['id'] : '';
    
    if (empty($_POST['page_name']))
        $dou->dou_msg($_LANG['page_name'] . $_LANG['is_empty']);
    
    if (!$check->is_unique_id($_POST['unique_id']))
        $dou->dou_msg($_LANG['unique_id_wrong']);

    if ($dou->value_exist('page', 'unique_id', $_POST['unique_id'], "id != '$id'"))
        $dou->dou_msg($_LANG['unique_id_existed']);
        
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token']);
 
    // 可视化编辑模式，生成一个随机编辑码
    if ($_POST['mode'] == 'visualize') {
        $editor_code = $dou->get_one("SELECT editor_code FROM " . $dou->table('page') . " WHERE id = '$id'");
        $editor_code = $editor_code ? $editor_code : $dou->rand_editor_code();
    }
    
    $sql = "UPDATE " . $dou->table('page') . " SET unique_id = '$_POST[unique_id]', parent_id = '$_POST[parent_id]', page_name = '$_POST[page_name]', content = '$_POST[content]', keywords = '$_POST[keywords]', description = '$_POST[description]', editor_code = '$editor_code', mode = '$_POST[mode]' WHERE id = '$id'";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['page_edit'] . ': ' . $_POST['page_name']);
    $dou->dou_msg($_LANG['page_edit_succes'], 'page.php', '', '3');
}

// 前台可视化编辑
elseif ($rec == 'visualize') {
    $act = $check->is_rec($_REQUEST['act']) ? $_REQUEST['act'] : 'default';
    
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : '';
    $page_name = $dou->get_one("SELECT page_name FROM " . $dou->table('page') . " WHERE id = '$id'");
    
    if ($act == 'default') {
        $dou->query("UPDATE " . $dou->table('page') . " SET content = '$_POST[content]' WHERE id = '$id'");
        $dou->create_admin_log($_LANG['page_edit'] . '（' . $_LANG['page_mode_visualize'] . '）' . ': ' . $page_name);
        $data['status'] = 'yes';
        echo json_encode($data);
    } elseif ($act == 'clear') {
        $dou->query("UPDATE " . $dou->table('page') . " SET content = '' WHERE id = '$id'");
        $dou->create_admin_log($_LANG['page_edit'] . '（' . $_LANG['page_mode_visualize_clear'] . '）' . ': ' . $page_name);
     
        $dou->dou_msg($_LANG['page_mode_visualize_clear'] . $_LANG['success'], "page.php?rec=edit&id=$id", '', '3');
    }
}

/**
 * +----------------------------------------------------------
 * 单页面删除
 * +----------------------------------------------------------
 */
elseif ($rec == 'del') {
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : $dou->dou_msg($_LANG['illegal'], 'page.php');
    
    $page_name = $dou->get_one("SELECT page_name FROM " . $dou->table('page') . " WHERE id = '$id'");
    $is_parent = $dou->get_one("SELECT id FROM " . $dou->table('page') . " WHERE parent_id = '$id'");
    
    if ($id == '1') {
        $dou->dou_msg($_LANG['page_del_wrong'], 'page.php', '', '3');
    } elseif ($is_parent) {
        $_LANG['page_del_is_parent'] = preg_replace('/d%/Ums', $page_name, $_LANG['page_del_is_parent']);
        $dou->dou_msg($_LANG['page_del_is_parent'], 'page.php', '', '3');
    } else {
        if (isset($_POST['confirm'])) {
            $dou->create_admin_log($_LANG['page_del'] . ': ' . $page_name);
            $dou->delete('page', "id = '$id'", 'page.php');
        } else {
            $_LANG['del_check'] = preg_replace('/d%/Ums', $page_name, $_LANG['del_check']);
            $dou->dou_msg($_LANG['del_check'], 'page.php', '', '30', "page.php?rec=del&id=$id");
        }
    }
}

?>