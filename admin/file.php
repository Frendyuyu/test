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

// 验证并获取合法的REQUEST
$module = $check->is_letter($_REQUEST['module']) ? $_REQUEST['module'] : '';

// 图片上传
include_once (ROOT_PATH . 'include/file.class.php');
$file = new File('images/' . $module . '/'); // 实例化类文件(文件上传路径，结尾加斜杠)

// 赋值给模板
$smarty->assign('rec', $rec);
$smarty->assign('cur', 'file');

/**
 * +----------------------------------------------------------
 * 文件上传盒子
 * +----------------------------------------------------------
 */
if ($rec == 'box') {
    // 验证并获取合法的REQUEST
    $item_id = $check->is_number($_REQUEST['item_id']) ? $_REQUEST['item_id'] : '';
    $type = $check->is_letter($_REQUEST['type']) ? $_REQUEST['type'] : '';
    $img_width = $check->is_number($_REQUEST['img_width']) ? $_REQUEST['img_width'] : $_CFG['img_width'];

    // 文件上传盒子
    $custom_filename = $item_id . '_' . $type . '_' . $dou->create_rand_string('number', 6, time());
    $image = $file->box($module, $item_id, $type . '_file', $type, $custom_filename, '', '', $img_width, $_CFG['watermark']);
     
    if ($type == 'content') {
        $html = '<img src="' . $dou->dou_file($image) . '" data-file="' . $image . '" />';
    } else {
        $html = $dou->get_file_list($module, $item_id, $type);
    }
    
    echo $html;
}

/**
 * +----------------------------------------------------------
 * 文件删除
 * +----------------------------------------------------------
 */
elseif ($rec == 'del') {
    // 验证并获取合法的REQUEST
    $number = preg_match("/^[a-z0-9.]+$/", $_REQUEST['number']) ? $_REQUEST['number'] : '';
    $file_info = $dou->get_row('file', 'module, item_id, type', "number = '$number'");
    
    // 删除文件
    $dou->del_file($number);
 
    // 显示已经上传的文件列表
    $html = $dou->get_file_list($file_info['module'], $file_info['item_id'], $file_info['type']);
    
    echo $html;
} 

/**
 * +----------------------------------------------------------
 * 大文件上传
 * +----------------------------------------------------------
 */
elseif ($rec == 'bigfile') {
    $file_type = 'jpg,jpeg,gif,png,zip,rar,pdf,xls,xlsx,doc,docx,wmv,avi,mp4,flv';
 
    if ($_REQUEST['act'] == 'ext') {
        $name = explode(".", $_REQUEST['check_filename']); // 将上传前的文件以“.”分开取得文件类型
        $img_count = count($name); // 获得截取的数量
        $img_type = $name[$img_count - 1]; // 取得文件的类型
        if (stripos($file_type, $img_type) === false) {
            echo $_LANG['file_support'] . $file_type . $_LANG['file_support_no'] . $img_type;
        }
        exit;
    }
     
    // 调用方法，返回结果
    $file->bigfile('file', $_POST['blob_num'], $_POST['total_blob_num'], $_POST['file_name'], $_POST['file_md5_value'], $file_type);
}

?>