<header id="header">
 <div class="top d-none d-lg-block">
  <div class="container">
   <ul class="top-nav">
    <?php if ($this->_tpl_vars['open']['language']): ?>
    <li class="parent lang-select"><a href="javascript:;"><?php echo $this->_tpl_vars['lang']['cur_language']; ?>
</a>
     <ul>
      <?php $_from = $this->_tpl_vars['lang_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lang_menu']):
?>
      <li><a href="<?php echo $this->_tpl_vars['lang_menu']['url']; ?>
"><?php echo $this->_tpl_vars['lang_menu']['name']; ?>
</a></li>
      <?php endforeach; endif; unset($_from); ?>
     </ul>
    </li>
    <?php endif; ?> 
    <?php $_from = $this->_tpl_vars['nav_top_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nav']):
?>
    <li<?php if ($this->_tpl_vars['nav']['child']): ?> class="parent"<?php endif; ?>>
     <a href="<?php echo $this->_tpl_vars['nav']['url']; ?>
"<?php if ($this->_tpl_vars['nav']['target']): ?> target="_blank"<?php endif; ?>><?php echo $this->_tpl_vars['nav']['nav_name']; ?>
</a>
     <?php if ($this->_tpl_vars['nav']['child']): ?>
     <ul>
      <?php $_from = $this->_tpl_vars['nav']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?>
      <li><a href="<?php echo $this->_tpl_vars['child']['url']; ?>
"><?php echo $this->_tpl_vars['child']['nav_name']; ?>
</a></li>
      <?php endforeach; endif; unset($_from); ?>
     </ul>
     <?php endif; ?> 
    </li>
    <?php endforeach; endif; unset($_from); ?>
    <li><a href="javascript:AddFavorite('<?php echo $this->_tpl_vars['site']['home_url']; ?>
', '<?php echo $this->_tpl_vars['site']['site_name']; ?>
')"><?php echo $this->_tpl_vars['lang']['add_favorite']; ?>
</a></li>
    <?php if ($this->_tpl_vars['open']['user']): ?> 
    <?php if ($this->_tpl_vars['global_user']): ?>
    <li><a href="<?php echo $this->_tpl_vars['url']['user']; ?>
"><?php echo $this->_tpl_vars['global_user']['user_name']; ?>
，<?php echo $this->_tpl_vars['lang']['user_welcom_top']; ?>
</a></li>
    <li><a href="<?php echo $this->_tpl_vars['url']['logout']; ?>
"><?php echo $this->_tpl_vars['lang']['user_logout']; ?>
</a></li>
    <?php else: ?>
    <li><a href="<?php echo $this->_tpl_vars['url']['login']; ?>
"><?php echo $this->_tpl_vars['lang']['user_login_nav']; ?>
</a></li>
    <li><a href="<?php echo $this->_tpl_vars['url']['register']; ?>
"><?php echo $this->_tpl_vars['lang']['user_register_nav']; ?>
</a></li>
    <?php endif; ?> 
    <?php endif; ?>
   </ul>
   <ul class="search">
    <div class="search-box">
     <form method="get" action="<?php echo $this->_tpl_vars['site']['home_url']; ?>
">
      <input name="s" type="text" class="keyword" value="<?php echo $this->smarty_modifier_escape($this->_tpl_vars['keyword']); ?>
" placeholder="<?php echo $this->_tpl_vars['lang']['search_placeholder']; ?>
" size="25">
      <input type="submit" class="btnSearch" value="<?php echo $this->_tpl_vars['lang']['btn_submit']; ?>
">
     </form>
    </div>
   </ul>
  </div>
 </div>
 <nav class="navbar navbar-expand-lg">
  <div class="container">
   <div class="navbar-brand"> <a href="<?php echo $this->_tpl_vars['site']['home_url']; ?>
" class="logo"><img src="https://127.0.0.1/test/theme/default/images/<?php echo $this->_tpl_vars['site']['site_logo']; ?>
" alt="<?php echo $this->_tpl_vars['site']['site_name']; ?>
" /></a> </div>
   <div class="navbar-action d-lg-none"> 
    <?php if ($this->_tpl_vars['open']['user']): ?> 
    <a href="<?php echo $this->_tpl_vars['url']['user']; ?>
" class="fa fa-user-circle-o"></a> 
    <?php endif; ?>
    <button type="button" class="menu" data-toggle="collapse" data-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation"> <span class="fa fa-bars"></span> </button>
   </div>
   <div class="main-nav collapse navbar-collapse justify-content-lg-end" id="main-nav">
    <ul class="navbar-nav">
     <li class="nav-item<?php if ($this->_tpl_vars['index']['cur']): ?> active<?php endif; ?>"> <a class="nav-link" href="<?php echo $this->_tpl_vars['site']['home_url']; ?>
"><?php echo $this->_tpl_vars['lang']['home']; ?>
</a></li>
     <?php $_from = $this->_tpl_vars['nav_middle_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['nav_middle_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_middle_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['nav']):
        $this->_foreach['nav_middle_list']['iteration']++;
?>
     <li class="nav-item<?php if ($this->_tpl_vars['nav']['child']): ?> dropdown<?php endif; ?><?php if ($this->_tpl_vars['nav']['cur']): ?> active<?php endif; ?>"> <a href="<?php echo $this->_tpl_vars['nav']['url']; ?>
" class="nav-link<?php if ($this->_tpl_vars['nav']['child']): ?> dropdown-toggle<?php endif; ?><?php if ($this->_tpl_vars['nav']['cur']): ?> active<?php endif; ?>" <?php if ($this->_tpl_vars['nav']['child']): ?> data-toggle="dropdown"<?php endif; ?> aria-haspopup="true" aria-expanded="false"<?php if ($this->_tpl_vars['nav']['target']): ?> target="_blank"<?php endif; ?>><?php echo $this->_tpl_vars['nav']['nav_name']; ?>
</a> 
      <?php if ($this->_tpl_vars['nav']['child']): ?>
      <ul class="dropdown-menu">
       <?php $_from = $this->_tpl_vars['nav']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?> 
       <li<?php if ($this->_tpl_vars['child']['child']): ?> class="dropdown"<?php endif; ?>> <a href="<?php echo $this->_tpl_vars['child']['url']; ?>
" class="dropdown-item<?php if ($this->_tpl_vars['child']['child']): ?> dropdown-toggle<?php endif; ?>" <?php if ($this->_tpl_vars['child']['child']): ?> data-toggle="dropdown"<?php endif; ?>><?php echo $this->_tpl_vars['child']['nav_name']; ?>
</a> 
        <?php if ($this->_tpl_vars['child']['child']): ?>
        <ul class="dropdown-menu">
         <?php $_from = $this->_tpl_vars['child']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['children']):
?> 
         <li<?php if ($this->_tpl_vars['children']['child']): ?> class="dropdown"<?php endif; ?>> <a class="dropdown-item<?php if ($this->_tpl_vars['children']['child']): ?> dropdown-toggle<?php endif; ?>" href="<?php echo $this->_tpl_vars['children']['url']; ?>
"><?php echo $this->_tpl_vars['children']['nav_name']; ?>
</a> 
          <?php if ($this->_tpl_vars['children']['child']): ?>
          <ul class="dropdown-menu">
           <?php $_from = $this->_tpl_vars['children']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
           <li><a class="dropdown-item" href="<?php echo $this->_tpl_vars['item']['url']; ?>
"><?php echo $this->_tpl_vars['item']['nav_name']; ?>
</a></li>
           <?php endforeach; endif; unset($_from); ?>
          </ul>
          <?php endif; ?>
         </li>
         <?php endforeach; endif; unset($_from); ?>
        </ul>
        <?php endif; ?>
       </li>
       <?php endforeach; endif; unset($_from); ?>
      </ul>
      <?php endif; ?>
     </li>
     <?php endforeach; endif; unset($_from); ?>
     <?php if ($this->_tpl_vars['open']['language']): ?>
     <li class="nav-item dropdown d-md-none">
      <a href="javascript:;" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $this->_tpl_vars['lang']['cur_language']; ?>
</a> 
      <ul class="dropdown-menu">
       <?php $_from = $this->_tpl_vars['lang_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
       <li> <a href="<?php echo $this->_tpl_vars['item']['url']; ?>
" class="dropdown-item"}><?php echo $this->_tpl_vars['item']['name']; ?>
</a> 
       <?php endforeach; endif; unset($_from); ?>
      </ul>
     </li>
     <?php endif; ?> 
    </ul>
    <form class="form-inline my-2 my-lg-0 d-md-none" action="<?php echo $this->_tpl_vars['site']['home_url']; ?>
">
     <input class="form-control mr-sm-2" name="s" type="text" value="<?php echo $this->smarty_modifier_escape($this->_tpl_vars['keyword']); ?>
" placeholder="<?php echo $this->_tpl_vars['lang']['search_placeholder']; ?>
">
     <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?php echo $this->_tpl_vars['lang']['btn_submit']; ?>
</button>
    </form>
   </div>
  </div>
 </nav>
</header>