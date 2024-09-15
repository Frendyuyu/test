<div class="pager">
 <ul>
  <?php if ($this->_tpl_vars['pager']['page'] != '1'): ?>
  <li><a href="<?php echo $this->_tpl_vars['pager']['first']; ?>
"><i class="fa fa-angle-double-left"></i></a></li>
  <li><a href="<?php echo $this->_tpl_vars['pager']['previous']; ?>
"><i class="fa fa-angle-left"></i></a></li>
  <?php endif; ?>
  <?php $_from = $this->_tpl_vars['pager']['box']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['box']):
?>
  <li<?php if ($this->_tpl_vars['box']['cur']): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['box']['url']; ?>
"><?php echo $this->_tpl_vars['box']['page']; ?>
</a></li>
  <?php endforeach; endif; unset($_from); ?>
  <?php if ($this->_tpl_vars['pager']['page'] != $this->_tpl_vars['pager']['page_count']): ?>
  <li><a href="<?php echo $this->_tpl_vars['pager']['next']; ?>
"><i class="fa fa-angle-right"></i></a></li>
  <li><a href="<?php echo $this->_tpl_vars['pager']['last']; ?>
"><i class="fa fa-angle-double-right"></i></a></li>
  <?php endif; ?>
 </ul>
</div>