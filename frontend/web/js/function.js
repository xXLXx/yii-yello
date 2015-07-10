$(document).ready(function() {
    //Select
    var params = {
        changedEl: ".j_select",
        visRows:4,
        scrollArrows:false
    }
    cuSel(params);
    $(window).load(function() {
        if($("body .j_select").size() > 0) {
            var zindex = 100;
            $ (".j_select").each (function ()
            {
                $ (this).css ("z-index", zindex);
                zindex -- ;
            });
        }
    });
    
    //Placeholder
    $('.j_placeholder').each(function(){
		new Placeholder($(this));
	});
    
    //Header
    if($("body .j_fix_header").size() > 0) {
        blockPosition($(".j_fix_header"));
        $(window).scroll(function() {
            blockPosition($(".j_fix_header"));
        });
    }
    
    //Checkbox
    $(document).on("click", ".j_checkbox", function() {
        if($(this).hasClass("active")) {
            $(this).removeClass("active");
        } else {
            $(this).addClass("active");
        }
    });
    
    //Radio
    $(document).on("click", ".j_radio", function() {
        $(this).parents(".j_radio_container").find(".j_radio").removeClass("active");
        $(this).addClass("active");
    });
    
    //Input change text type to password type
    if($("html").hasClass("ie8")) {} else {
        $(".j_text_pass_shift").focusin(function() {
            $(this).attr("type","password");
        }).focusout(function() {
            if(trim($(".j_text_pass_shift").val()) == '') {
                $(this).attr("type","text");
            }
        });
    }
    
    //Toggle popup
    $(document).on("click", ".j_toggle_link", function() {
        $(this).parents(".j_toggle_container").find(".j_toggle_block").toggle();
    });
    $ (document).click (function (e)
    {
        var target = $ (e.target);
        if (target.is ('.j_toggle_container') || target.parents ('.j_toggle_container').length) {
        } else {
            $ ('.j_toggle_block').hide();
        }
    });
    
    //Popup
    colorBoxInit = function() {
        if($("body .j_colorbox").size() > 0 || 
            $("body .j_colorbox_close").size() > 0 || 
            $("body .j_colorbox_photo").size() > 0) {
            var colorboxParams = {
                opacity:0.75,
                title:false,
                scrolling:false,
                close:"",
                onComplete: function() {
                    var params = {
                        changedEl: ".j_select",
                        visRows:3,
                        scrollArrows:false
                    }
                    cuSel(params);
                    $(".j_colorbox_live").colorbox(colorboxParams);
                    $('.j_placeholder').each(function() {
                        new Placeholder($(this));
                    });
                }
            }
            $(".j_colorbox").colorbox(colorboxParams);
        }
    };
    colorBoxInit();
    
    $(document).on("click", ".j_colorbox_close", function() {
        $.colorbox.close();
        return false;
    });
    
    function trim(str) {
        return str.replace(/^\s+|\s+$/g, '');
    }
    
    //Scrollpane
    if($("body .j_scrollpane").size() > 0) {
        $(".j_scrollpane").jScrollPane();
    }

    $(document).ready(
        $('#request-password-reset-form').on('beforeSubmit', function(event, jqXHR, settings) {
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                success: function(data) {
                    if (data.status === 'ok') {
                        $('.j_reset_item').toggle();
                    } else if (data.status === 'error') {
                        var error = data.message.email[0];
                        form.find('.error-message').text(error);
                    } else {
                        form.find('.error-message').text('Unknown error. Contact admin please.');
                    }
                }
            });
            return false;
        })
    );
});

function Placeholder(container){
	var _this = this;
	this.container = $(container);
	var placeholder = this.container.attr('alt');
	this.container.removeAttr('placeholder');
	
	setTimeout(function() {
		if (trim(_this.container.val()) == '' || trim(_this.container.val()) == placeholder) {
			_this.container.addClass('placeholder').val(placeholder);
		}
	}, 1);
	
	this.container.bind({
		focus: function(){
			if (trim(_this.container.val()) == placeholder) {
				_this.container.removeClass('placeholder').val('');
			}
		},
		focusout: function() {
			setTimeout(function() {
				if (trim(_this.container.val()) == '') {
					_this.container.addClass('placeholder').val(placeholder);
				}
			}, 1);
		}
	});
	function trim(str) {
		return str.replace(/^\s+|\s+$/g, '');
	}
}

function blockPosition(block) {
    var scroll = $(window).scrollTop();
    if(scroll > 0){
        block.addClass("fixed");
    } else {
        block.removeClass("fixed");
    }
}
