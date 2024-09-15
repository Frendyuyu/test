$(function() {
    // 表单提交
    $('#popupFormBtn').on("click",function() {
        $('#popupForm').ajaxForm({
            type: 'POST',
            data: {},
            dataType: 'json',
            success: function(data) {
                $('#' + data.id).addClass("cur");
                $('.popup').remove();
                $('.popup-bg').remove();
            },
            error: function() {
                alert('操作失败');
            },
            clearForm: true
        }).submit();
    })
});