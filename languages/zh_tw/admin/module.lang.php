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

// 模塊擴展
$_LANG['module'] = '模塊擴展';
$_LANG['module_unzip_wrong'] = '壓縮包解壓失敗';
$_LANG['module_install_cloud'] = '在線安裝模塊'; // 在線安裝模塊
$_LANG['module_install_local'] = '安裝本地模塊'; // 本地安裝模塊
$_LANG['module_install_local_cue'] = '<strong>操作說明：</strong>首先將您要安裝模塊的壓縮包放到 "cache" 目錄下，然後請點擊 <a href="module.php?rec=install_local">載入待安裝模塊</a>，即可進行安裝操作。';
$_LANG['module_install_local_list'] = '待安裝模塊';
$_LANG['module_install_local_btn'] = '安裝';
$_LANG['module_install_local_success'] = '成功安裝離線模塊';
$_LANG['module_uninstall'] = '卸載已安裝模塊'; // 卸載模塊
$_LANG['module_uninstall_cue'] = '<strong>操作說明：</strong>首先刪除模塊鎖定文件“data/module.lock”（該文件在下壹次登錄後臺時會重新生成），然後請點擊 <a href="module.php?rec=uninstall">載入待刪除模塊</a>，即可進行卸載操作，系統會將對應模塊文件和數據表全部刪除。';
$_LANG['module_uninstall_list'] = '待刪除模塊';
$_LANG['module_uninstall_btn'] = '卸載';
$_LANG['module_uninstall_wrong'] = '無法卸載，模塊不存在或模塊卸載操作被鎖定！';
$_LANG['module_uninstall_install_file_wrong'] = '模塊卸載索引文件缺失！';
$_LANG['module_uninstall_success'] = '成功卸載模塊';

?>