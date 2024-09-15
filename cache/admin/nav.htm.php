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
   <h3><a href="<?php echo $this->_tpl_vars['action_link']['href']; ?>
" class="actionBtn"><?php echo $this->_tpl_vars['action_link']['text']; ?>
</a><?php echo $this->_tpl_vars['ur_here']; ?>
</h3>
   <?php if ($this->_tpl_vars['rec'] == 'default'): ?>
   <div class="navList">
    <ul class="tab">
     <li><a href="nav.php"<?php if ($this->_tpl_vars['type'] == 'middle'): ?> class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['nav_type_middle']; ?>
</a></li>
     <li><a href="nav.php?type=top"<?php if ($this->_tpl_vars['type'] == 'top'): ?> class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['nav_type_top']; ?>
</a></li>
     <li><a href="nav.php?type=bottom"<?php if ($this->_tpl_vars['type'] == 'bottom'): ?> class="selected"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['nav_type_bottom']; ?>
</a></li>
    </ul>
    <table width="100%" border="0" cellpadding="10" cellspacing="0" class="tableBasic">
     <tr>
      <th width="123" align="center"><?php echo $this->_tpl_vars['lang']['nav_name']; ?>
</th>
      <th class="m-none" align="left"><?php echo $this->_tpl_vars['lang']['nav_link']; ?>
</th>
      <th class="m-none" width="80" align="center"><?php echo $this->_tpl_vars['lang']['sort']; ?>
</th>
      <th width="120" align="center"><?php echo $this->_tpl_vars['lang']['handler']; ?>
</th>
     </tr>
     <?php $_from = $this->_tpl_vars['nav_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nav_list']):
?>
     <tr>
      <td><?php echo $this->_tpl_vars['nav_list']['mark']; ?>
 <?php echo $this->_tpl_vars['nav_list']['nav_name']; ?>
<?php if ($this->_tpl_vars['nav_list']['icon']): ?> <a href="<?php echo $this->_tpl_vars['nav_list']['icon']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['nav_list']['icon']; ?>
" width="12" height="12" align="absMiddle"></a><?php endif; ?></td>
      <td class="m-none"><?php echo $this->_tpl_vars['nav_list']['guide']; ?>
</td>
      <td class="m-none" align="center"><?php echo $this->_tpl_vars['nav_list']['sort']; ?>
</td>
      <td align="center"><a href="nav.php?rec=edit&id=<?php echo $this->_tpl_vars['nav_list']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['edit']; ?>
</a> | <a href="nav.php?rec=del&id=<?php echo $this->_tpl_vars['nav_list']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['del']; ?>
</a></td>
     </tr>
     <?php endforeach; endif; unset($_from); ?>
    </table>
   </div>
   <?php endif; ?> 
   <?php if ($this->_tpl_vars['rec'] == 'add'): ?> 
   <script type="text/javascript">
     <?php echo '
     $(function(){ $(".idTabs").idTabs(); });
     '; ?>

    </script>
   <div class="idTabs">
    <ul class="tab">
     <li><a href="#nav_add"><?php echo $this->_tpl_vars['lang']['nav_inside']; ?>
</a></li>
     <li><a href="#nav_defined"><?php echo $this->_tpl_vars['lang']['nav_defined']; ?>
</a></li>
    </ul>
    <div class="items" style="margin-top: 20px;">
     <div id="nav_add">
      <form action="nav.php?rec=insert" method="post" enctype="multipart/form-data">
       <div class="formBasic">
        <dl>
         <dt><?php echo $this->_tpl_vars['lang']['nav_system']; ?>
</dt>
         <dd>
          <select name="nav_menu" onchange="change('nav_name', this)">
           <option value=""><?php echo $this->_tpl_vars['lang']['nav_menu']; ?>
</option>
           <?php $_from = $this->_tpl_vars['catalog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['catalog']):
?>
           <option value="<?php echo $this->_tpl_vars['catalog']['module']; ?>
,<?php echo $this->_tpl_vars['catalog']['guide']; ?>
"<?php if ($this->_tpl_vars['catalog']['cur']): ?> selected="selected"<?php endif; ?> title="<?php echo $this->_tpl_vars['catalog']['name']; ?>
"><?php echo $this->_tpl_vars['catalog']['mark']; ?>
 <?php echo $this->_tpl_vars['catalog']['name']; ?>
</option>
           <?php endforeach; endif; unset($_from); ?>
          </select>
         </dd>
        </dl>
        <dl>
         <dt><?php echo $this->_tpl_vars['lang']['nav_name']; ?>
</dt>
         <dd>
          <input type="text" id="nav_name" name="nav_name" value="" size="40" class="inpMain" />
          <span class="lang"><?php echo $this->_tpl_vars['btn_lang']['nav_name']; ?>
</span>
         </dd>
        </dl>
        <?php if ($this->_tpl_vars['site']['open_icon']): ?>
        <dl>
         <dt><?php echo $this->_tpl_vars['lang']['icon']; ?>
</dt>
         <dd>
          <input type="file" name="icon" size="38" class="inpFlie" />
          <?php if ($this->_tpl_vars['nav_info']['icon']): ?><a href="<?php echo $this->_tpl_vars['nav_info']['icon']; ?>
" target="_blank"><img src="images/icon_yes.png"></a><?php else: ?><img src="images/icon_no.png"><?php endif; ?></dd>
        </dl>
        <?php endif; ?>
        <dl>
         <dt><?php echo $this->_tpl_vars['lang']['nav_type']; ?>
</dt>
         <dd>
          <label for="type_0">
           <input type="radio" name="type" id="type_0" value="middle" checked="true" onChange="dou_callback('nav.php?rec=nav_select&id=<?php echo $this->_tpl_vars['nav_info']['id']; ?>
', 'type', this.value, 'parent')">
           <?php echo $this->_tpl_vars['lang']['nav_type_middle']; ?>
</label>
          <label for="type_1">
           <input type="radio" name="type" id="type_1" value="top" onChange="dou_callback('nav.php?rec=nav_select&id=<?php echo $this->_tpl_vars['nav_info']['id']; ?>
', 'type', this.value, 'parent')">
           <?php echo $this->_tpl_vars['lang']['nav_type_top']; ?>
</label>
          <label for="type_2">
           <input type="radio" name="type" id="type_2" value="bottom" onChange="dou_callback('nav.php?rec=nav_select&id=<?php echo $this->_tpl_vars['nav_info']['id']; ?>
', 'type', this.value, 'parent')">
           <?php echo $this->_tpl_vars['lang']['nav_type_bottom']; ?>
</label>
         </dd>
        </dl>
        <dl>
         <dt><?php echo $this->_tpl_vars['lang']['parent']; ?>
</dt>
         <dd id="parent">
          <select name="parent_id">
           <option value="0"><?php echo $this->_tpl_vars['lang']['empty']; ?>
</option>
           <?php $_from = $this->_tpl_vars['nav_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
           <option value="<?php echo $this->_tpl_vars['list']['id']; ?>
"><?php echo $this->_tpl_vars['list']['mark']; ?>
 <?php echo $this->_tpl_vars['list']['nav_name']; ?>
</option>
           <?php endforeach; endif; unset($_from); ?>
          </select>
         </dd>
        </dl>
        <dl>
         <dt><?php echo $this->_tpl_vars['lang']['sort']; ?>
</dt>
         <dd>
          <input type="text" name="sort" value="50" size="5" class="inpMain" />
         </dd>
        </dl>
        <dl>
         <input type="hidden" name="token" value="<?php echo $this->_tpl_vars['token']; ?>
" />
         <input name="submit" class="btn" type="submit" value="<?php echo $this->_tpl_vars['lang']['btn_submit']; ?>
" />
        </dl>
       </div>
      </form>
     </div>
     <div id="nav_defined">
      <form action="nav.php?rec=insert" method="post" enctype="multipart/form-data">
       <div class="formBasic">
        <dl>
         <dt><?php echo $this->_tpl_vars['lang']['nav_name']; ?>
</dt>
         <dd>
          <input type="text" name="nav_name" value="" size="40" class="inpMain" />
          <span class="lang"><?php echo $this->_tpl_vars['btn_lang']['nav_name']; ?>
</span>
         </dd>
        </dl>
        <?php if ($this->_tpl_vars['site']['open_icon']): ?>
        <dl>
         <dt><?php echo $this->_tpl_vars['lang']['icon']; ?>
</dt>
         <dd>
          <input type="file" name="icon" size="38" class="inpFlie" />
          <?php if ($this->_tpl_vars['nav_info']['icon']): ?><a href="<?php echo $this->_tpl_vars['nav_info']['icon']; ?>
" target="_blank"><img src="images/icon_yes.png"></a><?php else: ?><img src="images/icon_no.png"><?php endif; ?></dd>
        </dl>
        <?php endif; ?>
        <dl>
         <dt><?php echo $this->_tpl_vars['lang']['nav_type']; ?>
</dt>
         <dd>
          <label for="type_0">
           <input type="radio" name="type" id="type_0" value="middle" checked="true" onChange="dou_callback('nav.php?rec=nav_select&id=<?php echo $this->_tpl_vars['nav_info']['id']; ?>
', 'type', this.value, 'parent_external')">
           <?php echo $this->_tpl_vars['lang']['nav_type_middle']; ?>
</label>
          <label for="type_1">
           <input type="radio" name="type" id="type_1" value="top" onChange="dou_callback('nav.php?rec=nav_select&id=<?php echo $this->_tpl_vars['nav_info']['id']; ?>
', 'type', this.value, 'parent_external')">
           <?php echo $this->_tpl_vars['lang']['nav_type_top']; ?>
</label>
          <label for="type_2">
           <input type="radio" name="type" id="type_2" value="bottom" onChange="dou_callback('nav.php?rec=nav_select&id=<?php echo $this->_tpl_vars['nav_info']['id']; ?>
', 'type', this.value, 'parent_external')">
           <?php echo $this->_tpl_vars['lang']['nav_type_bottom']; ?>
</label>
         </dd>
        </dl>
        <dl>
         <dt><?php echo $this->_tpl_vars['lang']['nav_link']; ?>
</dt>
         <dd>
          <input type="text" name="guide" value="" size="80" class="inpMain" />
          <span class="lang"><?php echo $this->_tpl_vars['btn_lang']['guide']; ?>
</span>
         </dd>
        </dl>
        <dl>
         <dt><?php echo $this->_tpl_vars['lang']['parent']; ?>
</dt>
         <dd id="parent_external">
          <select name="parent_id">
           <option value="0"><?php echo $this->_tpl_vars['lang']['empty']; ?>
</option>
           <?php $_from = $this->_tpl_vars['nav_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
           <option value="<?php echo $this->_tpl_vars['list']['id']; ?>
"><?php echo $this->_tpl_vars['list']['mark']; ?>
 <?php echo $this->_tpl_vars['list']['nav_name']; ?>
</option>
           <?php endforeach; endif; unset($_from); ?>
          </select>
         </dd>
        </dl>
        <dl>
         <dt><?php echo $this->_tpl_vars['lang']['sort']; ?>
</dt>
         <dd>
          <input type="text" name="sort" value="50" size="5" class="inpMain" />
         </dd>
        </dl>
        <dl>
         <input type="hidden" name="token" value="<?php echo $this->_tpl_vars['token']; ?>
" />
         <input type="hidden" name="nav_menu" value="nav,0" />
         <input name="submit" class="btn" type="submit" value="<?php echo $this->_tpl_vars['lang']['btn_submit']; ?>
" />
        </dl>
       </div>
      </form>
     </div>
    </div>
   </div>
   <?php endif; ?> 
   <?php if ($this->_tpl_vars['rec'] == 'edit'): ?>
   <form action="nav.php?rec=update" method="post" enctype="multipart/form-data">
    <div class="formBasic"> 
     <?php if ($this->_tpl_vars['nav_info']['module'] != 'nav'): ?>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['nav_system']; ?>
</dt>
      <dd>
       <select name="nav_menu" onchange="change('nav_name', this)">
        <option value=""><?php echo $this->_tpl_vars['lang']['nav_menu']; ?>
</option>
        <?php $_from = $this->_tpl_vars['catalog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['catalog']):
?>
        <option value="<?php echo $this->_tpl_vars['catalog']['module']; ?>
,<?php echo $this->_tpl_vars['catalog']['guide']; ?>
"<?php if ($this->_tpl_vars['catalog']['cur']): ?> selected="selected"<?php endif; ?> title="<?php echo $this->_tpl_vars['catalog']['name']; ?>
"><?php echo $this->_tpl_vars['catalog']['mark']; ?>
 <?php echo $this->_tpl_vars['catalog']['name']; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>
       </select>
      </dd>
     </dl>
     <?php endif; ?>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['nav_name']; ?>
</dt>
      <dd>
       <input type="text" id="nav_name" name="nav_name" value="<?php echo $this->_tpl_vars['nav_info']['nav_name']; ?>
" size="40" class="inpMain" />
       <span class="lang"><?php echo $this->_tpl_vars['btn_lang']['nav_name']; ?>
</span>
      </dd>
     </dl>
     <?php if ($this->_tpl_vars['site']['open_icon']): ?>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['icon']; ?>
</dt>
      <dd>
       <input type="file" name="icon" size="38" class="inpFlie" />
       <?php if ($this->_tpl_vars['nav_info']['icon']): ?><a href="<?php echo $this->_tpl_vars['nav_info']['icon']; ?>
" target="_blank"><img src="images/icon_yes.png"></a><?php else: ?><img src="images/icon_no.png"><?php endif; ?></dd>
     </dl>
     <?php endif; ?>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['nav_type']; ?>
</dt>
      <dd>
       <label for="type_0">
        <input type="radio" name="type" id="type_0" value="middle"<?php if ($this->_tpl_vars['nav_info']['type'] == 'middle'): ?> checked="true"<?php endif; ?> onChange="dou_callback('nav.php?rec=nav_select&id=<?php echo $this->_tpl_vars['nav_info']['id']; ?>
', 'type', this.value, 'parent')">
        <?php echo $this->_tpl_vars['lang']['nav_type_middle']; ?>
</label>
       <label for="type_1">
        <input type="radio" name="type" id="type_1" value="top"<?php if ($this->_tpl_vars['nav_info']['type'] == 'top'): ?> checked="true"<?php endif; ?> onChange="dou_callback('nav.php?rec=nav_select&id=<?php echo $this->_tpl_vars['nav_info']['id']; ?>
', 'type', this.value, 'parent')">
        <?php echo $this->_tpl_vars['lang']['nav_type_top']; ?>
</label>
       <label for="type_2">
        <input type="radio" name="type" id="type_2" value="bottom"<?php if ($this->_tpl_vars['nav_info']['type'] == 'bottom'): ?> checked="true"<?php endif; ?> onChange="dou_callback('nav.php?rec=nav_select&id=<?php echo $this->_tpl_vars['nav_info']['id']; ?>
', 'type', this.value, 'parent')">
        <?php echo $this->_tpl_vars['lang']['nav_type_bottom']; ?>
</label>
      </dd>
     </dl>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['nav_link']; ?>
</dt>
      <dd> 
       <?php if ($this->_tpl_vars['nav_info']['module'] == 'nav'): ?>
       <input type="text" name="guide" value="<?php echo $this->_tpl_vars['nav_info']['url']; ?>
" size="60" class="inpMain" />
       <span class="lang"><?php echo $this->_tpl_vars['btn_lang']['guide']; ?>
</span>
       <?php else: ?>
       <input type="text" name="guide_no" value="<?php echo $this->_tpl_vars['nav_info']['url']; ?>
" size="60" readOnly="true" class="inpMain" />
       <b class="cue"><?php echo $this->_tpl_vars['lang']['nav_not_modify']; ?>
</b> 
       <?php endif; ?></dd>
     </dl>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['parent']; ?>
</dt>
      <dd id="parent">
       <select name="parent_id">
        <option value="0"><?php echo $this->_tpl_vars['lang']['empty']; ?>
</option>
        <?php $_from = $this->_tpl_vars['nav_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nav_list']):
?> 
        <option value="<?php echo $this->_tpl_vars['nav_list']['id']; ?>
"<?php if ($this->_tpl_vars['nav_list']['id'] == $this->_tpl_vars['nav_info']['parent_id']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['nav_list']['mark']; ?>
 <?php echo $this->_tpl_vars['nav_list']['nav_name']; ?>

        </option>
        <?php endforeach; endif; unset($_from); ?>
       </select>
      </dd>
     </dl>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['sort']; ?>
</dt>
      <dd>
       <input type="text" name="sort" value="<?php if ($this->_tpl_vars['nav_info']['sort']): ?><?php echo $this->_tpl_vars['nav_info']['sort']; ?>
<?php else: ?>50<?php endif; ?>" size="5" class="inpMain" />
      </dd>
     </dl>
     <dl>
      <input type="hidden" name="token" value="<?php echo $this->_tpl_vars['token']; ?>
" />
      <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['nav_info']['id']; ?>
" />
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
</body>
</html>