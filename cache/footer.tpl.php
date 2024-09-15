<footer id="footer">
 <div class="container">
  <div class="row">
   <?php $_from = $this->_tpl_vars['nav_bottom_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['nav_bottom_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_bottom_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['nav']):
        $this->_foreach['nav_bottom_list']['iteration']++;
?>
   <?php if ($this->_foreach['nav_bottom_list']['iteration'] <= 4): ?>
   <div class="col-md-2">
    <div class="foot-nav">
     <div class="nav-parent">
      <a href="<?php echo $this->_tpl_vars['nav']['url']; ?>
"><?php echo $this->_tpl_vars['nav']['nav_name']; ?>
</a>
     </div>
     <div class="nav-child">
      <?php $_from = $this->_tpl_vars['nav']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?>
      <a href="<?php echo $this->_tpl_vars['child']['url']; ?>
"><?php echo $this->_tpl_vars['child']['nav_name']; ?>
</a>
      <?php endforeach; endif; unset($_from); ?>
     </div>
    </div>
   </div>
   <?php endif; ?>
   <?php endforeach; endif; unset($_from); ?>
   <div class="col-md-2">
    <?php if ($this->_tpl_vars['site']['weixin_img']): ?>
    <div class="weixin"><img src="<?php echo $this->_tpl_vars['site']['weixin_img']; ?>
" /><p><?php echo $this->_tpl_vars['site']['weixin_name']; ?>
</p></div>
    <?php endif; ?>
   </div>
   <div class="col-md-2">
    <div class="contact">
     <div class="tel"><?php echo $this->_tpl_vars['site']['tel']; ?>
</div>
     <?php if ($this->_tpl_vars['site']['qq']['0']['number']): ?> 
     <div class="online-qq"><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $this->_tpl_vars['site']['qq']['0']['number']; ?>
&amp;site=qq&amp;menu=yes" target="_blank"><i class="fa fa-qq"></i><?php echo $this->_tpl_vars['lang']['online_qq']; ?>
</a></div>
     <?php endif; ?> 
     <div class="email"><?php echo $this->_tpl_vars['site']['email']; ?>
</div>
    </div>
   </div>
  </div>
  <div class="copy-right"><?php echo $this->_tpl_vars['lang']['copyright']; ?>
 <?php echo $this->_tpl_vars['lang']['powered_by']; ?>
 <?php if ($this->_tpl_vars['site']['icp']): ?><a href="https://beian.miit.gov.cn/" target="_blank"><?php echo $this->_tpl_vars['site']['icp']; ?>
</a><?php endif; ?><?php if ($this->_tpl_vars['site']['net_safe_record']): ?><a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?php echo $this->_tpl_vars['site']['net_safe_record_number']; ?>
" class="net-safe-record" target="_blank"><img src="https://127.0.0.1/test/theme/default/images/icon_net_safe_record.png" /><?php echo $this->_tpl_vars['site']['net_safe_record']; ?>
</a><?php endif; ?></div>
  </div>
</footer>
<?php if ($this->_tpl_vars['site']['code']): ?>
<div style="display:none"><?php echo $this->_tpl_vars['site']['code']; ?>
</div>
<?php endif; ?>