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
<script type="text/javascript" src="images/jquery.autotextarea.js"></script>
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
   <div class="filter">
    <form action="product.php" method="post">
     <select name="cat_id">
      <option value="0"><?php echo $this->_tpl_vars['lang']['uncategorized']; ?>
</option>
      <?php $_from = $this->_tpl_vars['product_category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
    <a class="btnGray" href="tool.php?rec=sort&act=reset&module=product"><?php echo $this->_tpl_vars['lang']['sort_reset']; ?>
</a> <a class="btnGray" href="tool.php?rec=sort&act=close"><?php echo $this->_tpl_vars['lang']['sort_close']; ?>
</a> 
    <?php else: ?> 
    <a class="btnGray" href="product.php?rec=thumb"><?php echo $this->_tpl_vars['lang']['product_thumb']; ?>
</a> <a class="btnGray" href="tool.php?rec=sort&act=open"><?php echo $this->_tpl_vars['lang']['sort_open']; ?>
</a> 
    <?php endif; ?> 
    </span> </div>
   <div id="list">
    <form name="action" method="post" action="product.php?rec=action">
     <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
      <tr>
       <th width="22" align="center"><input name='chkall' type='checkbox' id='chkall' onclick='selectcheckbox(this.form)' value='check'></th>
       <th class="m-none" width="40" align="center"><?php echo $this->_tpl_vars['lang']['record_id']; ?>
</th>
       <th align="left"><?php echo $this->_tpl_vars['lang']['product_name']; ?>
</th>
       <th class="m-none" align="center"><?php echo $this->_tpl_vars['lang']['product_price']; ?>
</th>
       <?php $_from = $this->_tpl_vars['user_level_option']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['level']):
?>
       <th class="m-none" align="center"><?php echo $this->_tpl_vars['level']['name']; ?>
</th>
       <?php endforeach; endif; unset($_from); ?>
       <th class="m-none" width="150" align="center"><?php echo $this->_tpl_vars['lang']['product_category']; ?>
</th>
       <?php if ($this->_tpl_vars['site']['stock']): ?>
       <th width="100" align="center"><?php echo $this->_tpl_vars['lang']['product_stock']; ?>
</th>
       <?php endif; ?>
       <?php if ($this->_tpl_vars['open']['point']): ?>
       <th width="100" align="center"><?php echo $this->_tpl_vars['lang']['product_point']; ?>
</th>
       <?php endif; ?>
       <?php if ($this->_tpl_vars['open']['sort']): ?>
       <th class="m-none" width="80" align="center"><?php echo $this->_tpl_vars['lang']['sort']; ?>
</th>
       <?php endif; ?>
       <th class="m-none" width="80" align="center"><?php echo $this->_tpl_vars['lang']['add_time']; ?>
</th>
       <th width="80" align="center"><?php echo $this->_tpl_vars['lang']['handler']; ?>
</th>
      </tr>
      <?php $_from = $this->_tpl_vars['product_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['product']):
?>
      <tr>
       <td align="center"><input type="checkbox" name="checkbox[]" value="<?php echo $this->_tpl_vars['product']['id']; ?>
" /></td>
       <td class="m-none" align="center"><?php echo $this->_tpl_vars['product']['id']; ?>
</td>
       <td><a href="product.php?rec=edit&id=<?php echo $this->_tpl_vars['product']['id']; ?>
"><?php echo $this->_tpl_vars['product']['name']; ?>
</a><?php if ($this->_tpl_vars['product']['image']): ?> <a href="<?php echo $this->_tpl_vars['product']['image']; ?>
" target="_blank"><img src="images/icon_picture.png" width="16" height="16" align="absMiddle"></a><?php endif; ?></td>
       <td class="m-none" align="center"><?php echo $this->_tpl_vars['product']['price']; ?>
</td>
       <?php $_from = $this->_tpl_vars['product']['level_price']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['level']):
?>
       <td class="m-none" align="center"><?php echo $this->_tpl_vars['level']['price_format']; ?>
</td>
       <?php endforeach; endif; unset($_from); ?>
       <td class="m-none" align="center"><?php if ($this->_tpl_vars['product']['cat_name']): ?><a href="product.php?cat_id=<?php echo $this->_tpl_vars['product']['cat_id']; ?>
"><?php echo $this->_tpl_vars['product']['cat_name']; ?>
</a><?php else: ?><?php echo $this->_tpl_vars['lang']['uncategorized']; ?>
<?php endif; ?></td>
       <?php if ($this->_tpl_vars['site']['stock']): ?>
       <td align="center"><?php echo $this->_tpl_vars['product']['stock']; ?>
</td>
       <?php endif; ?>
       <?php if ($this->_tpl_vars['open']['point']): ?>
       <td align="center"><?php echo $this->_tpl_vars['product']['point']; ?>
</td>
       <?php endif; ?>
       <?php if ($this->_tpl_vars['open']['sort']): ?>
       <td class="m-none" align="center"><?php echo $this->_tpl_vars['product']['sort']; ?>
</td>
       <?php endif; ?>
       <td class="m-none" align="center"><?php echo $this->_tpl_vars['product']['add_time']; ?>
</td>
       <td align="center"><a href="product.php?rec=edit&id=<?php echo $this->_tpl_vars['product']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['edit']; ?>
</a> | <a href="product.php?rec=del&id=<?php echo $this->_tpl_vars['product']['id']; ?>
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
       <?php $_from = $this->_tpl_vars['product_category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
   <form action="product.php?rec=<?php echo $this->_tpl_vars['form_action']; ?>
" method="post" enctype="multipart/form-data">
    <div class="formBasic">
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['product_name']; ?>
</dt>
      <dd>
       <input type="text" name="name" value="<?php echo $this->_tpl_vars['product']['name']; ?>
" size="80" class="inpMain" />
       <span class="lang"><?php echo $this->_tpl_vars['btn_lang']['name']; ?>
</span>
      </dd>
     </dl>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['product_category']; ?>
</dt>
      <dd>
       <select name="cat_id">
        <option value="0"><?php echo $this->_tpl_vars['lang']['uncategorized']; ?>
</option>
        <?php $_from = $this->_tpl_vars['product_category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cate']):
?> 
        <option value="<?php echo $this->_tpl_vars['cate']['cat_id']; ?>
"<?php if ($this->_tpl_vars['cate']['cat_id'] == $this->_tpl_vars['product']['cat_id']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['cate']['mark']; ?>
 <?php echo $this->_tpl_vars['cate']['cat_name']; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>
       </select>
      </dd>
     </dl>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['product_price']; ?>
</dt>
      <dd>
       <input type="text" name="price" value="<?php if ($this->_tpl_vars['product']['price']): ?><?php echo $this->_tpl_vars['product']['price']; ?>
<?php else: ?>0<?php endif; ?>" size="40" class="inpMain" />
      </dd>
     </dl>
     <?php if ($this->_tpl_vars['open']['user_level']): ?>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['product_level_price']; ?>
</dt>
      <dd>
       <table border="0" cellpadding="0" cellspacing="0" class="tableColumn">
        <tr> 
         <?php $_from = $this->_tpl_vars['user_level_option']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['level']):
?>
         <td><dt><?php echo $this->_tpl_vars['level']['name']; ?>
</dt>
          <dd>
           <input type="text" name="level_price[<?php echo $this->_tpl_vars['level']['key']; ?>
]" value="<?php echo $this->_tpl_vars['level']['price']; ?>
" size="10" class="inpMain" />
          </dd></td>
         <?php endforeach; endif; unset($_from); ?> 
        </tr>
       </table>
      </dd>
     </dl>
     <?php endif; ?> 
     <?php if ($this->_tpl_vars['product']['defined']): ?>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['product_defined']; ?>
</dt>
      <dd> <textarea name="defined" id="defined" cols="50" class="textAreaAuto" style="height:<?php echo $this->_tpl_vars['product']['defined_count']; ?>
0px"><?php echo $this->_tpl_vars['product']['defined']; ?>
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
      <dt><?php echo $this->_tpl_vars['lang']['product_content']; ?>
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
       <?php if ($this->_tpl_vars['product']['image']): ?><a href="<?php echo $this->_tpl_vars['product']['image']; ?>
" target="_blank"><img src="images/icon_yes.png"></a><?php else: ?><img src="images/icon_no.png"><?php endif; ?>
       <p class="cue"><?php echo $this->_tpl_vars['setting']['theme']['product_img_size']; ?>
</p>
      </dd>
     </dl>
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
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['product_gallery']; ?>
</dt>
      <dd> 
       <!-- FileBox -->
       <div id="galleryFile" class="fileBox">
        <ul class="fileAdd">
         <li class="btnFile" onclick="fileBox('gallery', 'galleryList', '<?php echo $this->_tpl_vars['cur']; ?>
', '<?php echo $this->_tpl_vars['item_id']; ?>
');"><?php echo $this->_tpl_vars['lang']['product_gallery_btn']; ?>
</li>
         <li class="fileStatus" style="display:none"><img src="images/loader.gif" alt="uploading"/></li>
        </ul>
        <ul id="galleryList" class="fileList">
         <?php echo $this->_tpl_vars['product']['img_list_html']; ?>

        </ul>
       </div>
       <!-- /FileBox --> 
      </dd>
     </dl>
     <?php if ($this->_tpl_vars['open']['attribute']): ?>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['attribute']; ?>
</dt>
      <dd>
       <link href="templates/attribute.css" rel="stylesheet" type="text/css">
       <script type="text/javascript" src="images/attribute.js"></script>
       <div class="attribute">
        <?php $_from = $this->_tpl_vars['product']['attribute_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['attribute']):
?>
        <div class="attHead"><?php echo $this->_tpl_vars['attribute']['name']; ?>
</div>
        <div class="attAction">
         <input type="text" id="<?php echo $this->_tpl_vars['attribute']['att_id']; ?>
Value" class="inpMain" size="10" placeholder="<?php echo $this->_tpl_vars['lang']['attribute_value_value']; ?>
" />
         <input type="text" id="<?php echo $this->_tpl_vars['attribute']['att_id']; ?>
Remark" class="inpMain" size="10" placeholder="<?php echo $this->_tpl_vars['lang']['attribute_value_remark']; ?>
" />
         <input type="text" id="<?php echo $this->_tpl_vars['attribute']['att_id']; ?>
PriceChange" class="inpMain" size="3" placeholder="<?php echo $this->_tpl_vars['lang']['attribute_value_price_change']; ?>
" />
         <a href="javascript:;" class="btnAtt" onclick="attAction('add', '<?php echo $this->_tpl_vars['product']['id']; ?>
', '<?php echo $this->_tpl_vars['attribute']['att_id']; ?>
');"><?php echo $this->_tpl_vars['lang']['add']; ?>
</a>
        </div>
        <ul id="<?php echo $this->_tpl_vars['attribute']['att_id']; ?>
Html" class="attValue">
         <?php echo $this->_tpl_vars['attribute']['value_list']; ?>

        </ul>
        <?php endforeach; endif; unset($_from); ?>
       </div>
      </dd>
     </dl>
     <?php else: ?> 
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['product_model']; ?>
</dt>
      <dd> 
       <!-- FileBox -->
       <div class="modelBox">
        <div class="modelAdd">
         <input type="text" id="modelId" size="5" class="inpMain" autocomplete="off" placeholder="<?php echo $this->_tpl_vars['lang']['product_model_cue']; ?>
" />
         <a href="javascript:;" class="fa fa-plus" <?php if ($this->_tpl_vars['rec'] == 'edit'): ?>onclick="modelBox('add', '<?php echo $this->_tpl_vars['product']['id']; ?>
');"<?php else: ?>data-popup-id="cueBox" data-title="<?php echo $this->_tpl_vars['lang']['product_model_wrong']; ?>
" data-align="center"<?php endif; ?> title="<?php echo $this->_tpl_vars['lang']['product_model_title']; ?>
"></a> </div>
        <ul id="modelList" class="modelList">
         <?php echo $this->_tpl_vars['product']['model_list']; ?>

        </ul>
       </div>
       <!-- /FileBox --> 
      </dd>
     </dl>
     <?php endif; ?> 
     <?php if ($this->_tpl_vars['site']['stock']): ?>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['product_stock']; ?>
</dt>
      <dd>
       <input type="text" name="stock" value="<?php if ($this->_tpl_vars['rec'] == 'edit'): ?><?php echo $this->_tpl_vars['product']['stock']; ?>
<?php else: ?>100<?php endif; ?>" size="10" class="inpMain" />
      </dd>
     </dl>
     <?php endif; ?> 
     <?php if ($this->_tpl_vars['open']['point']): ?>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['product_point']; ?>
</dt>
      <dd>
       <input type="text" name="point" value="<?php if ($this->_tpl_vars['product']['point']): ?><?php echo $this->_tpl_vars['product']['point']; ?>
<?php else: ?>0<?php endif; ?>" size="10" class="inpMain" />
      </dd>
     </dl>
     <?php endif; ?> 
     <?php if ($this->_tpl_vars['open']['sort']): ?>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['sort']; ?>
</dt>
      <dd>
       <input type="text" name="sort" value="<?php if ($this->_tpl_vars['product']['sort']): ?><?php echo $this->_tpl_vars['product']['sort']; ?>
<?php else: ?>50<?php endif; ?>" size="5" class="inpMain" />
      </dd>
     </dl>
     <?php endif; ?>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['keywords']; ?>
</dt>
      <dd>
       <input type="text" name="keywords" value="<?php echo $this->_tpl_vars['product']['keywords']; ?>
" size="114" class="inpMain" />
       <span class="lang"><?php echo $this->_tpl_vars['btn_lang']['keywords']; ?>
</span>
      </dd>
     </dl>
     <dl>
      <dt><?php echo $this->_tpl_vars['lang']['description']; ?>
</dt>
      <dd>
       <textarea name="description" cols="115" rows="3" class="textArea" /><?php echo $this->_tpl_vars['product']['description']; ?>
</textarea>
       <p class="lang"><?php echo $this->_tpl_vars['btn_lang']['description']; ?>
</p>
     </dd>
     </dl>
     <dl>
      <?php if (! $this->_tpl_vars['open']['sort']): ?>
      <input type="hidden" name="sort" value="<?php if ($this->_tpl_vars['product']['sort']): ?><?php echo $this->_tpl_vars['product']['sort']; ?>
<?php else: ?>50<?php endif; ?>" />
      <?php endif; ?>
      <input type="hidden" name="token" value="<?php echo $this->_tpl_vars['token']; ?>
" />
      <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['product']['id']; ?>
">
      <input name="submit" class="btn" type="submit" value="<?php echo $this->_tpl_vars['lang']['btn_submit']; ?>
" />
     </dl>
    </div>
   </form>
   <?php endif; ?> 
   <?php if ($this->_tpl_vars['rec'] == 'thumb'): ?>
   <h3><a href="<?php echo $this->_tpl_vars['action_link']['href']; ?>
" class="actionBtn"><?php echo $this->_tpl_vars['action_link']['text']; ?>
</a><?php echo $this->_tpl_vars['ur_here']; ?>
</h3>
   <script type="text/javascript">
    <?php echo '
     function mask(i) {
        document.getElementById(\'mask\').innerHTML += i;
        document.getElementById(\'mask\').scrollTop = 100000000;
     }
     function success() {
        var d=document.getElementById(\'success\');
        d.style.display="block";
     }
    '; ?>

    </script>
   <dl id="maskBox">
    <dt><em><?php echo $this->_tpl_vars['mask']['count']; ?>
</em><?php if (! $this->_tpl_vars['mask']['confirm']): ?>
     <form action="product.php?rec=thumb" method="post">
      <input name="confirm" class="btn" type="submit" value="<?php echo $this->_tpl_vars['lang']['product_thumb_start']; ?>
" />
     </form>
     <?php endif; ?></dt>
    <dd class="maskBg"><?php echo $this->_tpl_vars['mask']['bg']; ?>
<i id="success"><?php echo $this->_tpl_vars['lang']['product_thumb_succes']; ?>
</i></dd>
    <dd id="mask"></dd>
   </dl>
   <?php endif; ?> 
  </div>
 </div>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
<?php if ($this->_tpl_vars['rec'] == 'default'): ?> 
<script type="text/javascript">
<?php echo 'onload = function() {document.forms[\'action\'].reset();}'; ?>

</script> 
<?php else: ?> 
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "filebox.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
<?php endif; ?> 
<?php if ($this->_tpl_vars['rec'] != 're_thumb'): ?>
</body>
</html>
<?php endif; ?>