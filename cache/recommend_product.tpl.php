<div class="product-list">
 <div class="container">
  <div class="row"> 
   <?php $_from = $this->_tpl_vars['recommend_product']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['recommend_product'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['recommend_product']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product']):
        $this->_foreach['recommend_product']['iteration']++;
?>
   <div class="col-md-3 col-6">
    <div class="item">
     <div class="img scale"><a href="<?php echo $this->_tpl_vars['product']['url']; ?>
"><img src="<?php echo $this->_tpl_vars['product']['thumb']; ?>
" /></a></div>
     <div class="name"><a href="<?php echo $this->_tpl_vars['product']['url']; ?>
"><?php echo $this->_tpl_vars['product']['name']; ?>
</a></div>
     <?php if ($this->_tpl_vars['site']['show_price']): ?>
     <div class="price"><?php if ($this->_tpl_vars['product']['level_price']): ?><?php echo $this->_tpl_vars['product']['level_price']; ?>
<em class="price-line"><?php echo $this->_tpl_vars['product']['price']; ?>
</em><?php else: ?><?php echo $this->_tpl_vars['product']['price']; ?>
<?php endif; ?></div>
     <?php endif; ?>
    </div>
   </div>
   <?php endforeach; endif; unset($_from); ?> 
  </div>
 </div>
</div>