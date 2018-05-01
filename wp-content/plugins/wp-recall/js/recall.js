
jQuery(window).load(function() {
    jQuery(document.body).bind("drop", function(e){
        e.preventDefault();
    });
});

function rcl_get_value_url_params(){
    var tmp_1 = new Array();
    var tmp_2 = new Array();
    var rcl_url_params = new Array();
    var get = location.search;
    if(get !== ''){
        tmp_1 = (get.substr(1)).split('&');
        for(var i=0; i < tmp_1.length; i++) {
            tmp_2 = tmp_1[i].split('=');
            rcl_url_params[tmp_2[0]] = tmp_2[1];
        }
    }
    
    return rcl_url_params;
}

var rcl_url_params = rcl_get_value_url_params();

function rcl_is_valid_url(url){
  var objRE = /http(s?):\/\/[-\w\.]{3,}\.[A-Za-z]{2,3}/;
  return objRE.test(url);
}

function setAttr_rcl(prmName,val){
    var res = '';
    var d = location.href.split("#")[0].split("?");  
    var base = d[0];
    var query = d[1];
    if(query) {
        var params = query.split("&");  
        for(var i = 0; i < params.length; i++) {  
                var keyval = params[i].split("=");  
                if(keyval[0] !== prmName) {  
                        res += params[i] + '&';
                }
        }
    }
    res += prmName + '=' + val;
    return base + '?' + res;
} 

function rcl_ajax_tab(e,data){
    jQuery('.rcl-tab-button .recall-button').removeClass('active');
    e.addClass('active');
    var url = data.post.tab_url;
    if(url != window.location){
        if ( history.pushState ){
            window.history.pushState(null, null, url);
        }
    }
    jQuery('#lk-content').html(data.result);
}

jQuery(function($){

    $("#recallbar .menu-item-has-children").hover(function() {
        $(this).children(".sub-menu").css({'visibility': 'visible'})
    }, function() {
        $(this).children(".sub-menu").css({'visibility': ''})
    });

    $('body').on('click','.rcl-ajax',function(){
        rcl_preloader_show('#lk-content > div');
        var e = $(this);
        var post = e.data('post');
        var tab_url = e.attr('href');
        var dataString = 'action=rcl_ajax&post='+post+'&tab_url='+tab_url;
        dataString += '&ajax_nonce='+Rcl.nonce;
        $.ajax({
            type: 'POST', 
            data: dataString, 
            dataType: 'json', 
            url: Rcl.ajaxurl,
            success: function(data){
                rcl_preloader_hide();
                if(data.result.error){
                    rcl_notice(data.result.error,'error',10000);
                    return false;
                }
                var funcname = data.post.callback;              
                new (window[funcname])(e,data);
            }			
        }); 
        return false;
    });
    
    $("body .rcl-smiles > img").on({
        mouseenter: function () {
            var sm_box = $(this).next();
            var block = sm_box.children();
            sm_box.show();
            if(block.html()) return false;
            block.html(Rcl.local.loading+'...');
            var dir = $(this).data('dir');
            var area = $(this).parent().data('area');
            var dataString = 'action=rcl_get_smiles_ajax&area='+area;
            if(dir) dataString += '&dir='+dir;
            dataString += '&ajax_nonce='+Rcl.nonce;
            $.ajax({
                type: 'POST', 
                data: dataString, 
                dataType: 'json', 
                url: Rcl.ajaxurl,
                success: function(data){				
                        if(data['result']==1){
                                block.html(data['content']);
                        }else{
                                rcl_notice(Rcl.local.error,'error',10000);
                        }					
                }			
            }); 
        },
        mouseleave: function () {
            $(this).next().hide();
        }
    });
    
    $("body .rcl-smiles > .rcl-smiles-list").on({
        mouseenter: function () {
            $(this).show();           
        },
        mouseleave: function () {
            $(this).hide();
        }
    });

    $('body').on('hover click','.rcl-smiles > img',function(){
        var block = $(this).next().children();
        if(block.html()) return false;
        block.html(Rcl.local.loading+'...');
        var dir = $(this).data('dir');
        var area = $(this).parent().data('area');
        var dataString = 'action=rcl_get_smiles_ajax&area='+area;
        if(dir) dataString += '&dir='+dir;
        dataString += '&ajax_nonce='+Rcl.nonce;
        $.ajax({
            type: 'POST', 
            data: dataString, 
            dataType: 'json', 
            url: Rcl.ajaxurl,
            success: function(data){				
                    if(data['result']==1){
                            block.html(data['content']);
                    }else{
                            rcl_notice(Rcl.local.error,'error',10000);
                    }					
            }			
        }); 
        return false;
    });

    $("body").on("click",'.rcl-smiles-list img',function(){
            var alt = $(this).attr("alt");
            var area = $(this).parents(".rcl-smiles").data("area");
            $("#"+area).val($("#"+area).val()+" "+alt+" ");
    });

    //общий чат
    $('#lk-content, #rcl-popup').on('click','.author-avatar',function(){
        var userid = $(this).attr("user_id");
        if(!userid) return false;
        var ava = $(this).html();
        $(".author-avatar").children().removeAttr('style');
        $(this).children().css('opacity','0.4');
        $("#adressat_mess").val(userid);
        $("#opponent").html(ava);
        //return false;
    });

    $('#rcl-popup,.floatform').on('click','.close-popup',function(){
        $('#rcl-overlay').fadeOut();
        $('.floatform').fadeOut();
        $('#rcl-popup').empty();		
        return false;
    });
    
    $('#rcl-overlay').click(function(){
        $('#rcl-overlay').fadeOut();
        $('.floatform').fadeOut();
        $('#rcl-popup').empty();		
        return false;
    });

    $("#temp-files").on('click','.thumb-foto',function(){		
        $("#temp-files .thumb-foto").removeAttr("checked");
        $(this).attr("checked",'checked');			
    });

    $(".thumbs a").click(function(){	
        var largePath = $(this).attr("href");
        var largeAlt = $(this).attr("title");		
        $("#largeImg").attr({ src: largePath, alt: largeAlt });
        $(".largeImglink").attr({ href: largePath });		
        $("h2 em").html(" (" + largeAlt + ")"); return false;
    });	
	
    $('.public-post-group').click(function(){				
        $(this).slideUp();
        $(this).next().slideDown();
        return false;
    });
    
    $('.close-public-form').click(function(){				
        $(this).parent().prev().slideDown();
        $(this).parent().slideUp();
        return false;
    });

    $(".float-window-recall").on('click','.close',function(){	
        $(".float-window-recall").remove();
        return false; 
    });

    $('.close_edit').click(function(){
        $('.group_content').empty();
    });

    $('.form-tab-rcl .link-tab-rcl').click(function(){
        $('.form-tab-rcl').hide();
        if($(this).hasClass('link-login-rcl')) $('#login-form-rcl').show();
        if($(this).hasClass('link-register-rcl')) $('#register-form-rcl').show();
        if($(this).hasClass('link-remember-rcl')) $('#remember-form-rcl').show();
        return false; 
    });
    
    $('.rcl-tab-button .block_button').click(function() {      
        var url = setAttr_rcl('tab',$(this).parent().data('tab'));
        if(url !== window.location){
            if ( history.pushState ){
                window.history.pushState(null, null, url);
            }
        }
        return false;
    });

    $('.rcl-tab-button .block_button').click(function(){
        if($(this).hasClass('active'))return false;
        var id = $(this).parent().data('tab');		
        $(".rcl-tab-button .block_button").removeClass("active");
        $(".recall_content_block").removeClass("active").slideUp();
        $(this).addClass("active");
        $('#tab-'+id).slideDown().addClass("active");
        return false;
    });		

    if(rcl_url_params['action-rcl']){
        $('.form-tab-rcl').slideUp();
        $('#'+rcl_url_params['action-rcl']+'-form-rcl').slideDown();		
        return false; 
    }

    if(rcl_url_params['tab']){		
        var id_block = rcl_url_params['tab'];
        var offsetTop = $("#lk-content").offset().top;
        $('body,html').animate({scrollTop:offsetTop -50}, 1000);
        view_recall_content_block(id_block);
    }
    
    $('.public_block form.edit-form').find('.requared-checkbox').each(function(){
        rcl_update_require_checkbox(this);
    });
    
    $('body').on('click','.requared-checkbox',function(){
        rcl_update_require_checkbox(this);
    });
    
    $('#rcl-notice,body').on('click','a.close-notice',function(){           
            rcl_close_notice(jQuery(this).parent());
            return false;
    });
    
    function rcl_update_require_checkbox(e){
        var name = $(e).attr('name');
        var chekval = $('form input[name="'+name+'"]:checked').val();
        if(chekval) $('form input[name="'+name+'"]').attr('required',false);
        else $('form input[name="'+name+'"]').attr('required',true);
    }
	
    function view_recall_content_block(id_block){
        $(".rcl-tab-button .recall-button").removeClass("active");
        $("#lk-content .recall_content_block").removeClass("active");
        //$('.recall_content_block').slideUp();
        $('#tab-button-'+id_block).children('.recall-button').addClass("active");
        $('#lk-content .'+id_block+'_block').addClass("active");
        return false;
    }
    
    $.fn.extend({
        insertAtCaret: function(myValue){
            return this.each(function(i) {
                if (document.selection) {
                    // Для браузеров типа Internet Explorer
                    this.focus();
                    var sel = document.selection.createRange();
                    sel.text = myValue;
                    this.focus();
                }
                else if (this.selectionStart || this.selectionStart == '0') {
                    // Для браузеров типа Firefox и других Webkit-ов
                    var startPos = this.selectionStart;
                    var endPos = this.selectionEnd;
                    var scrollTop = this.scrollTop;
                    this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
                    this.focus();
                    this.selectionStart = startPos + myValue.length;
                    this.selectionEnd = startPos + myValue.length;
                    this.scrollTop = scrollTop;
                } else {
                    this.value += myValue;
                    this.focus();
                }
            })
        }
    });
    
    $.cookie = function(name, value, options) {
        if (typeof value !== 'undefined') { 
                options = options || {};
                if (value === null) {
                        value = '';
                        options.expires = -1;
                }
                var expires = '';
                if (options.expires && (typeof options.expires === 'number' || options.expires.toUTCString)) {
                        var date;
                        if (typeof options.expires === 'number') {
                                date = new Date();
                                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
                        } else {
                                date = options.expires;
                        }
                        expires = '; expires=' + date.toUTCString();
                }
                var path = options.path ? '; path=' + (options.path) : '';
                var domain = options.domain ? '; domain=' + (options.domain) : '';
                var secure = options.secure ? '; secure' : '';
                document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
        } else {
                var cookieValue = null;
                if (document.cookie && document.cookie !== '') {
                        var cookies = document.cookie.split(';');
                        for (var i = 0; i < cookies.length; i++) {
                                var cookie = $.trim(cookies[i]);
                                if (cookie.substring(0, name.length + 1) === (name + '=')) {
                                        cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                                        break;
                                }
                        }
                }
                return cookieValue;
        }
    };

});

function rcl_close_notice(e){
    jQuery(e).animate({
        opacity: 0,
        height: 'hide'
    }, 300);
}

function rcl_add_dropzone(idzone){

    jQuery(document.body).bind("drop", function(e){
        var dropZone = jQuery(idzone),
        node = e.target, 
        found = false;

        if(dropZone[0]){		
            dropZone.removeClass('in hover');
            do {               
                if (node === dropZone[0]) {
                    found = true;
                    break;
                }
                node = node.parentNode;
            } while (node != null);

            if(found){
                e.preventDefault();
            }else{			
                return false;
            }
        }
    });

    jQuery(idzone).bind('dragover', function (e) {
        var dropZone = jQuery(idzone),
                timeout = window.dropZoneTimeout;

        if (!timeout) {
                dropZone.addClass('in');
        } else {
                clearTimeout(timeout);
        }

        var found = false,
                node = e.target;

        do {
                if (node === dropZone[0]) {
                        found = true;
                        break;
                }
                node = node.parentNode;
        } while (node != null);

        if (found) {
                dropZone.addClass('hover');
        } else {
                dropZone.removeClass('hover');
        }

        window.dropZoneTimeout = setTimeout(function () {
                window.dropZoneTimeout = null;
                dropZone.removeClass('in hover');
        }, 100);
    });
}

function passwordStrength(password){
    var desc = new Array();
    desc[0] = Rcl.local.pass0;
    desc[1] = Rcl.local.pass1;
    desc[2] = Rcl.local.pass2;
    desc[3] = Rcl.local.pass3;
    desc[4] = Rcl.local.pass4;
    desc[5] = Rcl.local.pass5;
    var score   = 0;
    if (password.length > 6) score++;   
    if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;
    if (password.match(/\d+/)) score++;
    if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) score++;
    if (password.length > 12) score++;
    document.getElementById("passwordDescription").innerHTML = desc[score];
    document.getElementById("passwordStrength").className = "strength" + score;
}

function rcl_notice(text,type,time_close){

    time_close = time_close || false;

    var notice_id = rcl_rand(1, 1000);

    var html = '<div id="notice-'+notice_id+'" class="notice-window type-'+type+'"><a href="#" class="close-notice"><i class="fa fa-times"></i></a>'+text+'</div>';	
    if(!jQuery('#rcl-notice').size()){
            jQuery('body > div').last().after('<div id="rcl-notice">'+html+'</div>');
    }else{
            if(jQuery('#rcl-notice > div').size()) jQuery('#rcl-notice > div:last-child').after(html);
            else jQuery('#rcl-notice').html(html);
    }

    if(time_close){
        setTimeout(function () {
            rcl_close_notice('#rcl-notice #notice-'+notice_id)
        }, time_close);
    }
}

function rcl_preloader_show(e){
    jQuery(e).after('<div class="rcl_preloader"><i class="fa fa-spinner fa-pulse"></i></div>');
}

function rcl_preloader_hide(){
    jQuery('.rcl_preloader').remove();
}

function rcl_rand( min, max ) {
    if( max ) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
    } else {
            return Math.floor(Math.random() * (min + 1));
    }
}

function rcl_add_dynamic_field(e){
    var parent = jQuery(e).parents('.dynamic-value');
    var box = parent.parent('.dynamic-values');
    var html = parent.html();
    box.append('<span class="dynamic-value">'+html+'</span>');
    jQuery(e).attr('onclick','rcl_remove_dynamic_field(this);return false;').children('i').toggleClass("fa-plus fa-minus");
    box.children('span').last().children('input').val('');
}

function rcl_remove_dynamic_field(e){
    jQuery(e).parents('.dynamic-value').remove();
}
