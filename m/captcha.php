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

if (!isset($_REQUEST['rec']))
    define('EXIT_INIT', true);

require (dirname(__FILE__) . '/include/init.php');
require (ROOT_PATH . 'include/captcha.class.php');

// 开启SESSION
session_start();

if ($_REQUEST['rec'] == 'sms') {
    $response = $sms->captcha($_POST['sms_token'], $_POST['telphone']);
    echo $response['msg'];
} else {
    // 实例化验证码
    $captcha = new Captcha(70, 25);
    @ob_end_clean(); // 清除之前出现的多余输入
    $captcha->create_captcha();
}

?>