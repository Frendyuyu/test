/**
 +----------------------------------------------------------
 * Bootstrap Navbar 一级菜单改为可以点击
 +----------------------------------------------------------
 */
$(document).ready(function() {
    /* 顶部导航 */
    $("ul.top-nav li.parent").hover(function() {
        $(this).addClass("hover");
        $('ul:first', this).css('display', 'block');
    },
    function() {
        $(this).removeClass("hover");
        $('ul:first', this).css('display', 'none');
    });
    
    // 恢复父级菜单可点击
    if ($(window).width() > 768) {
         $(document).off('click.bs.dropdown.data-api');
    }
    
    // 增加三级菜单支持
    $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
        if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        var $subMenu = $(this).next(".dropdown-menu");
        $subMenu.toggleClass('show');


        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
            $('.dropdown-submenu .show').removeClass("show");
        });
     
        return false;
    });

    // navbar一定高度后置顶固定
    if ($('.navbar').hasClass("scroll")) {
        $(window).on("scroll", function(){
            var scrollTop = $(window).scrollTop();
            var navbarHeight = $('.navbar').outerHeight();
            
            if (scrollTop > navbarHeight){
                $(".navbar.scroll").addClass("fix");
            } else {
                $(".navbar.scroll").removeClass("fix");
            }
        });
    }
});

/**
 +----------------------------------------------------------
 * 刷新验证码
 +----------------------------------------------------------
 */
function refreshimage() {
    var cap = document.getElementById("vcode");
    cap.src = cap.src + '?';
}

/**
 +----------------------------------------------------------
 * 表单提交
 +----------------------------------------------------------
 */
function douSubmit(form_id, callback) {
    var callback = arguments[1] ? arguments[1] : 'json';
    var formParam = $("#"+form_id).serialize(); //序列化表格内容为字符串
    
    $.ajax({
        type: "POST",
        url: $("#"+form_id).attr("action")+'&do=callback',
        data: formParam,
        dataType: "json",
        success: function(form) {
            if (!form) {
                $("#"+form_id).submit();
            } else {
                for(var key in form) {
                    if (callback == 'alert') {
                        if (form[key]) {
                            alert(form[key]);
                            break;
                        }
                    } else {
                        $("#"+key).html(form[key]);
                    }
                }
            }
        },   
        error:function (data, status, e){   
          alert("error");   
        }
    });
}

/**
 +----------------------------------------------------------
 * 弹出确认提示
 +----------------------------------------------------------
 */
function douConfirm(url, msg) {
    if (confirm(msg)) {
        window.location.href = url;
    }
}

/**
 +----------------------------------------------------------
 * 清空对象内HTML
 +----------------------------------------------------------
 */
function douRemove(target) {
    var obj = document.getElementById(target);
    obj.parentNode.removeChild(obj);
}

/**
 +----------------------------------------------------------
 * 收藏本站
 +----------------------------------------------------------
 */
function AddFavorite(url, title) {
    try {
        window.external.addFavorite(url, title)
    } catch(e) {
        try {
            window.sidebar.addPanel(title, url, "")
        } catch(e) {
            alert("加入收藏失败，请使用Ctrl+D进行添加")
        }
    }
}