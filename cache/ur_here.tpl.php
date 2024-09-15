<div class="ur-here">
 <?php echo $this->_tpl_vars['lang']['ur_here']; ?>
：<a href="<?php echo $this->_tpl_vars['site']['root_url']; ?>
"><?php echo $this->_tpl_vars['lang']['home']; ?>
</a><?php if ($this->_tpl_vars['ur_here']['module']): ?><b>></b><a href="<?php echo $this->_tpl_vars['ur_here']['module']['url']; ?>
"><?php echo $this->_tpl_vars['ur_here']['module']['name']; ?>
</a><?php endif; ?><?php if ($this->_tpl_vars['ur_here']['class']): ?><b>></b><a href="<?php echo $this->_tpl_vars['ur_here']['class']['url']; ?>
"><?php echo $this->_tpl_vars['ur_here']['class']['name']; ?>
</a><?php endif; ?><?php if ($this->_tpl_vars['ur_here']['title']): ?><b>></b><?php echo $this->_tpl_vars['ur_here']['title']; ?>
<?php endif; ?>
</div>