<?php /* Smarty version 2.6.26, created on 2020-03-13 11:18:54
         compiled from setting.htm */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<link href="templates/images/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/images/jquery.min.js"></script>
<script type="text/javascript" src="templates/images/global.js"></script>
</head>
<body>
<div id="wrapper">
 <div class="logo"><a href="http://www.dou.co" target="_blank"><img src="templates/images/logo.gif" alt="DouPHP" title="DouPHP" /></a></div>
 <div class="setting">
  <div id="cue"></div>
  <form id="install" action="index.php?step=install" method="post">
   <ul>
    <h3><?php echo $this->_tpl_vars['lang']['setting_mysql']; ?>
</h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
      <td width="120"><strong><?php echo $this->_tpl_vars['lang']['setting_host']; ?>
：</strong></td>
      <td width="225">
       <input type="text" name="dbhost" id="dbhost" class="textInput" value="127.0.0.1"/>
      </td>
      <td><?php echo $this->_tpl_vars['lang']['setting_host_cue']; ?>
</td>
     </tr>
     <tr>
      <td><strong><?php echo $this->_tpl_vars['lang']['setting_dbuser']; ?>
：</strong></td>
      <td>
       <input name="dbuser" type="text" class="textInput"/>
      </td>
      <td><?php echo $this->_tpl_vars['lang']['setting_dbuser_cue']; ?>
</td>
     </tr>
     <tr>
      <td><strong><?php echo $this->_tpl_vars['lang']['setting_dbpass']; ?>
：</strong></td>
      <td>
       <input type="password" name="dbpass" class="textInput"/>
      </td>
      <td><?php echo $this->_tpl_vars['lang']['setting_dbpass_cue']; ?>
</td>
     </tr>
     <tr>
      <td><strong><?php echo $this->_tpl_vars['lang']['setting_dbname']; ?>
：</strong></td>
      <td>
       <input name="dbname" type="text" class="textInput"/>
      </td>
      <td><?php echo $this->_tpl_vars['lang']['setting_dbname_cue']; ?>
</td>
     </tr>
     <tr>
      <td><strong><?php echo $this->_tpl_vars['lang']['setting_prefix']; ?>
：</strong></td>
      <td>
       <input type="text" name="prefix" class="textInput" value="dou_"/>
      </td>
      <td><?php echo $this->_tpl_vars['lang']['setting_prefix_cue']; ?>
</td>
     </tr>
     <tr>
      <td><strong><?php echo $this->_tpl_vars['lang']['setting_test_data']; ?>
：</strong></td>
      <td height="30">
       <label>
        <input type="radio" name="test_data" value="yes" checked="true">
        <?php echo $this->_tpl_vars['lang']['setting_test_data_yes']; ?>
</label>
       <label>
        <input type="radio" name="test_data" value="no">
        <?php echo $this->_tpl_vars['lang']['setting_test_data_no']; ?>
</label>
      </td>
      <td><?php echo $this->_tpl_vars['lang']['setting_test_data_cue']; ?>
</td>
     </tr>
    </table>
    <h3><?php echo $this->_tpl_vars['lang']['setting_manager']; ?>
</h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
      <td width="120"><strong><?php echo $this->_tpl_vars['lang']['setting_username']; ?>
：</strong></td>
      <td width="225">
       <input name="username" type="text" class="textInput"/>
      </td>
      <td><?php echo $this->_tpl_vars['lang']['setting_username_cue']; ?>
</td>
     </tr>
     <tr>
      <td><strong><?php echo $this->_tpl_vars['lang']['setting_password']; ?>
：</strong></td>
      <td>
       <input type="password" name="password" class="textInput"/>
      </td>
      <td><?php echo $this->_tpl_vars['lang']['setting_password_cue']; ?>
</td>
     </tr>
     <tr>
      <td><strong><?php echo $this->_tpl_vars['lang']['setting_password_confirm']; ?>
：</strong></td>
      <td>
       <input type="password" name="password_confirm" class="textInput"/>
      </td>
      <td><?php echo $this->_tpl_vars['lang']['setting_password_confirm_cue']; ?>
</td>
     </tr>
     <tr>
      <td><strong><?php echo $this->_tpl_vars['lang']['setting_email']; ?>
：</strong></td>
      <td>
       <input name="email" type="text" class="textInput"/>
      </td>
      <td><?php echo $this->_tpl_vars['lang']['setting_email_cue']; ?>
</td>
     </tr>
    </table>
   </ul>
   <p class="action">
    <input type="button" class="btnGray" value="<?php echo $this->_tpl_vars['lang']['back']; ?>
" onclick="location.href='index.php?step=check'"/>
    <input type="button" class="btn" value="<?php echo $this->_tpl_vars['lang']['setting_submit']; ?>
" onclick="douSubmit('install')">
   </p>
  </form>
 </div>
</div>
</body>
</html>