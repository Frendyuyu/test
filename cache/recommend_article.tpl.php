<div class="article-list"> 
 <div class="container">
  <div class="row">
   <div class="img-box col-md-5">
    <?php $_from = $this->_tpl_vars['recommend_article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['article_img'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['article_img']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['article']):
        $this->_foreach['article_img']['iteration']++;
?>
    <?php if (($this->_foreach['article_img']['iteration'] <= 1)): ?>
    <dl class="img scale"><a href="<?php echo $this->_tpl_vars['article']['url']; ?>
"><?php if ($this->_tpl_vars['article']['image']): ?><img src="<?php echo $this->_tpl_vars['article']['image']; ?>
" /><?php else: ?><em>NO IMAGE</em><?php endif; ?></a>
    </dl>
    <dl class="item">
     <dt><em><?php echo $this->_tpl_vars['article']['time']['d']; ?>
</em><b><?php echo $this->_tpl_vars['article']['time']['y']; ?>
-<?php echo $this->_tpl_vars['article']['time']['m']; ?>
</b></dt>
     <dd><a href="<?php echo $this->_tpl_vars['article']['url']; ?>
"><?php echo $this->_tpl_vars['article']['title']; ?>
</a>
      <p><?php echo $this->smarty_modifier_truncate($this->_tpl_vars['article']['description'], 66, "..."); ?>
</p>
     </dd>
    </dl>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
   </div>
   <div class="text-box col-md-7"> 
    <?php $_from = $this->_tpl_vars['recommend_article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['article_text'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['article_text']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['article']):
        $this->_foreach['article_text']['iteration']++;
?>
    <?php if (! ($this->_foreach['article_text']['iteration'] <= 1)): ?>
    <dl class="item">
     <dt><em><?php echo $this->_tpl_vars['article']['time']['d']; ?>
</em><b><?php echo $this->_tpl_vars['article']['time']['y']; ?>
-<?php echo $this->_tpl_vars['article']['time']['m']; ?>
</b></dt>
     <dd><a href="<?php echo $this->_tpl_vars['article']['url']; ?>
"><?php echo $this->_tpl_vars['article']['title']; ?>
</a>
      <p><?php echo $this->smarty_modifier_truncate($this->_tpl_vars['article']['description'], 76, "..."); ?>
</p>
     </dd>
    </dl>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?> 
   </div>
  </div>
 </div>
</div>