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
<link href="https://127.0.0.1/test/theme/default/css/swiper.min.css" rel="stylesheet" type="text/css" />
<link href="https://127.0.0.1/test/theme/default/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="https://127.0.0.1/test/theme/default/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/slide_show.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 <div id="index">
  <div class="index-box">
   <div class="container">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/about.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
   </div>
  </div>
  <?php if ($this->_tpl_vars['recommend_product']): ?>
  <div class="index-box bg">
   <h3><b><?php echo $this->_tpl_vars['lang']['product_news']; ?>
</b><em>Recommend Product</em></h3>
   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/recommend_product.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
   <div class="more"><a href="<?php echo $this->_tpl_vars['url']['product']; ?>
"><?php echo $this->_tpl_vars['lang']['product_more']; ?>
</a></div>
  </div>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['recommend_article']): ?>
  <div class="index-box">
   <h3><b><?php echo $this->_tpl_vars['lang']['article_news']; ?>
</b><em>Recommend News</em></h3>
   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/recommend_article.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
   <div class="more"><a href="<?php echo $this->_tpl_vars['url']['article']; ?>
"><?php echo $this->_tpl_vars['lang']['article_more']; ?>
</a></div>
  </div>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['open']['link']): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/link.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>
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
<script type="text/javascript" src="https://127.0.0.1/test/theme/default/js/swiper.min.js"></script>
<script type="text/javascript" src="https://127.0.0.1/test/theme/default/js/slide.show.js"></script>
<script type="text/javascript" src="https://127.0.0.1/test/theme/default/js/dou.js"></script>
<script type="text/javascript" src="https://127.0.0.1/test/theme/default/js/online_service.js"></script>
</body>
</html>