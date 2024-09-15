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
<script type="text/javascript" src="images/jquery.form.min.js"></script>
</head>
<body>
<div id="dcWrap"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 <div id="dcLeft"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
 <div id="dcMain"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "handle.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <div class="mainBox" style="<?php echo $this->_tpl_vars['workspace']['height']; ?>
">
   <?php if ($this->_tpl_vars['rec'] == 'default'): ?>
   <h3><a href="<?php echo $this->_tpl_vars['action_link']['href']; ?>
" class="actionBtn"><?php echo $this->_tpl_vars['action_link']['text']; ?>
</a><?php echo $this->_tpl_vars['ur_here']; ?>
</h3>
   <div id="page"> 
    <?php $_from = $this->_tpl_vars['page_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page_list']):
?>
    <dl class="child<?php echo $this->_tpl_vars['page_list']['level']; ?>
">
     <dt><?php echo $this->_tpl_vars['page_list']['page_name']; ?>

      <p><?php echo $this->_tpl_vars['page_list']['unique_id']; ?>
</p>
     </dt>
     <dd><a href="page.php?rec=edit&id=<?php echo $this->_tpl_vars['page_list']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['edit']; ?>
</a> | <a href="page.php?rec=del&id=<?php echo $this->_tpl_vars['page_list']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['del']; ?>
</a></dd>
    </dl>
    <?php endforeach; endif; unset($_from); ?> 
   </div>
   <?php endif; ?> 
   <?php if ($this->_tpl_vars['rec'] == 'add' || $this->_tpl_vars['rec'] == 'edit'): ?>
   <h3>
    <a href="<?php echo $this->_tpl_vars['action_link']['href']; ?>
" class="actionBtn"><?php echo $this->_tpl_vars['action_link']['text']; ?>
</a>
    <?php if ($this->_tpl_vars['open']['data']): ?>
    <a href="data.php?rec=add&module=<?php echo $this->_tpl_vars['cur']; ?>
&id=<?php echo $this->_tpl_vars['item_id']; ?>
" class="actionBtn add"><?php echo $this->_tpl_vars['lang']['data_add']; ?>
</a>
    <?php if (! $this->_tpl_vars['data']['category']): ?> 
    <a href="data.php?rec=copy&module=<?php echo $this->_tpl_vars['cur']; ?>
&id=<?php echo $this->_tpl_vars['item_id']; ?>
" class="actionBtn"><?php echo $this->_tpl_vars['lang']['data_copy']; ?>
</a>
    <?php endif; ?> 
    <?php endif; ?> 
    <?php echo $this->_tpl_vars['ur_here']; ?>

   </h3>
   <form action="page.php?rec=<?php echo $this->_tpl_vars['form_action']; ?>
" method="post">
    <div class="formBasic">
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['page_name']; ?>
</dt>
      <dd>
       <input type="text" name="page_name" value="<?php echo $this->_tpl_vars['page']['page_name']; ?>
" size="40" class="inpMain" />
       <span class="lang"><?php echo $this->_tpl_vars['btn_lang']['page_name']; ?>
</span>
      </dd>
     </dl>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['unique']; ?>
</dt>
      <dd>
       <input type="text" name="unique_id" value="<?php echo $this->_tpl_vars['page']['unique_id']; ?>
" size="40" class="inpMain" />
      </dd>
     </dl>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['parent']; ?>
</dt>
      <dd>
       <select name="parent_id">
        <option value="0"><?php echo $this->_tpl_vars['lang']['empty']; ?>
</option>
        <?php $_from = $this->_tpl_vars['page_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?> 
        <option value="<?php echo $this->_tpl_vars['list']['id']; ?>
"<?php if ($this->_tpl_vars['list']['id'] == $this->_tpl_vars['page']['parent_id']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['list']['mark']; ?>
 <?php echo $this->_tpl_vars['list']['page_name']; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>
       </select>
      </dd>
     </dl>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['page_content']; ?>
</dt>
      <dd> 
       <?php if ($this->_tpl_vars['page']['mode'] == 'visualize'): ?>
       <a class="btnGray" href="<?php echo $this->_tpl_vars['page']['editor_url']; ?>
" target="_blank"><?php echo $this->_tpl_vars['lang']['page_mode_visualize_go']; ?>
</a>
       <p class="cue"><?php echo $this->_tpl_vars['lang']['page_mode_data_cue_a']; ?>
<?php echo $this->_tpl_vars['page']['unique_id']; ?>
.dwt<?php echo $this->_tpl_vars['lang']['page_mode_data_cue_b']; ?>
<a class="btnSys" href="page.php?rec=visualize&act=clear&id=<?php echo $this->_tpl_vars['page']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['page_mode_visualize_clear']; ?>
</a></p>
       <?php else: ?>
       <!-- 编辑器（所需变量：$cur、$item_id、$item_content） -->
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editor.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
       <?php endif; ?>
       <p class="lang"><?php echo $this->_tpl_vars['btn_lang']['content']; ?>
</p>
      </dd>
     </dl>
     <?php if ($this->_tpl_vars['open']['data']): ?>
     <?php $_from = $this->_tpl_vars['data']['category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
     <dl>
      <dt><?php echo $this->_tpl_vars['item']['class']['name']; ?>
</dt>
      <dd>
       <div class="fragmentList"> 
        <?php $_from = $this->_tpl_vars['item']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
        <div class="item">
         <div class="name"><?php echo $this->_tpl_vars['list']['name']; ?>
</div>
         <div class="content"><?php echo $this->_tpl_vars['list']['content']; ?>
</div>
         <div class="edit"><a href="data.php?rec=edit&id=<?php echo $this->_tpl_vars['list']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['edit']; ?>
</a></div>
        </div>
        <?php endforeach; endif; unset($_from); ?> 
       </div>
      </dd>
     </dl>
     <?php endforeach; endif; unset($_from); ?>
     <?php endif; ?>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['keywords']; ?>
</dt>
      <dd>
       <input type="text" name="keywords" value="<?php echo $this->_tpl_vars['page']['keywords']; ?>
" size="114" class="inpMain" />
       <span class="lang"><?php echo $this->_tpl_vars['btn_lang']['keywords']; ?>
</span>
      </dd>
     </dl>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['description']; ?>
</dt>
      <dd>
       <textarea name="description" cols="115" rows="3" class="textArea" /><?php echo $this->_tpl_vars['page']['description']; ?>
</textarea>
       <p class="lang"><?php echo $this->_tpl_vars['btn_lang']['description']; ?>
</p>
      </dd>
     </dl>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['page_mode']; ?>
</dt>
      <dd>
       <label for="mode_0">
        <input type="radio" name="mode" id="mode_0" value="editor"<?php if ($this->_tpl_vars['page']['mode'] == 'editor' || ! $this->_tpl_vars['page']['mode']): ?> checked="true"<?php endif; ?>>
        <?php echo $this->_tpl_vars['lang']['page_mode_editor']; ?>
</label>
       <label for="mode_1">
        <input type="radio" name="mode" id="mode_1" value="visualize"<?php if ($this->_tpl_vars['page']['mode'] == 'visualize'): ?> checked="true"<?php endif; ?>>
        <?php echo $this->_tpl_vars['lang']['page_mode_visualize']; ?>
</label>
       <p class="cue"><?php echo $this->_tpl_vars['lang']['page_mode_cue']; ?>
</p>
      </dd>
     </dl>
     <dl>
      <input type="hidden" name="token" value="<?php echo $this->_tpl_vars['token']; ?>
" />
      <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['page']['id']; ?>
">
      <input name="submit" class="btn" type="submit" value="<?php echo $this->_tpl_vars['lang']['btn_submit']; ?>
" />
     </dl>
    </div>
   </form>
   <?php endif; ?> 
  </div>
 </div>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "filebox.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>