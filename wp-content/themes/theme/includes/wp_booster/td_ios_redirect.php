<?php
td_js_buffer::add_to_header("\n" . "

//themeforest iframe removal code - used only on demo
var td_is_safari = false;
var td_is_ios = false;
var td_is_windows_phone = false;



var ua = navigator.userAgent.toLowerCase();

var td_is_android = ua.indexOf('android') > -1;

if (ua.indexOf('safari')!=-1){
    if(ua.indexOf('chrome')  > -1){

    }else{
        td_is_safari = true;
    }
}

if(navigator.userAgent.match(/(iPhone|iPod|iPad)/i)) {
    td_is_ios = true;
}

if (navigator.userAgent.match(/Windows Phone/i)) {
    td_is_windows_phone = true;
}

if(td_is_ios || td_is_safari || td_is_windows_phone || td_is_android) {
    if (top.location != location) {
        top.location.replace('" . TD_THEME_DEMO_URL . "/');
    }
}
    ");