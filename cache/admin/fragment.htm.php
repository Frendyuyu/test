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
   <div id="sMenu">
    <h3><i class="fa fa-picture-o"></i><?php echo $this->_tpl_vars['lang']['menu_site_home_other']; ?>
</h3>
    <ul>
     <li><a href="site_home.php"<?php if ($this->_tpl_vars['cur'] == 'site_home'): ?> class="cur"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['site_home']; ?>
</a></li>
     <li><a href="show.php"<?php if ($this->_tpl_vars['cur'] == 'show'): ?> class="cur"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['show']; ?>
</a></li>
     <li><a href="fragment.php"<?php if ($this->_tpl_vars['cur'] == 'fragment'): ?> class="cur"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['fragment']; ?>
</a></li>
     <?php if ($this->_tpl_vars['open']['box']): ?>
     <li><a href="box.php"<?php if ($this->_tpl_vars['cur'] == 'box'): ?> class="cur"<?php endif; ?>><?php echo $this->_tpl_vars['lang']['box']; ?>
</a></li>
     <?php endif; ?>
    </ul>
   </div>
   <div id="sMain">
    <div id="siteHome" class="mainBox" style="<?php echo $this->_tpl_vars['workspace']['height']; ?>
">
     <h3>
      <a href="<?php echo $this->_tpl_vars['action_link']['href']; ?>
" class="actionBtn"><?php echo $this->_tpl_vars['action_link']['text']; ?>
</a>
      <?php if ($this->_tpl_vars['rec'] == 'edit'): ?>
      <?php if ($this->_tpl_vars['fragment']['lock'] == '0'): ?>
      <a href="fragment.php?rec=del&id=<?php echo $this->_tpl_vars['fragment']['id']; ?>
" class="actionBtn gray"><?php echo $this->_tpl_vars['lang']['del']; ?>
</a>
      <?php endif; ?>
      <a href="javascript:;" class="actionBtn gray" data-popup-id="linkBox" data-title="<?php echo $this->_tpl_vars['link_box']['title']; ?>
" data-text="<?php echo $this->_tpl_vars['link_box']['text']; ?>
" data-btn-name="<?php echo $this->_tpl_vars['link_box']['btn_name']; ?>
" data-btn-link="<?php echo $this->_tpl_vars['link_box']['btn_link']; ?>
"><?php echo $this->_tpl_vars['link_box']['action']; ?>
</a>
      <?php endif; ?>
      <?php echo $this->_tpl_vars['ur_here']; ?>

     </h3>
     <?php if ($this->_tpl_vars['rec'] == 'default'): ?>
     <div class="fragmentList"> 
      <?php $_from = $this->_tpl_vars['fragment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fragment_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fragment_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['fragment']):
        $this->_foreach['fragment_list']['iteration']++;
?>
      <div class="area-box<?php if ($this->_foreach['fragment_list']['iteration'] % 2 == 0): ?> bg<?php endif; ?>">
       <div class="item">
        <div class="name"><?php echo $this->_tpl_vars['fragment']['name']; ?>
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
     <?php endif; ?> 
     <?php if ($this->_tpl_vars['rec'] == 'add' || $this->_tpl_vars['rec'] == 'edit'): ?>
     <div class="simpleModule big">
      <div class="left">
       <div class="formBox">
        <form action="fragment.php?rec=<?php echo $this->_tpl_vars['form_action']; ?>
" method="post" enctype="multipart/form-data">
         <div class="formBasic">
          <dl>
           <dt><?php echo $this->_tpl_vars['lang']['fragment_name']; ?>
</dt>
           <dd>
            <input type="text" name="name" value="<?php echo $this->_tpl_vars['fragment']['name']; ?>
" size="40" class="inpMain" />
            <span class="lang"><?php echo $this->_tpl_vars['btn_lang']['name']; ?>
</span>
            <p class="cue"><?php echo $this->_tpl_vars['lang']['fragment_name_cue']; ?>
</p>
           </dd>
          </dl>
          <dl>
           <dt><?php echo $this->_tpl_vars['lang']['fragment_mark']; ?>
</dt>
           <dd>
            <input type="text" name="mark" value="<?php echo $this->_tpl_vars['fragment']['mark']; ?>
" size="40" class="inpMain" />
            <p class="cue"><?php echo $this->_tpl_vars['lang']['fragment_mark_cue']; ?>
</p>
           </dd>
          </dl>
          <dl>
           <dt><?php echo $this->_tpl_vars['lang']['fragment_image']; ?>
</dt>
           <dd>
            <div class="image"> 
             <?php if ($this->_tpl_vars['fragment']['image']): ?> 
             <a href="<?php echo $this->_tpl_vars['fragment']['image']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['fragment']['image']; ?>
" height="100" /></a> 
             <?php endif; ?>
             <p>
              <input type="file" name="image" />
              <p class="lang"><?php echo $this->_tpl_vars['btn_lang']['image']; ?>
</p>
             </p>
            </div>
            <p class="cue"><?php echo $this->_tpl_vars['lang']['fragment_image_cue']; ?>
</p>
           </dd>
          </dl>
          <dl>
           <dt><?php echo $this->_tpl_vars['lang']['fragment_text']; ?>
</dt>
           <dd>
            <textarea name="text" cols="92" rows="4" class="textArea"><?php echo $this->_tpl_vars['fragment']['text']; ?>
</textarea>
            <p class="lang"><?php echo $this->_tpl_vars['btn_lang']['text']; ?>
</p>
            <p class="cue"><?php echo $this->_tpl_vars['lang']['fragment_text_cue']; ?>
</p>
           </dd>
          </dl>
          <dl>
           <dt><?php echo $this->_tpl_vars['lang']['fragment_link']; ?>
</dt>
           <dd>
            <input type="text" name="link" value="<?php echo $this->_tpl_vars['fragment']['link']; ?>
" size="90" class="inpMain" />
            <span class="lang"><?php echo $this->_tpl_vars['btn_lang']['link']; ?>
</span>
            <p class="cue"><?php echo $this->_tpl_vars['lang']['fragment_link_cue']; ?>
</p>
           </dd>
          </dl>
          <dl>
           <dt><?php echo $this->_tpl_vars['lang']['fragment_home']; ?>
</dt>
           <dd>
            <label for="home_1">
             <input type="radio" name="home" id="home_1" value="1"<?php if ($this->_tpl_vars['fragment']['home'] == '1' || ! $this->_tpl_vars['fragment']['home']): ?> checked="true"<?php endif; ?>>
             <?php echo $this->_tpl_vars['lang']['yes']; ?>
</label>
            <label for="home_0">
             <input type="radio" name="home" id="home_0" value="0"<?php if ($this->_tpl_vars['fragment']['home'] == '0'): ?> checked="true"<?php endif; ?>>
             <?php echo $this->_tpl_vars['lang']['no']; ?>
</label>
           </dd>
          </dl>
          <dl>
           <dt><?php echo $this->_tpl_vars['lang']['fragment_parent']; ?>
</dt>
           <dd>
            <select name="parent_id">
             <option value="0"><?php echo $this->_tpl_vars['lang']['empty']; ?>
</option>
             <?php $_from = $this->_tpl_vars['fragment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?> 
             <?php if ($this->_tpl_vars['list']['id'] == $this->_tpl_vars['fragment']['parent_id']): ?>
             <option value="<?php echo $this->_tpl_vars['list']['id']; ?>
" selected="selected"><?php echo $this->_tpl_vars['list']['name']; ?>
</option>
             <?php else: ?>
             <option value="<?php echo $this->_tpl_vars['list']['id']; ?>
"><?php echo $this->_tpl_vars['list']['name']; ?>
</option>
             <?php endif; ?> 
             <?php endforeach; endif; unset($_from); ?>
            </select>
            <span class="cue"><?php echo $this->_tpl_vars['lang']['fragment_parent_cue']; ?>
</span></dd>
          </dl>
          <dl>
           <input type="hidden" name="token" value="<?php echo $this->_tpl_vars['token']; ?>
" />
           <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['fragment']['id']; ?>
">
           <input name="submit" class="btn" type="submit" value="<?php echo $this->_tpl_vars['lang']['btn_submit']; ?>
" />
          </dl>
         </div>
        </form>
       </div>
      </div>
      <?php if ($this->_tpl_vars['fragment']['box']): ?>
      <div class="right">
       <div class="title"><?php echo $this->_tpl_vars['lang']['box_list']; ?>
</div>
       <div class="fragmentList inPage">
        <div class="area-box"> 
         <?php $_from = $this->_tpl_vars['box_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
       </div>
      </div>
      <?php endif; ?> 
     </div>
     <?php endif; ?> 
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