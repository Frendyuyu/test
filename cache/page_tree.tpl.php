<div class="tree-box">
 <h3><?php echo $this->_tpl_vars['lang']['about_tree']; ?>
</h3>
 <ul>
  <?php if ($this->_tpl_vars['top']['page_name']): ?>
  <li<?php if ($this->_tpl_vars['top_cur']): ?> class="cur"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['top']['url']; ?>
"><?php echo $this->_tpl_vars['top']['page_name']; ?>
</a></li>
  <?php endif; ?>
  <?php $_from = $this->_tpl_vars['page_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
  <li<?php if ($this->_tpl_vars['list']['cur']): ?> class="cur"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['list']['url']; ?>
"><?php echo $this->_tpl_vars['list']['page_name']; ?>
</a></li>
  <?php if ($this->_tpl_vars['list']['child']): ?>
  <ul>
   <?php $_from = $this->_tpl_vars['list']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?>
   <li<?php if ($this->_tpl_vars['child']['cur']): ?> class="cur"<?php endif; ?>><i>-</i><a href="<?php echo $this->_tpl_vars['child']['url']; ?>
"><?php echo $this->_tpl_vars['child']['page_name']; ?>
</a></li>
   <?php endforeach; endif; unset($_from); ?>
  </ul>
  <?php endif; ?>
  <?php endforeach; endif; unset($_from); ?>
 </ul>
</div>