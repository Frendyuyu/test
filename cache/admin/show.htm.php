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
  <div id="subBox"> 
   <?php if ($this->_tpl_vars['open']['box'] || $this->_tpl_vars['open']['fragment']): ?>
   <div id="sMenu">
    <h3><i class="fa fa-picture-o"></i><?php echo $this->_tpl_vars['lang']['menu_site_home_other']; ?>
</h3>
    <ul>
     <li><a href="site_home.php"<?php if ($this->_tpl_vars['cur'] == 'site_home'): ?> class="cur"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['site_home']; ?>
</a></li>
     <li><a href="show.php"<?php if ($this->_tpl_vars['cur'] == 'show'): ?> class="cur"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['show']; ?>
</a></li>
     <?php if ($this->_tpl_vars['open']['fragment']): ?>
     <li><a href="fragment.php"<?php if ($this->_tpl_vars['cur'] == 'fragment'): ?> class="cur"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['fragment']; ?>
</a></li>
     <?php endif; ?> 
     <?php if ($this->_tpl_vars['open']['box']): ?>
     <li><a href="box.php"<?php if ($this->_tpl_vars['cur'] == 'box'): ?> class="cur"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['box']; ?>
</a></li>
     <?php endif; ?>
    </ul>
   </div>
   <?php endif; ?>
   <div <?php if ($this->_tpl_vars['open']['box'] || $this->_tpl_vars['open']['fragment']): ?>id="sMain"<?php endif; ?>>
    <div class="mainBox" style="<?php echo $this->_tpl_vars['workspace']['height']; ?>
">
     <h3><?php echo $this->_tpl_vars['ur_here']; ?>

      <p><?php echo $this->_tpl_vars['lang']['show_cue']; ?>
</p>
     </h3>
     <div class="simpleModule">
      <div class="left">
       <div class="title"><?php echo $this->_tpl_vars['lang']['show_add']; ?>
</div>
       <div class="formBox">
        <form action="show.php?rec=<?php if ($this->_tpl_vars['show']): ?>update<?php else: ?>insert<?php endif; ?>"<?php if ($this->_tpl_vars['show']): ?> class="formEdit"<?php endif; ?> method="post" enctype="multipart/form-data">
         <div class="formBasic">
          <dl>
           <dt><?php echo $this->_tpl_vars['lang']['show_name']; ?>
</dt>
           <dd>
            <input type="text" name="show_name" value="<?php echo $this->_tpl_vars['show']['show_name']; ?>
" size="40" class="inpMain" />
            <p class="lang"><?php echo $this->_tpl_vars['btn_lang']['show_name']; ?>
</p>
           </dd>
          </dl>
          <dl>
           <dt><?php echo $this->_tpl_vars['lang']['show_img']; ?>
</dt>
           <dd>
            <input type="file" name="show_img" class="inpFlie" />
            <?php if ($this->_tpl_vars['show']['show_img']): ?><a href="<?php echo $this->_tpl_vars['show']['show_img']; ?>
" target="_blank"><img src="images/icon_yes.png"></a><?php else: ?><?php endif; ?> 
            <p class="lang"><?php echo $this->_tpl_vars['btn_lang']['show_img']; ?>
</p>
            <p class="cue"><?php echo $this->_tpl_vars['setting']['theme']['banner_img_size']; ?>
</p>
           </dd>
          </dl>
          <dl>
           <dt><?php echo $this->_tpl_vars['lang']['show_link']; ?>
</dt>
           <input type="text" name="show_link" value="<?php echo $this->_tpl_vars['show']['show_link']; ?>
" size="40" class="inpMain" />
           </dd>
          </dl>
          <dl>
           <dt><?php echo $this->_tpl_vars['lang']['show_text']; ?>
</dt>
           <dd>
            <textarea name="show_text" cols="50" rows="4" class="textArea"><?php echo $this->_tpl_vars['show']['show_text']; ?>
</textarea>
            <p class="lang"><?php echo $this->_tpl_vars['btn_lang']['show_text']; ?>
</p>
           </dd>
          </dl>
          <dl>
           <dt><?php echo $this->_tpl_vars['lang']['sort']; ?>
</dt>
           <dd>
           <dd>
            <input type="text" name="sort" value="<?php if ($this->_tpl_vars['show']['sort']): ?><?php echo $this->_tpl_vars['show']['sort']; ?>
<?php else: ?>50<?php endif; ?>" size="20" class="inpMain" />
           </dd>
          </dl>
          <dl>
           <?php if ($this->_tpl_vars['show']): ?> 
           <a href="show.php" class="btnGray"><?php echo $this->_tpl_vars['lang']['cancel']; ?>
</a>
           <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['show']['id']; ?>
">
           <?php endif; ?>
           <input type="hidden" name="token" value="<?php echo $this->_tpl_vars['token']; ?>
" />
           <input name="submit" class="btn" type="submit" value="<?php echo $this->_tpl_vars['lang']['btn_submit']; ?>
" />
          </dl>
         </div>
        </form>
       </div>
      </div>
      <div class="right">
       <div class="title"><?php echo $this->_tpl_vars['lang']['show_list']; ?>
</div>
       <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tr>
         <td width="100"><b><?php echo $this->_tpl_vars['lang']['show_name']; ?>
</b></td>
         <td class="m-none"></td>
         <td width="50" align="center"><b><?php echo $this->_tpl_vars['lang']['sort']; ?>
</b></td>
         <td width="80" align="center"><b><?php echo $this->_tpl_vars['lang']['handler']; ?>
</b></td>
        </tr>
        <?php $_from = $this->_tpl_vars['show_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['show_list']):
?>
        
        <tr<?php if ($this->_tpl_vars['show_list']['id'] == $this->_tpl_vars['id']): ?> class="active"<?php endif; ?>>
        
        <td><a href="<?php echo $this->_tpl_vars['show_list']['show_img']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['show_list']['show_img']; ?>
" width="100" /></a></td>
         <td class="m-none"><?php echo $this->_tpl_vars['show_list']['show_name']; ?>
</td>
         <td align="center"><?php echo $this->_tpl_vars['show_list']['sort']; ?>
</td>
         <td align="center"><a href="show.php?rec=edit&id=<?php echo $this->_tpl_vars['show_list']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['edit']; ?>
</a> | <a href="show.php?rec=del&id=<?php echo $this->_tpl_vars['show_list']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['del']; ?>
</a></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
       </table>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
</body>
</html>