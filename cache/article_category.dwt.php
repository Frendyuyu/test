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
  <div class="row">
   <div class="col-md-2"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/article_tree.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
   <div class="col-md-10"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/ur_here.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div id="article-list"> 
     <?php $_from = $this->_tpl_vars['article_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['article_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['article_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['article']):
        $this->_foreach['article_list']['iteration']++;
?> 
     <dl<?php if (($this->_foreach['article_list']['iteration'] == $this->_foreach['article_list']['total'])): ?> class="last"<?php endif; ?>>
     <div class="num-date"> <em><?php echo $this->_tpl_vars['article']['click']; ?>
</em>
      <p><?php echo $this->_tpl_vars['article']['add_time_short']; ?>
</p>
     </div>
     <dt><a href="<?php echo $this->_tpl_vars['article']['url']; ?>
"><?php echo $this->_tpl_vars['article']['title']; ?>
</a></dt>
     <dd<?php if ($this->_tpl_vars['article']['image']): ?> class="have-img"<?php endif; ?>><?php if ($this->_tpl_vars['article']['image']): ?>
      <p class="img"><img src="<?php echo $this->_tpl_vars['article']['image']; ?>
" /></p>
      <?php endif; ?>
      <p class="desc"><?php echo $this->smarty_modifier_truncate($this->_tpl_vars['article']['description'], 96, "..."); ?>
</p>
     </dd>
     </dl>
     <?php endforeach; endif; unset($_from); ?> 
    </div>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/pager.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
   <div class="clear"></div>
  </div>
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