jQuery(document).ready(function($) {
    
    jQuery('.rcl-public-editor .rcl-upload-box .upload-image-url').live('keyup',function(){        
        var content = jQuery(this).val();
        
        var idbox = jQuery(this).parents('.rcl-upload-box').attr('id');
        var res = rcl_is_valid_url(content);
        if(!res) return false;

        rcl_preloader_show('#'+idbox);
        var parent = jQuery(this).parent();
        var dataString = 'action=rcl_upload_box&url_image='+content;
        dataString += '&ajax_nonce='+Rcl.nonce;
        jQuery.ajax({
            type: 'POST', 
            data: dataString, 
            dataType: 'json', 
            url: Rcl.ajaxurl,
            success: function(data){

                if(data['error']){
                    rcl_notice(data['error'],'error',10000);
                    rcl_preloader_hide();
                    return false;
                }

                jQuery('#'+idbox).html(data[0]['content']);
                rcl_preloader_hide();

            }			
        });
        return false;
    });
    
    jQuery('#rcl-delete-post .delete-toggle').click(function() {
        jQuery(this).next().toggle('fast');
        return false;
    });

    jQuery('form[name="public_post"] input[name="edit-post-rcl"],form[name="public_post"] input[name="add_new_task"]').click(function(){
        var error=0;
        jQuery('form[name="public_post"]').find(':input').each(function() {
            for(var i=0;i<field.length;i++){
                if(jQuery(this).attr('name')==field[i]){
                    if(jQuery(this).val()==''){
                            jQuery(this).attr('style','border:1px solid red !important');
                            error=1;
                    }else{
                            jQuery(this).attr('style','border:1px solid #E6E6E6 !important');
                    }
                }
            }
        });
        if(error==0) return true;
        else return false;
    });

});

function rcl_add_editor_box(e,type,idbox,content){
    rcl_preloader_show(e);
    var dataString = 'action=rcl_add_editor_box';
    if(type) dataString += '&type='+type;
    if(idbox) dataString += '&idbox='+idbox;
    dataString += '&ajax_nonce='+Rcl.nonce;
    jQuery.ajax({
        type: 'POST', 
        data: dataString, 
        dataType: 'json', 
        url: Rcl.ajaxurl,
        success: function(data){
            if(data['error']){
                rcl_notice(data['error'],'error',10000);
                return false;
            }
            var editor = jQuery(e).parents('.rcl-public-editor');
            editor.children('.rcl-editor-content').append(data['content']);
            if(content) jQuery('#rcl-upload-'+idbox).html(content);
            rcl_preloader_hide();
            return true;
        }			
    }); 
    return false;
}
	
function rcl_delete_editor_box(e){
	var box = jQuery(e).parents('.rcl-content-box');
	box.remove();
	return false;
}

function rcl_delete_post(element){
    rcl_preloader_show(element);
    var post_id = jQuery(element).data('post');
    var post_type = jQuery(element).parents('form').data('post_type');
    var dataString = 'action=rcl_ajax_delete_post&post_id='+post_id;
    dataString += '&ajax_nonce='+Rcl.nonce;
    jQuery.ajax({
        type: 'POST', data: dataString, dataType: 'json', url: Rcl.ajaxurl,
        success: function(data){
            rcl_preloader_hide();
            if(data['error']){
                rcl_notice(data['error'],'error',10000);
                return false;
            }
            jQuery('.'+data['post_type']+'-'+post_id).remove();
            rcl_notice(data['success'],'success',10000);
        }
    });
    return false;
}

function rcl_edit_post(element){	

    var post_id = jQuery(element).data('post');
    var dataString = 'action=rcl_get_edit_postdata&post_id='+post_id;
    dataString += '&ajax_nonce='+Rcl.nonce;
    jQuery.ajax({
            type: 'POST', data: dataString, dataType: 'json', url: Rcl.ajaxurl,
            success: function(data){                                   
                if(data['error']){
                    rcl_notice(data['error'],'error',10000);
                    return false;
                }                                   
                if(data['result']==100){
                    
                    ssi_modal.show({
                        title: Rcl.local.edit_box_title,
                        className: 'rcl-edit-post-form',
                        sizeClass: 'small',
                        buttons: [{
                            label: Rcl.local.save,
                            closeAfter: false,
                            method: function () {
                                rcl_preloader_show('#rcl-popup-content > form');
                                var postdata   = jQuery('#rcl-popup-content form').serialize();
                                var dataString = 'action=rcl_edit_postdata&'+postdata;
                                dataString += '&ajax_nonce='+Rcl.nonce;
                                jQuery.ajax({
                                    type: 'POST', data: dataString, dataType: 'json', url: Rcl.ajaxurl,
                                    success: function(data){
                                        if(data['error']){
                                            rcl_notice(data['error'],'warning',10000);
                                        }  
                                        if(data['result']==100){
                                            rcl_notice(data['content'],'success',10000);
                                            ssi_modal.close();
                                        }
                                        rcl_preloader_hide();
                                    }
                                });
                            }
                        }, {
                            label: Rcl.local.close,
                            closeAfter: true
                        }],
                        content: '<div id="rcl-popup-content">'+data['content']+'</div>'
                    });

                }
            }
    });
}

function rcl_init_upload_box(idbox){
	
    rcl_add_dropzone('#rcl-upload-'+idbox);

    var cntFiles = 0;

    jQuery('#rcl-upload-'+idbox+' .rcl-box-uploader').fileupload({
        dataType: 'json',
        type: 'POST',
        singleFileUploads:false,
        url: Rcl.ajaxurl,
        formData:{action:'rcl_upload_box',ajax_nonce:Rcl.nonce},
        dropZone: jQuery('#rcl-upload-'+idbox),
        change: function (e, data){				
                rcl_preloader_show('#rcl-upload-'+idbox);
        },
        done: function (e, data) {				
            if(data.result['error']){
                rcl_notice(data.result['error'],'error',10000);
                rcl_preloader_hide();
                return false;
            }
            var id = idbox;
            jQuery.each(data.files, function (index, file) {
                if(cntFiles>=1){
                        id++;
                        rcl_add_editor_box('#rcl-upload-'+idbox,'image',id,data.result[cntFiles]['content']);					
                }else{
                        jQuery('#rcl-upload-'+idbox).html(data.result[cntFiles]['content']);
                }
                cntFiles++;
            });
            rcl_preloader_hide();
        }
    });
	
}

function rcl_preview(e){

	var submit = jQuery(e);
	var formblock = submit.parents('form');
	var required = true;
        var post_type = formblock.data('post_type');
        
	formblock.find(':required').each(function(){
            if(!jQuery(this).val()){
                jQuery(this).css('box-shadow','0px 0px 1px 1px red');
                required = false;
            }else{
                jQuery(this).css('box-shadow','none');
            }
	});
        
        if(formblock.find( 'input[name="cats[]"]' ).length > 0){             
            if(formblock.find('input[name="cats[]"]:checked').length == 0){
                formblock.find( 'input[name="cats[]"]' ).css('box-shadow','0px 0px 1px 1px red');
                required = false;
            }else{
                formblock.find( 'input[name="cats[]"]' ).css('box-shadow','none');
            }
        }

	if(!required){
            rcl_notice(Rcl.local.requared_fields_empty,'error',10000);
            return false;
	}

        submit.attr('disabled',true).val(Rcl.local.wait+'...');
	
	var iframe = jQuery("#contentarea-"+post_type+"_ifr").contents().find("#tinymce").html();
	if(iframe){
            tinyMCE.triggerSave();
            formblock.find('textarea[name="post_content"]').html(iframe);
        }
	
        var string   = formblock.serialize();

	var dataString = 'action=rcl_preview_post&'+string;
        dataString += '&ajax_nonce='+Rcl.nonce;
	jQuery.ajax({
            type: 'POST', 
            data: dataString, 
            dataType: 'json', 
            url: Rcl.ajaxurl,
            success: function(data){

                if(data['error']){
                    rcl_notice(data['error'],'error',10000);
                    submit.attr('disabled',false).val(Rcl.local.preview);
                    return false;
                }

                if(data['content']){
                    
                    ssi_modal.show({
                        sizeClass: 'small',
                        title: Rcl.local.preview,
                        className: 'rcl-preview-post',
                        buttons: [{
                            className: 'btn btn-primary',
                            label: Rcl.local.edit,
                            closeAfter: true,
                            method: function () {
                                submit.attr('disabled',false).val(Rcl.local.preview);
                            }
                        }, {
                            className: 'btn btn-danger',
                            label: Rcl.local.publish,
                            closeAfter: false,
                            method: function () {
                                jQuery('form.rcl-public-form').submit();
                            }
                        }],
                        content: '<div id="rcl-preview">'+data['content']+'</div>'
                    });

                    submit.attr('disabled',false).val(Rcl.local.preview);
                    return true;
                }

                submit.attr('disabled',false).val(Rcl.local.preview);
                rcl_notice(Rcl.local.error,'error',10000);

            }
	}); 
	return false;

}

function rcl_get_prefiew_content(formblock,iframe){
    formblock.find('textarea[name="post_content"]').html(iframe);
    return formblock.serialize();
}

function rcl_preview_close(e){
    ssi_modal.close();	
}

function rcl_init_public_form(post_type,post_id){
    
    var maxcnt = Rcl.public.maxcnt;
    var maxsize_mb = Rcl.public.maxsize_mb;
    var maxsize = maxsize_mb*1024*1024;

    rcl_add_dropzone('#rcl-public-dropzone-'+post_type);
    
    jQuery('#upload-public-form-'+post_type).fileupload({
        dataType: 'json',
        type: 'POST',
        dropZone: jQuery('#rcl-public-dropzone-'+post_type),
        url: Rcl.ajaxurl,
        formData:{action:'rcl_imagepost_upload',post_type:post_type,post_id:post_id,ajax_nonce:Rcl.nonce},
        singleFileUploads:false,
        autoUpload:true,
        progressall: function (e, data) {
            /*var progress = parseInt(data.loaded / data.total * 100, 10);
            jQuery('#upload-box-message .progress-bar').show().css('width',progress+'px');*/
        },
        send:function (e, data) {
            var error = false;
            rcl_preloader_show('.public_block form');                   
            var cnt_now = jQuery('#temp-files-'+post_type+' li').length;                    
            jQuery.each(data.files, function (index, file) {
                cnt_now++;
                if(cnt_now>Rcl.public.maxcnt){
                    rcl_notice(Rcl.local.allowed_downloads,'error',10000);
                    error = true;
                }                       
                if(file['size']>maxsize){
                    rcl_notice(Rcl.local.upload_size_public,'error',10000);                            
                    error = true;
                }                       
            });
            if(error){
                rcl_preloader_hide();
                return false;
            }
        },
        done: function (e, data) {
            jQuery.each(data.result, function (index, file) {
                if(data.result['error']){
                    rcl_notice(data.result['error'],'error',10000);
                    rcl_preloader_hide();
                    return false;
                }

                if(file['string']){
                    jQuery('#temp-files-'+post_type).append(file['string']);
                }
            });
            rcl_preloader_hide();
        }
    });
}

function rcl_add_image_in_form(e,$file){
    var post_type = jQuery(e).parents("form").data("post_type");           
    var ifr = jQuery("#contentarea-"+post_type+"_ifr").contents().find("#tinymce").html();
    jQuery("#contentarea-"+post_type+"").insertAtCaret($file+"&nbsp;");
    jQuery("#contentarea-"+post_type+"_ifr").contents().find("#tinymce").html(ifr+$file+"&nbsp;");
    return false;
}