<?php if ($this->_tpl_vars['site']['show_customer']): ?>
<link href="https://127.0.0.1/test/theme/default/css/online_service.css" rel="stylesheet" type="text/css" />
<div class="online-service">
 <?php if ($this->_tpl_vars['site']['qq']): ?>
 <div class="item">
  <i class="item-icon qq"></i>
  <div class="pop-box">
   <div class="item-box">
    <div class="qq-box">
     <?php $_from = $this->_tpl_vars['site']['qq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['qq']):
?>
     <a class="qq" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $this->_tpl_vars['qq']['number']; ?>
&site=qq&menu=yes" target="_blank"><i class="qq-icon"></i><?php if ($this->_tpl_vars['qq']['nickname']): ?><?php echo $this->_tpl_vars['qq']['nickname']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lang']['online_qq']; ?>
<?php endif; ?></a>
     <?php endforeach; endif; unset($_from); ?>
    </div>
   </div>
  </div>
 </div>
 <?php endif; ?>
 <?php if ($this->_tpl_vars['site']['weixin_img']): ?>
 <div class="item">
  <i class="item-icon weixin"></i>
  <div class="pop-box">
   <div class="item-box">
    <div class="weixin-box"><img src="<?php echo $this->_tpl_vars['site']['weixin_img']; ?>
" /><p><?php echo $this->_tpl_vars['site']['weixin_name']; ?>
</p></div>
   </div>
  </div>
 </div>
 <?php endif; ?>
 <div class="item">
  <i class="item-icon tel"></i>
  <div class="pop-box">
   <div class="item-box">
    <div class="tel-box"><?php echo $this->_tpl_vars['site']['tel']; ?>
</div>
   </div>
  </div>
 </div>
 <?php if ($this->_tpl_vars['site']['chat']): ?>
 <div class="item">
  <a class="item-icon chat" href="<?php echo $this->_tpl_vars['site']['chat']; ?>
" target="_blank"></a>
 </div>
 <?php endif; ?>
 <p class="go-top"><a href="javascript:;" onfocus="this.blur();" class="go-btn"></a></p>
</div>
<?php endif; ?>