<div class="tree-box">
 <h3><?php echo $this->_tpl_vars['lang']['article_tree']; ?>
</h3>
 <ul>
  <?php $_from = $this->_tpl_vars['article_category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cate']):
?>
  <li<?php if ($this->_tpl_vars['cate']['cur']): ?> class="cur"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['cate']['url']; ?>
"><?php echo $this->_tpl_vars['cate']['cat_name']; ?>
</a></li>
  <?php if ($this->_tpl_vars['cate']['child']): ?>
  <ul>
   <?php $_from = $this->_tpl_vars['cate']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?>
   <li<?php if ($this->_tpl_vars['child']['cur']): ?> class="cur"<?php endif; ?>><i>-</i><a href="<?php echo $this->_tpl_vars['child']['url']; ?>
"><?php echo $this->_tpl_vars['child']['cat_name']; ?>
</a></li>
   <?php endforeach; endif; unset($_from); ?>
  </ul>
  <?php endif; ?>
  <?php endforeach; endif; unset($_from); ?>
 </ul>
 <ul class="search">
  <div class="search-box">
   <form method="get" action="<?php echo $this->_tpl_vars['site']['root_url']; ?>
">
    <input type="hidden" name="module" value="article">
    <input name="s" type="text" class="keyword" title="<?php echo $this->_tpl_vars['lang']['search_cue']; ?>
" value="<?php echo $this->smarty_modifier_escape($this->_tpl_vars['keyword_article']); ?>
" placeholder="<?php echo $this->_tpl_vars['lang']['search_article']; ?>
">
    <input type="submit" class="btnSearch" value="<?php echo $this->_tpl_vars['lang']['btn_submit']; ?>
">
   </form>
  </div>
 </ul>
</div>