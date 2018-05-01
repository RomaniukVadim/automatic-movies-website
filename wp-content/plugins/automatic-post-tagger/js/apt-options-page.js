function apt_set_widget_visibility(apt_widget_id){
	var ele = document.getElementById("apt_widget_id_["+apt_widget_id+"]");

	var apt_widget_id = apt_widget_id;

	if(ele.style.display == "block"){
    	ele.style.display = "none"; //display the change immediately - we won't wait for the script, that would be too slow

		//save id to db
		var data = {
			action: 'apt_set_widget_visibility',
			security: apt_options_page_nonce.security,
			apt_widget_id: apt_widget_id,
			};
		jQuery.ajax ({
			type: 'POST',
			url: ajaxurl,
			data: data,
		});
  	}
	else {
		ele.style.display = "block"; //display the change immediately - we won't wait for the script, that would be too slow

		//delete id from db
		var data = {
			action: 'apt_set_widget_visibility',
			security: apt_options_page_nonce.security,
			apt_widget_id: apt_widget_id,
			};
		jQuery.ajax ({
			type: 'POST',
			url: ajaxurl,
			data: data,
		});
	}
}

//change backgrounds of input fields
function apt_change_background(apt_item_editor,apt_widget_id){
	if(apt_item_editor == 1){ //change the background in the keyword editor
		if (document.getElementById("apt_keyword_set_list_checkbox_"+apt_widget_id).checked){
			document.getElementById("apt_keyword_set_list_name_"+apt_widget_id).style.backgroundColor='#FFD2D2';
			document.getElementById("apt_keyword_set_list_related_keywords_"+apt_widget_id).style.backgroundColor='#FFD2D2';
			document.getElementById("apt_keyword_set_list_group_"+apt_widget_id).style.backgroundColor='#FFD2D2';
		}
		else{
			document.getElementById("apt_keyword_set_list_name_"+apt_widget_id).style.backgroundColor='';
			document.getElementById("apt_keyword_set_list_related_keywords_"+apt_widget_id).style.backgroundColor='';
			document.getElementById("apt_keyword_set_list_group_"+apt_widget_id).style.backgroundColor='';
		}
	}
	else{ //if apt_item_editor != 1, change the background in the group editor
		if (document.getElementById("apt_configuration_group_list_checkbox_"+apt_widget_id).checked){
			document.getElementById("apt_configuration_group_list_name_"+apt_widget_id).style.backgroundColor='#FFD2D2';
			document.getElementById("apt_configuration_group_list_keyword_set_count_"+apt_widget_id).style.backgroundColor='#FFD2D2';
			document.getElementById("apt_configuration_group_list_status_"+apt_widget_id).style.backgroundColor='#FFD2D2';
			document.getElementById("apt_configuration_group_list_term_limit_"+apt_widget_id).style.backgroundColor='#FFD2D2';
			document.getElementById("apt_configuration_group_list_taxonomies_"+apt_widget_id).style.backgroundColor='#FFD2D2';
		}
		else{
			document.getElementById("apt_configuration_group_list_name_"+apt_widget_id).style.backgroundColor='';
			document.getElementById("apt_configuration_group_list_keyword_set_count_"+apt_widget_id).style.backgroundColor='';
			document.getElementById("apt_configuration_group_list_status_"+apt_widget_id).style.backgroundColor='';
			document.getElementById("apt_configuration_group_list_term_limit_"+apt_widget_id).style.backgroundColor='';
			document.getElementById("apt_configuration_group_list_taxonomies_"+apt_widget_id).style.backgroundColor='';
		}
	}
}
