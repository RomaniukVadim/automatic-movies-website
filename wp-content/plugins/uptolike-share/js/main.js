//1.4.5 03/02/16
var onmessage = function (e) {
    if (e.data !== null && typeof e.data === 'object') {
        if ('ready' == e.data.action ){
            json = jQuery('input#uptolike_json').val();
            initConstr(json);
        }
        if (('json' in e.data) && ('code' in e.data)) {
            $('input#uptolike_json').val(e.data.json);
            $('#widget_code').val(e.data.code);
            jQuery('#settings_form').submit();
        }

        //$('iframe#stats_iframe').hide();
        //document.getElementById('stats_iframe').style.display = 'none';
        if (e.data.url.indexOf('statistics.html', 0) != -1) {
            switch (e.data.action) {
                case 'badCredentials':
                    //bad creds will show also when email and key is not entered yet
                    if (($('table input#uptolike_email').val() != '') && ($('table input.id_number').val() != '')) {
                        //document.location.hash = "stat";
                        hashChange('#stat');
                        //$('#bad_key_field').show();
                        document.getElementById('bad_key_field').style.display = 'table-row';
                        console.log('badCredentials');
                    }
                    break;
                case 'foreignAccess':
                    if (($('table input#uptolike_email').val() != '') && ($('table input.id_number').val() != '')) {
                        hashChange('#stat');

                        //$('#foreignAccess_field').show();
                        document.getElementById('foreignAccess_field').style.display = 'table-row';
                    }
                    console.log('foreignAccess');
                    break;
                case 'ready':
                    console.log('ready');
                    document.getElementById('stats_iframe').style.display = 'table-row';
                    //$('iframe#stats_iframe').show();
                    break;
                case 'resize':
                    console.log('ready');
                    //$('iframe#stats_iframe').show();
                    document.getElementById('stats_iframe').style.display = 'block';
                    //$('#key_auth_field').hide();
                    document.getElementById('key_auth_field').style.display = 'none';
                    //$('#cryptkey_field').hide();
                    document.getElementById('cryptkey_field').style.display = 'none';
                    //$('#email_tr').hide();
                    document.getElementById('email_tr').style.display = 'none';
                    //$('#after_key_req').hide();
                    document.getElementById('after_key_req').style.display = 'none';
                    break;
                default:
                    console.log(e.data.action);
            }
            // if (e.data.action == 'badCredentials') {
            //     $('#bad_key_field').show();
            // }
        }
        if ((e.data.url.indexOf('constructor.html', 0) != -1) && (typeof e.data.size != 'undefined')) {
            if (e.data.size != 0) document.getElementById("cons_iframe").style.height = e.data.size + 'px';
            //alert(e.data.size);
        }
        if ((e.data.url.indexOf('statistics.html', 0) != -1) && (typeof e.data.size != 'undefined')) {
            if (e.data.size != 0)  document.getElementById("stats_iframe").style.height = e.data.size + 'px';
        }
    }
};

if (typeof window.addEventListener != 'undefined') {
    window.addEventListener('message', onmessage, false);
} else if (typeof window.attachEvent != 'undefined') {
    window.attachEvent('onmessage', onmessage);
}
var getCode = function () {
    var win = document.getElementById("cons_iframe").contentWindow;
    win.postMessage({action: 'getCode'}, "*");
};
function initConstr(jsonStr) {
    var win = document.getElementById("cons_iframe").contentWindow;
    if ('' !== jsonStr) {
        win.postMessage({action: 'initialize', json: jsonStr}, "*");
    }

}
function emailEntered(){
    //$('#uptolike_email_field').css('background-color', 'lightgray');
    //$('#uptolike_email_field').prop('disabled', 'disabled');
    //$('#get_key_btn_field').hide();
    document.getElementById('get_key_btn_field').style.display = 'none';
    document.getElementById('after_key_req').style.display = 'table-row';
    //$('#after_key_req').show();
    //$('#before_key_req').hide();
    document.getElementById('before_key_req').style.display = 'none';
    //$('#cryptkey_field').show();
    document.getElementById('cryptkey_field').style.display = 'table-row';
    //$('#key_auth_field').show();
    document.getElementById('key_auth_field').style.display = 'table-row';
}

function regMe(my_mail) {
    site_url = $('#uptolike_site_url').html().replace('http://','').replace('https://','');
    str = jQuery.param({ email: my_mail,
        partner: 'cms',
        projectId: 'cms' + site_url.replace( new RegExp("^www.","gim"),"").replace(/\-/g, '').replace(/\./g, ''),
        url:site_url.replace( new RegExp("^www.","gim"),"")});
    dataURL = "https://uptolike.com/api/getCryptKeyWithUserReg.json";
    jQuery.getJSON(dataURL + "?" + str + "&callback=?", {}, function (result) {
        var jsonString = JSON.stringify(result);
        var result = JSON.parse(jsonString);
        if ('ALREADY_EXISTS' == result.statusCode) {
            alert('Пользователь с таким email уже зарегистрирован, обратитесь в службу поддержки.');
        } else if ('MAIL_SENDED' == result.statusCode) {
            alert('Ключ отправлен вам на email. Теперь необходимо ввести его в поле ниже.');
            emailEntered();
        } else if ('ILLEGAL_ARGUMENTS' == result.statusCode) {
            alert('Email указан неверно.')
        }
    });
}

function hashChange(hsh) {
    //var hsh = ;
    if (('#stat' == hsh) || ('#cons' == hsh)) {
        $('.nav-tab-wrapper a').removeClass('nav-tab-active');
        $('.wrapper-tab').removeClass('active');
        $('#con_' + hsh.slice(1)).addClass('active');
        $('a.nav-tab#' + hsh.slice(1)).addClass('nav-tab-active');
        /*
         /*if ('#reg' == hsh) {
         $('.reg_btn').show();
         $('.reg_block').show();
         $('.enter_btn').hide();
         $('.enter_block').hide();
         }
         if ('#enter' == hsh) {
         $('.reg_btn').hide();
         $('.reg_block').hide();
         $('.enter_btn').show();
         $('.enter_block').show();
         }*/
    }
}

window.onhashchange = function() {
    hashChange(document.location.hash);
};

jQuery(document).ready(function () {
    $ = jQuery;
    if ($('table input#uptolike_email').val() != ''){
        $('#uptolike_email_field').val($('table input#uptolike_email').val());
        emailEntered();
    }
    if (($('table input#uptolike_email').val() != '') && ($('table input.id_number').val() == '')) {
        //document.location.hash = "stat";
        hashChange('#stat');
    }

    $('input.id_number').css('width','520px');//fix
    $('.uptolike_email').val($('#uptolike_email').val())//init fields with hidden value (server email)
    $('#uptolike_cryptkey').attr('value', $('table input.id_number').val());
    $('div.enter_block').hide();
    $('div.reg_block').hide();
    $('.reg_btn').click(function(){
        $('.reg_block').toggle('fast');
        $('.enter_btn').toggle('fast');
    });
    $('.enter_btn').click(function(){
        $('.enter_block').toggle('fast');
        $('.reg_btn').toggle('fast');
    });
    //getkey
    $('button#get_key').click(function(){
        //my_email = $('.reg_block .uptolike_email').val();
        my_email = $('#uptolike_email_field').val();
        regMe(my_email);
        // my_key = $('.enter_block input.id_number').val();
        //$('table input.id_number').attr('value',my_key);
        $('table input#uptolike_email').attr('value',my_email);
        $('#settings_form').submit();
    });
    //auth
    $('button#auth').click(function(){
        my_email = $('#uptolike_email_field').val();
        my_key = $('#uptolike_cryptkey').val();
        $('table input.id_number').attr('value',my_key);
        $('table input#uptolike_email').attr('value',my_email);
        $('#settings_form').submit();
    });
    //if unregged user
    if ($('.id_number').val() == '') {
        $('#uptolike_email').after('<button type="button" onclick="regMe();">Зарегистрироваться</button>');
        json = $('input#uptolike_json').val();
        initConstr(json);
    }
    $('#widget_code').parent().parent().attr('style', 'display:none');
    $('#uptolike_json').parent().parent().attr('style', 'display:none');
    $('table .id_number').parent().parent().attr('style', 'display:none');
    $('#uptolike_email').parent().parent().attr('style', 'display:none');

    $('.nav-tab-wrapper a').click(function (e) {
        e.preventDefault();
        var click_id = $(this).attr('id');
        if (click_id != $('.nav-tab-wrapper a.nav-tab-active').attr('id')) {
            $('.nav-tab-wrapper a').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');
            $('.wrapper-tab').removeClass('active');
            $('#con_' + click_id).addClass('active');
        }
    });

    hashChange();
    $.getScript( "https://uptolike.com/api/getsession.json" )
        .done(function( script, textStatus ) {
            $('iframe#cons_iframe').attr('src',$('iframe#cons_iframe').attr('data-src'));
            $('iframe#stats_iframe').attr('src',$('iframe#stats_iframe').attr('data-src'));
        });

});
