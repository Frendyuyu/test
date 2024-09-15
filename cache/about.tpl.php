<div class="row about">
 <div class="col-md-4">
  <div class="img scale">
   <?php if ($this->_tpl_vars['fragment']['about']['image']): ?>
   <img src="<?php echo $this->_tpl_vars['fragment']['about']['image']; ?>
" />
   <?php else: ?>
   <img src="https://127.0.0.1/test/theme/default/images/img_about.jpg" />
   <?php endif; ?>
  </div>
 </div>
 <div class="col-md-8">
  <h2><?php echo $this->_tpl_vars['about']['page_name']; ?>
</h2>
  <div class="desc"><?php echo $this->smarty_modifier_truncate($this->_tpl_vars['about']['content'], 220, "..."); ?>
</div>
  <div class="more"><a href="<?php echo $this->_tpl_vars['about']['link']; ?>
"><?php echo $this->_tpl_vars['lang']['about_link']; ?>
</a></div>
 </div>
</div>