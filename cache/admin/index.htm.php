<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="copyright" content="DouCo Co.,Ltd." />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title><?php echo $this->_tpl_vars['lang']['home']; ?>
<?php if ($this->_tpl_vars['ur_here']): ?> - <?php echo $this->_tpl_vars['ur_here']; ?>
 <?php endif; ?></title>
<link href="<?php echo $this->_tpl_vars['site']['root_url']; ?>
favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="templates/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="templates/public.css" rel="stylesheet" type="text/css">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "javascript.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['rec'] == 'default' && ! $this->_tpl_vars['site']['close_update']): ?>
<script type="text/javascript">fetch_update_number('<?php echo $this->_tpl_vars['localsite']; ?>
', '<?php echo $this->_tpl_vars['localsystem']; ?>
')</script>
<?php endif; ?>
</head>
<body>
<div id="dcWrap"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 <div id="dcLeft"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
 <div id="dcMain"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "handle.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php if ($this->_tpl_vars['workspace']['admin_theme_custom']['index']): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "index.custom.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php else: ?>
  <div id="index" class="mainBox" style="padding-top:18px;<?php echo $this->_tpl_vars['workspace']['height']; ?>
">
   <?php if ($this->_tpl_vars['rec'] == 'default'): ?>
   <div id="right" class="m-none">
    <div class="quickMenu">
     <h2><?php echo $this->_tpl_vars['lang']['quick_menu']; ?>
</h2>
     <div class="menu">
      <dl>
       <?php if ($this->_tpl_vars['site']['rewrite']): ?>
       <dt><a href="system.php?light=rewrite"><?php echo $this->_tpl_vars['lang']['close']; ?>
</a><?php echo $this->_tpl_vars['lang']['quick_menu_rewrite']; ?>
（<?php echo $this->_tpl_vars['lang']['opened']; ?>
）</dt>
       <?php else: ?>
       <dt><a href="system.php?light=rewrite"><?php echo $this->_tpl_vars['lang']['open']; ?>
</a><?php echo $this->_tpl_vars['lang']['quick_menu_rewrite']; ?>
（<?php echo $this->_tpl_vars['lang']['open_no']; ?>
）</dt>
       <?php endif; ?>
       <dd><?php echo $this->_tpl_vars['lang']['quick_menu_rewrite_cue']; ?>
</dd>
      </dl>
      <dl>
       <?php if ($this->_tpl_vars['site']['captcha']): ?>
       <dt><a href="system.php?light=captcha"><?php echo $this->_tpl_vars['lang']['close']; ?>
</a><?php echo $this->_tpl_vars['lang']['quick_menu_captcha']; ?>
（<?php echo $this->_tpl_vars['lang']['opened']; ?>
）</dt>
       <?php else: ?>
       <dt><a href="system.php?light=captcha"><?php echo $this->_tpl_vars['lang']['open']; ?>
</a><?php echo $this->_tpl_vars['lang']['quick_menu_captcha']; ?>
（<?php echo $this->_tpl_vars['lang']['open_no']; ?>
）</dt>
       <?php endif; ?>
       <dd><?php echo $this->_tpl_vars['lang']['quick_menu_captcha_cue']; ?>
</dd>
      </dl>
      <dl>
       <dt><a href="tool.php?rec=directory_check"><?php echo $this->_tpl_vars['lang']['quick_menu_directory_check']; ?>
</a><?php echo $this->_tpl_vars['lang']['quick_menu_directory']; ?>
</dt>
       <dd><?php echo $this->_tpl_vars['lang']['quick_menu_directory_cue']; ?>
</dd>
      </dl>
      <?php if ($this->_tpl_vars['site']['developer']): ?>
      <dl>
       <dt><a href="tool.php?rec=custom_admin_path"><?php echo $this->_tpl_vars['lang']['modify']; ?>
</a><?php echo $this->_tpl_vars['lang']['quick_menu_custom_admin_path']; ?>
</dt>
       <dd><?php echo $this->_tpl_vars['lang']['quick_menu_custom_admin_path_cue']; ?>
</dd>
      </dl>
      <?php endif; ?>
      <dl>
       <dt><a href="tool.php?rec=replace_url"><?php echo $this->_tpl_vars['lang']['modify']; ?>
</a><?php echo $this->_tpl_vars['lang']['quick_menu_replace_url']; ?>
</dt>
       <dd><?php echo $this->_tpl_vars['lang']['quick_menu_replace_url_cue']; ?>
</dd>
      </dl>
     </div>
    </div>
   </div>
   <div id="main">
    <?php $_from = $this->_tpl_vars['sys_info']['folder_exists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['warning']):
?>
    <div class="warning"><?php echo $this->_tpl_vars['warning']; ?>
</div>
    <?php endforeach; endif; unset($_from); ?>
    <?php if ($this->_tpl_vars['unum']['system'] || $this->_tpl_vars['unum']['module'] || $this->_tpl_vars['unum']['theme']): ?>
    <div class="sysMsg"><span>系统有更新</span><a href="cloud.php?rec=update">进入更新页面</a><a href="system.php?dou" class="last">关闭升级提示<em>（您将错过系统的漏洞修复以及功能升级）</em></a></div>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['cue_open_ssl']): ?>
    <div class="sysMsg"><span>您的站点已启用HTTPS，建议后台访问时也使用HTTPS访问</span><a href="<?php echo $this->_tpl_vars['ssl_url']; ?>
" target="_blank">立即进入HTTPS模式</a></div>
    <?php endif; ?>
    <div class="indexBox">
     <h2><?php echo $this->_tpl_vars['lang']['title_page']; ?>
</h2>
     <ul class="page">
      <?php $_from = $this->_tpl_vars['page_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page']):
?> 
      <a href="page.php?rec=edit&id=<?php echo $this->_tpl_vars['page']['id']; ?>
"<?php if ($this->_tpl_vars['page']['level'] > 0): ?> class="child<?php echo $this->_tpl_vars['page']['level']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['page']['page_name']; ?>
</a> 
      <?php endforeach; endif; unset($_from); ?>
      <div class="clear"></div>
     </ul>
    </div>
    <?php if ($this->_tpl_vars['quick_start']): ?>
    <div class="indexBox">
     <h2><a href="index.php?rec=close_quick_start" class="close" title="<?php echo $this->_tpl_vars['lang']['close']; ?>
">X</a><?php echo $this->_tpl_vars['lang']['quick_start']; ?>
<em>（<?php echo $this->_tpl_vars['lang']['quick_start_cue']; ?>
）</em></h2>
     <ul class="quickStart">
      <?php $_from = $this->_tpl_vars['quick_start']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?> 
      <li>
       <span>
        <em><?php echo $this->_tpl_vars['item']['text']; ?>
</em>
        <a href="<?php echo $this->_tpl_vars['item']['link']; ?>
"<?php if ($this->_tpl_vars['item']['target']): ?> target="<?php echo $this->_tpl_vars['item']['target']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['quick_start_do']; ?>
</a>
       </span>
      </li>
      <?php endforeach; endif; unset($_from); ?>
     </ul>
    </div>
    <?php endif; ?>
    <div class="indexBoxTwo">
     <div class="box-left">
      <div class="backupBox">
       <div class="indexBox">
        <h2><?php echo $this->_tpl_vars['lang']['title_backup']; ?>
</h2>
        <div class="backup">
         <dl>
          <dd class="date"><?php echo $this->_tpl_vars['backup']['new']['maketime']; ?>
</dd>
          <dt><?php echo $this->_tpl_vars['lang']['backup_new']; ?>
：<?php echo $this->_tpl_vars['backup']['new']['filename']; ?>
</dt>
          <dd class="size"><?php echo $this->_tpl_vars['backup']['new']['filesize']; ?>
</dd>
         </dl>
         <dl class="last">
          <dd class="date"><?php echo $this->_tpl_vars['backup']['old']['maketime']; ?>
</dd>
          <dt><?php echo $this->_tpl_vars['lang']['backup_old']; ?>
：<?php echo $this->_tpl_vars['backup']['old']['filename']; ?>
</dt>
          <dd class="size"><?php echo $this->_tpl_vars['backup']['old']['filesize']; ?>
</dd>
         </dl>
        </div>
       </div>
       <div class="prompt<?php if ($this->_tpl_vars['backup']['light']): ?> red<?php endif; ?>">
        <span class="text"><?php echo $this->_tpl_vars['lang']['backup_action_cue']; ?>
<em><?php echo $this->_tpl_vars['backup']['msg']; ?>
</em></span>
        <a href="backup.php" class="btnBackup"><?php echo $this->_tpl_vars['lang']['backup_action_btn']; ?>
</a>
       </div>
      </div>
      <div class="indexBox">
       <h2><?php echo $this->_tpl_vars['lang']['title_site_info']; ?>
</h2>
       <div class="siteInfo">
        <ul>
         <li><?php echo $this->_tpl_vars['lang']['num_page']; ?>
：<?php echo $this->_tpl_vars['sys_info']['num_page']; ?>
</li>
         <li><?php echo $this->_tpl_vars['lang']['num_article']; ?>
：<?php echo $this->_tpl_vars['sys_info']['num_article']; ?>
</li>
         <li><?php echo $this->_tpl_vars['lang']['num_product']; ?>
：<?php echo $this->_tpl_vars['sys_info']['num_product']; ?>
</li>
        </ul>
        <ul>
         <li><?php echo $this->_tpl_vars['lang']['language']; ?>
：<?php echo $this->_tpl_vars['site']['language']; ?>
</li>
         <li><?php echo $this->_tpl_vars['lang']['charset']; ?>
：<?php echo $this->_tpl_vars['sys_info']['charset']; ?>
</li>
         <li><?php echo $this->_tpl_vars['lang']['site_theme']; ?>
：<?php echo $this->_tpl_vars['site']['site_theme']; ?>
</li>
         <li><?php echo $this->_tpl_vars['lang']['rewrite']; ?>
：<?php if ($this->_tpl_vars['site']['rewrite']): ?><?php echo $this->_tpl_vars['lang']['open']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lang']['close']; ?>
<a href="system.php" class="cueRed ml"><?php echo $this->_tpl_vars['lang']['open_cue']; ?>
</a> 
            <?php endif; ?></li>
         <li><?php echo $this->_tpl_vars['lang']['if_sitemap']; ?>
：<?php if ($this->_tpl_vars['site']['sitemap']): ?><?php echo $this->_tpl_vars['lang']['open']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lang']['close']; ?>
<?php endif; ?></li>
         <li><?php echo $this->_tpl_vars['lang']['build_date']; ?>
：<?php echo $this->_tpl_vars['sys_info']['build_date']; ?>
</li>
        </ul>
        <ul class="long">
         <li><?php echo $this->_tpl_vars['lang']['cache_root_url']; ?>
：<?php echo $this->_tpl_vars['site']['root_url']; ?>
<?php echo $this->_tpl_vars['cache_root_url_cue']; ?>
</li>
        </ul>
        <ul class="last long">
         <li><?php if (! $this->_tpl_vars['pure_mode']): ?><?php echo $this->_tpl_vars['lang']['dou_version']; ?>
：<?php endif; ?><?php echo $this->_tpl_vars['site']['douphp_version']; ?>
<?php if ($this->_tpl_vars['authorized']): ?>（正版授权）<?php endif; ?></li>
        </ul>
       </div>
      </div>
     </div>
     <div class="box-right">
      <div class="indexBox">
       <h2><?php echo $this->_tpl_vars['lang']['title_admin_log']; ?>
<em>（<?php echo $this->_tpl_vars['lang']['manager_log_create_time']; ?>
/<?php echo $this->_tpl_vars['lang']['manager_log_user_name']; ?>
/<?php echo $this->_tpl_vars['lang']['manager_log_ip']; ?>
）</em></h2>
       <div class="adminLog">
        <?php $_from = $this->_tpl_vars['log_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['log_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['log_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['log']):
        $this->_foreach['log_list']['iteration']++;
?>
        <dl<?php if (($this->_foreach['log_list']['iteration'] == $this->_foreach['log_list']['total'])): ?> class="last"<?php endif; ?>>
         <dd class="date"><?php echo $this->_tpl_vars['log']['ip']; ?>
</dd>
         <dt><?php echo $this->_tpl_vars['log']['create_time']; ?>
</dt>
         <dd class="name"><?php echo $this->_tpl_vars['log']['user_name']; ?>
</dd>
        </dl>
        <?php endforeach; endif; unset($_from); ?>
       </div>
      </div>
      <div class="indexBox">
       <h2><?php echo $this->_tpl_vars['lang']['title_sys_info']; ?>
</h2>
       <div class="siteInfo">
        <ul>
         <li><?php echo $this->_tpl_vars['lang']['php_version']; ?>
：<?php echo $this->_tpl_vars['sys_info']['php_ver']; ?>
</li>
         <li><?php echo $this->_tpl_vars['lang']['max_filesize']; ?>
：<?php echo $this->_tpl_vars['sys_info']['max_filesize']; ?>
</li>
         <li><?php echo $this->_tpl_vars['lang']['gd']; ?>
：<?php echo $this->_tpl_vars['sys_info']['gd']; ?>
</li>
         <li><?php echo $this->_tpl_vars['lang']['zlib']; ?>
：<?php echo $this->_tpl_vars['sys_info']['zlib']; ?>
</li>
         <li><?php echo $this->_tpl_vars['lang']['timezone']; ?>
：<?php echo $this->_tpl_vars['sys_info']['timezone']; ?>
</li>
         <li><?php echo $this->_tpl_vars['lang']['socket']; ?>
：<?php echo $this->_tpl_vars['sys_info']['socket']; ?>
</li>
        </ul>
        <ul class="last long">
         <li><?php echo $this->_tpl_vars['lang']['mysql_version']; ?>
：<?php echo $this->_tpl_vars['sys_info']['mysql_ver']; ?>
</li>
         <li><?php echo $this->_tpl_vars['lang']['os']; ?>
：<?php echo $this->_tpl_vars['sys_info']['os']; ?>
(<?php echo $this->_tpl_vars['sys_info']['ip']; ?>
)</li>
         <li><?php echo $this->_tpl_vars['lang']['web_server']; ?>
：<?php echo $this->_tpl_vars['sys_info']['web_server']; ?>
</li>
        </ul>
       </div>
      </div>
     </div>
    </div>
    <?php if (! $this->_tpl_vars['pure_mode']): ?>
    <div class="indexBox">
     <h2><?php echo $this->_tpl_vars['lang']['title_official']; ?>
</h2>
     <ul class="powered">
      <li><?php echo $this->_tpl_vars['lang']['about_site']; ?>
：<a href="http://www.douphp.com" target="_blank">http://www.douphp.com</a></li>
      <li><?php echo $this->_tpl_vars['lang']['about_help']; ?>
：<a href="http://help.douphp.com" target="_blank">help.douphp.com</a><em>（<?php echo $this->_tpl_vars['lang']['about_help_cue']; ?>
）</em></li>
      <li><?php echo $this->_tpl_vars['lang']['about_contributor']; ?>
：Wooyun.org, Pany, Tea</li>
      <?php if (! $this->_tpl_vars['authorized']): ?>
      <li><?php echo $this->_tpl_vars['lang']['about_license']; ?>
：<a href="http://www.douphp.com/license.html" target="_blank">http://www.douphp.com/license.html</a><em>（您可以免费使用DouPHP（不限商用），但必须保留相关版权信息，如要去除请“<a href="https://www.douphp.com/buy" style="color: #0072C6" target="_blank">购买商业授权</a>”。）</em></li>
      <?php endif; ?>
     </ul>
    </div>
    <?php endif; ?>
   </div>
   <?php endif; ?>
  </div>
  <?php endif; ?>
 </div>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>