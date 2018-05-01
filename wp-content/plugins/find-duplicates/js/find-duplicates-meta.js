
function find_meta(type) {
    jQuery('#fd-meta-results li').remove();
    var data = {
        action:'get_duplicate_results_meta',
        id: jQuery("#post_ID").val(),
        title: jQuery("#title").val(),
        content: jQuery("#content").val(),
        type: type
        //field: jQuery("#field").val()
    };
        jQuery.ajax({
            type:"POST",
            url:ajaxurl,
            data:data,
            dataType:"json",
            success:function (response) {
                if (response[0] == -1) {
                    jQuery('#log').append(response[1]);
                } else {
                    elements = response[2];
                    //jQuery('#log').append(response[1]);
                    found = response[3];
                    if(found == 0) {
                        jQuery('#fd-meta-results').append('<li><strong>no duplicates found</strong></li>');
                    }
                    jQuery.each(elements, function () {
                        jQuery('#fd-meta-results').append('<li class="resultrow" id="' + this[0] + '"><strong>' + this[2] + '%</strong> <a href="' + this[3] + 'post.php?post=' + this[0] + '&action=edit">' + this[4] + ' (ID: ' + this[0] + ')</a></li>');
                    });
                }
                jQuery("#ajax-loader").hide();
            },
            error:function (xhr, ajaxOptions, thrownError) {
                jQuery('#fd-meta-results').append('<li><strong>'+xhr.responseText + ":" + thrownError+ '</strong></li>');
                jQuery("#ajax-loader").hide();
            }
        });
}