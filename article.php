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

$_CUR = 'article';
require (dirname(__FILE__) . '/include/init.php');
$smarty->assign('cur', $_CUR);

// 验证并获取合法的ID，如果不合法将其设定为-1 
$id = $firewall->get_legal_id('article', $_REQUEST['id'], $_REQUEST['unique_id']);
$cat_id = $dou->get_one("SELECT cat_id FROM " . $dou->table('article') . " WHERE id = '$id'");
$parent_id = $dou->get_one("SELECT parent_id FROM " . $dou->table('article_category') . " WHERE cat_id = '" . $cat_id . "'");
if ($id == -1)
    $dou->dou_msg($GLOBALS['_LANG']['page_wrong'], ROOT_URL);
    
/* 获取详细信息 */
$article = $dou->get_row('article', '*', "id = '$id'");

// 格式化数据
$article['time'] = $dou->format_time($article['add_time']);
$article['add_time'] = date("Y-m-d", $article['add_time']);
$article['image'] = $dou->dou_file($article['image']);

// 多语言
$article = $dou->lang_box($article, 'article', 'title, content, keywords, description');

// 对应的分类信息
$cate_info = $dou->get_row('article_category', 'cat_id, cat_name, parent_id', "cat_id = '$article[cat_id]'");
$cate_info['url'] = $dou->rewrite_url('article_category', $article['cat_id']);
$article['cate_info'] = $cate_info;

// 访问统计
$click = $article['click'] + 1;
$dou->query("update " . $dou->table('article') . " SET click = '$click' WHERE id = '$id'");

// 评论功能
if ($_OPEN['comment']) {
    require (ROOT_PATH . 'include/comment.class.php');
    $page = $check->is_number($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
    $comment = new Comment('article', $id, 10, $page);
    $smarty->assign('comment', $comment->data());
}

// 赋值给模板-meta和title信息
$smarty->assign('page_title', $dou->page_title('article_category', $cat_id, $article['title']));
$smarty->assign('keywords', $article['keywords']);
$smarty->assign('description', $article['description']);

// 赋值给模板-导航栏
$smarty->assign('nav_top_list', $dou->get_nav('top'));
$smarty->assign('nav_middle_list', $dou->get_nav('middle', '0', 'article_category', $cat_id, $parent_id));
$smarty->assign('nav_bottom_list', $dou->get_nav('bottom'));

// 赋值给模板-数据
$smarty->assign('ur_here', $dou->ur_here('article_category', $cat_id, $article['title']));
$smarty->assign('article_category', $dou->get_category('article_category', 0, $cat_id));
$smarty->assign('lift', $dou->lift('article', $id, $cat_id));
$smarty->assign('article', $article);
$smarty->assign('defined', $dou->format_defined($article['defined']));

$smarty->display('article.dwt');

?>