/*
 * jQuery Reveal Plugin 1.0
 * www.ZURB.com
 * Copyright 2010, ZURB
 * Free to use under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
*/

$(function() {
    $('a[data-popup-id]').on('click', function(e) {
        e.preventDefault(); // 防止链接打开 URL
     
        // 初始化
        var popupId = $(this).attr('data-popup-id'); // 返回data-popup-id值
        var mode = $(this).attr('data-mode'); // 模式
        var title = $(this).attr('data-title');
        
        // 表单提交
        if (mode != 'html' && $('#' + popupId).length == 0) {
            if (popupId == 'langBox') {
                // 初始化
                var language_pack = $(this).attr('data-lang');
                var module = $(this).attr('data-module');
                var item_id = $(this).attr('data-item-id');
                var field = $(this).attr('data-field');
                var token = $(this).attr('data-token');
                var type = $(this).attr('data-type');
                
                $(this).attr('id', language_pack + '_' + field);
     
                $.ajax({
                    type: 'POST',
                    url: 'language_value.php?rec=value',
                    data: {'language_pack':language_pack, 'module':module, 'item_id':item_id, 'field':field, 'type':type},
                    dataType: 'html',
                    success: function(value) {
                        // 表单部分
                        if (type == 'content') {
                            var popupEditorId = Date.parse(new Date());
                            var option = 
                                '<div id="contentFile" class="fileBox"><ul class="fileBtn"><li class="btnFile" onclick="fileBox(\'content\', \'' + popupEditorId + '\', \'' + module + '\', \'' + item_id + '\');">插入图片</li><li class="fileStatus" style="display:none"><img src="images/loader.gif" alt="uploading"/></li></ul></div>'
                              + '<script type="text/plain" id="' + popupEditorId + '" name="value" class="editor">' + value + '</script>'
                              + '<script type="text/javascript">var um = UM.getEditor(\'' + popupEditorId + '\')</script>';
                        } else if (type == 'file') {
                            var option = '<input type="file" name="value" size="38" class="inpFlie" />';
                            if (value) {
                                var option = option + '<a href="' + value + '" target="_blank"><img class="icon" src="images/icon_yes.png"></a>';
                            } else {
                                var option = option + '<img class="icon" src="images/icon_no.png">';
                            }
                        } else if (type == 'textarea') {
                            var option = '<textarea name="value" cols="115" rows="3" class="textArea">' + value + '</textarea>';
                        } else {
                            var option = '<input type="text" name="value" class="inpMain" value="' + value + '" size="20" />';
                        }
                        
                        var content = 
                            '<div class="content">'
                            + '<form id="popupForm" action="language_value.php?rec=insert" method="post" enctype="multipart/form-data">'
                              + option
                              + '<input type="hidden" name="language_pack" value="' + language_pack + '" />'
                              + '<input type="hidden" name="module" value="' + module + '" />'
                              + '<input type="hidden" name="item_id" value="' + item_id + '" />'
                              + '<input type="hidden" name="field" value="' + field + '" />'
                              + '<input type="hidden" name="token" value="' + token + '" />'
                              + '<input type="hidden" name="type" value="' + type + '" />'
                              + '<input id="popupFormBtn" name="submit" class="btn" type="button" value="提交" />'
                            + '</form>'
                          + '</div>'
                          + '<script type="text/javascript" src="images/popup.form.js"></script>';
                        
                        // 弹出框代码
                        var popupHtml = '<div id="' + popupId + '" class="popup big">'
                                   + '<div class="title">' + title + '</div>'
                                   + content
                                   + '<a class="close-popup">×</a>'
                                 + '</div>';
                        $("body").append(popupHtml);
                     
                        $('#'+popupId).reveal($(this).data()); // 引用reveal方法
                    }
                });
            } else {
                // 初始化
                var text = $(this).attr('data-text');
                var btnName = $(this).attr('data-btn-name');
                var btnLink = $(this).attr('data-btn-link');
                var align = $(this).attr('data-align');
                
                if (text) {
                    var content = '<div class="content">' + text + '</div>';
                }
             
                if (btnName) {
                    var action = '<div class="action"><a href="' + btnLink + '" class="btn">' + btnName + '</a></div>';
                }
                
                // 弹出框代码
                var popupHtml = '<div id="' + popupId + '" class="popup ' + align + '">'
                           + '<div class="title">' + title + '</div>'
                           + (content ? content : '')
                           + (action ? action : '')
                           + '<a class="close-popup">×</a>'
                         + '</div>';
                $("body").append(popupHtml);
             
                $('#'+popupId).reveal($(this).data()); // 引用reveal方法
            }
        }
        
        
    });

    // 对jquery扩展了一个reveal方法
    $.fn.reveal = function(options) {
        var defaults = {  
            animationspeed: 300, // 动画过场速度
            closeonbackgroundclick: true, // 点击背景时关闭弹窗
            dismissmodalclass: 'close-popup' // 关闭按钮的样式名
        }; 
        
        // 获取设置选项，例如options.abc可以获取data-abc的值
        var options = $.extend({}, defaults, options);
     
        return this.each(function() {
            var modal = $(this),
                topMeasure  = parseInt(modal.css('top')),
                locked = false,
                modalBG = $('.popup-bg');
            
            if(modalBG.length == 0) {
                modalBG = $('<div class="popup-bg" />').insertAfter(modal);
            }            
     
            // 进场动画
            modal.bind('reveal:open', function () {
              modalBG.unbind('click.modalEvent');
                $('.' + options.dismissmodalclass).unbind('click.modalEvent');
                if(!locked) {
                    lockModal();
                    
                    // 渐渐显示
                    modal.css({'opacity' : 0, 'visibility' : 'visible', 'top': $(document).scrollTop()+topMeasure});
                    modalBG.fadeIn(options.animationspeed/2);
                    modal.delay(options.animationspeed/2).animate({
                        "opacity" : 1
                    }, options.animationspeed,unlockModal());                    
                }
                modal.unbind('reveal:open');
            });     

            // 关闭动画
            modal.bind('reveal:close', function () {
              if(!locked) {
                    lockModal();
               
                    // 渐渐关闭
                    modalBG.delay(options.animationspeed).fadeOut(options.animationspeed);
                    modal.animate({
                        "opacity" : 0
                    }, options.animationspeed, function() {
                        modal.css({'opacity' : 1, 'visibility' : 'hidden', 'top' : topMeasure});
                        unlockModal();
                    });                    
                }
                modal.unbind('reveal:close');
                
                // 关闭后删掉元素
                if (options.mode != 'html') {
                    modal.remove();
                    modalBG.remove();
                }
            });     
       
            // 立即执行打开事件
            modal.trigger('reveal:open')
            
            // 关闭按钮绑定关闭事件
            var closeButton = $('.' + options.dismissmodalclass).bind('click.modalEvent', function () {
              modal.trigger('reveal:close')
            });
            
            if(options.closeonbackgroundclick) {
                modalBG.css({"cursor":"pointer"})
                modalBG.bind('click.modalEvent', function () {
                  modal.trigger('reveal:close')
                });
            }
            $('body').keyup(function(e) {
                if(e.which===27){ modal.trigger('reveal:close'); } // 27 is the keycode for the Escape key
            });
            
            function unlockModal() { 
                locked = false;
            }
            function lockModal() {
                locked = true;
            }    
            
        });//each call
    }//orbit plugin call
});