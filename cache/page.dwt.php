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
<?php if ($this->_tpl_vars['editor_mode']): ?>
<link href="https://127.0.0.1/test/theme/default/css/jquery.notebook.min.css" rel="stylesheet" />
<?php endif; ?>
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
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/page_tree.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
   <div class="col-md-10"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/ur_here.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div id="page">
     <h1><?php echo $this->_tpl_vars['page']['page_name']; ?>
</h1>
     <div class="content<?php if ($this->_tpl_vars['editor_mode']): ?> visualize-box<?php endif; ?>"> <?php echo $this->_tpl_vars['page']['content']; ?>
 </div>
    </div>
   </div>
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
<?php if ($this->_tpl_vars['editor_mode']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/jquery_notebook.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
</body>
</html>