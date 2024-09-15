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
" class="actionBtn add"><?php echo $this->_tpl_vars['action_link']['text']; ?>
</a><?php echo $this->_tpl_vars['ur_here']; ?>
</h3>
   <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
    <tr>
     <th width="120" align="left"><?php echo $this->_tpl_vars['lang']['product_category_cat_name']; ?>
</th>
     <th align="left"><?php echo $this->_tpl_vars['lang']['unique']; ?>
</th>
     <?php if ($this->_tpl_vars['open']['attribute']): ?>
     <th class="m-none" align="left"><?php echo $this->_tpl_vars['lang']['attribute']; ?>
</th>
     <?php endif; ?>
     <th class="m-none" align="left"><?php echo $this->_tpl_vars['lang']['description']; ?>
</th>
     <th class="m-none" width="60" align="center"><?php echo $this->_tpl_vars['lang']['sort']; ?>
</th>
     <th width="80" align="center"><?php echo $this->_tpl_vars['lang']['handler']; ?>
</th>
    </tr>
    <?php $_from = $this->_tpl_vars['product_category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cate']):
?>
    <tr>
     <td align="left"><?php echo $this->_tpl_vars['cate']['mark']; ?>
 <a href="product.php?cat_id=<?php echo $this->_tpl_vars['cate']['cat_id']; ?>
"><?php echo $this->_tpl_vars['cate']['cat_name']; ?>
</a></td>
     <td><?php echo $this->_tpl_vars['cate']['unique_id']; ?>
</td>
     <?php if ($this->_tpl_vars['open']['attribute']): ?>
     <td class="m-none"><?php $_from = $this->_tpl_vars['cate']['attribute_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['attribute']):
?><em class="btnSet"><?php echo $this->_tpl_vars['attribute']['name']; ?>
</em> <?php endforeach; endif; unset($_from); ?><a class="btnSet" href="attribute.php?cat_id=<?php echo $this->_tpl_vars['cate']['cat_id']; ?>
"><?php echo $this->_tpl_vars['lang']['attribute_manage']; ?>
</a></td>
     <?php endif; ?>
     <td class="m-none"><?php echo $this->_tpl_vars['cate']['description']; ?>
</td>
     <td class="m-none" align="center"><?php echo $this->_tpl_vars['cate']['sort']; ?>
</td>
     <td align="center"><a href="product_category.php?rec=edit&cat_id=<?php echo $this->_tpl_vars['cate']['cat_id']; ?>
"><?php echo $this->_tpl_vars['lang']['edit']; ?>
</a> | <a href="product_category.php?rec=del&cat_id=<?php echo $this->_tpl_vars['cate']['cat_id']; ?>
"><?php echo $this->_tpl_vars['lang']['del']; ?>
</a></td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
   </table>
   <?php endif; ?> 
   <?php if ($this->_tpl_vars['rec'] == 'add' || $this->_tpl_vars['rec'] == 'edit'): ?>
   <h3><a href="<?php echo $this->_tpl_vars['action_link']['href']; ?>
" class="actionBtn"><?php echo $this->_tpl_vars['action_link']['text']; ?>
</a><?php echo $this->_tpl_vars['ur_here']; ?>
</h3>
   <form action="product_category.php?rec=<?php echo $this->_tpl_vars['form_action']; ?>
" method="post" enctype="multipart/form-data">
    <div class="formBasic">
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['product_category_cat_name']; ?>
</dt>
      <dd>
       <input type="text" name="cat_name" value="<?php echo $this->_tpl_vars['cat_info']['cat_name']; ?>
" size="40" class="inpMain" />
       <span class="lang"><?php echo $this->_tpl_vars['btn_lang']['cat_name']; ?>
</span>
      </dd>
     </dl>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['unique']; ?>
</dt>
      <dd>
       <input type="text" name="unique_id" value="<?php echo $this->_tpl_vars['cat_info']['unique_id']; ?>
" size="40" class="inpMain" />
      </dd>
     </dl>
     <?php if ($this->_tpl_vars['site']['open_icon']): ?>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['icon']; ?>
</dt>
      <dd>
       <input type="file" name="icon" size="38" class="inpFlie" />
       <?php if ($this->_tpl_vars['cat_info']['icon']): ?><a href="<?php echo $this->_tpl_vars['cat_info']['icon']; ?>
" target="_blank"><img src="images/icon_yes.png"></a><?php else: ?><img src="images/icon_no.png"><?php endif; ?></dd>
     </dl>
     <?php endif; ?>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['parent']; ?>
</dt>
      <dd>
       <select name="parent_id">
        <option value="0"><?php echo $this->_tpl_vars['lang']['empty']; ?>
</option>
        <?php $_from = $this->_tpl_vars['product_category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cate']):
?> 
        <option value="<?php echo $this->_tpl_vars['cate']['cat_id']; ?>
"<?php if ($this->_tpl_vars['cate']['cat_id'] == $this->_tpl_vars['cat_info']['parent_id']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['cate']['mark']; ?>
 <?php echo $this->_tpl_vars['cate']['cat_name']; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>
       </select>
      </dd>
     </dl>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['keywords']; ?>
</dt>
      <dd>
       <input type="text" name="keywords" value="<?php echo $this->_tpl_vars['cat_info']['keywords']; ?>
" size="40" class="inpMain" />
       <span class="lang"><?php echo $this->_tpl_vars['btn_lang']['keywords']; ?>
</span>
      </dd>
     </dl>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['description']; ?>
</dt>
      <dd>
       <textarea name="description" cols="60" rows="4" class="textArea"><?php echo $this->_tpl_vars['cat_info']['description']; ?>
</textarea>
       <p class="lang"><?php echo $this->_tpl_vars['btn_lang']['description']; ?>
</p>
      </dd>
     </dl>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['sort']; ?>
</dt>
      <dd>
       <input type="text" name="sort" value="<?php if ($this->_tpl_vars['cat_info']['sort']): ?><?php echo $this->_tpl_vars['cat_info']['sort']; ?>
<?php else: ?>50<?php endif; ?>" size="5" class="inpMain" />
      </dd>
     </dl>
     <dl>
      <input type="hidden" name="token" value="<?php echo $this->_tpl_vars['token']; ?>
" />
      <input type="hidden" name="cat_id" value="<?php echo $this->_tpl_vars['cat_info']['cat_id']; ?>
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