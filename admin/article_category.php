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

// 赋值给模板
$smarty->assign('rec', $rec);
$smarty->assign('cur', 'article_category');

/**
 * +----------------------------------------------------------
 * 分类列表
 * +----------------------------------------------------------
 */
if ($rec == 'default') {
    $smarty->assign('ur_here', $_LANG['article_category']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['article_category_add'],
            'href' => 'article_category.php?rec=add' 
    ));
    
    // 赋值给模板
    $smarty->assign('article_category', $dou->get_category_nolevel('article_category'));
    
    $smarty->display('article_category.htm');
} 

/**
 * +----------------------------------------------------------
 * 分类添加
 * +----------------------------------------------------------
 */
elseif ($rec == 'add') {
    $smarty->assign('ur_here', $_LANG['article_category_add']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['article_category'],
            'href' => 'article_category.php' 
    ));
    
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    
    // 赋值给模板
    $smarty->assign('form_action', 'insert');
    $smarty->assign('article_category', $dou->get_category_nolevel('article_category'));
    $smarty->assign('btn_lang', $dou->btn_lang('article_category', '', 'cat_name, keywords, description'));
    
    $smarty->display('article_category.htm');
} 

elseif ($rec == 'insert') {
    if (empty($_POST['cat_name']))
        $dou->dou_msg($_LANG['article_category_cat_name'] . $_LANG['is_empty']);

    if (!$check->is_unique_id($_POST['unique_id']))
        $dou->dou_msg($_LANG['unique_id_wrong']);

    if ($dou->value_exist('article_category', 'unique_id', $_POST['unique_id']))
        $dou->dou_msg($_LANG['unique_id_existed']);
        
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token']);
    
    $sql = "INSERT INTO " . $dou->table('article_category') . " (cat_id, unique_id, parent_id, cat_name, keywords, description, sort)" . " VALUES (NULL, '$_POST[unique_id]', '$_POST[parent_id]', '$_POST[cat_name]', '$_POST[keywords]', '$_POST[description]', '$_POST[sort]')";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['article_category_add'] . ': ' . $_POST['cat_name']);
    $dou->dou_msg($_LANG['article_category_add_succes'], 'article_category.php');
} 

/**
 * +----------------------------------------------------------
 * 分类编辑
 * +----------------------------------------------------------
 */
elseif ($rec == 'edit') {
    $smarty->assign('ur_here', $_LANG['article_category_edit']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['article_category'],
            'href' => 'article_category.php' 
    ));
    
    // 获取分类信息
    $cat_id = $check->is_number($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '';
    $cat_info = $dou->get_row('article_category', '*', "cat_id = '$cat_id'");
    
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    
    // 赋值给模板
    $smarty->assign('form_action', 'update');
    $smarty->assign('article_category', $dou->get_category_nolevel('article_category', '0', '0', $cat_id));
    $smarty->assign('cat_info', $cat_info);
    $smarty->assign('btn_lang', $dou->btn_lang('article_category', $cat_id, 'cat_name, keywords, description'));
    
    $smarty->display('article_category.htm');
} 

elseif ($rec == 'update') {
    // 验证并获取合法的ID
    $cat_id = $check->is_number($_POST['cat_id']) ? $_POST['cat_id'] : '';
    
    if (empty($_POST['cat_name']))
        $dou->dou_msg($_LANG['article_category_cat_name'] . $_LANG['is_empty']);

    if (!$check->is_unique_id($_POST['unique_id']))
        $dou->dou_msg($_LANG['unique_id_wrong']);

    if ($dou->value_exist('article_category', 'unique_id', $_POST['unique_id'], "cat_id != '$cat_id'"))
        $dou->dou_msg($_LANG['unique_id_existed']);
        
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token']);
    
    $sql = "update " . $dou->table('article_category') . " SET cat_name = '$_POST[cat_name]', unique_id = '$_POST[unique_id]', parent_id = '$_POST[parent_id]', keywords = '$_POST[keywords]' ,description = '$_POST[description]', sort = '$_POST[sort]' WHERE cat_id = '$cat_id'";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['article_category_edit'] . ': ' . $_POST['cat_name']);
    $dou->dou_msg($_LANG['article_category_edit_succes'], 'article_category.php');
} 

/**
 * +----------------------------------------------------------
 * 分类删除
 * +----------------------------------------------------------
 */
elseif ($rec == 'del') {
    $cat_id = $check->is_number($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : $dou->dou_msg($_LANG['illegal'], 'article_category.php');
    $cat_name = $dou->get_one("SELECT cat_name FROM " . $dou->table('article_category') . " WHERE cat_id = '$cat_id'");
    $is_parent = $dou->get_one("SELECT id FROM " . $dou->table('article') . " WHERE cat_id = '$cat_id'") . $dou->get_one("SELECT cat_id FROM " . $dou->table('article_category') . " WHERE parent_id = '$cat_id'");
    
    if ($is_parent) {
        $_LANG['article_category_del_is_parent'] = preg_replace('/d%/Ums', $cat_name, $_LANG['article_category_del_is_parent']);
        $dou->dou_msg($_LANG['article_category_del_is_parent'], 'article_category.php', '', '3');
    } else {
        if (isset($_POST['confirm'])) {
            // 删除相应图标图片
            $icon = $dou->get_one("SELECT icon FROM " . $dou->table('product_category') . " WHERE cat_id = '$cat_id'");
            $dou->del_file($icon);
         
            // 删除对应语言项
            if ($_OPEN['language'])
                $dou->del_lang_value('article_category', $cat_id);
            
            $dou->create_admin_log($_LANG['article_category_del'] . ': ' . $cat_name);
            $dou->delete('article_category', "cat_id = $cat_id", 'article_category.php');
        } else {
            $_LANG['del_check'] = preg_replace('/d%/Ums', $cat_name, $_LANG['del_check']);
            $dou->dou_msg($_LANG['del_check'], 'article_category.php', '', '30', "article_category.php?rec=del&cat_id=$cat_id");
        }
    }
}

?>