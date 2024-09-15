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
<script type="text/javascript" src="images/jquery.autotextarea.js"></script>
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
   <div class="mainBox" style="<?php echo $this->_tpl_vars['workspace']['height']; ?>
">
    <?php if ($this->_tpl_vars['rec'] == 'default'): ?>
    <h3><a href="<?php echo $this->_tpl_vars['action_link']['href']; ?>
" class="actionBtn add"><?php echo $this->_tpl_vars['action_link']['text']; ?>
</a><?php echo $this->_tpl_vars['ur_here']; ?>
</h3>
    <div class="filter">
     <form action="article.php" method="post">
      <select name="cat_id">
       <option value="0"><?php echo $this->_tpl_vars['lang']['uncategorized']; ?>
</option>
       <?php $_from = $this->_tpl_vars['article_category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cate']):
?>
       <option value="<?php echo $this->_tpl_vars['cate']['cat_id']; ?>
"<?php if ($this->_tpl_vars['cate']['cat_id'] == $this->_tpl_vars['cat_id']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['cate']['mark']; ?>
 <?php echo $this->_tpl_vars['cate']['cat_name']; ?>
</option>
       <?php endforeach; endif; unset($_from); ?>
      </select>
      <input name="keyword" type="text" class="inpMain" value="<?php echo $this->_tpl_vars['keyword']; ?>
" size="20" />
      <input name="submit" class="btnGray" type="submit" value="<?php echo $this->_tpl_vars['lang']['btn_filter']; ?>
" />
     </form>
     <span>
      <?php if ($this->_tpl_vars['open']['sort']): ?>
      <a class="btnGray" href="tool.php?rec=sort&act=reset&module=article"><?php echo $this->_tpl_vars['lang']['sort_reset']; ?>
</a>
      <a class="btnGray" href="tool.php?rec=sort&act=close"><?php echo $this->_tpl_vars['lang']['sort_close']; ?>
</a>
      <?php else: ?>
      <a class="btnGray" href="tool.php?rec=sort&act=open"><?php echo $this->_tpl_vars['lang']['sort_open']; ?>
</a>
      <?php endif; ?>
     </span>
    </div>
    <div id="list">
     <form name="action" method="post" action="article.php?rec=action">
      <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
       <tr>
        <th width="22" align="center"><input name='chkall' type='checkbox' id='chkall' onclick='selectcheckbox(this.form)' value='check'></th>
        <th class="m-none" width="40" align="center"><?php echo $this->_tpl_vars['lang']['record_id']; ?>
</th>
        <th align="left"><?php echo $this->_tpl_vars['lang']['article_name']; ?>
</th>
        <th class="m-none" width="150" align="center"><?php echo $this->_tpl_vars['lang']['article_category']; ?>
</th>
        <?php if ($this->_tpl_vars['open']['sort']): ?>
        <th class="m-none" width="80" align="center"><?php echo $this->_tpl_vars['lang']['sort']; ?>
</th>
        <?php endif; ?>
        <th class="m-none" width="80" align="center"><?php echo $this->_tpl_vars['lang']['add_time']; ?>
</th>
        <th width="80" align="center"><?php echo $this->_tpl_vars['lang']['handler']; ?>
</th>
       </tr>
       <?php $_from = $this->_tpl_vars['article_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['article']):
?>
       <tr>
        <td align="center"><input type="checkbox" name="checkbox[]" value="<?php echo $this->_tpl_vars['article']['id']; ?>
" /></td>
        <td class="m-none" align="center"><?php echo $this->_tpl_vars['article']['id']; ?>
</td>
        <td><a href="article.php?rec=edit&id=<?php echo $this->_tpl_vars['article']['id']; ?>
"><?php echo $this->_tpl_vars['article']['title']; ?>
</a><?php if ($this->_tpl_vars['article']['image']): ?> <a href="<?php echo $this->_tpl_vars['article']['image']; ?>
" target="_blank"><img src="images/icon_picture.png" width="16" height="16" align="absMiddle"></a><?php endif; ?></td>
        <td class="m-none" align="center"><?php if ($this->_tpl_vars['article']['cat_name']): ?><a href="article.php?cat_id=<?php echo $this->_tpl_vars['article']['cat_id']; ?>
"><?php echo $this->_tpl_vars['article']['cat_name']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['lang']['uncategorized']; ?>
<?php endif; ?></td>
        <?php if ($this->_tpl_vars['open']['sort']): ?>
        <td class="m-none" align="center"><?php echo $this->_tpl_vars['article']['sort']; ?>
</td>
        <?php endif; ?>
        <td class="m-none" align="center"><?php echo $this->_tpl_vars['article']['add_time']; ?>
</td>
        <td align="center"><a href="article.php?rec=edit&id=<?php echo $this->_tpl_vars['article']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['edit']; ?>
</a> | <a href="article.php?rec=del&id=<?php echo $this->_tpl_vars['article']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['del']; ?>
</a></td>
       </tr>
       <?php endforeach; endif; unset($_from); ?>
      </table>
      <div class="action">
       <select name="action" onchange="douAction()">
        <option value="0"><?php echo $this->_tpl_vars['lang']['select']; ?>
</option>
        <option value="del_all"><?php echo $this->_tpl_vars['lang']['del']; ?>
</option>
        <option value="category_move"><?php echo $this->_tpl_vars['lang']['category_move']; ?>
</option>
       </select>
       <select name="new_cat_id" style="display:none">
        <option value="0"><?php echo $this->_tpl_vars['lang']['uncategorized']; ?>
</option>
        <?php $_from = $this->_tpl_vars['article_category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cate']):
?>
        <option value="<?php echo $this->_tpl_vars['cate']['cat_id']; ?>
"<?php if ($this->_tpl_vars['cate']['cat_id'] == $this->_tpl_vars['cat_id']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['cate']['mark']; ?>
 <?php echo $this->_tpl_vars['cate']['cat_name']; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>
       </select>
       <input name="submit" class="btn" type="submit" value="<?php echo $this->_tpl_vars['lang']['btn_execute']; ?>
" />
      </div>
     </form>
    </div>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pager.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
    <?php endif; ?>
    <?php if ($this->_tpl_vars['rec'] == 'add' || $this->_tpl_vars['rec'] == 'edit'): ?>
    <h3><a href="<?php echo $this->_tpl_vars['action_link']['href']; ?>
" class="actionBtn"><?php echo $this->_tpl_vars['action_link']['text']; ?>
</a><?php echo $this->_tpl_vars['ur_here']; ?>
</h3>
    <form action="article.php?rec=<?php echo $this->_tpl_vars['form_action']; ?>
" method="post" enctype="multipart/form-data">
     <div class="formBasic">
      <dl>
       <dt><?php echo $this->_tpl_vars['lang']['article_title']; ?>
</dt>
       <dd>
        <input type="text" name="title" value="<?php echo $this->_tpl_vars['article']['title']; ?>
" size="80" class="inpMain" />
        <span class="lang"><?php echo $this->_tpl_vars['btn_lang']['title']; ?>
</span>
       </dd>
      </dl>
      <dl>
       <dt><?php echo $this->_tpl_vars['lang']['article_category']; ?>
</dt>
       <dd>
        <select name="cat_id">
         <option value="0"><?php echo $this->_tpl_vars['lang']['uncategorized']; ?>
</option>
         <?php $_from = $this->_tpl_vars['article_category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cate']):
?>
         <option value="<?php echo $this->_tpl_vars['cate']['cat_id']; ?>
"<?php if ($this->_tpl_vars['cate']['cat_id'] == $this->_tpl_vars['article']['cat_id']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['cate']['mark']; ?>
 <?php echo $this->_tpl_vars['cate']['cat_name']; ?>
</option>
         <?php endforeach; endif; unset($_from); ?>
        </select>
       </dd>
      </dl>
      <?php if ($this->_tpl_vars['article']['defined']): ?>
      <dl>
       <dt valign="top"><?php echo $this->_tpl_vars['lang']['article_defined']; ?>
</dt>
       <dd>
        <textarea name="defined" id="defined" cols="50" class="textAreaAuto" style="height:<?php echo $this->_tpl_vars['article']['defined_count']; ?>
0px"><?php echo $this->_tpl_vars['article']['defined']; ?>
</textarea>
        <script type="text/javascript">
         <?php echo '
          $("#defined").autoTextarea({maxHeight:300});
         '; ?>

        </script>
        </dd>
      </dl>
      <?php endif; ?>
      <dl>
       <dt valign="top"><?php echo $this->_tpl_vars['lang']['article_content']; ?>
</dt>
       <dd> 
        <!-- 编辑器（所需变量：$cur、$item_id、$item_content） -->
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editor.htm", 'smarty_include_vars' => array('var' => 'content')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <p class="lang"><?php echo $this->_tpl_vars['btn_lang']['content']; ?>
</p>
       </dd>
      </dl>
      <dl>
       <dt><?php echo $this->_tpl_vars['lang']['thumb']; ?>
</dt>
       <dd>
        <input type="file" name="image" size="38" class="inpFlie" />
        <?php if ($this->_tpl_vars['article']['image']): ?><a href="<?php echo $this->_tpl_vars['article']['image']; ?>
" target="_blank"><img src="images/icon_yes.png"></a><?php else: ?><img src="images/icon_no.png"><?php endif; ?>
        <p class="cue"><?php echo $this->_tpl_vars['setting']['theme']['article_img_size']; ?>
</p>
       </dd>
      </dl>
      <?php if ($this->_tpl_vars['open']['sort']): ?>
      <dl>
       <dt><?php echo $this->_tpl_vars['lang']['sort']; ?>
</dt>
       <dd><input type="text" name="sort" value="<?php if ($this->_tpl_vars['article']['sort']): ?><?php echo $this->_tpl_vars['article']['sort']; ?>
<?php else: ?>50<?php endif; ?>" size="5" class="inpMain" /></dd>
      </dl>
      <?php endif; ?>
      <dl>
       <dt><?php echo $this->_tpl_vars['lang']['add_time']; ?>
</dt>
       <dd>
        <input type="text" name="add_time" value="<?php echo $this->_tpl_vars['article']['add_time']; ?>
" size="15" class="inpMain" />
       </dd>
      </dl>
      <dl>
       <dt><?php echo $this->_tpl_vars['lang']['keywords']; ?>
</dt>
       <dd>
        <input type="text" name="keywords" value="<?php echo $this->_tpl_vars['article']['keywords']; ?>
" size="135" class="inpMain" />
        <span class="lang"><?php echo $this->_tpl_vars['btn_lang']['keywords']; ?>
</span>
       </dd>
      </dl>
      <dl>
       <dt><?php echo $this->_tpl_vars['lang']['description']; ?>
</dt>
       <dd>
        <textarea name="description" cols="115" rows="3" class="textArea" /><?php echo $this->_tpl_vars['article']['description']; ?>
</textarea>
        <p class="lang"><?php echo $this->_tpl_vars['btn_lang']['description']; ?>
</p>
       </dd>
      </dl>
      <dl>
       <?php if (! $this->_tpl_vars['open']['sort']): ?>
       <input type="hidden" name="sort" value="<?php if ($this->_tpl_vars['article']['sort']): ?><?php echo $this->_tpl_vars['article']['sort']; ?>
<?php else: ?>50<?php endif; ?>" />
       <?php endif; ?>
       <input type="hidden" name="token" value="<?php echo $this->_tpl_vars['token']; ?>
" />
       <input type="hidden" name="image" value="<?php echo $this->_tpl_vars['article']['image']; ?>
">
       <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['article']['id']; ?>
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
 ?>
 </div>
<?php if ($this->_tpl_vars['rec'] == 'default'): ?>
<script type="text/javascript">
<?php echo 'onload = function() {document.forms[\'action\'].reset();}'; ?>

</script>
<?php endif; ?>
</body>
</html>