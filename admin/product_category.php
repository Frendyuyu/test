<?php
/**
 * DouPHP
 * --------------------------------------------------------------------------------------------------
 * 版权所有 2013-2020 漳州豆壳网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.douphp.com
 * --------------------------------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在遵守授权协议前提下对程序代码进行修改和使用；不允许对程序代码以任何形式任何目的的再发布。
 * 授权协议: http://www.douphp.com/license.html
 * --------------------------------------------------------------------------------------------------
 * Author: DouCo
 * Release Date: 2019-01-08
 */
define('IN_DOUCO', true);

require (dirname(__FILE__) . '/include/init.php');

// rec操作项的初始化
$rec = $check->is_rec($_REQUEST['rec']) ? $_REQUEST['rec'] : 'default';

// 图片上传
include_once (ROOT_PATH . 'include/file.class.php');
$file = new File('images/product/icon/'); // 实例化类文件(文件上传路径，结尾加斜杠)

// 款式属性模块
if ($_OPEN['attribute']) {
    include_once (ROOT_PATH . 'include/attribute.class.php');
    $dou_attribute = new Attribute();
}

// 赋值给模板
$smarty->assign('rec', $rec);
$smarty->assign('cur', 'product_category');

/**
 * +----------------------------------------------------------
 * 分类列表
 * +----------------------------------------------------------
 */
if ($rec == 'default') {
    $smarty->assign('ur_here', $_LANG['product_category']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['product_category_add'],
            'href' => 'product_category.php?rec=add' 
    ));
    
    // 赋值给模板
    $smarty->assign('product_category', $dou->get_category_nolevel('product_category'));
    
    $smarty->display('product_category.htm');
} 

/**
 * +----------------------------------------------------------
 * 分类添加
 * +----------------------------------------------------------
 */
elseif ($rec == 'add') {
    $smarty->assign('ur_here', $_LANG['product_category_add']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['product_category'],
            'href' => 'product_category.php' 
    ));
    
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    
    // 赋值给模板
    $smarty->assign('form_action', 'insert');
    $smarty->assign('product_category', $dou->get_category_nolevel('product_category'));
    $smarty->assign('btn_lang', $dou->btn_lang('product_category', '', 'cat_name, keywords, description'));
    
    $smarty->display('product_category.htm');
} 

elseif ($rec == 'insert') {
    if (empty($_POST['cat_name']))
        $dou->dou_msg($_LANG['product_category_cat_name'] . $_LANG['is_empty']);
    
    if (!$check->is_unique_id($_POST['unique_id']))
        $dou->dou_msg($_LANG['unique_id_wrong']);
        
    if ($dou->value_exist('product_category', 'unique_id', $_POST['unique_id']))
        $dou->dou_msg($_LANG['unique_id_existed']);
        
    // 文件上传盒子
    $auto_id = $dou->auto_id('product_category');
    $icon = $file->box('product_category', $auto_id, 'icon', 'main', 'cat_' . $auto_id);
        
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token']);
    
    $sql = "INSERT INTO " . $dou->table('product_category') . " (cat_id, unique_id, parent_id, cat_name, icon, keywords, description, sort)" . " VALUES (NULL, '$_POST[unique_id]', '$_POST[parent_id]', '$_POST[cat_name]', '$icon', '$_POST[keywords]', '$_POST[description]', '$_POST[sort]')";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['product_category_add'] . ': ' . $_POST[cat_name]);
    $dou->dou_msg($_LANG['product_category_add_succes'], 'product_category.php');
} 

/**
 * +----------------------------------------------------------
 * 分类编辑
 * +----------------------------------------------------------
 */
elseif ($rec == 'edit') {
    $smarty->assign('ur_here', $_LANG['product_category_edit']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['product_category'],
            'href' => 'product_category.php' 
    ));
    
    // 获取分类信息
    $cat_id = $check->is_number($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '';
    $cat_info = $dou->get_row('product_category', '*', "cat_id = '$cat_id'");
    $cat_info['icon'] = $dou->dou_file($cat_info['icon']);
    
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    
    // 赋值给模板
    $smarty->assign('form_action', 'update');
    $smarty->assign('product_category', $dou->get_category_nolevel('product_category', '0', '0', $cat_id));
    $smarty->assign('cat_info', $cat_info);
    $smarty->assign('btn_lang', $dou->btn_lang('product_category', $cat_id, 'cat_name, keywords, description'));
    
    $smarty->display('product_category.htm');
} 

elseif ($rec == 'update') {
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token']);
    
    // 验证并获取合法的ID
    $cat_id = $check->is_number($_POST['cat_id']) ? $_POST['cat_id'] : '';
    
    if (empty($_POST['cat_name']))
        $dou->dou_msg($_LANG['product_category_cat_name'] . $_LANG['is_empty']);

    if (!$check->is_unique_id($_POST['unique_id']))
        $dou->dou_msg($_LANG['unique_id_wrong']);

    if ($dou->value_exist('product_category', 'unique_id', $_POST['unique_id'], "cat_id != '$cat_id'"))
        $dou->dou_msg($_LANG['unique_id_existed']);
        
    // 文件上传盒子
    $icon = $file->box('product_category', $cat_id, 'icon', 'main', 'cat_' . $cat_id);
    $icon = $icon ? ", icon = '" . $icon . "'" : '';
    
    $sql = "update " . $dou->table('product_category') . " SET unique_id = '$_POST[unique_id]', cat_name = '$_POST[cat_name]'" . $icon . ", parent_id = '$_POST[parent_id]', keywords = '$_POST[keywords]', description = '$_POST[description]', sort = '$_POST[sort]' WHERE cat_id = '$cat_id'";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['product_category_edit'] . ': ' . $_POST['cat_name']);
    $dou->dou_msg($_LANG['product_category_edit_succes'], 'product_category.php');
} 

/**
 * +----------------------------------------------------------
 * 分类删除
 * +----------------------------------------------------------
 */
elseif ($rec == 'del') {
    $cat_id = $check->is_number($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : $dou->dou_msg($_LANG['illegal'], 'product_category.php');
    $cat_name = $dou->get_one("SELECT cat_name FROM " . $dou->table('product_category') . " WHERE cat_id = '$cat_id'");
    $is_parent = $dou->get_one("SELECT id FROM " . $dou->table('product') . " WHERE cat_id = '$cat_id'") .
             $dou->get_one("SELECT cat_id FROM " . $dou->table('product_category') . " WHERE parent_id = '$cat_id'");
    
    if ($is_parent) {
        $_LANG['product_category_del_is_parent'] = preg_replace('/d%/Ums', $cat_name, $_LANG['product_category_del_is_parent']);
        $dou->dou_msg($_LANG['product_category_del_is_parent'], 'product_category.php', '', '3');
    } else {
        if (isset($_POST['confirm'])) {
            // 删除相应图标图片
            $icon = $dou->get_one("SELECT icon FROM " . $dou->table('product_category') . " WHERE cat_id = '$cat_id'");
            $dou->del_file($icon);
         
            // 删除对应语言项
            if ($_OPEN['language'])
                $dou->del_lang_value('product_category', $cat_id);
            
            $dou->create_admin_log($_LANG['product_category_del'] . ': ' . $cat_name);
            $dou->delete('product_category', "cat_id = $cat_id", 'product_category.php');
        } else {
            $_LANG['del_check'] = preg_replace('/d%/Ums', $cat_name, $_LANG['del_check']);
            $dou->dou_msg($_LANG['del_check'], 'product_category.php', '', '30', "product_category.php?rec=del&cat_id=$cat_id");
        }
    }
}

?>