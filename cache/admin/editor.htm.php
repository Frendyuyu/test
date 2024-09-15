<link href="include/umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="include/umeditor/umeditor.config.js"></script>
<script type="text/javascript" src="include/umeditor/umeditor.min.js"></script>
<script type="text/javascript" src="include/umeditor/lang/zh-cn/zh-cn.js"></script>
<div id="contentFile" class="fileBox">
 <ul class="fileBtn">
  <li class="btnFile" onclick="fileBox('content', 'editorId', '<?php echo $this->_tpl_vars['cur']; ?>
', '<?php echo $this->_tpl_vars['item_id']; ?>
');"><?php echo $this->_tpl_vars['lang']['file_insert_image']; ?>
</li>
  <li class="fileStatus" style="display:none"><img src="images/loader.gif" alt="uploading"/></li>
 </ul>
</div>
<script type="text/plain" id="editorId" name="content" class="editor"><?php echo $this->_tpl_vars['item_content']; ?>
</script>
<script type="text/javascript">var um = UM.getEditor('editorId')</script>