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

$_CUR = 'article_category';
require (dirname(__FILE__) . '/include/init.php');
$smarty->assign('cur', $_CUR);

// 验证并获取合法的ID，如果不合法将其设定为-1
$cat_id = $firewall->get_legal_id('article_category', $_REQUEST['id'], $_REQUEST['unique_id']);
if ($cat_id == -1) {
    $dou->dou_msg($GLOBALS['_LANG']['page_wrong'], M_URL);
} elseif ($cat_id) {
    $where = ' WHERE cat_id IN (' . $cat_id . $dou->dou_child_id('article_category', $cat_id) . ')';
}

// 未加入分页条件的SQL语句
$sql = "SELECT * FROM " . $dou->table('article') . $where . " ORDER BY sort ASC, id DESC";
    
// 获取分页信息
$page = $check->is_number($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
$limit = $dou->pager($sql, ($_DISPLAY['article'] ? $_DISPLAY['article'] : 10), $page, $dou->rewrite_url('article_category', $cat_id));

/* 获取文章列表 */
$sql = $sql . $limit; // 加入分页条件的SQL语句
$query = $dou->query($sql);
while ($row = $dou->fetch_array($query)) {
    $url = $dou->rewrite_url('article', $row['id']);
    
    // 如果描述不存在则自动从详细介绍中截取
    $description = $row['description'] ? $row['description'] : $dou->dou_substr($row['content'], 200, false);
 
    // 文章对应的分类信息
    $cate_info_row = $dou->get_row('article_category', 'cat_id, cat_name', "cat_id = '$row[cat_id]'");
    $cate_info_row['url'] = $dou->rewrite_url('article_category', $row['cat_id']);
    
    $article_list[] = array (
            "id" => $row['id'],
            "cat_id" => $row['cat_id'],
            "title" => $row['title'],
            "defined" => $dou->format_defined($row['defined']),
            "image" => $dou->dou_file($row['image']),
            "add_time" => date("Y-m-d", $row['add_time']),
            "add_time_short" => date("m-d", $row['add_time']),
            "time" => $dou->format_time($row['add_time']),
            "click" => $row['click'],
            "description" => $description,
            "url" => $url,
            "cate_info" => $cate_info_row
    );
}

// 获取分类信息
$cate_info = $dou->get_row('article_category', 'cat_id, cat_name, parent_id, keywords, description', "cat_id = '$cat_id'");

// 如果为末级分类则显示当前同级分类
if ($dou->dou_child_id('article_category', $cat_id)) {
    $parent_id = $cat_id;
} else {
    $parent_id = $dou->get_one("SELECT parent_id FROM " . $dou->table('article_category') . " WHERE cat_id = '$cat_id'");;
}

// 赋值给模板-meta和title信息
$smarty->assign('page_title', $dou->page_title('article_category', $cat_id));
$smarty->assign('keywords', $cate_info['keywords'] ? $cate_info['keywords'] : $_CFG['site_keywords']);
$smarty->assign('description', $cate_info['description'] ? $cate_info['description'] : $_CFG['site_description']);

// 赋值给模板-导航栏
$smarty->assign('nav_list', $dou->get_nav_mobile('mobile', '0', 'article_category', $cat_id, $cate_info['parent_id']));

// 赋值给模板-数据
$smarty->assign('head', $_LANG['article_category']);
$smarty->assign('ur_here', $dou->ur_here('article_category', $cat_id));
$smarty->assign('cate_info', $cate_info);
$smarty->assign('article_category', $dou->get_category('article_category', $parent_id, $cat_id));
$smarty->assign('article_list', $article_list);

$smarty->display('article_category.dwt');

?>