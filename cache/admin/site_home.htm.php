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
<script type="text/javascript" src="images/slide.js"></script>
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
 <i class="fa fa-angle-right"></i></p>
     </h3>
     <div id="siteHome">
      <div class="fragmentList"> 
       <div class="area-box">
        <div class="item">
         <div class="name"><?php echo $this->_tpl_vars['lang']['site_logo']; ?>
</div>
         <div class="content"><img src="<?php echo $this->_tpl_vars['site']['root_url']; ?>
/theme/<?php echo $this->_tpl_vars['site']['site_theme']; ?>
/images/<?php echo $this->_tpl_vars['site']['site_logo']; ?>
" alt="<?php echo $this->_tpl_vars['site']['site_name']; ?>
" /></div>
         <div class="edit"><a href="system.php?light=site_logo"><?php echo $this->_tpl_vars['lang']['edit']; ?>
</a></div>
        </div>
       </div>
       <div class="slideBox">
        <ul class="slideShow">
         <?php $_from = $this->_tpl_vars['show_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['show_list']):
?>
         <li><a href="show.php?rec=edit&id=<?php echo $this->_tpl_vars['show_list']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['show_list']['show_img']; ?>
" alt="<?php echo $this->_tpl_vars['show_list']['show_name']; ?>
"><span><em><?php echo $this->_tpl_vars['lang']['edit']; ?>
</em></span></a></li>
         <?php endforeach; endif; unset($_from); ?>
        </ul>
       </div>
       <?php $_from = $this->_tpl_vars['fragment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fragment_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fragment_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['fragment']):
        $this->_foreach['fragment_list']['iteration']++;
?>
       <div class="area-box<?php if ($this->_foreach['fragment_list']['iteration'] % 2 == 0): ?> bg<?php endif; ?>">
        <div class="item">
         <div class="name parent"><?php echo $this->_tpl_vars['fragment']['name']; ?>
</div>
         <div class="content"><?php echo $this->_tpl_vars['fragment']['content']; ?>
</div>
         <div class="edit"><a href="fragment.php?rec=edit&id=<?php echo $this->_tpl_vars['fragment']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['edit']; ?>
</a></div>
        </div>
        <?php $_from = $this->_tpl_vars['fragment']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?>
        <div class="item">
         <div class="name"><?php echo $this->_tpl_vars['child']['name']; ?>
</div>
         <div class="content"><?php echo $this->_tpl_vars['child']['content']; ?>
</div>
         <div class="edit"><a href="fragment.php?rec=edit&id=<?php echo $this->_tpl_vars['child']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['edit']; ?>
</a></div>
        </div>
        <?php endforeach; endif; unset($_from); ?>
        <?php $_from = $this->_tpl_vars['fragment']['box_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['box']):
?>
        <div class="item">
         <div class="name"><?php echo $this->_tpl_vars['box']['name']; ?>
</div>
         <div class="content"><?php echo $this->_tpl_vars['box']['text']; ?>
</div>
         <div class="edit"><a href="box.php?rec=edit&id=<?php echo $this->_tpl_vars['box']['id']; ?>
"><?php echo $this->_tpl_vars['lang']['edit']; ?>
</a></div>
        </div>
        <?php endforeach; endif; unset($_from); ?>
       </div>
       <?php endforeach; endif; unset($_from); ?> 
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
<script type="text/javascript">
<?php echo '
$(function() {
	$(\'.slideShow\').responsiveSlides({
  auto: false,
		pager: true,
		nav: true,
		namespace: \'slide\',
	});
});
'; ?>

</script>
</body>
</html>