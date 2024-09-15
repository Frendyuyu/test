<form action="file.php?rec=box&module=<?php echo $this->_tpl_vars['cur']; ?>
" id="fileBoxForm" enctype="multipart/form-data" style="display:none">
 <input id="fileBoxField" type="file" name="filebox_file">
 <input type="hidden" name="item_id" value="<?php echo $this->_tpl_vars['item_id']; ?>
">
</form>