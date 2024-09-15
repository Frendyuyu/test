<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="copyright" content="DouCo Co.,Ltd." />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title><?php echo $this->_tpl_vars['lang']['home']; ?>
<?php if ($this->_tpl_vars['ur_here']): ?> - <?php echo $this->_tpl_vars['ur_here']; ?>
 <?php endif; ?></title>
<link href="<?php echo $this->_tpl_vars['site']['root_url']; ?>
favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="templates/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="templates/public.css" rel="stylesheet" type="text/css">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "javascript.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="images/jquery.tab.js"></script>
</head>
<body>
<div id="dcWrap">
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 <div id="dcLeft"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
 <div id="dcMain">
   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "handle.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
   <div id="system" class="mainBox" style="<?php echo $this->_tpl_vars['workspace']['height']; ?>
">
    <h3><?php if ($this->_tpl_vars['site']['developer']): ?><a href="<?php echo $this->_tpl_vars['action_link']['href']; ?>
" class="actionBtn"><?php echo $this->_tpl_vars['action_link']['text']; ?>
</a><?php endif; ?><?php echo $this->_tpl_vars['ur_here']; ?>
</h3>
    <div class="idTabs">
     <ul class="tab">
      <?php $_from = $this->_tpl_vars['cfg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tab']):
?>
      <li><a href="#<?php echo $this->_tpl_vars['tab']['name']; ?>
"><?php echo $this->_tpl_vars['tab']['lang']; ?>
</a></li>
      <?php endforeach; endif; unset($_from); ?>
      <?php if ($this->_tpl_vars['parameter_system_list']): ?>
      <li><a href="#parameter"><?php echo $this->_tpl_vars['lang']['parameter']; ?>
</a></li>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['sms_tab']): ?>
      <li><a href="sms.php"><?php echo $this->_tpl_vars['lang']['sms']; ?>
</a></li>
      <?php endif; ?>
      <?php $_from = $this->_tpl_vars['lang_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
      <li><a href="language.php?rec=system&language_pack=<?php echo $this->_tpl_vars['item']['language_pack']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
<?php echo $this->_tpl_vars['lang']['language_setting']; ?>
</a></li>
      <?php endforeach; endif; unset($_from); ?>
     </ul>
     <div class="formBox">
      <form action="system.php?rec=update" method="post" enctype="multipart/form-data">
       <?php $_from = $this->_tpl_vars['cfg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cfg']):
?>
       <div id="<?php echo $this->_tpl_vars['cfg']['name']; ?>
">
        <div class="formBasic">
         <?php $_from = $this->_tpl_vars['cfg']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cfg_list']):
?>
         <?php if ($this->_tpl_vars['cfg_list']['type'] != 'array'): ?>
         <dl<?php if ($this->_tpl_vars['cfg_list']['name'] == $this->_tpl_vars['light']): ?> class="light"<?php endif; ?>>
          <dt><?php echo $this->_tpl_vars['cfg_list']['lang']; ?>
</dt>
          <dd>
           <?php if ($this->_tpl_vars['cfg_list']['type'] == 'radio'): ?>
           <label for="<?php echo $this->_tpl_vars['cfg_list']['name']; ?>
_0">
            <input type="radio" name="<?php echo $this->_tpl_vars['cfg_list']['name']; ?>
" id="<?php echo $this->_tpl_vars['cfg_list']['name']; ?>
_0" value="0"<?php if ($this->_tpl_vars['cfg_list']['value'] == '0'): ?> checked="true"<?php endif; ?>>
            <?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
           <label for="<?php echo $this->_tpl_vars['cfg_list']['name']; ?>
_1">
            <input type="radio" name="<?php echo $this->_tpl_vars['cfg_list']['name']; ?>
" id="<?php echo $this->_tpl_vars['cfg_list']['name']; ?>
_1" value="1"<?php if ($this->_tpl_vars['cfg_list']['value'] == '1'): ?> checked="true"<?php endif; ?>>
            <?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
           <?php elseif ($this->_tpl_vars['cfg_list']['type'] == 'select'): ?>
           <select name="<?php echo $this->_tpl_vars['cfg_list']['name']; ?>
">
            <?php $_from = $this->_tpl_vars['cfg_list']['box']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['value']):
?>
            <option value="<?php echo $this->_tpl_vars['value']; ?>
"<?php if ($this->_tpl_vars['cfg_list']['value'] == $this->_tpl_vars['value']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['value']; ?>
</option>
            <?php endforeach; endif; unset($_from); ?>
           </select>
           <?php elseif ($this->_tpl_vars['cfg_list']['type'] == 'file'): ?>
           <input type="file" name="<?php echo $this->_tpl_vars['cfg_list']['name']; ?>
" size="18" />
           <?php if ($this->_tpl_vars['cfg_list']['value']): ?><a href="../<?php echo $this->_tpl_vars['cfg_list']['value']; ?>
" target="_blank"><img src="images/icon_yes.png"></a><?php else: ?><img src="images/icon_no.png"><?php endif; ?>
           <?php elseif ($this->_tpl_vars['cfg_list']['type'] == 'textarea'): ?>
           <textarea name="<?php echo $this->_tpl_vars['cfg_list']['name']; ?>
" cols="83" rows="8" class="textArea" /><?php echo $this->_tpl_vars['cfg_list']['value']; ?>
</textarea>
           <?php else: ?>
           <?php if ($this->_tpl_vars['cfg_list']['name'] == 'domain'): ?>
           <input type="text" name="<?php echo $this->_tpl_vars['cfg_list']['name']; ?>
" value="<?php echo $this->_tpl_vars['cfg_list']['value']; ?>
" placeholder="<?php echo $this->_tpl_vars['site']['root_url']; ?>
" size="80" class="inpMain" />
           <?php else: ?>
           <input type="text" name="<?php echo $this->_tpl_vars['cfg_list']['name']; ?>
" value="<?php echo $this->_tpl_vars['cfg_list']['value']; ?>
" size="80" class="inpMain" />
           <?php endif; ?>
           <?php endif; ?>
           <?php if ($this->_tpl_vars['cfg_list']['cue']): ?>
            <?php if ($this->_tpl_vars['cfg_list']['type'] == 'radio' || $this->_tpl_vars['cfg_list']['type'] == 'select'): ?>
            <span class="cue ml"><?php echo $this->_tpl_vars['cfg_list']['cue']; ?>
</span>
            <?php else: ?>
            <p class="cue"><?php echo $this->_tpl_vars['cfg_list']['cue']; ?>
</p>
            <?php endif; ?>
           <?php endif; ?>
          </dd>
         </dl>
         <?php else: ?>
         <?php $_from = $this->_tpl_vars['cfg_list']['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cfg']):
?>
         <dl<?php if ($this->_tpl_vars['cfg_list']['name'] == $this->_tpl_vars['light']): ?> class="light"<?php endif; ?>>
          <dt><?php echo $this->_tpl_vars['cfg']['lang']; ?>
</dt>
          <dd>
           <input type="text" name="<?php echo $this->_tpl_vars['cfg']['name']; ?>
" value="<?php echo $this->_tpl_vars['cfg']['value']; ?>
" size="80" class="inpMain" />
           <?php if ($this->_tpl_vars['cfg']['cue']): ?>
           <p class="cue"><?php echo $this->_tpl_vars['cfg']['cue']; ?>
</p>
           <?php endif; ?>
          </dd>
         </dl>
         <?php endforeach; endif; unset($_from); ?>
         <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?>
         <?php if ($this->_tpl_vars['cfg']['name'] == 'customer'): ?>
         <?php $_from = $this->_tpl_vars['parameter_customer_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['parameter']):
?>
         <dl>
          <dt><?php echo $this->_tpl_vars['parameter']['lang']; ?>
</dt>
          <dd>
           <input type="text" name="_parameter_<?php echo $this->_tpl_vars['parameter']['name']; ?>
" value="<?php echo $this->_tpl_vars['parameter']['value']; ?>
" size="80" class="inpMain">
           <?php if ($this->_tpl_vars['parameter']['cue']): ?>
											<p class="cue"><?php echo $this->_tpl_vars['parameter']['cue']; ?>
</p>
											<?php endif; ?>
          </dd>
         </dl>
         <?php endforeach; endif; unset($_from); ?>
         <?php if ($this->_tpl_vars['site']['developer']): ?>
         <dl>
          <dd>
           <a class="btnGray" href="parameter.php?rec=add&group=customer">增加</a>
											<p class="cue">如果需要可以增加更多的在线客服联系方式</p>
          </dd>
         </dl>
         <?php endif; ?>
         <?php endif; ?>
        </div>
       </div>
       <?php endforeach; endif; unset($_from); ?>
       <?php if ($this->_tpl_vars['parameter_system_list']): ?>
       <div id="parameter">
        <div class="formBasic">
         <?php $_from = $this->_tpl_vars['parameter_system_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['parameter']):
?>
         <dl>
          <dt><?php echo $this->_tpl_vars['parameter']['lang']; ?>
</dt>
          <dd>
           <input type="text" name="_parameter_<?php echo $this->_tpl_vars['parameter']['name']; ?>
" value="<?php echo $this->_tpl_vars['parameter']['value']; ?>
" size="80" class="inpMain">
           <?php if ($this->_tpl_vars['parameter']['cue']): ?>
											<p class="cue"><?php echo $this->_tpl_vars['parameter']['cue']; ?>
</p>
											<?php endif; ?>
          </dd>
         </dl>
         <?php endforeach; endif; unset($_from); ?>
        </div>
       </div>
       <?php endif; ?>
       <div class="formBasic">
        <dl>
         <input type="hidden" name="token" value="<?php echo $this->_tpl_vars['token']; ?>
" />
         <input name="submit" class="btn" type="submit" value="<?php echo $this->_tpl_vars['lang']['btn_submit']; ?>
" />
        </dl>
       </div>
       </form>
     </div>
    </div>
   </div>
 </div>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<script type="text/javascript">
 <?php echo '$(function(){$(".idTabs").idTabs();});'; ?>

</script>
</body>
</html>