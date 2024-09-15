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

$_CUR = 'product_category';
require (dirname(__FILE__) . '/include/init.php');
$smarty->assign('cur', $_CUR);

// 验证并获取合法的ID，如果不合法将其设定为-1
$cat_id = $firewall->get_legal_id('product_category', $_REQUEST['id'], $_REQUEST['unique_id']);
if ($cat_id == -1) {
    $dou->dou_msg($GLOBALS['_LANG']['page_wrong'], ROOT_URL);
} elseif ($cat_id) {
    $where = ' WHERE cat_id IN (' . $cat_id . $dou->dou_child_id('product_category', $cat_id) . ')';
}

// 未加入分页条件的SQL语句
$sql = "SELECT * FROM " . $dou->table('product') . $where . " ORDER BY sort ASC, id DESC";

// 获取分页信息
$page = $check->is_number($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
$limit = $dou->pager($sql, ($_DISPLAY['product'] ? $_DISPLAY['product'] : 10), $page, $dou->rewrite_url('product_category', $cat_id));

/* 获取产品列表 */
$sql = $sql . $limit; // 加入分页条件的SQL语句
$query = $dou->query($sql);
while ($row = $dou->fetch_array($query)) {
    // 多语言
    $row = $dou->lang_box($row, 'product', 'name, content, description');
    
    $url = $dou->rewrite_url('product', $row['id']); // 获取经过伪静态产品链接
    $add_time = date("Y-m-d", $row['add_time']);
    
    // 如果描述不存在则自动从详细介绍中截取
    $description = $row['description'] ? $row['description'] : $dou->dou_substr($row['content'], 150, false);
    
    // 等级价格
    $level_price = $dou->level_price($row['level_price']); // 会员等级价格
    
    // 对应的分类信息
    $cate_info_row = $dou->get_row('product_category', 'cat_id, cat_name', "cat_id = '$row[cat_id]'");
    $cate_info_row['url'] = $dou->rewrite_url('product_category', $row['cat_id']);
    
    $product_list[] = array (
            "id" => $row['id'],
            "cat_id" => $row['cat_id'],
            "name" => $row['name'],
            "defined" => $dou->format_defined($row['defined']),
            "price" => $row['price'] > 0 ? $dou->price_format($row['price']) : $_LANG['price_discuss'],
            "level_price" => $level_price ? $dou->price_format($level_price) : '',
            "thumb" => $dou->dou_file($row['image'], true),
            "image" => $dou->dou_file($row['image']),
            "defined" => $dou->format_defined($row['defined']),
            "add_time" => $add_time,
            "description" => $description,
            "url" => $url,
            "cate_info" => $cate_info_row
    );
}

// 获取分类信息
$cate_info = $dou->get_row('product_category', '*', "cat_id = '$cat_id'");
$cate_info = $dou->lang_box($cate_info, 'product_category', 'cat_name, keywords, description'); // 多语言

// 赋值给模板-meta和title信息
$smarty->assign('page_title', $dou->page_title('product_category', $cat_id));
$smarty->assign('keywords', $cate_info['keywords'] ? $cate_info['keywords'] : $_CFG['site_keywords']);
$smarty->assign('description', $cate_info['description'] ? $cate_info['description'] : $_CFG['site_description']);

// 赋值给模板-导航栏
$smarty->assign('nav_top_list', $dou->get_nav('top'));
$smarty->assign('nav_middle_list', $dou->get_nav('middle', '0', 'product_category', $cat_id, $cate_info['parent_id']));
$smarty->assign('nav_bottom_list', $dou->get_nav('bottom'));

// 赋值给模板-数据
$smarty->assign('ur_here', $dou->ur_here('product_category', $cat_id));
$smarty->assign('cate_info', $cate_info);
$smarty->assign('product_category', $dou->get_category('product_category', 0, $cat_id));
$smarty->assign('product_list', $product_list);

$smarty->display('product_category.dwt');

?>