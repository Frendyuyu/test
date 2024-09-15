<?php
/**
 * DouPHP
 * --------------------------------------------------------------------------------------------------
 * 版权所有 2013-2018 漳州豆壳网络科技有限公司，并保留所有权利。
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
class Install {
    /**
     * +----------------------------------------------------------
     * 判断是否为rec操作项
     * +----------------------------------------------------------
     */
    function is_rec($rec = '') {
        if (preg_match("/^[a-z_]+$/", $rec)) {
            return true;
        }
    }

    /**
     * +----------------------------------------------------------
     * 判断用户名是否规范
     * +----------------------------------------------------------
     */
    function is_username($username) {
        if (preg_match("/^[a-zA-Z]{1}([0-9a-zA-Z]|[._]){3,19}$/", $username)) {
            return true;
        }
    }
    
    /**
     * +----------------------------------------------------------
     * 判断密码是否规范
     * +----------------------------------------------------------
     */
    function is_password($password) {
        if (preg_match("/^[\@A-Za-z0-9\!\#\$\%\^\&\*\.\~]{6,22}$/", $password)) {
            return true;
        }
    }

    /**
     * +----------------------------------------------------------
     * 判断是否为邮件地址
     * +----------------------------------------------------------
     */
    function is_email($email) {
        if (preg_match("/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/", $email)) {
            return true;
        }
    }
    
    /**
     * +----------------------------------------------------------
     * 判断 文件/目录 是否可写
     * +----------------------------------------------------------
     */
    function check_writeable($file) {
        if (file_exists($file)) {
            if (is_dir($file)) {
                $dir = $file;
                if ($fp = @fopen("$dir/test.txt", 'w')) {
                    @fclose($fp);
                    @unlink("$dir/test.txt");
                    $writeable = 1;
                } else {
                    $writeable = 0;
                }
            } else {
                if ($fp = @fopen($file, 'a+')) {
                    @fclose($fp);
                    $writeable = 1;
                } else {
                    $writeable = 0;
                }
            }
        } else {
            $writeable = 2;
        }
        
        return $writeable;
    }
 
    /**
     * +----------------------------------------------------------
     * 删除目录
     * +----------------------------------------------------------
     * $dir 路径
     * $only_file 是否保留目录结构只删除文件
     * $refer_dir 以参考目录里的文件为准进行删除操作
     * +----------------------------------------------------------
     */
    function del_dir($dir, $only_file = false, $refer_dir = '') {
        if (!$dir || !@is_dir($dir)) return 0;
        
        if ($dir[strlen($dir) - 1] != DIRECTORY_SEPARATOR) $dir .= DIRECTORY_SEPARATOR; // 如果目录结尾不包含 / 就给它加上
        if ($refer_dir) {
            if (!@is_dir($refer_dir)) return 0;
            if ($refer_dir[strlen($refer_dir) - 1] != DIRECTORY_SEPARATOR) $refer_dir .= DIRECTORY_SEPARATOR;
        }
        
        $opendir = $refer_dir ? $refer_dir : $dir; // 判断是否以参考目录为准
        if ($handle = @opendir($opendir)) {
            while (($file = @readdir($handle)) !== false) {
                if ($file != '.' && $file != '..') { // .表示当前目录,..表示上一级目录
                    if (@is_dir($opendir . $file) && !is_link($opendir . $file)) { // 是目录
                        $this->del_dir($dir . $file, $only_file, ($refer_dir ? $refer_dir . $file : ''));
                    } else { // 是文件
                        @unlink($dir . $file);
                    }
                }
            }
            closedir($handle);
         
            // 如果设置only_file，只删除文件保留目录
            if (!$only_file) @rmdir($dir);  
        }
    }
    
}
?>