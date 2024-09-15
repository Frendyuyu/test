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
$file = new File('images/fragment/'); // 实例化类文件(文件上传路径，结尾加斜杠)

$smarty->assign('rec', $rec);
$smarty->assign('cur', 'fragment');

/**
 * +----------------------------------------------------------
 * 数据列表
 * +----------------------------------------------------------
 */
if ($rec == 'default') {
    $smarty->assign('ur_here', $_LANG['fragment_list']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['fragment_add'],
            'href' => 'fragment.php?rec=add' 
    ));
    
    // 赋值给模板
    $smarty->assign('fragment_list', $dou->get_fragment_list());
    $smarty->display('fragment.htm');
} 

/**
 * +----------------------------------------------------------
 * 数据添加
 * +----------------------------------------------------------
 */
elseif ($rec == 'add') {
    $smarty->assign('ur_here', $_LANG['fragment_add']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['fragment_list'],
            'href' => 'fragment.php' 
    ));
    
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    
    // 赋值给模板
    $smarty->assign('form_action', 'insert');
    $smarty->assign('fragment_list', $dou->get_fragment_list());
    $smarty->assign('btn_lang', $dou->btn_lang('fragment', '', 'name, image, text, link'));
    
    $smarty->display('fragment.htm');
} 

elseif ($rec == 'insert') {
    // 验证碎片名称
    if (empty($_POST['name']))
        $dou->dou_msg($_LANG['fragment_name'] . $_LANG['is_empty']);
    
    // 验证码碎片标记
    if (!preg_match("/^[a-z0-9_]+$/", $_POST['mark']))
        $dou->dou_msg($_LANG['fragment_mark_cue']);

    // 文件上传盒子
    $image = $file->box('fragment', $dou->auto_id('fragment'), 'image', 'main', $_POST['mark']);
        
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token']);
    
    $sql = "INSERT INTO " . $dou->table('fragment') . " (id, name, mark, parent_id, text ,image, link, home)" . " VALUES (NULL, '$_POST[name]', '$_POST[mark]', '$_POST[parent_id]', '$_POST[text]', '$image', '$_POST[link]', '$_POST[home]')";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['fragment_add'] . ': ' . $_POST['name']);
    $dou->dou_msg($_LANG['fragment_add_succes'], 'fragment.php');
} 

/**
 * +----------------------------------------------------------
 * 数据编辑
 * +----------------------------------------------------------
 */
elseif ($rec == 'edit') {
    $smarty->assign('ur_here', $_LANG['fragment_edit']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['fragment_list'],
            'href' => 'fragment.php' 
    ));
    
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : '';
    
    $fragment = $dou->get_row('fragment', '*', "id = '$id'");
    
    // 格式化数据
    $fragment['image'] = $dou->dou_file($fragment['image']);
 
    // 格式化语言项
    $lang_array = array('name', 'mark', 'image', 'text', 'link');
    foreach ($lang_array as $value) {
        $_LANG['fragment_' . $value . '_cue'] = preg_replace('/.唯一标记/Ums', '.' . $fragment['mark'], $_LANG['fragment_' . $value . '_cue']);
    }
 
    // 关联内容盒子
    $link_box = array (
            "title" => $_LANG['fragment_link_box_a'] . '“' . $fragment['mark'] . '”' . $_LANG['fragment_link_box_b'],
            "text" => $_LANG['fragment_link_text'],
            "btn_link" => 'fragment.php?rec=link_box&id=' . $id,
            "btn_name" => $fragment['box'] ? $_LANG['fragment_link_box_btn_cancel'] : $_LANG['fragment_link_box_btn'],
            "action" => $fragment['box'] ? $_LANG['fragment_link_box_cancel'] : $_LANG['fragment_link_box']
    );
    
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    
    // 赋值给模板
    $smarty->assign('form_action', 'update');
    $smarty->assign('fragment_list', $dou->get_fragment_list(0, $id));
    $smarty->assign('fragment', $fragment);
    $smarty->assign('box_list', $dou->get_box_list($fragment['box']));
    $smarty->assign('lang', $_LANG);
    $smarty->assign('link_box', $link_box);
    $smarty->assign('btn_lang', $dou->btn_lang('fragment', $id, 'name, image, text, link'));
    
    $smarty->display('fragment.htm');
} 

elseif ($rec == 'update') {
    // 验证并获取合法的ID
    $id = $check->is_number($_POST['id']) ? $_POST['id'] : '';
    
    if (empty($_POST['name']))
        $dou->dou_msg($_LANG['fragment_name'] . $_LANG['is_empty']);
    
    if (!preg_match("/^[a-z0-9_]+$/", $_POST['mark']))
        $dou->dou_msg($_LANG['fragment_mark_cue']);

    // 文件上传盒子
    $image = $file->box('fragment', $id, 'image', 'main', $_POST['mark']);
    $image = $image ? ", image = '" . $image . "'" : '';
    
    // CSRF防御令牌验证$id
    $firewall->check_token($_POST['token']);
    
    $sql = "UPDATE " . $dou->table('fragment') . " SET name = '$_POST[name]', mark = '$_POST[mark]', parent_id = '$_POST[parent_id]', text = '$_POST[text]'" . $image . ", link = '$_POST[link]', home = '$_POST[home]' WHERE id = '$id'";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['fragment_edit'] . ': ' . $_POST['name']);
    $dou->dou_msg($_LANG['fragment_edit_succes'], 'fragment.php', '', '3');
}

/**
 * +----------------------------------------------------------
 * 数据删除
 * +----------------------------------------------------------
 */
elseif ($rec == 'del') {
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : $dou->dou_msg($_LANG['illegal'], 'fragment.php');
    
    $name = $dou->get_one("SELECT name FROM " . $dou->table('fragment') . " WHERE id = '$id'");
    $is_parent = $dou->get_one("SELECT id FROM " . $dou->table('fragment') . " WHERE parent_id = '$id'");
    
    if ($is_parent) {
        $_LANG['fragment_del_is_parent'] = preg_replace('/d%/Ums', $name, $_LANG['fragment_del_is_parent']);
        $dou->dou_msg($_LANG['fragment_del_is_parent'], 'fragment.php', '', '3');
    } else {
        if (isset($_POST['confirm'])) {
            // 删除相应商品图片
            $image = $dou->get_one("SELECT image FROM " . $dou->table('fragment') . " WHERE id = '$id'");
            $dou->del_file($image);
            
            $dou->create_admin_log($_LANG['fragment_del'] . ': ' . $name);
            $dou->delete('fragment', "id = $id", 'fragment.php');
        } else {
            $_LANG['del_check'] = preg_replace('/d%/Ums', $name, $_LANG['del_check']);
            $dou->dou_msg($_LANG['del_check'], 'fragment.php', '', '30', "fragment.php?rec=del&id=$id");
        }
    }
}

/**
 * +----------------------------------------------------------
 * 关联内容盒子
 * +----------------------------------------------------------
 */
elseif ($rec == 'link_box') {
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : exit;
    $box = $dou->get_one("SELECT box FROM " . $dou->table('fragment') . " WHERE id = '$id'");
    
    // 更新关联状态
    if ($box) {
        $dou->query("UPDATE " . $dou->table('fragment') . " SET box = '' WHERE id = '$id'");
    } else {
        $dou->query("UPDATE " . $dou->table('fragment') . " SET box = mark WHERE id = '$id'");
    }
    
    $dou->dou_header('fragment.php?rec=edit&id=' . $id);
} 

?>