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

$smarty->assign('rec', $rec);
$smarty->assign('cur', 'parameter');

/**
 * +----------------------------------------------------------
 * 参数设置列表
 * +----------------------------------------------------------
 */
if ($rec == 'default') {
    $smarty->assign('ur_here', $_LANG['parameter_list']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['parameter_add'],
            'href' => 'parameter.php?rec=add' 
    ));
 
    // 分组筛选
    $group = $check->is_letter($_REQUEST['group']) ? $_REQUEST['group'] : '';
    $where = $group ? " WHERE `group` = '$group'" : '';
    
    $sql = "SELECT * FROM " . $dou->table('parameter') . $where . " ORDER BY sort ASC, id ASC";
    $query = $dou->query($sql);
    while ($row = $dou->fetch_array($query)) {
        $parameter_list[] = array (
                "id" => $row['id'],
                "name" => $row['name'],
                "lang" => $row['lang'],
                "cue" => $row['cue'],
                "group" => $row['group'],
                "lock" => $row['lock']
        );
    }
    
    // 赋值给模板
    $smarty->assign('parameter_list', $parameter_list);
    
    $smarty->display('parameter.htm');
} 

/**
 * +----------------------------------------------------------
 * 参数设置添加
 * +----------------------------------------------------------
 */
elseif ($rec == 'add') {
    $smarty->assign('ur_here', $_LANG['parameter_add']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['parameter_list'],
            'href' => 'parameter.php' 
    ));
 
    // 定义分组
    $group = $check->is_letter($_REQUEST['group']) ? $_REQUEST['group'] : '';
    
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    
    // 赋值给模板
    $smarty->assign('form_action', 'insert');
    $smarty->assign('group', $group);
    
    $smarty->display('parameter.htm');
} 

elseif ($rec == 'insert') {
    if (!preg_match("/^[A-Za-z0-9_-]+$/", $_POST['name'])) {
        $dou->dou_msg($_LANG['parameter_name_cue']);
    } elseif ($dou->value_exist('parameter', 'name', $_POST['name'])) {
        $dou->dou_msg($_LANG['parameter_name'] . $_LANG['is_exist']);
    }
    
    if (!$_POST['lang'])
        $dou->dou_msg($_LANG['parameter_lang_cue']);
 
    // 定义分组
    $group = $check->is_letter($_REQUEST['group']) ? $_REQUEST['group'] : 'system';
        
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token']);
    
    $sql = "INSERT INTO " . $dou->table('parameter') . " (id, name, lang, cue, `group`, sort)" . " VALUES (NULL, '$_POST[name]', '$_POST[lang]', '$_POST[cue]', '$group', '$_POST[sort]')";
    $dou->query($sql);
 
    $back_url = $group == 'customer' ? 'system.php' : 'parameter.php';
    
    $dou->create_admin_log($_LANG['parameter_add'] . ': ' . $_POST['name']);
    $dou->dou_msg($_LANG['parameter_add'] . $_LANG['success'], $back_url);
} 

/**
 * +----------------------------------------------------------
 * 参数设置编辑
 * +----------------------------------------------------------
 */
elseif ($rec == 'edit') {
    $smarty->assign('ur_here', $_LANG['parameter_edit']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['parameter_list'],
            'href' => 'parameter.php' 
    ));
    
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : '';
    
    $parameter = $dou->get_row('parameter', '*', "id = '$id'");
    
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    
    // 赋值给模板
    $smarty->assign('form_action', 'update');
    $smarty->assign('parameter', $parameter);
    
    $smarty->display('parameter.htm');
} 

elseif ($rec == 'update') {
    // 验证并获取合法的ID
    $id = $check->is_number($_POST['id']) ? $_POST['id'] : '';
    
    // 参数别名
    $name = $dou->get_one("SELECT name FROM " . $dou->table('parameter') . " WHERE id = '$id'");
    if (!preg_match("/^[A-Za-z0-9_-]+$/", $_POST['name'])) {
        $dou->dou_msg($_LANG['parameter_name_cue']);
    } elseif ($dou->value_exist('parameter', 'name', $_POST['name']) && $name != $_POST['name']) {
        $dou->dou_msg($_LANG['parameter_name'] . $_LANG['is_exist']);
    }
    
    if (!$_POST['lang'])
        $dou->dou_msg($_LANG['parameter_lang_cue']);
        
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token']);
    
    $sql = "UPDATE " . $dou->table('parameter') . " SET name = '$_POST[name]', lang = '$_POST[lang]', cue = '$_POST[cue]', sort = '$_POST[sort]' WHERE id = '$id'";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['parameter_edit'] . ': ' . $_POST['name']);
    $dou->dou_msg($_LANG['parameter_edit'] . $_LANG['success'], 'parameter.php', '', '3');
}

/**
 * +----------------------------------------------------------
 * 参数值
 * +----------------------------------------------------------
 */
elseif ($rec == 'set') {
    $group = $check->is_letter($_REQUEST['group']) ? $_REQUEST['group'] : '';
    
    $smarty->assign('ur_here', ($_LANG[$group] ? $_LANG[$group] : $group) . $_LANG['parameter_value']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['system'],
            'href' => 'system.php' 
    ));
 
    // 分组筛选
    $where = $group ? " WHERE `group` = '$group'" : '';
    
    $sql = "SELECT * FROM " . $dou->table('parameter') . $where . " ORDER BY `group` DESC, sort ASC, id ASC";
    $query = $dou->query($sql);
    while ($row = $dou->fetch_array($query)) {
        $parameter_list[] = array (
                "id" => $row['id'],
                "name" => $row['name'],
                "lang" => $row['lang'],
                "value" => $row['value'],
                "cue" => $row['cue']
        );
    }
 
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    
    // 赋值给模板
    $smarty->assign('parameter_list', $parameter_list);
    
    $smarty->display('parameter.htm');
} 

elseif ($rec == 'set_post') {
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token']);
    
    foreach ($_POST as $name => $value) {
        $dou->query("UPDATE " . $dou->table('parameter') . " SET value = '$value' WHERE name = '$name'");
    }
    
    $dou->create_admin_log($_LANG['parameter'] . ': ' . $_LANG['edit_succes']);
    $dou->dou_msg($_LANG['edit_succes'], 'index.php');
}

/**
 * +----------------------------------------------------------
 * 参数设置删除
 * +----------------------------------------------------------
 */
elseif ($rec == 'del') {
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : $dou->dou_msg($_LANG['illegal'], 'parameter.php');
    
    $parameter = $dou->get_row('parameter', 'name, `lock`', "id = '$id'");
    
    if ($parameter['lock']) {
        $dou->dou_msg($_LANG['parameter_lock'], 'parameter.php', '', '3');
    } else {
        if (isset($_POST['confirm'])) {
            $dou->create_admin_log($_LANG['parameter_del'] . ': ' . $parameter['name']);
            $dou->delete('parameter', "id = '$id' AND `lock` = '0'", 'parameter.php');
        } else {
            $_LANG['del_check'] = preg_replace('/d%/Ums', $parameter['name'], $_LANG['del_check']);
            $dou->dou_msg($_LANG['del_check'], 'parameter.php', '', '30', "parameter.php?rec=del&id=$id");
        }
    }
}

?>