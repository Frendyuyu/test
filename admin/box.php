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
 
// 内容盒子上传
include_once (ROOT_PATH . 'include/file.class.php');
$file = new File('images/box/'); // 实例化类文件(文件上传路径，结尾加斜杠)

// 分组
if (isset($_REQUEST['class_unique_id']) && !$check->is_illegal_char($_REQUEST['class_unique_id'])) {
    $class_unique_id = $_REQUEST['class_unique_id'];
    $_SESSION['class_unique_id'] = $class_unique_id;
} else {
    $class_unique_id = $dou->get_one("SELECT class_unique_id FROM " . $dou->table('box'));
    if (!$_SESSION['class_unique_id'])
        $_SESSION['class_unique_id'] = $class_unique_id;
}

// 赋值给模板
$smarty->assign('rec', $rec);
$smarty->assign('cur', 'box');
$smarty->assign('ur_here', $_LANG['box']);
$smarty->assign('box_list', $dou->get_box_list($_SESSION['class_unique_id']));
$smarty->assign('class_tab', $dou->get_box('class', $_SESSION['class_unique_id']));
$smarty->assign('class_unique_id_cur', $_SESSION['class_unique_id']);
$smarty->assign('class_cur', $dou->get_one("SELECT class FROM " . $dou->table('box') . " WHERE class_unique_id = '" . $_SESSION['class_unique_id'] . "'"));

/**
 * +----------------------------------------------------------
 * 内容盒子列表
 * +----------------------------------------------------------
 */
if ($rec == 'default') {
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
 
    // 赋值给模板
    $smarty->assign('class_list', $dou->get_box('class'));
    $smarty->assign('btn_lang', $dou->btn_lang('box', '', 'name, text, image, link'));
    $smarty->display('box.htm');
} 

/**
 * +----------------------------------------------------------
 * 内容盒子添加处理
 * +----------------------------------------------------------
 */
elseif ($rec == 'insert') {
    // 判断是否为空
    $wrong = $check->fn_empty('box', 'name, class');
 
    // 显示错误提示
    if ($wrong) {
        foreach ($wrong as $key => $value) {
            $dou->dou_msg($wrong[$key]);;
        }
    }
 
    // 文件上传盒子
    $image = $file->box('box', $dou->auto_id('box'), 'image', 'main');

    // CSRF防御令牌验证
    $firewall->check_token($_POST['token']);

    $sql = "INSERT INTO " . $dou->table('box') . " (id, name, class, class_unique_id, text, link, image, sort)" . " VALUES (NULL, '$_POST[name]', '$_POST[class]', '$_POST[class_unique_id]', '$_POST[text]', '$_POST[link]', '$image', '$_POST[sort]')";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['box_add'] . ': ' . $_POST['name']);
    $dou->dou_header('box.php?class_unique_id=' . $_POST['class_unique_id']);
} 

/**
 * +----------------------------------------------------------
 * 内容盒子编辑
 * +----------------------------------------------------------
 */
elseif ($rec == 'edit') {
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : '';
    
    $box = $dou->get_row('box', '*', "id = '$id'");
    
    // 格式化数据
    $box['image'] = $dou->dou_file($box['image']);
    
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    
    // 赋值给模板
    $smarty->assign('box', $box);
    $smarty->assign('class_list', $dou->get_box('class', $box['class_unique_id']));
    $smarty->assign('btn_lang', $dou->btn_lang('box', $id, 'name, text, image, link'));
    
    $smarty->display('box.htm');
} 

elseif ($rec == 'update') {
    // 验证并获取合法的ID
    $id = $check->is_number($_POST['id']) ? $_POST['id'] : '';
    
    // 判断是否为空
    $wrong = $check->fn_empty('box', 'name, class');
 
    // 显示错误提示
    if ($wrong) {
        foreach ($wrong as $key => $value) {
            $dou->dou_msg($wrong[$key]);;
        }
    }
 
    // 文件上传盒子
    $image = $file->box('box', $id, 'image', 'main');
    $image = $image ? ", image = '" . $image . "'" : '';

    // CSRF防御令牌验证
    $firewall->check_token($_POST['token']);
    
    $sql = "UPDATE " . $dou->table('box') . " SET name='$_POST[name]', class = '$_POST[class]', class_unique_id = '$_POST[class_unique_id]', text = '$_POST[text]', link = '$_POST[link]'" . $image . ", sort = '$_POST[sort]' WHERE id = '$id'";
    $dou->query($sql);
    $dou->create_admin_log($_LANG['box_edit'] . ': ' . $_POST['name']);
    $dou->dou_header('box.php?class_unique_id=' . $_POST['class_unique_id']);
} 

/**
 * +----------------------------------------------------------
 * 文件盒子
 * +----------------------------------------------------------
 */
elseif ($rec == 'filebox') {
    // 验证并获取合法的REQUEST
    $id = $check->is_number($_REQUEST['item_id']) ? $_REQUEST['item_id'] : '';
    $type = $check->is_letter($_REQUEST['type']) ? $_REQUEST['type'] : '';
    
    // 文件上传盒子
    $custom_filename = $id . '_' . $type . '_' . $dou->create_rand_string('number', 6, time());
    $image = $file->box('box', $id, $type . '_file', $type, $custom_filename);
    $file_url = $dou->dou_file($image);
    $img = '<img src="' . $file_url. '" data-file="' . $image . '" />';
    
    echo $img;
}

/**
 * +----------------------------------------------------------
 * 内容盒子删除
 * +----------------------------------------------------------
 */
elseif ($rec == 'del') {
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : $dou->dou_msg($_LANG['illegal'], 'box.php');
    $name = $dou->get_one("SELECT name FROM " . $dou->table('box') . " WHERE id = '$id'");
    
    if (isset($_POST['confirm']) ? $_POST['confirm'] : '') {
        // 删除相应商品内容盒子
        $image = $dou->get_one("SELECT image FROM " . $dou->table('box') . " WHERE id = '$id'");
        $dou->del_file($image);
        
        $dou->create_admin_log($_LANG['box_del'] . ': ' . $name);
        $dou->delete('box', "id = $id", 'box.php');
    } else {
        $_LANG['del_check'] = preg_replace('/d%/Ums', $name, $_LANG['del_check']);
        $dou->dou_msg($_LANG['del_check'], 'box.php', '', '30', "box.php?rec=del&id=$id");
    }
}

?>