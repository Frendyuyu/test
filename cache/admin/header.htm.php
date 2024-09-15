<?php if ($this->_tpl_vars['workspace']['admin_theme_custom']['header']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.custom.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
<div id="dcHead">
 <div id="head">
  <div class="logo"><a href="index.php" title="<?php if (! $this->_tpl_vars['pure_mode']): ?>DouPHP轻量级企业网站管理系统<?php else: ?><?php echo $this->_tpl_vars['site']['site_name']; ?>
<?php endif; ?>"<?php if ($this->_tpl_vars['authorized']): ?> class="authorized"<?php endif; ?>><?php if (! $this->_tpl_vars['pure_mode']): ?>DouPHP轻量级企业网站管理系统<?php else: ?><?php echo $this->_tpl_vars['site']['site_name']; ?>
<?php endif; ?></a></div>
  <div class="box">
   <ul class="siteName"><?php echo $this->_tpl_vars['site']['site_name']; ?>
</ul>
   <ul class="nav">
    <?php if (! $this->_tpl_vars['site']['close_douphp_plus']): ?>
    <li class="m-none"><a href="module.php"<?php if ($this->_tpl_vars['cur'] == 'module'): ?> class="cur"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['top_module']; ?>
<?php if ($this->_tpl_vars['unum']['module']): ?><span class="unum"><span><?php echo $this->_tpl_vars['unum']['module']; ?>
</span></span><?php endif; ?></a></li>
    <?php endif; ?>
    <li class="m-none"><a href="<?php echo $this->_tpl_vars['site']['root_url']; ?>
" target="_blank"><?php echo $this->_tpl_vars['lang']['top_go_site']; ?>
</a></li>
    <li><a href="index.php?rec=clear_cache"><?php echo $this->_tpl_vars['lang']['clear_cache']; ?>
</a></li>
    <?php if (! $this->_tpl_vars['authorized']): ?>
    <li><a href="https://www.douphp.com/buy" target="_blank"><?php echo $this->_tpl_vars['lang']['top_buy_authorize']; ?>
</a></li>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['open']['language']): ?>
    <li><a href="language.php"><?php echo $this->_tpl_vars['lang']['language']; ?>
</a></li>
    <?php endif; ?>
    <li class="dropMenu"><a href="javaScript:;" class="parent"><?php echo $this->_tpl_vars['lang']['top_welcome']; ?>
<?php echo $this->_tpl_vars['user']['user_name']; ?>
</a>
     <div class="menu">
      <a href="manager.php?rec=edit&id=<?php echo $this->_tpl_vars['user']['user_id']; ?>
"><?php echo $this->_tpl_vars['lang']['top_manager_edit']; ?>
</a>
      <?php if (! $this->_tpl_vars['pure_mode']): ?>
      <a href="cloud.php?rec=account"><?php echo $this->_tpl_vars['lang']['cloud_account']; ?>
</a>
      <?php endif; ?>
      <a href="login.php?rec=logout"><?php echo $this->_tpl_vars['lang']['top_logout']; ?>
</a>
     </div>
    </li>
   </ul>
  </div>
 </div>
</div>
<!-- dcHead 结束 -->
<?php endif; ?>