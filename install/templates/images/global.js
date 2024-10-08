/**
/**
 +----------------------------------------------------------
 * 表单提交
 +----------------------------------------------------------
 */
function douSubmit(form_id) {
    var formParam = $("#"+form_id).serialize(); //序列化表格内容为字符串
    
    $.ajax({
        type: "POST",
        url: $("#"+form_id).attr("action")+'&do=callback',
        data: formParam,
        dataType: "html",
        success: function(html) {
            if (!html) {
                $("#"+form_id).submit();
            } else {
                $("#cue").html(html);
            }
        }
    });
}

/**
 +----------------------------------------------------------
 * 切换主机
 +----------------------------------------------------------
 */
function changeHost(target = 'dbhost') {
    var value = document.getElementById(target).value;
    if (value == 'localhost') {
        document.getElementById(target).value = '127.0.0.1';
    } else {
        document.getElementById(target).value = 'localhost';
    }
}