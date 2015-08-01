// site specific functions to be replaced with fancy stuff 
function returnconfirm(opt) {
    return opt;
}


var Vanilla = new function() {

    this.notificationProvider = window.notifyProvider !== undefined ? window.notifyProvider : "Toast";
    this.hotkeyset = window.hotkeys !== undefined ? window.hotkeys : null;

    // javascript alerts and notifications
    // default is toastr, adapt your custom notificaitons in the switcher.
    this.notify = function(msg, title, duration, msgtype, customoptions) {

        switch (this.notificationProvider) {
        default: // toastr
            if (msgtype == undefined) {
                msgtype = 'info';
            }
            var notifier = eval('toastr.' + msgtype.toLowerCase());

            if (duration !== undefined && !isNaN(duration)) {
                if (title == undefined) {
                    notifier(msg, { displayDuration: duration });
                } else {
                    notifier(msg, title, { displayDuration: duration });
                }
            } else {
                if (title == undefined) {
                    notifier(msg);
//                            toastr.success(msg);
                } else {
                    notifier(msg, title);
                }
            }
            break;

        }

        // sticky success with title

    }


    this.success = function(msg, title, duration, customoptions) {

        switch (this.notificationProvider) {
        default: // toastr
            var notifier = eval('toastr.success');

            if (duration !== undefined && !isNaN(duration)) {
                if (title == undefined) {
                    notifier(msg, { displayDuration: duration });
                } else {
                    notifier(msg, title, { displayDuration: duration });
                }
            } else {
                if (title == undefined) {
                    notifier(msg);
                    //                            toastr.success(msg);
                } else {
                    notifier(msg, title);
                }
            }
            break;

        }

        // sticky success with title

    }

    // keyboard shortcuts

    this.errormsg = function(msg, ismodal) {
        if (ismodal == 1) {
            this.notify(msg, "Error", 0, "error");
        } else {
            this.notify(msg, "Error", 4000, "error");
        }
    }

    this.errmsg = this.errormsg;

    this.alert = function(msg, callback) {
        bootbox.alert(msg, callback);
    }

    this.confirm = function(msg, callback) {
        nativeConfirm(msg);
    }

    this.prompt = function(msg, callback) {
        bootbox.prompt(msg, callback);

    }

    this.loadersmallwide = '<div id="fountainG"><div id="fountainG_1" class="fountainG"></div><div id="fountainG_2" class="fountainG"></div><div id="fountainG_3" class="fountainG"></div><div id="fountainG_4" class="fountainG"></div><div id="fountainG_5" class="fountainG"></div><div id="fountainG_6" class="fountainG"></div><div id="fountainG_7" class="fountainG"></div><div id="fountainG_8" class="fountainG"></div></div>';
       
    


    this.divloading = function (divid, msg) {
        if (msg !== undefined) {
            msg = "<br />" + msg;
        } else {
            msg = "";
        }
        var theparent = $(divid);
        var w = parseInt($(theparent).css('width'));
        var h = parseInt($(theparent).css('height'));
        var adjustparent = false;
        if (w < 300) {
            w = 300;
            adjustparent = true;
        }
        if (h < 120) {
            h = 120;
            adjustparent = true;
        }
        if (adjustparent) {
            $(theparent).css({ "position": "relative", "min-height":"120px" });
        }

        var loadingdiv = "<div class='loading-container' style='width:"+w+";height:"+h+";' ><img src=\"/Content/Img/ajax-loader.gif\" class=\"ajax-loader\" />" + msg + "</div>";
        $(theparent).html(loadingdiv);
    }


// not used yet.
    this.hotkeys = {
        addHotKey: function(thecode, keys, keyaction) {
            if (window.hotkeyset == undefined || window.hotkeyset == null) {
                window.hotkeyset = new Array();
            }
            window.hotkeyset[window.hotkeyset.length] = {
                keycode: thecode,
                useAlt: (keys.toLowerCase().indexOf("alt") > -1),
                useCtrl: (keys.toLowerCase().indexOf("ctrl") > -1),
                useShift: (keys.toLowerCase().indexOf("shift") > -1),
                action: keyaction
            }

        },
        Erect: function() {

            window.onkeydown = function(e) {
                e = e || window.event; // because of Internet Explorer quirks...
                k = e.which || e.charCode || e.keyCode; // because of browser differences...

                for (i = 0; i < window.hotkeyset.length; i++) {
                    if (k == window.hotkeyset[i].keycode && e.altKey == window.hotkeyset[i].useAlt && e.ctrlKey == window.hotkeyset[i].useCtrl && e.shiftKey == window.hotkeyset[i].useShift) {
                        eval(window.hotkeyset[i].action + '');
                        return false;
                    }
                    //var ms = 'Key: ' + k + " - spec: " + e.keycode + ", result: ";// + k == set[i].keycode + "";
                    //ms += 'Alt: ' + e.altKey + " - spec: " + set[i].useAlt + ", result: ";//+ e.altKey == set[i].useAlt + "";
                    //ms += 'Ctrl: ' + e.ctrlKey + " - spec: " + set[i].useCtrl + ", result: ";// + e.ctrlKey == set[i].useCtrl + "";
                    //ms += 'Shift: ' + e.shiftKey + " - spec: " + set[i].useShift + ", result: ";//+ e.shiftKey == set[i].useShift + "";
                    //Vanilla.notify(ms,"",2000,"error");
                }
                return true;
                //if (k == 65 && e.altKey && !e.ctrlKey && !e.shiftKey) {
                //    $("#myModal").modal('toggle');
                //} else {
                //    return true; // it's not a key we recognize, move on...
                //}
                //return false; // we processed the event, stop now.

            }

        },
        specialKeys: {
            8: "backspace",
            9: "tab",
            13: "return",
            16: "shift",
            17: "ctrl",
            18: "alt",
            19: "pause",
            20: "capslock",
            27: "esc",
            32: "space",
            33: "pageup",
            34: "pagedown",
            35: "end",
            36: "home",
            37: "left",
            38: "up",
            39: "right",
            40: "down",
            45: "insert",
            46: "del",
            96: "0",
            97: "1",
            98: "2",
            99: "3",
            100: "4",
            101: "5",
            102: "6",
            103: "7",
            104: "8",
            105: "9",
            106: "*",
            107: "+",
            109: "-",
            110: ".",
            111: "/",
            112: "f1",
            113: "f2",
            114: "f3",
            115: "f4",
            116: "f5",
            117: "f6",
            118: "f7",
            119: "f8",
            120: "f9",
            121: "f10",
            122: "f11",
            123: "f12",
            144: "numlock",
            145: "scroll",
            188: ",",
            190: ".",
            191: "/",
            224: "meta"
        },
        shiftNums: {
            "`": "~",
            "1": "!",
            "2": "@",
            "3": "#",
            "4": "$",
            "5": "%",
            "6": "^",
            "7": "&",
            "8": "*",
            "9": "(",
            "0": ")",
            "-": "_",
            "=": "+",
            ";": ": ",
            "'": "\"",
            ",": "<",
            ".": ">",
            "/": "?",
            "\\": "|"
        }


    }




    // instigate hotkeys when hotkeys array is found on page.
    //hotkeys = new Array();
    //hotkeys[hotkeys.length] = {  // alt+a opens log form
    //    keycode: 65, // a
    //    useAlt: true,
    //    useCtrl: false,
    //    useShift: false,
    //    action: " $('#myModal').modal('toggle')"
    //};
    //$(document).ready(function() {

    //    if (Vanilla.hotkeyset !== undefined && Vanilla.hotkeyset != null) {

    //        if (Vanilla.hotkeyset.length > 0) {


    //        }

    //    } 

    //});


}


(function ($) {
    // vanilla jquery plugins
    // disableSubmit - sets button to disabled while keeping the width. Options are text (override "Saving...") and replaceclass: eg "btn-primary,btn-default" will replace remove first and add second. if only one class is specified, it will be added.
    // enableSubmit - enables a submit button. option is text - if supplied, will replace existing text, otherwise data-enabled will be used, but if that doesn't exist, the text will remain unchanged.
    // hasAttr - returns whether an object has an attribute.

    $.fn.hasAttr = function (name) {
        return this.attr(name) !== undefined;
    };


    $.fn.disableSubmit = function (options) {

        var settings = $.extend({
            // These are the defaults.
            replaceclass: null,
            text: "Saving..."
        }, options);
        if (settings.replaceclass != null) {
            var fromto = settings.replaceclass.split(",");
            if (fromto.length > 1) {
                this.removeClass(fromto[0]);
            }
            this.addClass(fromto[1]);
        }
        var tw = this.innerWidth();
        this.prop("disabled", true);
        //console.log(this);
        this.attr("data-enabledval", this.val());
        if (this.prop("value").length > settings.text.length) {
            this.innerWidth(tw);
        }

        return this.val(settings.text);
    };


    $.fn.enableSubmit = function (options) {

        var settings = $.extend({
            // These are the defaults.
            text: null
        }, options);
        if (settings.text != null) {
            this.val(settings.text);
        } else {
            if ($(this).hasAttr('data-enabledval')) {
                this.val(this.data('enabledval'));
            } else {
                $(this).val($(this).attr("value"));
            }
        }
        this.prop("disabled", false);
        return this;
    };


    $.fn.disableButton = function (options) {
        var settings = $.extend({
            // These are the defaults.
            text: ""
        }, options);
        var tw = this.innerWidth();
        this.addClass("disabled");
        if (this.text().length > settings.text.length) {
            this.innerWidth(tw);
        }
        if (settings.text != "") {
            return this.text(settings.text);
        } else {
            return this;
        }
    };


    $.fn.enableButton = function (options) {

        var settings = $.extend({
            // These are the defaults.
            text: ""
        }, options);
        if (settings.text != "") {
            this.text(settings.text);
        } else {
            if ($(this).hasAttr('data-enabledval')) {
                this.text(this.data('enabledval'));
            }
        }
        this.removeClass("disabled");
            return this;
    };



}(jQuery));


$(document).ready(function(){
    bootstrapButtonDisablers();
    
});

function bootstrapButtonDisablers(){
$('body').on('beforeSubmit', 'form', function() {
    var form = $(this);
    if (form.find('.has-error').length) {
                    $(this+".disableme").each(function () {
                        if (this.tagName=="SUBMIT") {
                                $(this).enableSubmit({ text: msg });
                        } else {
                            $(this).enableButton({ text: msg });
                        }
                    });
    }else{
                $(".disableme").each(function () {
                        var msg = "Loading...";
                        if (typeof $(this).data("disabledmsg") != 'undefined') {
                            msg = $(this).data("disabledmsg");
                        }
                        if (this.tagName=="SUBMIT") {
                                $(this).disableSubmit({ text: msg });
                        } else {
                            $(this).disableButton({ text: msg });
                        }
                    });        
    }
  });    
  }