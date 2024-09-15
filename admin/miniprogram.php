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
$smarty->assign('cur', 'miniprogram');

/**
 * +----------------------------------------------------------
 * 我的小程序
 * +----------------------------------------------------------
 */
if ($rec == 'default') {
    $smarty->assign('ur_here', $_LANG['miniprogram_list']);

    // 判断小程序目录是否存在
    if (!file_exists(ROOT_PATH . MINIPROGRAM_PATH))
        mkdir(ROOT_PATH . MINIPROGRAM_PATH, 0777);

    $miniprogram_array = $dou->get_subdirs(ROOT_PATH . MINIPROGRAM_PATH);
    if (!$miniprogram_array)
        $dou->dou_header('miniprogram.php?rec=install');
 
    foreach ($miniprogram_array as $unique_id) {
        $miniprogram_list[] = $dou->get_miniprogram_info($unique_id);
    }
    
    $smarty->assign('miniprogram_list', $miniprogram_list);

    $smarty->display('miniprogram.htm');
}

/**
 * +----------------------------------------------------------
 * 发布小程序
 * +----------------------------------------------------------
 */
elseif ($rec == 'release') {
    $smarty->assign('ur_here', $_LANG['miniprogram_release']);
 
    $unique_id = $check->is_extend_id($_REQUEST['unique_id']) ? $_REQUEST['unique_id'] : '您购买的小程序目录';
    $miniprogram_path = MINIPROGRAM_PATH . '/' . $unique_id;
    
    $smarty->assign('miniprogram_path', $miniprogram_path);
    
    $smarty->display('miniprogram.htm');
}

/**
 * +----------------------------------------------------------
 * 小程序幻灯
 * +----------------------------------------------------------
 */
elseif ($rec == 'show') {
    $smarty->assign('ur_here', $_LANG['miniprogram_show']);
 
    // act操作项的初始化
    $act = $check->is_rec($_REQUEST['act']) ? $_REQUEST['act'] : 'default';
    
    // 图片上传
    include_once (ROOT_PATH . 'include/file.class.php');
    $file = new File('data/slide/' . MINIPROGRAM_PATH . '/'); // 实例化类文件(文件上传路径，结尾加斜杠)
                                                            
    // 赋值给模板
    $smarty->assign('act', $act);
    $smarty->assign('show_list', $dou->get_show_list('miniprogram'));
    
    // 幻灯列表
    if ($act == 'default') {
        // CSRF防御令牌生成
        $smarty->assign('token', $token = $firewall->get_token());
        
        $smarty->display('miniprogram.htm');
    }    

    // 幻灯添加处理
    elseif ($act == 'insert') {
        // 验证幻灯名称
        if (empty($_POST['show_name'])) $dou->dou_msg($_LANG['show_name'] . $_LANG['is_empty']);
            
        // 文件上传盒子
        if ($_FILES['show_img']['name'] != "") {
            $custom_filename = $dou->create_rand_string('letter', 6, date('Ymd'));
            $show_img = $file->box('show', $dou->auto_id('show'), 'show_img', 'main', $custom_filename);
        }
        
        // CSRF防御令牌验证
        $firewall->check_token($_POST['token']);
        
        $sql = "INSERT INTO " . $dou->table('show') . " (id, show_name, show_link, show_img, type, sort)" . " VALUES (NULL, '$_POST[show_name]', '$_POST[show_link]', '$show_img', 'miniprogram', '$_POST[sort]')";
        $dou->query($sql);
        
        $dou->create_admin_log($_LANG['miniprogram'] . ' - ' . $_LANG['show_add'] . ': ' . $_POST[show_name]);
        $dou->dou_msg($_LANG['show_add_succes'], 'miniprogram.php?rec=show');
    }    

    // 幻灯编辑
    elseif ($act == 'edit') {
        // 验证并获取合法的ID
        $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : '';
        
        $show = $dou->get_row('show', '*', "id = '$id'");
        
        // 格式化数据
        $show['show_img'] = $dou->dou_file($show['show_img']);
        
        // CSRF防御令牌生成
        $smarty->assign('token', $token = $firewall->get_token());
        
        // 赋值给模板
        $smarty->assign('id', $id);
        $smarty->assign('show', $show);
        
        $smarty->display('miniprogram.htm');
    } 

    elseif ($act == 'update') {
        // 验证并获取合法的ID
        $id = $check->is_number($_POST['id']) ? $_POST['id'] : '';
     
        // 验证幻灯名称
        if (empty($_POST['show_name'])) $dou->dou_msg($_LANG['show_name'] . $_LANG['is_empty']);
            
        // 图片上传
        if ($_FILES['show_img']['name'] != "") {
            $file_name = $dou->get_file_name($dou->get_one("SELECT show_img FROM " . $dou->table('show') . " WHERE id = '$id'"));
            $custom_filename = $file_name ? $file_name : $dou->create_rand_string('letter', 6, date('Ymd'));
            $show_img = $file->box('show', $id, 'show_img', 'main', $custom_filename);
            $show_img = ", show_img = '" . $show_img . "'";
        }
        
        // CSRF防御令牌验证
        $firewall->check_token($_POST['token']);
        
        $sql = "update " . $dou->table('show') . " SET show_name='$_POST[show_name]'" . $show_img . " ,show_link = '$_POST[show_link]', sort = '$_POST[sort]' WHERE id = '$id'";
        $dou->query($sql);
        
        $dou->create_admin_log($_LANG['miniprogram'] . ' - ' . $_LANG['show_edit'] . ': ' . $_POST[show_name]);
        $dou->dou_msg($_LANG['show_edit_succes'], 'miniprogram.php?rec=show');
    }    

    // 幻灯删除
    elseif ($act == 'del') {
        // 验证并获取合法的ID
        $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : $dou->dou_msg($_LANG['illegal'], 'miniprogram.php?rec=show');
        
        $show_name = $dou->get_one("SELECT show_name FROM " . $dou->table('show') . " WHERE id = '$id'");
        
        if (isset($_POST['confirm'])) {
            // 删除相应商品图片
            $show_img = $dou->get_one("SELECT show_img FROM " . $dou->table('show') . " WHERE id = '$id'");
            $dou->del_file($show_img);
            
            $dou->create_admin_log($_LANG['miniprogram'] . ' - ' . $_LANG['show_del'] . ': ' . $show_name);
            $dou->delete('show', "id = '$id'", 'miniprogram.php?rec=show');
        } else {
            $_LANG['del_check'] = preg_replace('/d%/Ums', $show_name, $_LANG['del_check']);
            $dou->dou_msg($_LANG['del_check'], 'miniprogram.php?rec=show', '', '30', "miniprogram.php?rec=show&act=del&id=$id");
        }
    }
}

/**
 * +----------------------------------------------------------
 * 小程序参数设置
 * +----------------------------------------------------------
 */
elseif ($rec == 'system') {
    $smarty->assign('ur_here', $_LANG['miniprogram_system']);
 
    // act操作项的初始化
    $act = $check->is_rec($_REQUEST['act']) ? $_REQUEST['act'] : 'default';
    
    // 系统设置
    if ($act == 'default') {
        // 配置项如果不存在，则先写入
        $set_list = array('miniprogram_appid', 'miniprogram_appsecret', 'miniprogram_pay_mch_id', 'miniprogram_pay_key');
        foreach ($set_list as $name) {
            if (!$dou->value_exist('parameter', 'name', $name)) {
                $dou->query("INSERT INTO " . $dou->table('parameter') . " (id, name, lang, value, cue, `group`)" . " VALUES (NULL, '$name', '" . $_LANG['miniprogram_' . $name . '_lang'] . "', '" . $_LANG['miniprogram_' . $name . '_value'] . "', '" . $_LANG['miniprogram_' . $name . '_cue'] . "', 'miniprogram')");
            }
        }
        
        // 读取配置项
        $sql = "SELECT * FROM " . $dou->table('parameter') . $where . " WHERE `group` = 'miniprogram' ORDER BY `group` DESC, sort ASC, id ASC";
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
        
        $smarty->assign('parameter_list', $parameter_list);
        $smarty->display('miniprogram.htm');
    }    

    // 系统设置数据更新
    elseif ($act == 'update') {
        // CSRF防御令牌验证
        $firewall->check_token($_POST['token']);
     
        foreach ($_POST as $name => $value) {
            $dou->query("UPDATE " . $dou->table('parameter') . " SET value = '$value' WHERE name = '$name'");
        }
        
        $dou->create_admin_log($_LANG['miniprogram'] . ' - ' . $_LANG['miniprogram_system'] . ': ' . $_LANG['edit_succes']);
        $dou->dou_msg($_LANG['edit_succes'], 'miniprogram.php?rec=system');
    }
} 

/**
 * +----------------------------------------------------------
 * 更多小程序
 * +----------------------------------------------------------
 */
elseif ($rec == 'install') {
    $smarty->assign('ur_here', $_LANG['miniprogram_install']);
 
    $smarty->assign('get', urlencode(serialize($_GET)));
    $smarty->assign('localsite', $dou->dou_localsite('miniprogram'));
    
    $smarty->display('miniprogram.htm');
} 

/**
 * +----------------------------------------------------------
 * 删除小程序
 * +----------------------------------------------------------
 */
elseif ($rec == 'del') {
    // 载入扩展功能
    include_once (ROOT_PATH . ADMIN_PATH . '/include/cloud.class.php');
    $dou_cloud = new Cloud('cache');

    if ($check->is_extend_id($unique_id = $_REQUEST['unique_id'])) {
        $miniprogram_array = $dou->get_subdirs(ROOT_PATH . MINIPROGRAM_PATH . '/');
        if (in_array($unique_id, $miniprogram_array)) { // 判断删除操作的模板是否真实存在
            $dou->del_dir(ROOT_PATH . MINIPROGRAM_PATH . '/' . $unique_id);
            $dou_cloud->change_updatedate('miniprogram', $unique_id, true); // 删除更新时间记录
            $dou->create_admin_log($_LANG['miniprogram_del'] . ': ' . $unique_id);
        }
    }
    
    $dou->dou_header('miniprogram.php');
}

?>