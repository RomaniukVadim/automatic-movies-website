var cancel = false;
var count = 0;
var similarity = 80;
var types = "";
var filterwords = "";
var statuses = [];
var datefrom = "";
var dateto = "";
var postlimit = 1;
var comparelimit = 1000;

function update_statistic() {
    similarity = jQuery("#similarity").slider("value");
    types = jQuery("input[name='types']:checked").val();
    datefrom = jQuery("#datefrom").val();
    dateto = jQuery("#dateto").val();
    //postlimit = jQuery("#postlimit").val();
    comparelimit = jQuery("#comparelimit").val();
    filterwords = jQuery("#filterwords").val();
    statuses = [];
    jQuery("input[name='status[]']:checked").each(function () {
        statuses.push(jQuery(this).val());
    });
    set_posts_count();
    jQuery('#count').html(count);
}

function set_posts_count() {
    var data = {
        action:'get_posts_count',
        types:types,
        statuses:statuses,
        datefrom:datefrom,
        dateto:dateto
    };
    jQuery.ajax({
        type:"POST",
        url:ajaxurl,
        async:false,
        data:data,
        dataType:"json",
        success:function (response) {
            count = response[0];
        },
        error:function (xhr, ajaxOptions, thrownError) {
            jQuery('#log').append(xhr.status + ":" + thrownError);
        }
    });
}

function find_them(startnew) {
    var data = {
        action:'get_duplicate_results',
        types:types,
        similarity:similarity,
        statuses:statuses,
        search_field: jQuery("#search_field").val(),
        filterhtml:jQuery("#filterhtml:checked").length,
        filterhtmlentities:jQuery("#filterhtmlentities:checked").length,
        comparelimit: comparelimit,
        postlimit: postlimit,
        filterwords: filterwords,
        datefrom:datefrom,
        dateto:dateto,
        startnew:startnew
    };
    if (cancel == false) {
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
                    jQuery('#log').append(response[1]);
                    done = response[0];
                    found = response[3];
                    jQuery.each(elements, function () {
                        jQuery('#results tbody').append('<tr class="resultrow" id="' + this[0] + '" olderid="' + this[1] + '">'+
                            '<td>' + this[2] + '%</td>'+
                            '<td><input type="checkbox" class="delete-new-checkbox" postid="' + this[0] + '" value="1"> <a href="' + this[3] + 'post.php?post=' + this[0] + '&action=edit">' + this[4] + ' (ID: ' + this[0] + ')</a></td>'+
                            '<td><input type="checkbox" class="delete-old-checkbox" postid="' + this[1] + '" value="1"> <a href="' + this[3] + 'post.php?post=' + this[1] + '&action=edit">' + this[5] + ' (ID: ' + this[1] + ')</a></td></tr>');
                    });

                    jQuery('#found').html(found);
                    jQuery('#done').html(done);
                    if (done < count) {
                        find_them(0);
                    } else {
                        jQuery("#cancel").click();
                        if (found > 0) {
                            jQuery("#deletebutton").show();
                        }
                    }
                }
            },
            error:function (xhr, ajaxOptions, thrownError) {
                jQuery('#log').append(xhr.responseText + ":" + thrownError);
            }
        });
    }
}

jQuery(document).ready(function () {
    jQuery( "#days" ).slider({
        min:1,
        max:31,
        value:1,
        change: function( event, ui ) {
            jQuery( "#days_amount" ).html( ui.value );
            jQuery( "#croninterval" ).val( ui.value );
        }
    });
    jQuery( "#similarity" ).slider({
        min:50,
        max:100,
        value:jQuery( "input[name='similarity']" ).val(),
        change: function( event, ui ) {
            jQuery( "#similarity_amount" ).html( ui.value );
            jQuery( "input[name='similarity']" ).val( ui.value );
        }
    });
    jQuery( "#similarity_amount" ).html( jQuery("#similarity").slider("value") );

    jQuery(function() {
        var dates = jQuery( "#datefrom, #dateto" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "yy-mm-dd",
            clearText: 'löschen', clearStatus: 'aktuelles Datum löschen',
            showOn: "button",
            buttonImage: "images/date-button.gif",
            buttonImageOnly: true,
            showButtonPanel: true,
            beforeShow: function( input ) {
                setTimeout(function() {
                    var buttonPane = jQuery(input)
                        .datepicker( "widget" )
                        .find( ".ui-datepicker-buttonpane" );

                    var btn = jQuery('<button class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all" type="button">Clear</button>');
                    btn
                        .unbind("click")
                        .bind("click", function () {
                            jQuery.datepicker._clearDate( input );
                            jQuery(input).val("");
                        });

                    btn.appendTo( buttonPane );

                }, 1 );
            },
            //numberOfMonths: 1,
            onSelect: function( selectedDate ) {
                var option = this.id == "datefrom" ? "minDate" : "maxDate",
                    instance = jQuery( this ).data( "datepicker" ),
                    date = jQuery.datepicker.parseDate(
                        instance.settings.dateFormat ||
                            jQuery.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
                update_statistic();
            }
        });
    });

    jQuery('#ajax-loader').ajaxStart(function () {
        jQuery(this).show();
    });

    jQuery('#ajax-loader').ajaxStop(function () {
        jQuery(this).hide();
    });


    update_statistic();

    jQuery("input[name='types'],input[name='status[]']").change(function () {
        update_statistic();
    });

    jQuery("#startbutton").click(function () {
        cancel = false;
        jQuery("#startbutton,#continuebutton,#auto_start,#deletebutton").hide();
        jQuery("#cancel").show();
        jQuery(".resultrow").remove();
        update_statistic();
        find_them(1);
    });

    jQuery("#continuebutton").click(function () {
        cancel = false;
        jQuery("#startbutton,#continuebutton,#auto_start,#deletebutton").hide();
        jQuery("#cancel").show();
        update_statistic();
        find_them(0);
    });

    //jQuery("#logtabs").tabs();
    jQuery("#deletebutton").click(function () {
        jQuery("#startbutton,#continuebutton,#auto_start,#deletebutton").hide();
        jQuery("#cancel").show();
        cancel = false;
        jQuery(".resultrow").each(function () {
            if (cancel == false) {
                row = jQuery(this);
                oldid = '';
                id = '';
                if(row.find(".delete-old-checkbox").is(":checked")) {
                    oldid = row.find(".delete-old-checkbox").attr("postid");
                }
                if(row.find(".delete-new-checkbox").is(":checked")) {
                    id = row.find(".delete-new-checkbox").attr("postid");
                }
                if(id > 0 || oldid > 0) {
                    var data = {
                        action:'remove_result',
                        id:id,
                        oldid:oldid
                    };
                    jQuery.ajax({
                        type:"POST",
                        url:ajaxurl,
                        async:false,
                        data:data,
                        dataType:"json",
                        success:function (response) {
                            if(response[0] == 0) {
                                jQuery('#log').append('Deleting '+oldid + ","+ id+' failed<br />');
                            } else {
                                jQuery('#log').append('Deleted: '+oldid + ","+ id+'<br />');
                                row.remove();
                            }
                        },
                        error:function (xhr, ajaxOptions, thrownError) {
                            jQuery('#log').append(xhr.status + ":" + thrownError);
                        }
                    });
                }
            }
        });
        if(jQuery(".resultrow").length > 0) {
            jQuery("#deletebutton,#continuebutton").show();
        }
        jQuery("#startbutton,#auto_start").show();
        jQuery("#cancel").hide();
    });

    jQuery("#cancel").click(function () {
        cancel = true;
        jQuery("#cancel").hide();
        jQuery("#startbutton,#continuebutton,#auto_start").show();
        if (found > 0) {
            jQuery("#deletebutton").show();
        }
        cancel = true;
    });
});