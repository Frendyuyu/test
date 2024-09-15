<?php if ($this->_tpl_vars['workspace']['admin_theme_custom']['handle']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "handle.custom.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
<div id="handle"> <!-- 当前位置 -->
 <ul>
  <li class="dropMenu"><a href="JavaScript:void(0);"><i class="fa fa-plus"></i><em><?php echo $this->_tpl_vars['lang']['top_add']; ?>
</em></a>
   <div class="menu">
    <a href="nav.php?rec=add"><?php echo $this->_tpl_vars['lang']['top_add_nav']; ?>
</a>
    <?php $_from = $this->_tpl_vars['workspace']['menu_column']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menu']):
?>
    <a href="<?php echo $this->_tpl_vars['menu']['name']; ?>
.php?rec=add"><?php echo $this->_tpl_vars['menu']['lang_top_add']; ?>
</a>
    <?php endforeach; endif; unset($_from); ?>
    <a href="show.php"><?php echo $this->_tpl_vars['lang']['top_add_show']; ?>
</a>
    <a href="page.php?rec=add"><?php echo $this->_tpl_vars['lang']['top_add_page']; ?>
</a>
    <a href="manager.php?rec=add"><?php echo $this->_tpl_vars['lang']['top_add_manager']; ?>
</a>
    <a href="link.php"><?php echo $this->_tpl_vars['lang']['top_add_link']; ?>
</a>
   </div>
  </li>
  <?php if (! $this->_tpl_vars['pure_mode']): ?>
  <li class="last"><a href="http://help.douphp.com" target="_blank"><i class="fa fa-question"></i><em><?php echo $this->_tpl_vars['lang']['top_help']; ?>
</em></a></li>
  <?php endif; ?>
 </ul>
</div>
<?php endif; ?>