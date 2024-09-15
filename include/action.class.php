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
class Action extends Common {
    /**
     * +----------------------------------------------------------
     * 当前位置
     * +----------------------------------------------------------
     * $module 模块名称
     * $class 分类ID或模块子栏目
     * $title 信息标题
     * +----------------------------------------------------------
     */
    function ur_here($module = '', $class = '', $title = '') {
        if ($module && $module != 'page') {
            $ur_here['module']['name'] = $GLOBALS['_LANG'][$module];
            $ur_here['module']['url'] = $this->rewrite_url($module);
        }
     
        // 如果存在分类
        if ($class) {
            if (is_numeric($class)) {
                global $_CUR_LANG;
                
                $ur_here['class']['name'] = $this->get_one("SELECT cat_name FROM " . $this->table($module) . " WHERE cat_id = '$class'");
                if ($_CUR_LANG) // 多语言
                    $ur_here['class']['name'] = $this->lang_value($ur_here['class']['name'], $module, $class, 'cat_name');;
            } else {
                $ur_here['class']['name'] = $GLOBALS['_LANG'][$class];
            }
            $ur_here['class']['url'] = $this->rewrite_url($module, $class);
        }
     
        if ($title) {
            $ur_here['title'] = $title;
        }
        
        return $ur_here;
    }
    
    /**
     * +----------------------------------------------------------
     * 标题
     * +----------------------------------------------------------
     * $module 模块名称
     * $class 分类ID或模块子栏目
     * $title 信息标题
     * +----------------------------------------------------------
     */
    function page_title($module = '', $class = '', $title = '') {
        // 如果是单页面，则只执行这一句
        if ($module == 'page') {
            $titles = $title . ' | ';
        } elseif ($module) {
            // 模块名称
            $main = $GLOBALS['_LANG'][$module] . ' | ';
            
            // 如果存在分类
            if ($class) {
                $cat_name = is_numeric($class) ? $this->get_one("SELECT cat_name FROM " . $this->table($module) . " WHERE cat_id = '$class'") : $GLOBALS['_LANG'][$class];
                $cat_name = $cat_name . ' | ';
            }
            
            // 如果存在标题
            if ($title)
                $title = $title . ' | ';
            
            $titles = $title . $cat_name . $main;
        }
     
        $power_title = ' - ' . $GLOBALS['power_text'] . ' FrendStdio';
        if (file_exists($cdkey_file = ROOT_PATH . 'data/..cdkey.php')) {
            if ($GLOBALS['decompile_init'] == substr(md5(DOU_SHELL), 16) . $GLOBALS['_CFG']['douphp_version'] . $this->format_url(ROOT_URL)) {
                $power_title = '';
            }
        }
        
        $page_title = ($titles ? $titles . $GLOBALS['_CFG']['site_name'] : $GLOBALS['_CFG']['site_title']) . $power_title;
        
        return $page_title;
    }
    
    /**
     * +----------------------------------------------------------
     * 信息提示
     * +----------------------------------------------------------
     * $text 提示的内容
     * $url 提示后要跳转的网址
     * $time 多久时间跳转
     * +----------------------------------------------------------
     */
    function dou_msg($text = '', $url = '', $time = 3) {
        if (!$text) {
            $text = $GLOBALS['_LANG']['dou_msg_success'];
        }
        
        /* 获取meta和title信息 */
        $GLOBALS['smarty']->assign('page_title', $GLOBALS['_CFG']['site_title']);
        $GLOBALS['smarty']->assign('keywords', $GLOBALS['_CFG']['site_keywords']);
        $GLOBALS['smarty']->assign('description', $GLOBALS['_CFG']['site_description']);
        
        /* 初始化导航栏 */
        $GLOBALS['smarty']->assign('nav_top_list', $this->get_nav('top'));
        $GLOBALS['smarty']->assign('nav_middle_list', $this->get_nav('middle'));
        $GLOBALS['smarty']->assign('nav_bottom_list', $this->get_nav('bottom'));
        
        /* 初始化数据 */
        $GLOBALS['smarty']->assign('ur_here', $GLOBALS['dou']->ur_here('page', '', $GLOBALS['_LANG']['dou_msg']));
        $GLOBALS['smarty']->assign('text', $text);
        $GLOBALS['smarty']->assign('url', $url);
        $GLOBALS['smarty']->assign('time', $time);
        
        // 根据跳转时间生成跳转提示
        $cue = preg_replace('/d%/Ums', $time, $GLOBALS['_LANG']['dou_msg_cue']);
        $GLOBALS['smarty']->assign('cue', $cue);
        
        $GLOBALS['smarty']->display('dou_msg.dwt');
        
        exit();
    }
}
?>