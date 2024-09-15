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
class Common extends DbMysql {
    /**
     * +----------------------------------------------------------
     * 获取导航菜单
     * +----------------------------------------------------------
     * $type 导航类型
     * $parent_id 默认获取一级导航
     * $current_module 当前页面模型名称，用于高亮导航栏
     * $current_id 当前页面栏目ID
     * +----------------------------------------------------------
     */
    function get_nav($type = 'middle', $parent_id = 0, $current_module = '', $current_id = '', $current_parent_id = '') {
        $nav = array ();
        $data = $this->fn_query("SELECT * FROM " . $this->table('nav') . " ORDER BY sort ASC");
        foreach ((array) $data as $value) {
            // 多语言
            $value = $this->lang_box($value, 'nav', 'nav_name, guide');
            
            // 根据$parent_id和$type筛选父级导航
            if ($value['parent_id'] == $parent_id && $value['type'] == $type) {
                // 如果是自定义链接则$value['guide']值链接地址，如果是内部导航则值是栏目ID
                if ($value['module'] == 'nav') {
                    if (strpos($value['guide'], 'http://') === 0 || strpos($value['guide'], 'https://') === 0) {
                        $value['url'] = $value['guide'];
                        // 自定义导航如果包含http则在新窗口打开
                        $value['target'] = true;
                    } else {
                        $value['url'] = ROOT_URL . $value['guide'];
                        // 系统会比对自定义链接是否包含在当前URL里，如果包含则高亮菜单，如果不需要此功能，请注释掉下面那行代码
                        $value['cur'] = strpos($_SERVER['REQUEST_URI'], $value['guide']);
                    }
                } else {
                    $value['unique_id'] = $this->get_unique($value['module'], $value['guide'] , 'short');
                    $value['url'] = $this->rewrite_url($value['module'], $value['guide']);
                    $value['cur'] = $this->dou_current($value['module'], $value['guide'], $current_module, $current_id, $current_parent_id);
                }
                $value['icon'] = $this->dou_file($value['icon']);
                
                foreach ($data as $child) {
                    // 筛选下级导航
                    if ($child['parent_id'] == $value['id']) {
                        $value['child'] = $this->get_nav($type, $value['id']);
                        break;
                    }
                }
                $nav[] = $value;
            }
        }
     
        if (!$nav && $type == 'bottom')
            $nav = $this->get_nav('middle', $parent_id, $current_module, $current_id, $current_parent_id);
        
        return $nav;
    }
    
    /**
     * +----------------------------------------------------------
     * 高亮当前菜单
     * +----------------------------------------------------------
     * $module 模块名称
     * $id 当前要判断的ID
     * $current_module 当前模块名称，例如在获取导航菜单时就会涉及到不同的模块
     * $current_id 当前的ID
     * +----------------------------------------------------------
     */
    function dou_current($module, $id, $current_module, $current_id = '', $current_parent_id = '') {
        if (($id == $current_id || $id == $current_parent_id) && $module == $current_module) {
            return true;
        } elseif (!$id && $module == $current_module) {
            return true;
        }
    }
    
    /**
     * +----------------------------------------------------------
     * 获取当前栏目对应的导航栏下级
     * +----------------------------------------------------------
     * $type 导航类型
     * $parent_id 默认获取一级导航
     * $current_module 当前页面模型名称，用于高亮导航栏
     * $current_id 当前页面栏目ID
     * +----------------------------------------------------------
     */
    function get_sub_nav($type = 'middle', $parent_id = 0, $current_module = '', $current_id = '') {
        // 当前导航里对应的父级ID
        $data = $this->get_row('nav', 'id, parent_id', "type = '$type' AND module = '$current_module' AND guide = '$current_id'");
        $get_parent_id = $data['parent_id'] == $parent_id ? $data['id'] : $data['parent_id'];
        $nav_sub_list = $this->get_nav($type, $get_parent_id, $current_module, $current_id);
        
        return $nav_sub_list;
    }

    /**
     * +----------------------------------------------------------
     * 获取网站信息
     * +----------------------------------------------------------
     */
    function get_config() {
        global $_CUR_LANG;
        
        $query = $this->select_all('config');
        while ($row = $this->fetch_array($query)) {
            $config[$row['name']] = $row['value'];
        }
        
        // 如果是后台调用，则不对信息进行格式化处理
        if (!defined('IS_ADMIN')) {
            if ($config['qq']) {
                $config['qq'] = $this->dou_qq($config['qq']);
            } else {
                $config['qq'] = array();
            }

            // 获取网安备案号数字部分
            if ($config['net_safe_record']) {
                if (preg_match('/\d+/', $config['net_safe_record'], $arr))
                   $config['net_safe_record_number'] = $arr[0];
            }
        }
     
        // 微信二维码
        if ($config['weixin_img']) {
            $config['weixin_img'] = ROOT_URL . 'images/upload/' . $config['weixin_img'] . $this->file_tail($config['file_update_time']);
        }
     
        // 给LOGO加上文件缓存
        $config['site_logo'] = $this->logo() . $this->file_tail($config['file_update_time']);
        
        // 额外定义
        $config['root_url'] = ROOT_URL;
        $config['m_url'] = defined('M_URL') ? M_URL : '';
        $config['admin_url'] = ROOT_URL . ADMIN_PATH . '/';
        $config['theme_url'] = ROOT_URL . 'theme/' . $config['site_theme'] . '/';
        $config['m_theme_url'] = defined('M_URL') ? M_URL . 'theme/' . $config['mobile_theme'] . '/' : '';
     
        // 首页链接地址
        $root_url = defined('IS_MOBILE') ? M_URL : ROOT_URL; // 移动版和PC版的根网址不同
        if ($_CUR_LANG) { // 多语言
            if ($_CUR_LANG['mode'] == 'rewrite_open') {
                $config['home_url'] = $root_url . $_CUR_LANG['sign'] . '/';
            } else {
                $config['home_url'] = $root_url . '?lang=' . $_CUR_LANG['pack'];
            }
         
            $lang_config_field = explode(',', 'site_name,site_title,site_keywords,site_description,address,tel,fax,email');
            $lang_config = $this->get_row('language', '*', "language_pack = '$_CUR_LANG[pack]'");
            foreach ($lang_config_field as $field) {
                if ($lang_config[$field])
                    $config[$field] = $lang_config[$field];
            }
        } else {
            $config['home_url'] = $root_url;
        }
        
        return $config;
    }
    
    /**
     * +----------------------------------------------------------
     * 重写 URL 地址
     * +----------------------------------------------------------
     * $module 模块
     * $value 根据是数字或字符来判断传递的是ID还是参数
     * +----------------------------------------------------------
     */
    function rewrite_url($module, $value = '', $type = '') {
        global $_CUR_LANG, $_MODULE;
        
        if (is_numeric($value)) {
            $id = $value; // 详细页和分类页会传的id和分类cat_id
        } else {
            $rec = $value; // 单模块会传递操作项值
        }
        
        if ($GLOBALS['_CFG']['rewrite']) {
            if (in_array($module, $_MODULE['single']) && $id) {
                $url = $module . '/' . $id;
            } else {
                $filename = $module != 'page' ? '/' . $id : '';
                $item = (!strpos($module, 'category') && $id) ? $filename . '.html' : '';
                $url = $this->get_unique($module, $id) . $item . ($rec ? '/' . $rec : '');
            }
        } else {
            $req = $rec ? '?rec=' . $rec : ($id ? '?id=' . $id : '');
            $url = $module . '.php' . $req;
        }
        
        if ($module == 'mobile') {
            $url = ROOT_URL . M_PATH; // 手机版链接
        } else {
            $root_url = (defined('IS_MOBILE') || $type == 'mobile') ? M_URL : ROOT_URL; // 移动版和PC版的根网址不同
            
            // 多语言
            if ($_CUR_LANG) {
                if ($_CUR_LANG['mode'] == 'rewrite_open') {
                    $url = $root_url . $_CUR_LANG['sign'] . '/' . $url;
                } else {
                    $url = $this->param($root_url . $url . '&lang=' . $_CUR_LANG['pack']);
                }
            } else {
                $url = $root_url . $url;
            }
        }
        
        return $url;
    }
    
    /**
     * +----------------------------------------------------------
     * 多语言
     * +----------------------------------------------------------
     */
    function lang_box($item = '', $module = '', $field_list = '') {
        global $_CUR_LANG;
        
        if ($_CUR_LANG) {
            $field_array = explode(',', preg_replace('# #', '', $field_list));
            $item_id = strpos($module, '_category') ? $item['cat_id'] : $item['id'];
            foreach ($field_array as $field) {
                $item[$field] = $this->lang_value($item[$field], $module, $item_id, $field);
            }
        }
        
        return $item;
    }
    
    /**
     * +----------------------------------------------------------
     * 显示多语言数据
     * +----------------------------------------------------------
     */
    function lang_value($value = '', $module = '', $item_id = '', $field = '') {
        global $_CUR_LANG;
        
        if ($_CUR_LANG) {
            $language_value = $this->get_one("SELECT value FROM " . $this->table('language_value') . " WHERE language_pack = '$_CUR_LANG[pack]' AND module = '$module' AND item_id = '$item_id' AND field = '$field'");
         
            return $language_value ? $language_value : $value;
        } else {
            return $value;
        }
    }
    
    /**
     * +----------------------------------------------------------
     * 系统模块
     * +----------------------------------------------------------
     */
    function dou_module() {
        global $_CUR_LANG;
        
        // 读取系统文件
        $setting = $this->read_system();
        $module['column'] = $setting['column_module'] ? array_filter($setting['column_module']) : array(); // 去除空值
        $module['single'] = $setting['single_module'] ? array_filter($setting['single_module']) : array();
        $module['link_user_center'] = $setting['link_user_center'] ? array_filter($setting['link_user_center']) : array();
        $module['no_show_menu'] = $setting['no_show_menu'] ? array_filter($setting['no_show_menu']) : array();
        $module['no_show_nav'] = $setting['no_show_nav'] ? array_filter($setting['no_show_nav']) : array();
        $module['all'] = array_merge($module['column'], $module['single']); 
        
        // 读取模块语言文件
        if (defined('IS_ADMIN')) {
            $lang_admin = $GLOBALS['_CFG']['language'] . '/admin';
            $lang_path = file_exists(ROOT_PATH . 'languages/' . $lang_admin) ? $lang_admin : 'zh_cn/admin';
        } else {
            $lang_path = $_CUR_LANG ? $_CUR_LANG['pack'] : $GLOBALS['_CFG']['language'];
        }
     
        $lang_list = glob(ROOT_PATH . 'languages/' . $lang_path . '/' . '*.lang.php');
        if (is_array($lang_list)) {
            foreach ($lang_list as $lang) {
                $module['lang'][] = $lang;
            }
        }

        // 读取模块初始化文件
        $init_list = glob(ROOT_PATH . 'include/' . '*.init.php');
        if (is_array($init_list)) {
            foreach ($init_list as $init) {
                $module['init'][] = $init;
            }
        }
        
        // 模块开启状态
        foreach ((array) $module['all'] as $module_id) {
            $_OPEN[$module_id] = true;
        }
     
        // 会员等级开启状态
        if (isset($GLOBALS['_PARAM']['user_level_option'])) {
            $_OPEN['user_level'] = $GLOBALS['_PARAM']['user_level_option'] ? true : false;
        } else {
            $_OPEN['user_level'] = false;
        }
        
        if (defined('IS_ADMIN')) {
            if (isset($_SESSION[DOU_ID]['sort'])) {
                $_OPEN['sort'] = $_SESSION[DOU_ID]['sort'] ? true : false;
            } else {
                $_OPEN['sort'] = false;
            }
        }
        $module['open'] = $_OPEN;
        
        return $module;
    }
     
    /**
     * +----------------------------------------------------------
     * 将系统文件转换为数组
     * +----------------------------------------------------------
     */
    function read_system() {
        $content = file(ROOT_PATH . 'data/system.php'); // 不当成PHP文件，主要是为了防止手动修改此文件时产生BOM头
        foreach ((array) $content as $line) {
            $line = trim($line);
            if (strpos($line, ':') !== false) {
                $arr = explode(':', $line);
                $setting[$arr[0]] = explode(',', $arr[1]);
            }
        }
        
        return $setting;
    }
    
    /**
     * +----------------------------------------------------------
     * Dou.decompile
     * +----------------------------------------------------------
     */
    function decompile($cdkey) {
        foreach ((array) $cdkey as $row) {
            $code .= chr($row);
        }
     
        return $code;
    }
    
    /**
     * +----------------------------------------------------------
     * 所有模块URL和当前模块URL生成
     * +----------------------------------------------------------
     */
    function dou_url() {
        // 所有模块URL
        $module = $this->dou_module();
        foreach ((array) $module['column'] as $module_id) {
            $url[$module_id] = $this->rewrite_url($module_id . '_category');
        }
        foreach ((array) $module['single'] as $module_id) {
            $url[$module_id] = $this->rewrite_url($module_id);
        }

        // 购物车URL
        $url['cart'] = $this->rewrite_url('order', 'cart');

        // 会员模块常用URL
        foreach (explode('|', 'login|register|logout|edit|password|sns|order|order_list|vip_log') as $value)
            $url[$value] = $this->rewrite_url('user', $value);

        // 订单模块常用URL
        foreach (explode('|', 'cashier') as $value)
            $url[$value] = $this->rewrite_url('order', $value);

        // 当前模块子栏目URL
        if ($GLOBALS['subbox']['sub']) { // 判断模块页面的column值
            foreach (explode('|', $GLOBALS['subbox']['sub']) as $value) {
                $url['sub'][$value] = $this->rewrite_url($GLOBALS['subbox']['module'], $value);
                
                if (!isset($url[$value]))
                    $url[$value] = $this->rewrite_url($GLOBALS['subbox']['module'], $value);
            }
        }
     
        // 单页面URL
        $data = $this->fn_query("SELECT id, unique_id FROM " . $this->table('page') . " ORDER BY id ASC");
        if (is_array($data)) {
            foreach ($data as $value) {
                $page[$value['unique_id']] = $this->rewrite_url('page', $value['id']);
            }
            $url['page'] = $page;
        }
        
        return $url;
    }
    
    /**
     * +----------------------------------------------------------
     * 获取别名
     * +----------------------------------------------------------
     * $module 模块
     * $id 项目ID
     * +----------------------------------------------------------
     */
    function get_unique($module, $id, $mode = 'full') {
        $filed = $module == 'page' ? 'id' : 'cat_id';
        $table_module = $module;
        
        // 非单页面和分类模型下获取分类ID
        if (!strpos($module, 'category') && $module != 'page') {
            $id = $this->get_one("SELECT cat_id FROM " . $this->table($module) . " WHERE id = " . $id);
            $table_module = $module . '_category';
        }
        
        $unique_id = $this->get_one("SELECT unique_id FROM " . $this->table($table_module) . " WHERE " . $filed . " = " . $id);
        
        // 把分类页和列表的别名统一
        $module = preg_replace("/\_category/", '', $module);

        if ($mode == 'full') {
            // 伪静态时使用的完整别名
            if ($module == 'page') {
                $unique = $unique_id;
            } elseif ($module == 'article') {
                $unique = $unique_id ? '/' . $unique_id : $unique_id;
                $unique = 'news' . $unique;
            } else {
                $unique = $unique_id ? '/' . $unique_id : $unique_id;
                $unique = $module . $unique;
            }
        } else {
            $unique = $unique_id ? $unique_id : ($module == 'article' ? 'news' : $module);
        }
        
        return $unique;
    }
    
    /**
     * +----------------------------------------------------------
     * 格式化商品价格
     * +----------------------------------------------------------
     * $price 需要格式化的价格
     * +----------------------------------------------------------
     */
    function price_format($price = '') {
        if ($price) {
            $price = number_format($price, $GLOBALS['_CFG']['price_decimal']);
            $price_format = preg_replace('/d%/Ums', $price, $GLOBALS['_LANG']['price_format']);
        }
        
        return $price_format;
    }
    
    /**
     * +----------------------------------------------------------
     * 获取当前分类下所有子分类
     * +----------------------------------------------------------
     * $table 数据表名
     * $parent_id 父类ID
     * $child 子类ID零时存储器
     * +----------------------------------------------------------
     */
    function dou_child_id($table, $parent_id = '0', &$child_id = '') {
        $data = $this->fn_query("SELECT * FROM " . $this->table($table) . " ORDER BY sort ASC, cat_id ASC");
        foreach ((array) $data as $value) {
            if ($value['parent_id'] == $parent_id) {
                $child_id .= ',' . $value['cat_id'];
                $this->dou_child_id($table, $value['cat_id'], $child_id);
            }
        }

        return $child_id;
    }
    
    /**
     * +----------------------------------------------------------
     * 向客户端发送原始的 HTTP 报头
     * +----------------------------------------------------------
     * $url 跳转网址
     * +----------------------------------------------------------
     */
    function dou_header($url) {
        header("Location: " . $url);
        exit;
    }
    
    /**
     * +----------------------------------------------------------
     * 获取无层次商品分类，将所有分类存至同一级数组，用$mark作为标记区分
     * +----------------------------------------------------------
     * $table 数据表名
     * $parent_id 默认获取一级导航
     * $level 无限极分类层次
     * $current_id 当前页面栏目ID
     * $category_nolevel 储存分类信息的数组
     * $mark 无限极分类标记
     * +----------------------------------------------------------
     */
    function get_category_nolevel($table, $parent_id = 0, $level = 0, $current_id = '', &$category_nolevel = array(), $mark = '-') {
        $data = $this->fn_query("SELECT * FROM " . $this->table($table) . " ORDER BY sort ASC, cat_id ASC");
        foreach ((array) $data as $value) {
            if ($value['parent_id'] == $parent_id && $value['cat_id'] != $current_id) {
                $value['url'] = $this->rewrite_url($table, $value['cat_id']);
                $value['mark'] = str_repeat($mark, $level);
                // 款式属性模块
                if ($GLOBALS['_OPEN']['attribute'] && $table == 'product_category' && $GLOBALS['dou_attribute']) {
                    $value['attribute_list'] = $GLOBALS['dou_attribute']->get_attribute_list($value['cat_id']);
                }
                
                $category_nolevel[] = $value;
                $this->get_category_nolevel($table, $value['cat_id'], $level + 1, $current_id, $category_nolevel);
            }
        }
        
        return $category_nolevel;
    }
    
    /**
     * +----------------------------------------------------------
     * 获取无层次单页面列表
     * +----------------------------------------------------------
     * $parent_id 调用该ID下的所有单页面，为空时则调用所有
     * $level 无限极分类层次
     * $current_id 当前页面栏目ID
     * $mark 无限极分类标记
     * +----------------------------------------------------------
     */
    function get_page_nolevel($parent_id = 0, $level = 0, $current_id = '', &$page_nolevel = array(), $mark = '-') {
        $data = $this->fn_query("SELECT * FROM " . $this->table('page') . " ORDER BY id ASC");
        foreach ((array) $data as $value) {
            if ($value['parent_id'] == $parent_id && $value['id'] != $current_id) {
                $value['url'] = $this->rewrite_url('page', $value['id']);
                $value['mark'] = str_repeat($mark, $level);
                $value['level'] = $level;
                $page_nolevel[] = $value;
                $this->get_page_nolevel($value['id'], $level + 1, $current_id, $page_nolevel);
            }
        }
        return $page_nolevel;
    }
    
    /**
     * +----------------------------------------------------------
     * 获取幻灯图片列表
     * +----------------------------------------------------------
     */
    function get_show_list($type = 'pc') {
        if ($type) {
            $where = " WHERE type = '$type'";
        }
        
        $sql = "SELECT * FROM " . $this->table('show') . $where . " ORDER BY sort ASC, id ASC";
        $query = $this->query($sql);
        while ($row = $this->fetch_array($query)) {
            // 多语言
            $row = $this->lang_box($row, 'show', 'show_name, show_img, show_text');
            
            $show_text_array = array();
            if (preg_match("(\r)", $row['show_text'])) {
                $show_text = str_replace("\r\n", "\r", $row['show_text']);
                $show_text_array = explode("\r", $show_text);
            }
            
            $show_list[] = array (
                    "id" => $row['id'],
                    "show_name" => $row['show_name'],
                    "show_link" => $row['show_link'],
                    "show_img" => $this->dou_file($row['show_img']),
                    "show_text" => $row['show_text'],
                    "show_text_array" => $show_text_array,
                    "sort" => $row['sort'] 
            );
        }
        
        return $show_list;
    }
    
    /**
     * +----------------------------------------------------------
     * 获取列表
     * +----------------------------------------------------------
     * $module 模块
     * $cat_id 分类ID
     * $num 调用数量
     * $sort 排序
     * +----------------------------------------------------------
     */
    function get_list($module, $cat_id = '', $num = '', $sort = '', $and = '') {
        $where = $cat_id == 'ALL' ? '' : " WHERE cat_id IN (" . $cat_id . $this->dou_child_id($module . '_category', $cat_id) . ")";
        $sort = $sort ? $sort . ',' : '';
        $and = $and ? ' AND ' . $and : '';
        $limit = $num ? ' LIMIT ' . $num : '';
        
        $sql = "SELECT * FROM " . $this->table($module) . $where . $and . " ORDER BY " . $sort . "id DESC" . $limit;
        $sql = $this->where($sql);
        $query = $this->query($sql);
        while ($row = $this->fetch_array($query)) {
            // 多语言
            $row = $this->lang_box($row, $module, 'name, title, content, description');
            
            $level_price = $this->level_price($row['level_price']);
            
            $item['id'] = $row['id'];
            $item['title'] = $row['title'];
            $item['name'] = $row['name'];
            $item['price'] = $row['price'] > 0 ? $this->price_format($row['price']) : $GLOBALS['_LANG']['price_discuss'];
            $item['level_price'] = $level_price > 0 ? $this->price_format($level_price) : '';
            $item['click'] = $row['click'];
            $item['defined'] = $this->format_defined($row['defined']);
            $item['add_time'] = date("Y-m-d", $row['add_time']);
            $item['add_time_short'] = date("m-d", $row['add_time']);
            $item['time'] = $this->format_time($row['add_time']);
            $item['description'] = $row['description'] ? $row['description'] : $this->dou_substr($row['content'], 320);
            $item['image'] = $this->dou_file($row['image']);
            $item['thumb'] = $this->dou_file($row['image'], true);
            $item['url'] = $this->rewrite_url($module, $row['id']);
            if ($row['cat_id']) {
                $item['cate_info'] = $this->get_row($module . '_category', 'cat_id, cat_name', "cat_id = '$row[cat_id]'");
                $item['cate_info']['url'] = $this->rewrite_url($module . '_category', $row['cat_id']);
            }
            
            $list[] = $item;
        }
        
        return $list;
    }
    
    /**
     * +----------------------------------------------------------
     * 调用所有分类栏目信息和分类项目
     * +----------------------------------------------------------
     * $module 模块
     * $item_number 调用项目数量
     * $parent_id 默认获取所有分类
     * $child 是否调用下一级
     * +----------------------------------------------------------
     */
    function get_category_data($module, $item_number = 5, $parent_id = NULL, $child = false) {
        $category_data = array();
        $where = $parent_id !== NULL ? " WHERE parent_id = '$parent_id'" : '';
        $sql = "SELECT * FROM " . $this->table($module . '_category') . $where . " ORDER BY sort ASC, cat_id ASC";
        $query = $this->query($sql);
        while ($row = $this->fetch_array($query)) {
            // 多语言
            $row = $this->lang_box($row, $module . '_category', 'cat_name');
            
            $url = $this->rewrite_url($module . '_category', $row['cat_id']);
            $category_data[] = array (
                    "cat_id" => $row['cat_id'],
                    "cat_name" => $row['cat_name'],
                    "icon" => $this->dou_file($row['icon']),
                    "unique_id" => $row['unique_id'],
                    "add_time" => date("Y-m-d", $row['add_time']),
                    "url" => $url,
                    "list" => $this->get_list($module, $row['cat_id'], $item_number, 'sort ASC'),
                    "child" => $child ? $this->get_category_data($module, $item_number, $row['cat_id']) : ''
            );
        }
        
        return $category_data;
    }
    
    /**
     * +----------------------------------------------------------
     * 格式化时间
     * +----------------------------------------------------------
     */
    function format_time($time) {
        $data['ymd'] = date("Y-m-d", $time);
        $data['y'] = date("Y", $time);
        $data['m'] = date("m", $time);
        $data['d'] = date("d", $time);
        
        return $data;
    }
    
    /**
     * +----------------------------------------------------------
     * 获取有层次的栏目分类，有几层分类就创建几维数组
     * +----------------------------------------------------------
     * $table 数据表名
     * $parent_id 默认获取一级导航
     * $current_id 当前页面栏目ID
     * +----------------------------------------------------------
     */
    function get_category($table, $parent_id = 0, $current_id = '') {
        $category = array ();
        $data = $this->fn_query("SELECT * FROM " . $this->table($table) . " ORDER BY sort ASC, cat_id ASC");
        foreach ((array) $data as $value) {
            // 多语言
            $value = $this->lang_box($value, $table, 'cat_name');
            
            // $parent_id将在嵌套函数中随之变化
            if ($value['parent_id'] == $parent_id) {
                $value['url'] = $this->rewrite_url($table, $value['cat_id']);
                $value['icon'] = $this->dou_file($value['icon']);
                $value['cur'] = $value['cat_id'] == $current_id ? true : false;
                
                foreach ($data as $child) {
                    // 筛选下级导航
                    if ($child['parent_id'] == $value['cat_id']) {
                        // 嵌套函数获取子分类
                        $value['child'] = $this->get_category($table, $value['cat_id'], $current_id);
                        break;
                    }
                }
                $category[] = $value;
            }
        }
        
        return $category;
    }
    
    /**
     * +----------------------------------------------------------
     * 获取指定分类单页面列表
     * +----------------------------------------------------------
     * $parent_id 调用该ID下的所有单页面，为空时则调用所有
     * $current_id 当前打开的单页面ID，高亮菜单使用
     * +----------------------------------------------------------
     */
    function get_page_list($parent_id = 0, $current_id = '') {
        $page_list = array ();
        $limit = $number ? " LIMIT $number" : '';
        $data = $this->fn_query("SELECT * FROM " . $this->table('page') . " ORDER BY id ASC" . $limit);
        foreach ((array) $data as $value) {
            // 多语言
            $value = $this->lang_box($value, 'page', 'page_name');
            
            // $parent_id将在嵌套函数中随之变化
            if ($value['parent_id'] == $parent_id) {
                $value['url'] = $this->rewrite_url('page', $value['id']);
                $value['cur'] = $value['id'] == $current_id ? true : false;
                
                foreach ($data as $child) {
                    // 筛选下级单页面
                    if ($child['parent_id'] == $value['id']) {
                        // 嵌套函数获取子分类
                        $value['child'] = $this->get_page_list($value['id'], $current_id);
                        break;
                    }
                }
                $page_list[] = $value;
            }
        }
        
        return $page_list;
    }
 
    /**
     * +----------------------------------------------------------
     * 获取文件列表
     * +----------------------------------------------------------
     */
    function get_file_list($module, $item_id, $type, $array_mode = false) {
        $sql = "SELECT number, file FROM " . $this->table('file') . " WHERE module = '$module' AND item_id = '$item_id' AND type = '$type' ORDER BY id ASC";
        $query = $this->query($sql);
        while ($row = $this->fetch_array($query)) {
            if ($array_mode) {
                $data[] = array (
                        "number" => $row['number'],
                        "item_id" => $item_id,
                        "file" => ROOT_URL . $row['file']
                );
            } else {
                $data .= '<li><img src="' . ROOT_URL . $row['file'] . '" /><span onclick="fileDel(' . "'" . $row['number'] . "'" . ", '" . $type . "List'" . ", '" . $module . "'" . ');" class="del">X</span></li>';
            }
        }

        return $data;
    }
    
    /**
     * +----------------------------------------------------------
     * 删除文件
     * +----------------------------------------------------------
     * $number 文件编号
     * +----------------------------------------------------------
     */
    function del_file($number) {
        $file = $this->get_row('file', 'file, thumb_size', "number = '$number'");
     
        // 删除主文件
        @unlink(ROOT_PATH . $file['file']);
     
        // 删除缩略图
        if ($file['thumb_size']) {
            $no_ext = explode(".", $file['file']);
            $image_thumb = $no_ext[0] . '_thumb' . '.' . $no_ext[1];
            @unlink(ROOT_PATH . $image_thumb);
        }
     
        $this->delete('file', "number = '$number'");
    }
    
    /**
     * +----------------------------------------------------------
     * 分页
     * +----------------------------------------------------------
     * $sql SQL查询条件
     * $page_size 每页显示数量
     * $page 当前页码
     * $page_url 地址栏中参数传递
     * $get 地址栏中参数传递
     * $close_rewrite 强制关闭伪静态
     * $record_count_reduce 总记录数手动减少
     * +----------------------------------------------------------
     */
    function pager($sql, $page_size = 10, $page = '', $page_url = '', $get = '', $close_rewrite = false, $record_count_reduce = '') {
        $record_count = $this->num_rows($this->query($sql));
        
        // 调整分页链接样式
        if (!defined('IS_ADMIN') && $GLOBALS['_CFG']['rewrite'] && !$close_rewrite) {
            $get_page = '/o';
            
            // 如果$page_url包含参数，在系统设置伪静态开启和不开启两种情况下会出现url中包含和不包含问号的情况
            if ($get) {
                $get = preg_replace('/&/', '?', $get, 1);
                $get = '/' . $get; // 起始参数前加'/'
            }
        } else {
            $get_page = strpos($page_url, '?') !== false ? '&page=' : '?page=';
        }
        
        $page_count = ceil($record_count / $page_size);
        $page_count = $page_count > 0 ? $page_count : 1; 
        $first = $page_url . $get_page . '1' . $get;
        $previous = $page_url . $get_page . ($page > 1 ? $page - 1 : 1) . $get;
        $next = $page_url . $get_page . ($page_count > $page ? $page + 1 : $page_count) . $get;
        $last = $page_url . $get_page . $page_count . $get;
     
        // 当分页总数超过6页时，起始分页由计算得出
        if ($page_count > 6) {
            if ($page_count - $page < 6) { // 总分页减去当前分页小于6页时
                $page_start = $page_count - 5; // 起始页就是总分页减去5，保证显示6个分页按钮
            } else {
                $page_start = $page;
            }
        } else {
            $page_start = 1;
        }
        
        // 页码循环显示，同时最多显示6页
        for ($p = $page_start; $p <= $page_start + 5 && $p <= $page_count; $p++) {
            $box[] = array (
                    "page" => $p,
                    "url" => $page_url . $get_page . $p . $get,
                    "cur" => $p == $page ? true : false
            );
        }
     
        $pager = array (
                "record_count" => $record_count,
                "page_size" => $page_size,
                "page" => $page,
                "page_count" => $page_count,
                "box" => $box,
                "previous" => $previous,
                "next" => $next,
                "first" => $first,
                "last" => $last 
        );
        
        $start = ($page - 1) * $page_size;
        $limit = " LIMIT $start, $page_size";
        
        if (!defined('IS_MINIPROGRAM'))
            $GLOBALS['smarty']->assign('pager', $pager);
        
        return $limit;
    }
    
    /**
     * +----------------------------------------------------------
     * 把第一个AND替换成WHERE
     * +----------------------------------------------------------
     */
    function where($where) {
        if (strpos($where, 'WHERE')) {
            return $where;
        } else {
            return preg_replace('/AND/', 'WHERE', $where, 1);
        }
    }
  
    /**
     * +----------------------------------------------------------
     * 把第一个&替换成?
     * +----------------------------------------------------------
     */
    function param($param) {
        if (strpos($param, '?')) {
            return $param;
        } else {
            return preg_replace('/&/', '?', $param, 1);
        }
    }
    
    /**
     * +----------------------------------------------------------
     * 获取上一项下一项
     * +----------------------------------------------------------
     */
    function lift($module, $id, $cat_id) {
        $field = $this->field_exist($module, 'title') ? 'title' : 'name'; // 判断包含title字段还是name字段
        $screen = $cat_id ? " AND cat_id = $cat_id" : ''; // 判断是否有分类筛选
        
        // 上一项
        $lift['previous'] = $this->fetch_assoc($this->query("SELECT id, description, image, " . $field . " FROM " . $this->table($module) . " WHERE id > $id" . $screen . " ORDER BY id ASC"));
        if ($lift['previous']) {
            $lift['previous']['url'] = $this->rewrite_url($module, $lift['previous']['id']);
            $lift['previous']['image'] = $this->dou_file($lift['previous']['image']);
            $lift['previous']['thumb'] = $this->dou_file($lift['previous']['image'], true);
         
            // 多语言
            $lift['previous'] = $this->lang_box($lift['previous'], 'article', $field);
        }
         
        // 下一项
        $lift['next'] = $this->fetch_assoc($this->query("SELECT id, description, image, " . $field . " FROM " . $this->table($module) . " WHERE id < $id" . $screen . " ORDER BY id DESC"));
        if ($lift['next']) {
            $lift['next']['url'] = $this->rewrite_url($module, $lift['next']['id']);
            $lift['next']['image'] = $this->dou_file($lift['next']['image']);
            $lift['next']['thumb'] = $this->dou_file($lift['next']['image'], true);
         
            // 多语言
            $lift['next'] = $this->lang_box($lift['next'], 'article', $field);
        }
        
        return $lift;
    }
    
    /**
     * +----------------------------------------------------------
     * 判断是否是移动客户端
     * +----------------------------------------------------------
     */
    function is_mobile() {
        static $is_mobile;
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        
        if (isset($is_mobile))
            return $is_mobile;
        
        if (empty($user_agent)) {
            $is_mobile = false;
        } else {
            // 移动端UA关键字
            $mobile_agents = array (
                    'Mobile',
                    'Android',
                    'Silk/',
                    'Kindle',
                    'BlackBerry',
                    'Opera Mini',
                    'Opera Mobi',
                    'MicroMessenger',
                    'Windows Phone'
            );
            $is_mobile = false;
            
            foreach ($mobile_agents as $device) {
                if (strpos($user_agent, $device) !== false) {
                    $is_mobile = true;
                    break;
                }
            }
        }
        
        return $is_mobile;
    }
    
    /**
     * +----------------------------------------------------------
     * 获取真实IP地址
     * +----------------------------------------------------------
     */
    function get_ip() {
        static $ip;
        if (isset($_SERVER)) {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")) {
                $ip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $ip = getenv("HTTP_CLIENT_IP");
            } else {
                $ip = getenv("REMOTE_ADDR");
            }
        }
        
        if (preg_match('/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/', $ip)) {
            return $ip;
        } else {
            return '127.0.0.1';
        }
    }

    /**
     * +----------------------------------------------------------
     * 获取第一条记录
     * +----------------------------------------------------------
     * $log 日志内容
     * $desc 是否倒序
     * +----------------------------------------------------------
     */
    function get_first_log($log, $desc = false) {
        $log_array = explode(',', $log);
        $log = $desc ? ($log_array[1] ? $log_array[1] : $log_array[0]) : $log_array[0];
        return $log;
    }

    /**
     * +----------------------------------------------------------
     * 获取插件配置信息
     * +----------------------------------------------------------
     * $unique_id 插件唯一ID
     * +----------------------------------------------------------
     */
    function get_plugin($unique_id) {
        $plugin = $this->get_row('plugin', '*', "unique_id = '$unique_id'");
        if ($plugin['config'])
            $plugin['config'] = unserialize($plugin['config']);
        
        return $plugin;
    }
 
    /**
     * +----------------------------------------------------------
     * 验证从模板引入的PHP文件
     * +----------------------------------------------------------
     * $file 需要验证码的PHP文件
     * +----------------------------------------------------------
     */
    function check_from_theme_php($file) {
        $content = file_get_contents($file);
        $illegal_word = array('insert', 'update', 'delete', 'create', 'truncate', 'drop', 'alter', 'into', 'load_file', 'outfile');
        $m = 0;
        for ($i=0; $i<count($illegal_word); $i++){
            if (stripos($content, $illegal_word[$i]) !== false) {
                $m++;
            }
        }
        if ($m == 0) return true;
    }
    
    /**
     * +----------------------------------------------------------
     * 判断 文件/目录 是否可写
     * +----------------------------------------------------------
     */
    function check_read_write($file) {
        if (file_exists($file)) {
            if (is_dir($file)) {
                $dir = $file;
                if ($fp = @fopen("$dir/test.txt", 'w')) {
                    @fclose($fp);
                    @unlink("$dir/test.txt");
                    $status = 'write';
                } else {
                    $status = 'no_write';
                }
            } else {
                if ($fp = @fopen($file, 'a+')) {
                    @fclose($fp);
                    $status = 'write';
                } else {
                    $status = 'no_write';
                }
            }
        } else {
            $status = 'no_exist';
        }
        
        return $status;
    }
    
    /**
     * +----------------------------------------------------------
     * 获取去除路径和扩展名的文件名
     * +----------------------------------------------------------
     * $file 图片地址
     * +----------------------------------------------------------
     */
    function get_file_name($file) {
        $basename = basename($file);
        return $file_name = substr($basename, 0, strrpos($basename, '.'));
    }

    /**
     * +----------------------------------------------------------
     * 邮件发送
     * +----------------------------------------------------------
     * $mailto 收件人地址
     * $title 邮件标题
     * $body 邮件正文
     * +----------------------------------------------------------
     */
    function send_mail($mailto, $subject = '', $body = '') {
        if ($GLOBALS['_CFG']['mail_service'] && file_exists(ROOT_PATH . 'include/mail.class.php')) {
            include_once (ROOT_PATH . 'include/mail.class.php');
            include_once (ROOT_PATH . 'include/smtp.class.php');

            $mail = new PHPMailer;                                // 实例化
            
            //$mail->SMTPDebug = 3;                               // 启用SMTP调试功能
             
            $mail->CharSet ="UTF-8";                              // 设定邮件编码
            $mail->isSMTP();                                      // 设定使用SMTP服务
            $mail->Host = $GLOBALS['_CFG']['mail_host'];          // SMTP服务器
            $mail->SMTPAuth = true;                               // 启用SMTP验证功能
            $mail->Username = $GLOBALS['_CFG']['mail_username'];  // SMTP服务器用户名
            $mail->Password = $GLOBALS['_CFG']['mail_password'];  // SMTP服务器密码
            if ($GLOBALS['_CFG']['mail_ssl'])
                $mail->SMTPSecure = 'ssl';                        // 安全协议，可以注释掉
            $mail->Port = $GLOBALS['_CFG']['mail_port'];          // SMTP服务器的端口号
            
            $mail->From = $GLOBALS['_CFG']['mail_username'];      // 发件人地址
            $mail->FromName = $GLOBALS['_CFG']['site_name'];      // 发件人姓名
            $mail->addAddress($mailto, '');                       // 收件地址，可选指定收件人姓名
            
            $mail->isHTML(true);                                  // 是否HTML格式邮件
            
            $mail->Subject = $subject;                            // 邮件标题
            $mail->Body    = $body;                               // 邮件内容
            
            // 邮件正文不支持HTML的备用显示
            $mail->AltBody = $GLOBALS['_LANG']['mail_altbody']; 
            
            if($mail->send()) {
                return 'success';
            }
        } else {
            $subject = "=?UTF-8?B?".base64_encode($subject)."?=";          // 解决邮件主题乱码问题，UTF8编码格式
            $header  = "From: ".$GLOBALS['_CFG']['site_name']." <".$GLOBALS['_CFG']['email'].">\n";
            $header .= "Return-Path: <".$GLOBALS['_CFG']['email'].">\n";   // 防止被当做垃圾邮件
            $header .= "MIME-Version: 1.0\n";
            $header .= "Content-type: text/html; charset=utf-8\n";         // 邮件内容为utf-8编码
            $header .= "Content-Transfer-Encoding: 8bit\r\n";              // 注意header的结尾，只有这个后面有\r
            ini_set('sendmail_from', $GLOBALS['_CFG']['email']);           // 解决mail的一个bug
            $body = wordwrap($body, 70);                                   // 每行最多70个字符,这个是mail方法的限制
            if (mail($mailto, $subject, $body, $header))
                return 'success';
        }
    }
    
    /**
     * +----------------------------------------------------------
     * 生成在线客服QQ数组
     * +----------------------------------------------------------
     */
    function dou_qq($im) {
        if ($im) {
            $im_explode = explode(',', $im);
            foreach ((array) $im_explode as $value) {
                if (strpos($value, '/') !== false) {
                    $arr = explode('/', $value);
                    $list['number'] = $arr['0'];
                    $list['nickname'] = $arr['1'];
                    $im_list[] = $list;
                } else {
                    $im_list[]['number'] = $value;
                }
            }
        }
        
        return $im_list;
    }
    
    /**
     * +----------------------------------------------------------
     * 清除html,换行，空格类并且可以截取内容长度
     * +----------------------------------------------------------
     * $str 要处理的内容
     * $length 要保留的长度
     * $charset 要处理的内容的编码，一般情况无需设置
     * +----------------------------------------------------------
     */
    function dou_substr($str, $length, $clear_space = true, $charset = DOU_CHARSET) {
        $str = trim($str); // 清除字符串两边的空格
        $str = strip_tags($str, ""); // 利用php自带的函数清除html格式
        $str = preg_replace("/\r\n/", "", $str);
        $str = preg_replace("/\r/", "", $str);
        $str = preg_replace("/\n/", "", $str);
        // 判断是否清除空格
        if ($clear_space) {
            $str = preg_replace("/\t/", "", $str);
            $str = preg_replace("/ /", "", $str);
            $str = preg_replace("/&nbsp;/", "", $str); // 匹配html中的空格
        }
        $str = trim($str); // 清除字符串两边的空格
        
        if (function_exists("mb_substr")) {
            $substr = mb_substr($str, 0, $length, $charset);
        } else {
            $c['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $c['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            preg_match_all($c[$charset], $str, $match);
            $substr = join("", array_slice($match[0], 0, $length));
        }
        
        return $substr;
    }

    /**
     * +----------------------------------------------------------
     * 生成随机数
     * +----------------------------------------------------------
     * $type 随机字符类型
     * $length 长度
     * $prefix 前缀
     * +----------------------------------------------------------
     */
    function create_rand_string($type = 'number', $length = 6, $prefix = '', $custom_chars = '') {
        // 设置随机字符范围，去掉了容易混淆的字符oOLl和数字01
        if (strpos($type, 'number') !== false)
            $chars = '0123456789';
        if (strpos($type, 'LETTER') !== false)
            $chars .= 'ABCDEFGHIJKMNPQRSTUVWXYZ';
        if (strpos($type, 'letter') !== false)
            $chars .= 'abcdefghijklmnopqrstuvwxyz';
        
        // 如果有自定义的字符则包含进去
        $chars = $chars . $custom_chars;
        
        $string = '';
        for($i = 0; $i < $length; $i++) {
            $string .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        
        return $prefix . $string;
    }
 
    /**
     * +----------------------------------------------------------
     * 生成随机数
     * +----------------------------------------------------------
     * $number 文件编号
     * $thumb 显示缩略图
     * +----------------------------------------------------------
     */
    function dou_file($number, $thumb = false) {
        if (strrchr($number, '.file') == '.file') {
            $file = $this->get_one("SELECT file FROM " . $this->table('file') . " WHERE number = '$number'");
            if (empty($file)) return false;
            if ($thumb) {
                $image = explode(".", $file);
                return ROOT_URL . $image[0] . "_thumb." . $image[1] . $this->file_tail();
            } else {
                return ROOT_URL . $file . $this->file_tail();
            }
        } else { // 允许不是dou file文件，可以直接是文件地址
            if (empty($number)) return false;
            if (strpos($number, 'http') === 0) { // 简单判断是外部文件
                return $number;
            } else {
                return ROOT_URL . $number;
            }
        }
    }
 
    /**
     * +----------------------------------------------------------
     * 文件小尾巴
     * +----------------------------------------------------------
     */
    function file_tail($file_update_time = '') {
        $file_update_time = $file_update_time ? $file_update_time : $GLOBALS['_CFG']['file_update_time'];
        $time_interval = time() - $file_update_time;
        
        // 系统最后一次重新上传文件的时间间隔小于86400秒（24小时）
        if ($file_update_time && $time_interval < 86400) {
            $tail = '?cache=' . $file_update_time;
        } else {
            $tail = '';
        }
     
        return $tail;
    }
 
    /**
     * +----------------------------------------------------------
     * 系统最后一次重新上传文件的时间
     * +----------------------------------------------------------
     */
    function file_update_time() {
        $file_update_time = time();
        $this->query("UPDATE " . $this->table('config') . " SET value = '$file_update_time' WHERE name = 'file_update_time'");
    }
 
    /**
     * +----------------------------------------------------------
     * 读取子目录绑定配置文件
     * +----------------------------------------------------------
     */
    function read_subdir_binding() {
        if (file_exists($subdir_binding_file = ROOT_PATH . "data/subdir.binding")) {
            $content = file_get_contents($subdir_binding_file);
            return trim($content);
        } else {
            return null;
        }
    }
 
    /**
     * +----------------------------------------------------------
     * 获取字段中不重复的值
     * +----------------------------------------------------------
     * $module 模块名称
     * $field 字段
     * $current_value 当前值
     * $one_level 只获取一级数组
     * +----------------------------------------------------------
     */
    function get_no_repeat_value($module, $field, $current_value = '', $one_level = false, $where = '') {
        $no_repeat_value_option = array();
        $where = $where ? ' WHERE ' . $where : '';
        $sql = "SELECT `" . $field . "` FROM " . $GLOBALS['dou']->table($module) . $where;
        $query = $GLOBALS['dou']->query($sql);
        while ($row = $GLOBALS['dou']->fetch_array($query)) {
            $no_repeat_value_option[] = $row[$field];
        }
        $no_repeat_value_option = array_filter(array_unique($no_repeat_value_option)); // 过滤掉重复值并去掉空值
        
        if ($one_level)
            return $no_repeat_value_option;

        foreach ($no_repeat_value_option as $value) {
            $no_repeat_value[] = array (
                    "value" => $value,
                    "cur" => $current_value ? ($current_value == $value ? true : false) : false // 如果当前属性POST传递值跟筛选值相同则高亮 
            );
        }

        return $no_repeat_value;
    }
 
    /**
     * +----------------------------------------------------------
     * 删除一维数组指定值
     * +----------------------------------------------------------
     */
    function del_array_value($array, $value) {
        foreach($array as $k=>$v) {
            if($v == $value) {
                unset($array[$k]);
            }
        }

        return $array;
    }
 
    /**
     * +----------------------------------------------------------
     * 字段值语言化
     * +----------------------------------------------------------
     * $prefix 语言文件前缀
     * $value_list 值列表
     * $cur 当前值
     * +----------------------------------------------------------
     */
    function data_list_lang_format($prefix, $value_list, $cur = '') {
        foreach (explode(',', $value_list) as $row) {
            $row = trim($row);
            $value_lang[] = array (
                    "value" => $row,
                    "format" => $GLOBALS['_LANG'][$prefix . $row],
                    "cur" => $row == $cur ? true : false
            );
        }
        
        return $value_lang;
    }
 
    /**
     * +----------------------------------------------------------
     * 字段值语言化
     * +----------------------------------------------------------
     * $prefix 语言文件前缀
     * $value 值
     * +----------------------------------------------------------
     */
    function data_lang_format($prefix, $value) {
        $lang = array (
                "value" => $value,
                "format" => $GLOBALS['_LANG'][$prefix . $value]
        );
        
        return $lang;
    }
 
    /**
     * +----------------------------------------------------------
     * cURL请求
     * +----------------------------------------------------------
     * $url 请求地址
     * $data 参数（一位数组）
     * +----------------------------------------------------------
     */
    function curl($url, $data = array()) {
        if (function_exists('curl_init')) {
            // 初始化
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url); // 请求地址
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 返回的内容作为变量储存，而不是直接输出

            // 通过POST传入参数
            if ($data) {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }

            // 如果发送的请求是https，必须要禁止服务器端校检SSL证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // 发送请求
            $response = curl_exec($ch);

            // 释放curl句柄, 关闭一个curl会话
            curl_close($ch);

            return $response;
        }
    }
 
    /**
     * +----------------------------------------------------------
     * 获取会员基本信息
     * +----------------------------------------------------------
     */
    function user_basic($user_id) {
        $user_basic = $this->get_row('user', 'user_id, email, telphone, contact, nickname, user_sn, avatar', "user_id = '$user_id'");
        
        if ($user_basic) {
            $user_basic['username'] = $user_basic['nickname'] ? $user_basic['nickname'] : ($user_basic['email'] ? $user_basic['email'] : $user_basic['telphone']);
            $user_basic['avatar'] = $this->dou_file($user_basic['avatar']);
        }
        
        return $user_basic;
    }
 
    /**
     * +----------------------------------------------------------
     * 获取等级名称
     * +----------------------------------------------------------
     * $cur_level 当前等级
     * $level_price 等级价格数组
     * +----------------------------------------------------------
     */
    function user_level_option($cur_level = '', $level_price = array()) {
        if ($GLOBALS['_PARAM']['user_level_option']) {
            $user_level_option = explode(',', $GLOBALS['_PARAM']['user_level_option']);
            foreach ($user_level_option as $value) {
                $option_list[] = array (
                        "key" => $value,
                        "name" => $this->user_level_name($value),
                        "cur" => $value == $cur_level ? true : false,
                        "price" => is_array($level_price) ? $level_price[$value] : '',
                        "price_format" => is_array($level_price) ? $this->price_format($level_price[$value]) : '',
                );
            }
        }
        
        return $option_list;
    }
 
    /**
     * +----------------------------------------------------------
     * 获取等级名称
     * +----------------------------------------------------------
     */
    function user_level_name($level = '') {
        $level_name = $GLOBALS['_LANG']['user_level_' . $level] ? $GLOBALS['_LANG']['user_level_' . $level] : $level;
        $level_name = $level_name ? $level_name : $GLOBALS['_LANG']['user_level_no'];
        
        return $level_name;
    }
 
    /**
     * +----------------------------------------------------------
     * 不同会员等级对应的价格
     * +----------------------------------------------------------
     */
    function level_price($level_price = '', $user_id = '') {
        $user_id = $user_id ? $user_id : $GLOBALS['_GLOBAL_USER']['user_id'];
        $user_level = $this->get_one("SELECT level FROM " . $this->table('user') . " WHERE user_id = '$user_id'");
        
        if ($GLOBALS['_OPEN']['user_level'] && $level_price) {
            $level_price = unserialize($level_price);
            if (is_array($level_price))
                return $level_price[$user_level];
        }
    }
 
    /**
     * +----------------------------------------------------------
     * VIP会员
     * +----------------------------------------------------------
     */
    function vip($user_id) {
        if (!$GLOBALS['_OPEN']['vip'])
            return false;
        
        $vip_log = $this->get_row('vip', '*', "user_id = '$user_id' AND status = 1 AND price > 0");
        
        if ($vip_log) {
            if ($vip_log['end_time'] > time()) {
                $vip['text'] = '<b>（VIP会员）</b>';
                $vip['class'] = ' class="viping"';
                $vip['status'] = 'yes';
            } else {
                $vip['text'] = '<b style="color:red">（VIP已过期）</b>';
                $vip['status'] = 'no';
            }
            $vip['start_time'] = date("Y-m-d", $vip_log['start_time']);
            $vip['end_time'] = date("Y-m-d", $vip_log['end_time']);
        }
        
        return $vip;
    }
 
    /**
     * +----------------------------------------------------------
     * 获取参数配置
     * +----------------------------------------------------------
     */
    function parameter() {
        $parameter = array();
        
        $query = $this->query("SELECT name, value, `group` FROM " . $this->table('parameter'));
        while ($row = $this->fetch_array($query)) {
            $parameter[$row['name']] = $row['value'];
        }
        
        return $parameter;
    }
 
    /**
     * +----------------------------------------------------------
     * 获取参数配置
     * +----------------------------------------------------------
     */
    function format_defined($defined) {
        // 格式化自定义参数
        if ($defined) {
            $defined_array = explode(',', $defined);
            foreach ((array)$defined_array as $r) {
                $array = explode('：', str_replace(":", "：", $r));

                if ($array['1']) {
                    $format_defined[] = array (
                            "arr" => $array['0'],
                            "value" => $array['1'] 
                    );
                }
            }
        }
        
        return $format_defined;
    }

    /**
     * +----------------------------------------------------------
     * 日志
     * +----------------------------------------------------------
     */
    function log($text = '') {
        if (!file_exists($log_path = ROOT_PATH . 'data/log/'))
            mkdir($log_path, 0777);
     
        $file_name = 'log_' . $this->create_rand_string('number', 4) . '.txt';
					   file_put_contents(ROOT_PATH . 'data/log/log_' . date("Y-m-d H:i:s", time()) . '.txt', $sql_insert_user);
    }

    /**
     * +----------------------------------------------------------
     * 格式化网址，如“domain.com”
     * +----------------------------------------------------------
     */
    function format_url($url) {
					   if (preg_match('#(https?\://[^/]+)(/.*)?#', $url, $matches)) {
								    $url = $matches[1];
								}
        return trim(str_replace('www.', '', str_replace('https://', '', str_replace('http://', '', $url))), '/');
    }

    /**
     * +----------------------------------------------------------
     * 获取关于我们
     * +----------------------------------------------------------
     */
    function get_about() {
        $about = $this->get_row('page', '*', "unique_id = 'about'");
        if (!$about)
            $about = $this->get_row('page', '*', "id = '1'");
        
        // 多语言
        $about = $this->lang_box($about, 'page', 'page_name, content, description');

        $about['content'] = $about['description'] ? $about['description'] : $this->dou_substr($about['content'], 300, false);
        $about['link'] = $this->rewrite_url('page', $about['id']);
        $about['page_list'] = $this->get_page_list($about['id']);
        
        return $about;
    }
    
    /**
     * +----------------------------------------------------------
     * 获取用户信息
     * +----------------------------------------------------------
     * $user_id 会员ID
     * +----------------------------------------------------------
     */
    function user_info($user_id) {
        $user = $this->get_row('user', 'user_sn, email, telphone, contact, nickname, avatar', "user_id = '$user_id'");
        
        if ($user) {
            $user['username'] = $GLOBALS['_PARAM']['login_mode'] == 'telphone' ? $user['telphone'] : $user['email'];
            $user['avatar'] = $user['avatar'] ? $this->dou_file($user['avatar']) : '';
              
            return $user;
        }
    }
    
    /**
     * +----------------------------------------------------------
     * 获取友情链接
     * +----------------------------------------------------------
     */
    function get_link_list() {
        if (!$GLOBALS['_OPEN']['link'])
            return array();
        
        $sql = "SELECT * FROM " . $this->table('link') . " ORDER BY sort ASC, id ASC";
        $query = $this->query($sql);
        while ($row = $this->fetch_array($query)) {
            $link_list[] = array (
                    "id" => $row['id'],
                    "link_name" => $row['link_name'],
                    "link_url" => $row['link_url'],
                    "sort" => $row['sort'] 
            );
        }

        return $link_list;
    }
    
    /**
     * +----------------------------------------------------------
     * 获取内容盒子分组
     * +----------------------------------------------------------
     */
    function get_box($type = 'list', $class_unique_id = '') {
        if (!$GLOBALS['_OPEN']['box'])
            return array();
        
        $class_list_array = $this->get_no_repeat_value('box', 'class_unique_id');
        
        if ($type == 'list') {
            foreach ((array)$class_list_array as $key => $row) {
                $list[$key] = $list[$row['value']] = $this->get_box_list($row['value']);
            }
        } else {
            foreach ((array)$class_list_array as $row) {
                $list[] = array (
                        "class" => $this->get_one("SELECT class FROM " . $this->table('box') . " WHERE class_unique_id = '" . $row['value'] . "'"),
                        "class_unique_id" => $row['value'],
                        "cur" => $row['value'] == $class_unique_id ? true : false
                );
            }
        }

        return $list;
    }

    /**
     * +----------------------------------------------------------
     * 获取内容盒子列表
     * +----------------------------------------------------------
     */
    function get_box_list($class_unique_id = '') {
        if (!$class_unique_id)
            return array();

        $sql = "SELECT * FROM " . $this->table('box') . $where . " WHERE class_unique_id = '$class_unique_id' ORDER BY sort ASC, id ASC";
        $query = $this->query($sql);
        while ($row = $this->fetch_array($query)) {
            // 多语言
            $row = $this->lang_box($row, 'box', 'name, text');
            
            $box_list[] = array (
                    "id" => $row['id'],
                    "class" => $row['class'],
                    "name" => $row['name'],
                    "text" => $row['text'],
                    "link" => $row['link'],
                    "image" => $this->dou_file($row['image']),
                    "sort" => $row['sort'] 
            );
        }

        return $box_list;
    }
    
    /**
     * +----------------------------------------------------------
     * 获取内容碎片
     * +----------------------------------------------------------
     */
    function get_fragment() {
        if (!$GLOBALS['_OPEN']['fragment'])
            return array();
        
        $sql = "SELECT * FROM " . $this->table('fragment') . " ORDER BY sort DESC, id DESC";
        $query = $this->query($sql);

        while ($row = $this->fetch_array($query)) {
            // 多语言
            $row = $this->lang_box($row, 'fragment', 'name, image, text, link');
									
									   $text_array = array();
            if (preg_match("(\r)", $row['text'])) {
                $text = str_replace("\r\n", "\r", $row['text']);
                $text_array = explode("\r", $text);
            }
            
            $fragment[$row['mark']] = array (
                    "name" => $row['name'],
                    "mark" => $row['mark'],
                    "image" => $this->dou_file($row['image']),
                    "text" => $row['text'],
                    "text_array" => $text_array,
                    "link" => $row['link']
            );
        }
        
        return $fragment;
    }
    
    /**
     * +----------------------------------------------------------
     * 获取语言菜单
     * +----------------------------------------------------------
     */
    function get_lang_menu($cur_language_pack = '') {
        if ($GLOBALS['_OPEN']['language']) {
            $cur_language_pack = $cur_language_pack ? $cur_language_pack : $GLOBALS['_CFG']['language'];
            
            // 默认语言
            require (ROOT_PATH . 'languages/' . $GLOBALS['_CFG']['language'] . '/common.lang.php');
            $lang_list_array[] = array (
                    "name" => $_LANG['cur_language'],
                    "language_pack" => $GLOBALS['_CFG']['language'],
                    "url" => ROOT_URL
            );
            
            $sql = "SELECT * FROM " . $this->table('language') . " ORDER BY sort DESC, language_id DESC";
            $query = $this->query($sql);

            while ($row = $this->fetch_array($query)) {
                $lang_list_array[] = array (
                        "name" => $row['name'],
                        "language_pack" => $row['language_pack']
                );
            }
            
            foreach ($lang_list_array as $row) {
                if ($cur_language_pack != $row['language_pack']) {
                    $url = $GLOBALS['_CFG']['rewrite'] ? ROOT_URL . str_replace('_', '-', $row['language_pack']) : ROOT_URL . '?lang=' . $row['language_pack'];
                    $lang_list[] = array (
                            "name" => $row['name'],
                            "language_pack" => $row['language_pack'],
                            "url" => $row['url'] ? $row['url'] : $url
                    );
                }
            }
            
            return $lang_list;
        }
    }
    
    /**
     * +----------------------------------------------------------
     * 获取LOGO
     * +----------------------------------------------------------
     */
    function logo($language_pack = '') {
        $site_logo = $this->get_one("SELECT value FROM " . $this->table('config') . " WHERE name = 'site_logo'");
        $language_pack = $language_pack ? $language_pack : (isset($GLOBALS['_CUR_LANG']) ? $GLOBALS['_CUR_LANG']['pack'] : '');
        
        if ($language_pack) {
            $language_site_logo = $this->get_one("SELECT site_logo FROM " . $this->table('language') . " WHERE language_pack = '$language_pack'");
            if ($language_site_logo)
                $site_logo = $language_site_logo;
        }
        
        return $site_logo;
    }

    /**
     * +----------------------------------------------------------
     * 获取款式列表
     * +----------------------------------------------------------
     */
    function get_model_list($model, $id) {
        if ($model) {
            $sql = "SELECT id, name, image FROM " . $this->table('product') . " WHERE model = '$model' ORDER BY sort ASC, id DESC";
            $query = $this->query($sql);
            while ($row = $this->fetch_array($query)) {
                $model_list[] = array (
                        "name" => $row['name'],
                        "thumb" => $this->dou_file($row['image'], true),
                        "image" => $this->dou_file($row['image']),
                        "cur" => $row['id'] == $id ? true : false,
                        "url" => $this->rewrite_url('product', $row['id'])
                );
            }

            return $model_list;
        }
    }
 
}

?>