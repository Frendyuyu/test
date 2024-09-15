<?php
/**
 * DouPHP
 * --------------------------------------------------------------------------------------------------
 * 版权所有 2014-2015 漳州豆壳网络科技有限公司，并保留所有权利。
 * 网站地址: https://www.douphp.com
 * --------------------------------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在遵守授权协议前提下对程序代码进行修改和使用；不允许对程序代码以任何形式任何目的的再发布。
 * 授权协议: https://www.douphp.com/license.html
 * --------------------------------------------------------------------------------------------------
 * Author: DouCo Co.,Ltd.
 * Release Date: 2020-06-01
 */

// 数据库 主机IP
$dbhost   = '127.0.0.1';

// 数据库 名称
$dbname   = 'test';

//数据库 用户
$dbuser   = 'root';

//数据库 密码
$dbpass   = 'root';

//数据库 表名前坠
$prefix   = 'dou_';

//数据库 字符集
define('DOU_CHARSET', 'utf-8');

// system sign
define('SYSTEM_SIGN', 'company');

// administrator path
define('ADMIN_PATH', isset($admining) ? $admining : 'admin');

// mobile path
define('M_PATH', 'm');

// miniprogram path
define('MINIPROGRAM_PATH', 'miniprogram');

?>