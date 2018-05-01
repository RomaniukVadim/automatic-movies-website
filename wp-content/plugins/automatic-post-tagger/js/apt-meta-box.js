function apt_create_new_keyword_set(){
	var apt_meta_box_term_name = jQuery('#apt_meta_box_term_name').val();
	var apt_meta_box_related_keywords = jQuery('#apt_meta_box_related_keywords').val();
	var apt_meta_box_configuration_group = jQuery('#apt_meta_box_configuration_group').val();
	 
	var data = {
		action: 'apt_meta_box_create_new_keyword_set',
		security: apt_meta_box_nonce.security,
		apt_meta_box_term_name: apt_meta_box_term_name,
		apt_meta_box_related_keywords: apt_meta_box_related_keywords,
		apt_meta_box_configuration_group: apt_meta_box_configuration_group,
	};
	jQuery.ajax ({
		type: 'POST',
		url: ajaxurl,
		data: data,
		success: function(response) {
			jQuery("#apt_meta_box_message").fadeIn("fast");
			document.getElementById("apt_meta_box_message").innerHTML=response; //print the returned message
			jQuery('#apt_meta_box_term_name, #apt_meta_box_related_keywords').val(''); //delete contents of the inputs; the configuration group will stay the same
			jQuery("#apt_meta_box_message").delay(5000).fadeOut("slow");
		}
	});

	jQuery('#apt_meta_box_term_name').focus(); //move the cursor to the first input after submitting
}

//send the data when the enter key is pressed
function apt_enter_submit(event){
	if (event.which == 13){
		apt_create_new_keyword_set();

		var $targ = jQuery(event.target);

		if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
			var focusNext = false;
			jQuery(this).find(":input:visible:not([disabled],[readonly]), a").each(function(){
				if (this === event.target) {
					focusNext = true;
				}
				else if (focusNext){
					jQuery(this).focus();
					return false;
				}
			});

			return false;
		}
	}
}

jQuery(function(){
	//bind apt_create_new_keyword_set() and execute both functions that prevent submitting the form and the other one that adds new keywords to the database
	jQuery('#apt_meta_box_create_new_keyword_set_button').click(function(){
		apt_create_new_keyword_set();
	});
});
