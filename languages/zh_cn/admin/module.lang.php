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

// 模块扩展
$_LANG['module'] = '模块扩展';
$_LANG['module_unzip_wrong'] = '压缩包解压失败';
$_LANG['module_install_cloud'] = '在线安装模块'; // 在线安装模块
$_LANG['module_install_local'] = '安装本地模块'; // 本地安装模块
$_LANG['module_install_local_cue'] = '<strong>操作说明：</strong>首先将您要安装模块的压缩包放到 "cache" 目录下，然后请点击 <a href="module.php?rec=install_local">载入待安装模块</a>，即可进行安装操作。';
$_LANG['module_install_local_list'] = '待安装模块';
$_LANG['module_install_local_btn'] = '安装';
$_LANG['module_install_local_success'] = '成功安装离线模块';
$_LANG['module_uninstall'] = '卸载已安装模块'; // 卸载模块
$_LANG['module_uninstall_cue'] = '<strong>操作说明：</strong>首先删除模块锁定文件“data/module.lock”（该文件在下一次登录后台时会重新生成），然后请点击 <a href="module.php?rec=uninstall">载入待删除模块</a>，即可进行卸载操作，系统会将对应模块文件和数据表全部删除。';
$_LANG['module_uninstall_list'] = '待删除模块';
$_LANG['module_uninstall_btn'] = '卸载';
$_LANG['module_uninstall_wrong'] = '无法卸载，模块不存在或模块卸载操作被锁定！';
$_LANG['module_uninstall_install_file_wrong'] = '模块卸载索引文件缺失！';
$_LANG['module_uninstall_success'] = '成功卸载模块';

?>