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
<div id="wrapper"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 <div class="container mb">
  <div class="row">
   <div class="col-md-2"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/product_tree.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
   <div class="col-md-10"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/ur_here.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div id="product">
     <div class="product-img">
      <?php if ($this->_tpl_vars['product']['gallery_list']): ?>
      <div class="swiper-container gallery-top">
       <div class="swiper-wrapper">
        <?php $_from = $this->_tpl_vars['product']['gallery_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['gallery'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gallery']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['gallery']):
        $this->_foreach['gallery']['iteration']++;
?>
        <div class="swiper-slide"><img src="<?php echo $this->_tpl_vars['gallery']['file']; ?>
" /></div>
        <?php endforeach; endif; unset($_from); ?>
       </div>
       <div class="swiper-button-next swiper-button-white"></div>
       <div class="swiper-button-prev swiper-button-white"></div>
      </div>
      <div class="swiper-container gallery-thumbs">
       <div class="swiper-wrapper">
        <?php $_from = $this->_tpl_vars['product']['gallery_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['gallery'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gallery']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['gallery']):
        $this->_foreach['gallery']['iteration']++;
?>
        <div class="swiper-slide"><img src="<?php echo $this->_tpl_vars['gallery']['file']; ?>
" /></div>
        <?php endforeach; endif; unset($_from); ?>
       </div>
      </div>
      <?php else: ?>
      <a href="<?php echo $this->_tpl_vars['product']['image']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['product']['image']; ?>
" width="300" /></a>
      <?php endif; ?>
     </div>
     <div class="product-info">
      <h1><?php echo $this->_tpl_vars['product']['name']; ?>
</h1>
      <ul>
       <?php if ($this->_tpl_vars['site']['show_price']): ?>
       <li class="product-price"><?php echo $this->_tpl_vars['lang']['price']; ?>
：<?php if ($this->_tpl_vars['product']['level_price']): ?><em class="price"><?php echo $this->_tpl_vars['product']['level_price']; ?>
</em><em class="price-line"><?php echo $this->_tpl_vars['product']['price']; ?>
</em><?php else: ?><em class="price"><?php echo $this->_tpl_vars['product']['price']; ?>
</em><?php endif; ?></li>
       <?php endif; ?>
       <?php $_from = $this->_tpl_vars['defined']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['defined'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['defined']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['defined']):
        $this->_foreach['defined']['iteration']++;
?>
       <li><?php echo $this->_tpl_vars['defined']['arr']; ?>
：<?php echo $this->_tpl_vars['defined']['value']; ?>
</li>
       <?php endforeach; endif; unset($_from); ?>
       <?php if ($this->_tpl_vars['product']['model_list']): ?>
       <li>
        <?php echo $this->_tpl_vars['lang']['product_model']; ?>
：
        <p class="model-list">
         <?php $_from = $this->_tpl_vars['product']['model_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['model']):
?>
         <a<?php if ($this->_tpl_vars['model']['cur']): ?> class="cur"<?php endif; ?> href="<?php echo $this->_tpl_vars['model']['url']; ?>
" title="<?php echo $this->_tpl_vars['model']['name']; ?>
"><img src="<?php echo $this->_tpl_vars['model']['thumb']; ?>
" alt="<?php echo $this->_tpl_vars['model']['name']; ?>
" /><i><?php echo $this->_tpl_vars['model']['name']; ?>
</i></a>
         <?php endforeach; endif; unset($_from); ?>
        </p>
       </li>
       <?php endif; ?>
      </ul>
      <?php if ($this->_tpl_vars['open']['order']): ?>
      <div class="buy-box">
       <form action="<?php echo $this->_tpl_vars['site']['root_url']; ?>
order.php?rec=insert" method="post">
        <?php if ($this->_tpl_vars['open']['attribute']): ?>
        <div class="attribute-list"> 
         <?php $_from = $this->_tpl_vars['product']['attribute_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['attribute']):
?>
         <dl>
          <dt><?php echo $this->_tpl_vars['attribute']['name']; ?>
</dt>
          <dd class="radio-box"> 
           <?php $_from = $this->_tpl_vars['attribute']['value_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['value_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['value_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['value_list']['iteration']++;
?>
           <label title="<?php echo $this->_tpl_vars['item']['remark']; ?>
" for="att_<?php echo $this->_tpl_vars['attribute']['att_id']; ?>
_<?php echo $this->_tpl_vars['item']['id']; ?>
">
            <input type="radio" name="att_<?php echo $this->_tpl_vars['attribute']['att_id']; ?>
" id="att_<?php echo $this->_tpl_vars['attribute']['att_id']; ?>
_<?php echo $this->_tpl_vars['item']['id']; ?>
" value="<?php echo $this->_tpl_vars['item']['id']; ?>
" <?php if (($this->_foreach['value_list']['iteration'] <= 1)): ?> checked="true"<?php endif; ?>>
            <span><?php if ($this->_tpl_vars['item']['image']): ?><i><img src="<?php echo $this->_tpl_vars['item']['image']; ?>
" /></i><?php endif; ?><em><?php echo $this->_tpl_vars['item']['value']; ?>
<?php echo $this->_tpl_vars['item']['price_change_format']; ?>
</em></span> </label>
           <?php endforeach; endif; unset($_from); ?> 
          </dd>
         </dl>
         <?php endforeach; endif; unset($_from); ?> 
        </div>
        <?php endif; ?>
        <input type="hidden" name="module" value="product" />
        <input type="hidden" name="item_id" value="<?php echo $this->_tpl_vars['product']['id']; ?>
" />
        <input type="hidden" name="number" value="1" />
        <input type="submit" name="submit" class="add-to-cart" value="<?php echo $this->_tpl_vars['lang']['order_addtocart']; ?>
" />
       </form>
      </div>
      <?php else: ?>
      <div class="btn-ask"> 
       <?php if ($this->_tpl_vars['site']['qq']['0']['number']): ?> 
       <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $this->_tpl_vars['site']['qq']['0']['number']; ?>
&amp;site=qq&amp;menu=yes" target="_blank"><i class="fa fa-qq"></i><?php echo $this->_tpl_vars['lang']['online_qq']; ?>
</a> 
       <?php endif; ?> 
      </div>
      <?php endif; ?> 
     </div>
     <div class="clear"></div>
     <div class="product-content">
      <h3><?php echo $this->_tpl_vars['lang']['product_content']; ?>
</h3>
      <ul>
       <?php echo $this->_tpl_vars['product']['content']; ?>

      </ul>
     </div>
    </div>
    <?php if ($this->_tpl_vars['open']['comment']): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/comment.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
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
<script type="text/javascript" src="https://127.0.0.1/test/theme/default/js/swiper.min.js"></script>
<script type="text/javascript" src="https://127.0.0.1/test/theme/default/js/slide.product.js"></script>
<script type="text/javascript" src="https://127.0.0.1/test/theme/default/js/dou.js"></script>
<script type="text/javascript" src="https://127.0.0.1/test/theme/default/js/online_service.js"></script>
</body>
</html>