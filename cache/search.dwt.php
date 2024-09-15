<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="<?php echo $this->_tpl_vars['keywords']; ?>
" />
<meta name="description" content="<?php echo $this->_tpl_vars['description']; ?>
" />
<meta name="generator" content="<?php echo $this->_tpl_vars['generator']; ?>
" />
<title><?php echo $this->_tpl_vars['page_title']; ?>
</title>
<link href="<?php echo $this->_tpl_vars['site']['root_url']; ?>
favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="https://127.0.0.1/test/theme/default/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://127.0.0.1/test/theme/default/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="https://127.0.0.1/test/theme/default/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 <div class="container mb"> 
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/ur_here.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <div id="search-list"> 
   <?php $_from = $this->_tpl_vars['search_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['search_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['search_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['search_list']['iteration']++;
?> 
   <dl<?php if (($this->_foreach['search_list']['iteration'] == $this->_foreach['search_list']['total'])): ?> class="last"<?php endif; ?>>
    <div class="date"> <em><?php echo $this->_tpl_vars['item']['time']['d']; ?>
</em>
     <p><?php echo $this->_tpl_vars['item']['time']['y']; ?>
-<?php echo $this->_tpl_vars['item']['time']['m']; ?>
</p>
    </div>
    <dt><a href="<?php echo $this->_tpl_vars['item']['url']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a></dt>
    <dd<?php if ($this->_tpl_vars['item']['image']): ?> class="have-img"<?php endif; ?>><?php if ($this->_tpl_vars['item']['image']): ?>
     <p class="img"><img src="<?php echo $this->_tpl_vars['item']['image']; ?>
"></p>
     <?php endif; ?>
     <p class="desc"><?php echo $this->smarty_modifier_truncate($this->_tpl_vars['item']['description'], 100, "..."); ?>
</p>
    </dd>
   </dl>
   <?php endforeach; endif; unset($_from); ?> 
  </div>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/pager.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 </div> 
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/online_service.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
<script type="text/javascript" src="https://127.0.0.1/test/theme/default/js/jquery.min.js"></script>
<script type="text/javascript" src="https://127.0.0.1/test/theme/default/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://127.0.0.1/test/theme/default/js/dou.js"></script>
<script type="text/javascript" src="https://127.0.0.1/test/theme/default/js/online_service.js"></script>
</body>
</html>