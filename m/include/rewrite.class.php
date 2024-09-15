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
class Rewrite {
    /**
     * +----------------------------------------------------------
     * 格式化URL
     * +----------------------------------------------------------
     * $route 伪静态后的URL
     * +----------------------------------------------------------
     */
    function format($route) {
        $mark['site_path'] = str_replace('include/rewrite.class.php', '', str_replace('\\', '/', __FILE__));
        
        // 拆分URL
        $parts = explode('/', $route);
        
        // 多语言模式
        if (preg_match("/^[a-zA-Z]{2}-[a-zA-Z]{2}$/", $parts[0])) {
            $mark['lang'] = $parts[0];
            array_splice($parts, 0, 1);
        }
        
        $parts[1] = isset($parts[1]) ? $parts[1] : '';
        $parts[2] = isset($parts[2]) ? $parts[2] : '';
        
        $mark['is_lang_home'] = isset($mark['lang']) && !$parts[0] ? true : false;

        // URL中news对应的是article模块
        $parts[0] = $parts[0] == 'news' ? 'article' : $parts[0];

        // 获取模块信息
        $module = $this->module();

        if (preg_match("/^([a-z0-9-]+)\.html$/", $parts[0])) { // 单页面URL格式化
            $mark['module'] = 'page';
            $mark['unique_id'] = str_replace('.html', '', $parts[0]);
        } elseif (in_array($parts[0], $module['column'])) { // 栏目模块URL格式化
            if (strpos($route, '.html')) {
                $mark['module'] = $parts[0];
                $mark['unique_id'] = !preg_match("/^([0-9]+)\.html$/", $parts[1]) ? $parts[1] : '';
                $mark['id'] = str_replace('.html', '', basename($route));
            } else {
                $mark['module'] = $parts[0] . '_category';
                if (preg_match("/^o([0-9]+)$/", $parts[1])) {
                    $mark['page'] = str_replace('o', '', $parts[1]);
                } else {
                    $mark['unique_id'] = $parts[1];
                    if (preg_match("/^o([0-9]+)$/", $parts[2])) {
                        $mark['page'] = str_replace('o', '', $parts[2]);
                    }
                }
            }
        } elseif (in_array($parts[0], $module['single'])) { // 单一模块URL格式化
            $mark['module'] = $parts[0];
            if (preg_match("/^o([0-9]+)$/", $parts[1])) {
                $mark['page'] = str_replace('o', '', $parts[1]);
            } elseif (preg_match("/^([0-9]+)$/", $parts[1])) {
                $mark['rec'] = 'info';
                $mark['id'] = $parts[1];
            } else {
                $mark['rec'] = $parts[1];
                if (preg_match("/^o([0-9]+)$/", $parts[2]))
                    $mark['page'] = str_replace('o', '', $parts[2]);
            }
        }

        return $mark;
    }

    /**
     * +----------------------------------------------------------
     * 系统模块
     * +----------------------------------------------------------
     */
    function module() {
        // 读取系统文件
        $content = file('../data/system.php');
        foreach ($content as $line) {
            $line = trim($line);
            if (strpos($line, ':') !== false) {
                $arr = explode(':', $line);
                $setting[$arr[0]] = explode(',', $arr[1]);
            }
        }

        $module['column'] = $setting['column_module'];
        $module['single'] = $setting['single_module'];

        return $module;
    }
}

?>