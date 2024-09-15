/**
 +----------------------------------------------------------
 * 短信发送
 +----------------------------------------------------------
 */
function sendCaptcha(type, account, captcha_token, check = 'no_allow_phone_exist') {
    var account = $('#' + account).val();
    $.ajax({
        url: root_url + 'captcha.php?rec=verification',
        type: "POST",
        async: false,
        data: {'type': type, 'account': account, 'captcha_token': captcha_token, 'check': check},
        success: function(data) {
           if (data == "success") {
                time();
            } else {
                alert(data);
            }
        }
    });
} 

/**
 +----------------------------------------------------------
 * 倒计时
 +----------------------------------------------------------
 */
var wait = 60;
function time() {
    var btn = $('#btnCaptcha');
    if(wait == 0) {
        btn.removeAttr("disabled");
        btn.val('获取验证码');
        wait = 60;
    } else {
        btn.attr("disabled",true);
        btn.val("重新发送(" + wait + ")");
        wait--;
        setTimeout(function() {
            time(btn)
        },
        1000)
    }
}
