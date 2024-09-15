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
if (!defined('IN_DOUCO')) {
    die('Hacking attempt');
}

if ($_CUR_LANG) {
    // 多语言默认只支持产品搜索
    $sql = "SELECT p.* FROM " . $GLOBALS['dou']->table('language_value') . " AS l LEFT JOIN  " . $GLOBALS['dou']->table('article') . " AS p ON l.item_id = p.id WHERE l.field = 'name' AND l.module = 'product' AND l.language_pack = '$_CUR_LANG[pack]' AND l.value LIKE '%$keyword%'";
} else {
    // 如无指定搜索特别模块将搜索所有栏目模块
    if ($check->is_letter($_REQUEST['module'])) {
        if ($_REQUEST['module'] == 'product') {
            $sql = "SELECT * FROM " . $dou->table($_REQUEST['module']) . " WHERE name LIKE '%$keyword%'";
        } else {
            $sql = "SELECT * FROM " . $dou->table($_REQUEST['module']) . " WHERE title LIKE '%$keyword%'";
        }
    } else {
        foreach ($_MODULE['column'] as $key => $module) {
            $name_field = $module == 'product' ? 'name' : 'title';
            if ($key == 0) {
                $sql = "SELECT '" . $module . "' module, id, " . $name_field . ", cat_id, content, image, description, add_time FROM " . $dou->table($module) . " WHERE " . $name_field . " LIKE '%$keyword%'";
            } else {
                $sql .= " UNION ALL SELECT '" . $module . "', id, " . $name_field . ", cat_id, content, image, description, add_time FROM " . $dou->table($module) . " WHERE " . $name_field . " LIKE '%$keyword%'";
            }
        }
    }
}

// 获取分页信息
$page = $check->is_number($_REQUEST['page']) ? $_REQUEST['page'] : 1;
$page_url = ROOT_URL . ($check->is_letter($_REQUEST['module']) ? '?module=' . $_REQUEST['module'] . '&s=' : '?s=') . $keyword;
$limit = $dou->pager($sql, 10, $page, $page_url, '', true);

/* 获取搜索结果列表 */
$sql = $sql . $limit; // 加入分页条件的SQL语句
$query = $dou->query($sql);
while ($row = $dou->fetch_array($query)) {
    $module = $check->is_letter($_REQUEST['module']) ? $_REQUEST['module'] : $row['module'];
    
    $url = $dou->rewrite_url($module, $row['id']);
    $add_time = date("Y-m-d", $row['add_time']);
    $add_time_short = date("m-d", $row['add_time']);
    $description = $row['description'] ? $row['description'] : $dou->dou_substr($row['content'], 150);
    $price = $row['price'] > 0 ? $dou->price_format($row['price']) : $_LANG['price_discuss'];
    $thumb = $dou->dou_file($row['image'], true);

    // 对应的分类信息
    $cate_info_row = $dou->get_row($module . '_category', 'cat_id, cat_name', "cat_id = '$row[cat_id]'");
    $cate_info_row['url'] = $dou->rewrite_url($module . '_category', $row['cat_id']);

    $search_list[] = array (
            "id" => $row['id'],
            "cat_id" => $row['cat_id'],
            "module" => $row['module'],
            "name" => str_replace($keyword, '<b>' . $keyword . '</b>', ($row['name'] ? $row['name'] : $row['title'])),
            "title" => str_replace($keyword, '<b>' . $keyword . '</b>', ($row['title'] ? $row['title'] : $row['name'])),
            "price" => $price,
            "image" => $module == 'product' ? $thumb : $dou->dou_file($row['image']),
            "thumb" => $thumb,
            "add_time" => $add_time,
            "add_time_short" => $add_time_short,
            "time" => $dou->format_time($row['add_time']),
            "click" => $row['click'],
            "description" => $description,
            "url" => $url,
            "cate_info" => $cate_info_row
    );
}

$search_results = preg_replace('/d%/Ums', $keyword, $_LANG['search_results']);

// 赋值给模板-meta和title信息
$smarty->assign('page_title', $dou->page_title('search', '', $search_results));
$smarty->assign('keywords', $_CFG['site_keywords']);
$smarty->assign('description', $_CFG['site_description']);

// 赋值给模板-导航栏
$smarty->assign('nav_top_list', $dou->get_nav('top'));
$smarty->assign('nav_middle_list', $dou->get_nav('middle'));
$smarty->assign('nav_bottom_list', $dou->get_nav('bottom'));

// 赋值给模板-数据
$smarty->assign('ur_here', $dou->ur_here('page', '', $search_results));
$smarty->assign('search_module', $module);
$smarty->assign('product_category', $dou->get_category('product_category'));
$smarty->assign('article_category', $dou->get_category('article_category'));
$smarty->assign('search_list', $search_list);
$smarty->assign('keyword', $keyword);

$smarty->display('search.dwt');

// 终止执行文件外的程序
exit();

?>