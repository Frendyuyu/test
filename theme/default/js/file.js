/**
 +----------------------------------------------------------
 * 文件盒子.文件上传
 +----------------------------------------------------------
 */
function fileBox(type, target, module, item_id, img_width = '800') {
    if ($('#' + type + 'Form').length == 0) {
        var form = 
           '<form action="' + root_url + module + '.php?rec=filebox" id="' + type + 'Form" enctype="multipart/form-data" style="display:none">'
           + '<input id="' + type + 'Field" type="file" name="' + type + '_file">'
           + '<input type="hidden" name="item_id" value="' + item_id + '">'
         + '</form>';
        $("body").append(form);
    }
   
    var status = $('#' + type + 'File .fileStatus');
    var btn = $('#' + type + 'File .btnFile');
    var field = $('#' + type + 'Field');
    var target = target ? target : 'content'; // 适配旧版
    
    // 点击文件域
    field.click();
    
    // 选择文件后文件域状态改变，开始提交表单
    field.off("change").on("change",function() {
        // 还要判断文件域是否为空
        if($(this).val() != '') { 
            $('#' + type + 'Form').ajaxForm({
                type: 'POST',
                data: {'type':type, 'img_width':img_width},
                beforeSubmit: function() {
                    status.show();
                    btn.hide();
                },
                success: function(html) {
                    // 如果是添加详情图片则插入到编辑器
                    if (type == 'content') {
                        if (html.indexOf('<img') >= 0 ) { 
                            UM.getEditor(target).execCommand('insertHtml', html);
                        } else {
                            alert(html);
                        }
                    } else {
                        $('#' + target).html(html);
                    }
                    status.hide();
                    btn.show();
                },
                error: function() {
                    status.hide();
                    btn.show();
                },
                clearForm: true
            }).submit();
         
            // 每次执行后要清空文件域
            field.val('');
        } 
   })
}

/**
 +----------------------------------------------------------
 * 文件盒子.文件删除
 +----------------------------------------------------------
 */
function fileDel(number, target, module) {
    var target = $('#' + target);
    
    $.ajax({
        type: "POST",
        url: root_url + module + '.php?rec=filedel',
        data: {"number":number},
        dataType: "html",
        success: function(html) {
            target.html(html);
        }
    });
}