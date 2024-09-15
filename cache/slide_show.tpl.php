<?php if ($this->_tpl_vars['show_list']): ?>
<div class="swiper-container slide-show">
 <div class="swiper-wrapper">
  <?php $_from = $this->_tpl_vars['show_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['show_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['show_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['show']):
        $this->_foreach['show_list']['iteration']++;
?>
  <div class="swiper-slide"><a href="<?php echo $this->_tpl_vars['show']['show_link']; ?>
" target="_blank" style="background-image:url(<?php echo $this->_tpl_vars['show']['show_img']; ?>
)"></a></div>
  <?php endforeach; endif; unset($_from); ?>
 </div>
 <!-- 如果需要分页器 -->
 <div class="swiper-pagination"></div>
 
 <!-- 如果需要导航按钮 -->
 <div class="swiper-button-prev"></div>
 <div class="swiper-button-next"></div>
</div>
<?php endif; ?>