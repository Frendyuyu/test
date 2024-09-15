<?php
/**
 * DouPHP
 * --------------------------------------------------------------------------------------------------
 * 版权所有 2013-2021 漳州豆壳网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.douphp.com
 * --------------------------------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在遵守授权协议前提下对程序代码进行修改和使用；不允许对程序代码以任何形式任何目的的再发布。
 * 授权协议: http://www.douphp.com/license.html
 * --------------------------------------------------------------------------------------------------
 * Author: DouCo
 * Release Date: 2019-01-08
 */
define('IN_DOUCO', true);

$_CUR = 'product';
require (dirname(__FILE__) . '/include/init.php');
$smarty->assign('cur', $_CUR);

// 验证并获取合法的ID，如果不合法将其设定为-1
$id = $firewall->get_legal_id('product', $_REQUEST['id'], $_REQUEST['unique_id']);
$cat_id = $dou->get_one("SELECT cat_id FROM " . $dou->table('product') . " WHERE id = '$id'");
$parent_id = $dou->get_one("SELECT parent_id FROM " . $dou->table('product_category') . " WHERE cat_id = '" . $cat_id . "'");
if ($id == -1)
    $dou->dou_msg($GLOBALS['_LANG']['page_wrong'], ROOT_URL);
    
// 获取产品信息
$product = $dou->get_row('product', '*', "id = '$id'");
$level_price = $dou->level_price($product['level_price']); // 会员等级价格

// 格式化数据
$product['price'] = $product['price'] > 0 ? $dou->price_format($product['price']) : $_LANG['price_discuss'];
$product['level_price'] = $level_price ? $dou->price_format($level_price) : '';
$product['add_time'] = date("Y-m-d", $product['add_time']);
$product['image'] = $dou->dou_file($product['image']);
$product['gallery_list'] = $dou->get_file_list('product', $id, 'gallery', true);
$product['model_list'] = $dou->get_model_list($product['model'], $id);

// 多语言
$product = $dou->lang_box($product, 'product', 'name, content, keywords, description');

// 款式属性模块
if ($_OPEN['attribute']) {
    include_once (ROOT_PATH . 'include/attribute.class.php');
    $dou_attribute = new Attribute();
    $product['attribute_list'] = $dou_attribute->get_attribute_list($product['cat_id'], $product['id'], true);
}

// 扩展数据模块
if ($_OPEN['data']) {
    include_once (ROOT_PATH . 'include/data.class.php');
    $dou_data = new Data();
    $smarty->assign('data', $dou_data->get_data('product', $id));
}

// 对应的分类信息
$cate_info = $dou->get_row('product_category', 'cat_id, cat_name, parent_id', "cat_id = '$product[cat_id]'");
$cate_info['url'] = $dou->rewrite_url('product_category', $product['cat_id']);
$product['cate_info'] = $cate_info;

// 评论功能
if ($_OPEN['comment']) {
    require (ROOT_PATH . 'include/comment.class.php');
    $page = $check->is_number($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
    $comment = new Comment();
    $smarty->assign('comment', $list = $comment->data('product', $id, 10, $page));
}

// 赋值给模板-meta和title信息
$smarty->assign('page_title', $dou->page_title('product_category', $cat_id, $product['name']));
$smarty->assign('keywords', $product['keywords']);
$smarty->assign('description', $product['description']);

// 赋值给模板-导航栏
$smarty->assign('nav_top_list', $dou->get_nav('top'));
$smarty->assign('nav_middle_list', $dou->get_nav('middle', '0', 'product_category', $cat_id, $parent_id));
$smarty->assign('nav_bottom_list', $dou->get_nav('bottom'));

// 赋值给模板-数据
$smarty->assign('ur_here', $dou->ur_here('product_category', $cat_id, $product['name']));
$smarty->assign('product_category', $dou->get_category('product_category', 0, $cat_id));
$smarty->assign('product', $product);
$smarty->assign('lift', $dou->lift('product', $id, $cat_id));
$smarty->assign('defined', $dou->format_defined($product['defined']));

$smarty->display('product.dwt');

?>