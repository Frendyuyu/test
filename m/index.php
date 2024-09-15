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

// 伪静态模式下首页将作为其它内页入口
if (isset($_REQUEST['route'])) {
    include ('include/rewrite.class.php');
    $dou_rewrite = new Rewrite();
    
    $_REWRITE = $dou_rewrite->format($_REQUEST['route']);
    if ($_REWRITE['module'] && file_exists($original_file = $_REWRITE['site_path'] . $_REWRITE['module'] . '.php')) {
        foreach ($_REWRITE as $key => $value) {
            if ($value)
                $_REQUEST[$key] = $value;
        }
        
        require ($original_file);
        exit;
    } else {
        if (!$_REWRITE['is_lang_home']) {
            header("Location: " . dirname('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']));
            exit;
        }
    }
}

define('IN_DOUCO', true);

$_CUR = 'index';
require (dirname(__FILE__) . '/include/init.php');
$smarty->assign('cur', $_CUR);

// 如果存在搜索词则转入搜索页面
if ($_REQUEST['s']) {
    if ($check->is_search_keyword($keyword = trim($_REQUEST['s']))) {
        require (ROOT_PATH . M_PATH . '/include/search.inc.php');
    } else {
        $dou->dou_msg($_LANG['search_keyword_wrong']);
    }
}

// 获取关于我们信息
$sql = "SELECT * FROM " . $dou->table('page') . " WHERE id = '1'";
$query = $dou->query($sql);
$about = $dou->fetch_array($query);

// 写入到index数组
$index['cur'] = true;

// 代码扩展，此文件不会随着系统升级被覆盖
if (file_exists($code_include_file = ROOT_PATH . M_PATH . '/..code.php'))
    require ($code_include_file);

// 赋值给模板-meta和title信息
$smarty->assign('page_title', $dou->page_title());
$smarty->assign('keywords', $_CFG['mobile_keywords']);
$smarty->assign('description', $_CFG['mobile_description']);

// 赋值给模板-导航栏
$smarty->assign('nav_list', $dou->get_nav_mobile());

// 赋值给模板-数据
$smarty->assign('show_list', is_array($dou->get_show_list('mobile')) ? $dou->get_show_list('mobile') : $dou->get_show_list('pc'));
$smarty->assign('index', $index);
$smarty->assign('recommend_product', $dou->get_list('product', 'ALL', $_DISPLAY['home_product'], 'sort ASC'));
$smarty->assign('recommend_article', $dou->get_list('article', 'ALL', $_DISPLAY['home_article'], 'sort ASC'));

$smarty->display('index.dwt');

?>