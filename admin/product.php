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

require (dirname(__FILE__) . '/include/init.php');

// rec操作项的初始化
$rec = $check->is_rec($_REQUEST['rec']) ? $_REQUEST['rec'] : 'default';

// 图片上传
include_once (ROOT_PATH . 'include/file.class.php');
$file = new File('images/product/'); // 实例化类文件(文件上传路径，结尾加斜杠)

// 款式属性模块
if ($_OPEN['attribute']) {
    include_once (ROOT_PATH . 'include/attribute.class.php');
    $dou_attribute = new Attribute();
}

// 扩展数据模块
if ($_OPEN['data']) {
    include_once (ROOT_PATH . 'include/data.class.php');
    $dou_data = new Data();
}

// 赋值给模板
$smarty->assign('rec', $rec);
$smarty->assign('cur', 'product');

/**
 * +----------------------------------------------------------
 * 产品列表
 * +----------------------------------------------------------
 */
if ($rec == 'default') {
    $smarty->assign('ur_here', $_LANG['product']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['product_add'],
            'href' => 'product.php?rec=add' 
    ));
    
    // 获取参数
    $cat_id = $check->is_number($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '';
    $keyword = isset($_REQUEST['keyword']) ? trim($_REQUEST['keyword']) : '';
    
    // 筛选条件
    if ($cat_id)
        $where = ' WHERE cat_id IN (' . $cat_id . $dou->dou_child_id('product_category', $cat_id) . ')';
    if ($keyword) {
        $where = $where . " AND name LIKE '%$keyword%'";
        $get = '&keyword=' . $keyword;
    }
 
    // 排序
    $sort = $_OPEN['sort'] ? "sort ASC, " : '';
    
    // 未加入分页条件的SQL语句
    $sql = "SELECT id, name, price, level_price, image, cat_id, stock, point, sort, add_time FROM " . $dou->table('product') . $where . " ORDER BY " . $sort . "id DESC";
    
    // 分页
    $page = $check->is_number($_REQUEST['page']) ? $_REQUEST['page'] : 1;
    $page_url = 'product.php' . ($cat_id ? '?cat_id=' . $cat_id : '');
    $limit = $dou->pager($sql, 15, $page, $page_url, $get);
    
    $sql = $sql . $limit; // 加入分页条件的SQL语句
    $query = $dou->query($sql);
    while ($row = $dou->fetch_array($query)) {
        $cat_name = $dou->get_one("SELECT cat_name FROM " . $dou->table('product_category') . " WHERE cat_id = '$row[cat_id]'");
        $add_time = date("Y-m-d", $row['add_time']);
        
        $product_list[] = array (
                "id" => $row['id'],
                "cat_id" => $row['cat_id'],
                "price" => $row['price'] > 0 ? $dou->price_format($row['price']) : '',
                "level_price" => $_OPEN['user_level'] ? $dou->user_level_option('', unserialize($row['level_price'])) : array(),
                "cat_name" => $cat_name,
                "name" => $row['name'],
                "image" => $dou->dou_file($row['image']),
                "stock" => $row['stock'],
                "point" => $row['point'] ? $row['point'] : '-',
                "sort" => $row['sort'],
                "add_time" => $add_time 
        );
    }
    
    // 赋值给模板
    $smarty->assign('cat_id', $cat_id);
    $smarty->assign('keyword', $keyword);
    $smarty->assign('product_category', $dou->get_category_nolevel('product_category'));
    $smarty->assign('product_list', $product_list);
    $smarty->assign('user_level_option', $dou->user_level_option());
    
    $smarty->display('product.htm');
} 

/**
 * +----------------------------------------------------------
 * 产品添加
 * +----------------------------------------------------------
 */
elseif ($rec == 'add') {
    $smarty->assign('ur_here', $_LANG['product_add']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['product'],
            'href' => 'product.php' 
    ));
    
    // 预先获取产品ID
    $item_id = $dou->auto_id('product');
    
    // 格式化自定义参数，并存到数组$product，商品编辑页面中调用商品详情也是用数组$product，
    if ($_DEFINED['product']) {
        $defined = explode(',', $_DEFINED['product']);
        foreach ($defined as $row) {
            $defined_product .= $row . "：\n";
        }
        $product['defined'] = trim($defined_product);
        $product['defined_count'] = count(explode("\n", $product['defined'])) * 2;
    }
 
    // 格式化
    $product['img_list_html'] = $dou->get_file_list('product', $item_id, 'gallery');
    
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    
    // 赋值给模板
    $smarty->assign('form_action', 'insert');
    $smarty->assign('product_category', $dou->get_category_nolevel('product_category'));
    $smarty->assign('item_id', $item_id);
    $smarty->assign('product', $product);
    $smarty->assign('user_level_option', $dou->user_level_option());
    $smarty->assign('btn_lang', $dou->btn_lang('product', '', 'name, content, keywords, description'));
    
    $smarty->display('product.htm');
} 

elseif ($rec == 'insert') {
    // 数据验证
    if (empty($_POST['name'])) $dou->dou_msg($_LANG['name'] . $_LANG['is_empty']);
    if (!$check->is_price($_POST['price'] = trim($_POST['price']))) $dou->dou_msg($_LANG['price_wrong']);
    
    // 文件上传盒子
    $image = $file->box('product', $dou->auto_id('product'), 'image', 'main', null, $_CFG['thumb_width'], $_CFG['thumb_height']);
    
    // 数据格式化
    $add_time = time();
    $_POST['defined'] = str_replace("\r\n", ',', $_POST['defined']);
    $level_price = serialize($_POST['level_price']);
    
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token']);
    
    $sql = "INSERT INTO " . $dou->table('product') . " (id, cat_id, name, price, level_price, stock, defined, content, image, point, keywords, description, sort, add_time)" . " VALUES (NULL, '$_POST[cat_id]', '$_POST[name]', '$_POST[price]', '$level_price', '$_POST[stock]', '$_POST[defined]', '$_POST[content]', '$image', '$_POST[point]', '$_POST[keywords]', '$_POST[description]', '$_POST[sort]', '$add_time')";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['product_add'] . ': ' . $_POST['name']);
    $dou->dou_msg($_LANG['product_add_succes'], 'product.php');
} 

/**
 * +----------------------------------------------------------
 * 产品编辑
 * +----------------------------------------------------------
 */
elseif ($rec == 'edit') {
    $smarty->assign('ur_here', $_LANG['product_edit']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['product'],
            'href' => 'product.php' 
    ));
    
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : '';
    
    $product = $dou->get_row('product', '*', "id = '$id'");
    
    // 格式化数据
    $product['image'] = $dou->dou_file($product['image']);
    $product['img_list_html'] = $dou->get_file_list('product', $id, 'gallery');
    $product['model_list'] = model_list($product['model'], $id);
 
    // 款式属性模块
    if ($_OPEN['attribute'])
        $product['attribute_list'] = $dou_attribute->get_attribute_list($product['cat_id'], $product['id']);
    
    // 扩展数据模块
    if ($_OPEN['data'])
        $smarty->assign('data', $dou_data->get_data('product', $id));
    
    // 格式化自定义参数
    if ($_DEFINED['product'] || $product['defined']) {
        $defined = explode(',', $_DEFINED['product']);
        foreach ($defined as $row) {
            $defined_product .= $row . "：\n";
        }
        // 如果商品中已经写入自定义参数则调用已有的
        $product['defined'] = $product['defined'] ? str_replace(",", "\n", $product['defined']) : trim($defined_product);
        $product['defined_count'] = count(explode("\n", $product['defined'])) * 2;
    }
    
    // CSRF防御令牌生成
    $smarty->assign('token', $token = $firewall->get_token());
    
    // 赋值给模板
    $smarty->assign('form_action', 'update');
    $smarty->assign('product_category', $dou->get_category_nolevel('product_category'));
    $smarty->assign('item_id', $id);
    $smarty->assign('item_content', $product['content']);
    $smarty->assign('product', $product);
    $smarty->assign('user_level_option', $dou->user_level_option('', unserialize($product['level_price'])));
    $smarty->assign('btn_lang', $dou->btn_lang('product', $id, 'name, content, keywords, description'));
    
    $smarty->display('product.htm');
} 

elseif ($rec == 'update') {
    // 验证并获取合法的ID
    $id = $check->is_number($_POST['id']) ? $_POST['id'] : '';
    
    // 数据验证
    if (empty($_POST['name'])) $dou->dou_msg($_LANG['name'] . $_LANG['is_empty']);
    if (!$check->is_price($_POST['price'] = trim($_POST['price']))) $dou->dou_msg($_LANG['price_wrong']);
        
    // 文件上传盒子
    $image = $file->box('product', $id, 'image', 'main', null, $_CFG['thumb_width'], $_CFG['thumb_height']);
    $image = $image ? ", image = '" . $image . "'" : '';
    
    // 格式化
    $_POST['defined'] = str_replace("\r\n", ',', $_POST['defined']);
    $level_price = serialize($_POST['level_price']);
    
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token']);
    
    $sql = "UPDATE " . $dou->table('product') . " SET cat_id = '$_POST[cat_id]', name = '$_POST[name]', price = '$_POST[price]', level_price = '$level_price', stock = '$_POST[stock]', defined = '$_POST[defined]' ,content = '$_POST[content]'" . $image . ", point = '$_POST[point]', keywords = '$_POST[keywords]', description = '$_POST[description]', sort = '$_POST[sort]' WHERE id = '$id'";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['product_edit'] . ': ' . $_POST['name']);
    $dou->dou_msg($_LANG['product_edit_succes'], 'product.php');
}

/**
 * +----------------------------------------------------------
 * 重新生成产品图片
 * +----------------------------------------------------------
 */
elseif ($rec == 'thumb') {
    $smarty->assign('ur_here', $_LANG['product_thumb']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['product'],
            'href' => 'product.php' 
    ));
    
    $sql = "SELECT file FROM " . $dou->table('file') . " WHERE module = 'product' AND thumb_size > 0 ORDER BY id ASC";
    $count = $dou->num_rows($query = $dou->query($sql));
    $mask['count'] = preg_replace('/d%/Ums', $count, $_LANG['product_thumb_count']);
    $mask_tag = '<i></i>';
    $mask['confirm'] = isset($_POST['confirm']) ? $_POST['confirm'] : '';
    
    for($i = 1; $i <= $count; $i++)
        $mask['bg'] .= $mask_tag;
    
    $smarty->assign('mask', $mask);
    $smarty->display('product.htm');
    
    if (isset($_POST['confirm'])) {
        echo ' ';
        while ($row = $dou->fetch_array($query)) {
            $file->thumb(basename($row['file']), $_CFG['thumb_width'], $_CFG['thumb_height']);
            echo "<script type=\"text/javascript\">mask('" . $mask_tag . "');</script>";
            flush();
            ob_flush();
        }
        echo "<script type=\"text/javascript\">success();</script>\n</body>\n</html>";
    }
}

/**
 * +----------------------------------------------------------
 * 产品型号
 * +----------------------------------------------------------
 */
elseif ($rec == 'model') {
    // 验证并获取合法的ID
    $mode = $check->is_letter($_REQUEST['mode']) ? $_REQUEST['mode'] : exit;
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : exit;
    $action_id = $check->is_number($_REQUEST['action_id']) ? $_REQUEST['action_id'] : exit;
 
    // 获取型号编号
    $model = $dou->get_one("SELECT model FROM " . $dou->table('product') . " WHERE id = '$id'");
    if (!$model) {
        $model = $dou->rand_model_sn();
        $dou->query("UPDATE " . $dou->table('product') . " SET model = '$model' WHERE id = '$id'");
    }
 
    if ($mode == 'add') {
        $dou->query("UPDATE " . $dou->table('product') . " SET model = '$model' WHERE id = '$action_id'");
    } else {
        if ($id == $action_id) {
            $dou->query("UPDATE " . $dou->table('product') . " SET model = '' WHERE model = '$model'");
        } else {
            $dou->query("UPDATE " . $dou->table('product') . " SET model = '' WHERE id = '$action_id'");
        }
    }
    
    echo model_list($model, $id);
}

/**
 * +----------------------------------------------------------
 * 产品删除
 * +----------------------------------------------------------
 */
elseif ($rec == 'del') {
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : $dou->dou_msg($_LANG['illegal'], 'product.php');
    
    $name = $dou->get_one("SELECT name FROM " . $dou->table('product') . " WHERE id = '$id'");
    
    if (isset($_POST['confirm'])) {
        // 删除相应图片
        $sql = "SELECT number FROM " . $dou->table('file') . " WHERE module = 'product' AND item_id = '$id' ORDER BY id ASC";
        $file_list = $dou->fn_query($sql);
        foreach ((array) $file_list as $row) {
            $dou->del_file($row['number']);
        }
     
        // 删除对应语言项
        if ($_OPEN['language'])
            $dou->del_lang_value('article', $id);
        
        $dou->create_admin_log($_LANG['product_del'] . ': ' . $name);
        $dou->delete('product', "id = '$id'", 'product.php');
    } else {
        $_LANG['del_check'] = preg_replace('/d%/Ums', $name, $_LANG['del_check']);
        $dou->dou_msg($_LANG['del_check'], 'product.php', '', '30', "product.php?rec=del&id=$id");
    }
}

/**
 * +----------------------------------------------------------
 * 批量操作选择
 * +----------------------------------------------------------
 */
elseif ($rec == 'action') {
    if (is_array($_POST['checkbox'])) {
        if ($_POST['action'] == 'del_all') {
            // 批量商品删除
            $dou->del_all('product', $_POST['checkbox'], 'id', 'image', true);
        } elseif ($_POST['action'] == 'category_move') {
            // 批量移动分类
            $dou->category_move('product', $_POST['checkbox'], $_POST['new_cat_id']);
        } else {
            $dou->dou_msg($_LANG['select_empty']);
        }
    } else {
        $dou->dou_msg($_LANG['product_select_empty']);
    }
}

/**
 * +----------------------------------------------------------
 * 获取款式列表
 * +----------------------------------------------------------
 */
function model_list($model, $id) {
    global $dou;
    
    if ($model) {
        $sql = "SELECT id, name, image FROM " . $dou->table('product') . " WHERE model = '$model' ORDER BY sort ASC, id DESC";
        $query = $dou->query($sql);
        while ($row = $dou->fetch_array($query)) {
            $data .= '<li><img src="' . $dou->dou_file($row['image']) . '" /><span onclick="' . "modelBox('del', '$id', '" . $row['id'] . "');" . '" class="del">X</span></li>';
        }

        return $data;
    }
}

?>