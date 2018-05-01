<?php

class Rcl_Custom_Fields{

    public $value;
    public $slug;
    public $required;
    public $files;
    public $placeholder;

    function __construct(){
        $this->files = array();
    }

    function get_title($field){
        if($field['type']=='agree'&&$field['url-agreement']) return '<a target="_blank" href="'.$field['url-agreement'].'">'.$field['title'].'</a>';
        return $field['title'];
    }

    function get_input($field,$value=false){
        global $user_LK,$user_ID;

        $this->value = (isset($field['default'])&&!$value)? $field['default']: stripslashes_deep($value);
        $this->slug = $field['slug'];
        $this->required = ($field['requared']==1)? 'required': '';
        $this->placeholder = (isset($field['placeholder'])&&$field['placeholder'])? "placeholder='".str_replace("'",'"',$field['placeholder'])."'": '';

        if(!$field['type']) return false;

        if(!is_admin()&&isset($field['admin'])&&$field['admin']==1&&$user_ID){
            $value = get_user_meta($user_LK,$this->slug,1);
            if($value){
                $html = $this->get_field_value($field,$value,false);               
                return $html;
            }else{
                return false;
            }
        }

        if($field['type']=='date') 
            rcl_datepicker_scripts();

        $callback = 'get_type_'.$field['type'];

        $html_field = $this->$callback($field);
        
        if(isset($field['notice'])&&$field['notice']) 
            $html_field .= '<span class="rcl-field-notice"><i class="fa fa-info" aria-hidden="true"></i>'.$field['notice'].'</span>';
        
        return '<span class="rcl-field-input type-'.$field['type'].'-input">'.$html_field.'</span>';
    }
    
    function get_type_dynamic($args){
        
        $field = '<span class="dynamic-values">';
        
        if($this->value&&is_array($this->value)){
            $cnt = count($this->value);
            foreach((array)$this->value as $k=>$val){
                $field .= '<span class="dynamic-value">';
                $field .= '<input type="text" '.$this->required.' '.$this->placeholder.' name="'.$this->slug.'[]" maxlength="50" value="'.$val.'"/>';
                if($cnt==($k+1)){
                    $field .= '<a href="#" onclick="rcl_add_dynamic_field(this);return false;"><i class="fa fa-plus" aria-hidden="true"></i></a>';
                }else{
                    $field .= '<a href="#" onclick="rcl_remove_dynamic_field(this);return false;"><i class="fa fa-minus" aria-hidden="true"></i></a>';
                }
                $field .= '</span>';
            }
        }else{
            $field .= '<span class="dynamic-value">';
            $field .= '<input type="text" '.$this->required.' '.$this->placeholder.' name="'.$this->slug.'[]" maxlength="50" value=""/>';
            $field .= '<a href="#" onclick="rcl_add_dynamic_field(this);return false;"><i class="fa fa-plus" aria-hidden="true"></i></a>';
            $field .= '</span>';
        }
        
        $field .= '</span>';
        
        return $field;
    }

    function get_type_text($field){
        return '<input type="text" '.$this->required.' '.$this->placeholder.' name="'.$this->slug.'" id="'.$this->slug.'" maxlength="50" value="'.$this->value.'"/>';
    }

    function get_type_tel($field){
        return '<input type="tel" '.$this->required.' '.$this->placeholder.' name="'.$this->slug.'" id="'.$this->slug.'" maxlength="50" value="'.$this->value.'"/>';
    }

    function get_type_email($field){
        return '<input type="email" '.$this->required.' '.$this->placeholder.' name="'.$this->slug.'" id="'.$this->slug.'" maxlength="50" value="'.$this->value.'"/>';
    }

    function get_type_url($field){
        return '<input type="url" '.$this->required.' '.$this->placeholder.' name="'.$this->slug.'" id="'.$this->slug.'" value="'.$this->value.'"/>';
    }

    function get_type_date($field){
        return '<input type="text" '.$this->required.' '.$this->placeholder.' class="rcl-datepicker" name="'.$this->slug.'" id="'.$this->slug.'" value="'.$this->value.'"/>';
    }

    function get_type_time($field){
        return '<input type="time" '.$this->required.' '.$this->placeholder.' name="'.$this->slug.'" id="'.$this->slug.'" maxlength="50" value="'.$this->value.'"/>';
    }

    function get_type_number($field){
        return '<input type="number" '.$this->required.' '.$this->placeholder.' name="'.$this->slug.'" id="'.$this->slug.'" maxlength="50" value="'.$this->value.'"/>';
    }

    function get_type_file($field){
        global $user_ID;
        $input = '';
        
        $user_id = (is_admin())? $_GET['user_id']: $user_ID;
        if(!$user_id) $user_id = $user_ID;

        $url = (is_admin()&&!(defined( 'DOING_AJAX' ) && DOING_AJAX))? 
                admin_url('?meta='.$this->slug.'&rcl-delete-file='.base64_encode($this->value).'&user_id='.$user_id): 
                get_bloginfo('wpurl').'/?meta='.$this->slug.'&rcl-delete-file='.base64_encode($this->value);
        
        if($this->value){
            $input .= $this->get_field_value($field,$this->value,0);
            if(!$field['requared']) $input .= '<span class="delete-file-url"><a href="'.wp_nonce_url($url, 'user-'.$user_ID ).'"> <i class="fa fa-times-circle-o"></i>'.__('delete','wp-recall').'</a></span>';
            $input = '<span class="file-manage-box">'.$input.'</span>';
        }

        $accept = ($field['field_select'])? 'accept=".'.implode(',.',array_map('trim',explode(',',$field['field_select']))).'"': '';
        $required = (!$this->value)? $this->required: '';
        
        $size = ($field['sizefile'])? $field['sizefile']: 2;

        $input .= '<span id="'.$this->slug.'-content" class="file-field-upload"><input class="meta-file" data-size="'.$size.'" type="file" '.$required.' '.$accept.' name="'.$this->slug.'" id="'.$this->slug.'" value=""/> ('.__('Max size','wp-recall').': '.$size.'MB)</span>';

        $input .= $this->get_files_scripts();

        $this->files[$this->slug] = $size;

        return $input;
    }

    function get_type_textarea($field){
        return '<textarea name="'.$this->slug.'" '.$this->required.' '.$this->placeholder.' id="'.$this->slug.'" rows="5" cols="50">'.$this->value.'</textarea>';
    }

    function get_type_agree($field){
        return '<input type="checkbox" '.checked($this->value,1,false).' '.$this->required.' name="'.$this->slug.'" id="'.$this->slug.'" value="1"/> '
                . '<label class="block-label" for="'.$this->slug.'">'.$field['field_select'].'</label>';
    }

    function get_type_select($field){
        $fields = explode('#',$field['field_select']);
        $count_field = count($fields);
        $field_select = '';
        for($a=0;$a<$count_field;$a++){
            $field_select .='<option '.selected($this->value,$fields[$a],false).' value="'.trim($fields[$a]).'">'.$fields[$a].'</option>';
        }
        return '<select '.$this->required.' name="'.$this->slug.'" id="'.$this->slug.'">
        '.$field_select.'
        </select>';
    }

    function get_type_multiselect($field){
        $fields = explode('#',$field['field_select']);
        $count_field = count($fields);
        $field_select = '';

        for($a=0;$a<$count_field;$a++){
            if(!is_array($this->value)) $selected = selected($this->value,$fields[$a],false);
            else {
                $arrValue = $this->value;
                for($ttt = 0; $ttt < count($arrValue); $ttt++) {
                    $selected = selected($arrValue[$ttt],$fields[$a],false);
                    if(strlen($selected) > 3) break;
                }
            }
            $field_select .='<option '.$selected.' value="'.trim($fields[$a]).'">'.$fields[$a].'</option>';
        }
        return '<select '.$this->required.' name="'.$this->slug.'[]" id="'.$this->slug.'" multiple>
        '.$field_select.'
        </select>';
    }

    function get_type_checkbox($field){
        $chek = explode('#',$field['field_select']);
        $count_field = count($chek);
        $input = '';
        $class = ($this->required) ? 'class="requared-checkbox"':'';
        for($a=0;$a<$count_field;$a++){
            $sl = '';
            if($this->value){
                foreach((array)$this->value as $meta){
                    if($chek[$a]!=$meta) continue;
                    $sl = 'checked=checked';
                    break;
                }
            }
            
            $input .='<span class="rcl-checkbox-box">'
                    . '<input '.$this->required.' '.$sl.' id="'.$this->slug.'_'.$a.'" type="checkbox" '.$class.' name="'.$this->slug.'[]" value="'.trim($chek[$a]).'"> ';
            $input .='<label class="block-label" for="'.$this->slug.'_'.$a.'">';
            $input .= (!isset($field['before']))? '': $field['before'];
            $input .= $chek[$a]
                    .'</label>'
                    . '</span>';
            $input .= (!isset($field['after']))? '': $field['after'];
        }
        return $input;
    }

    function get_type_radio($field){
        $radio = explode('#',$field['field_select']);
        $count_field = count($radio);
        $input = '';
        for($a=0;$a<$count_field;$a++){
            
            $input .='<span class="rcl-radio-box">'
                    . '<input '.$this->required.' '.checked($this->value,$radio[$a],false).' type="radio" '.checked($a,0,false).' id="'.$this->slug.'_'.$a.'" name="'.$this->slug.'" value="'.trim($radio[$a]).'"> ';
            $input .='<label class="block-label" for="'.$this->slug.'_'.$a.'">';        
            $input .= $radio[$a]
                    .'</label>'
                    . '</span>';
        }
        return $input;
    }

    function get_field_value($field,$value=false,$title=true){
        global $user_ID;
        
        if(!isset($field['type'])||!$value) return false;
        
        $show = '';
        
        if($value) 
            $value = stripslashes_deep($value);

        if(is_array($value)){
            
            if($field['filter']){
                $links = array();
                foreach($value as $val){
                    $links[] = '<a href="'.$this->get_filter_url($field['slug'],$val).'" target="_blank">'.$val.'</a>';
                }
                $value = $links;
            }
            
            $array_types = array('checkbox','multiselect','dynamic');
            
            if(in_array($field['type'],$array_types)){
                $chek_field = '';
                $chek_field = implode(', ',$value);
                if($chek_field)
                    $show = $chek_field;
            }
            
        }else{
            
            $value = esc_html($value);
            
            if(isset($field['filter'])&&$field['filter']){
                $value = '<a href="'.$this->get_filter_url($field['slug'],$value).'" target="_blank">'.$value.'</a>';
            }

        }
        
        $types = array('text','tel','time','date','number','select','radio');
            
        if(in_array($field['type'],$types)){
            $show = $value;
        }

        if($field['type']=='file')
                $show = '<i class="fa fa-upload" aria-hidden="true"></i><a href="'.wp_nonce_url(get_bloginfo('wpurl').'/?rcl-download-file='.base64_encode($value), 'user-'.$user_ID ).'">'.__('Upload the downloaded file','wp-recall').'</a>';
        if($field['type']=='email')
                $show = '<a rel="nofollow" target="_blank" href="mailto:'.$value.'">'.$value.'</a>';
        if($field['type']=='url')
                $show = '<a rel="nofollow" target="_blank" href="'.$value.'">'.$value.'</a>';            
        if($field['type']=='textarea')
                $show = nl2br($value);
        
        $show = '<span class="rcl-field-value type-'.$field['type'].'-value">'.$show.'</span>';
        
        if(isset($field['after'])) $show .= ' '.$field['after'];

        if($title&&$show) $show = '<p class="rcl-custom-fields"><b>'.$field['title'].':</b> '.$show.'</p>';

        return $show;
    }
    
    function get_filter_url($slug,$value){
        global $rcl_options;
        if(!isset($rcl_options['users_page_rcl'])||!$rcl_options['users_page_rcl']) return false;
        return rcl_format_url(get_permalink($rcl_options['users_page_rcl'])).'usergroup='.$slug.':'.$value;
    }

    function register_user_metas($user_id){

        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');

        $get_fields = get_option( 'rcl_profile_fields' );

        if(!$get_fields) return false;

	$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        foreach((array)$get_fields as $custom_field){
            $slug = $custom_field['slug'];
            if($custom_field['type']=='checkbox'){
                $select = explode('#',$custom_field['field_select']);
                $count_field = count($select);
                if(isset($_POST[$slug])){
                    foreach($_POST[$slug] as $val){
                        for($a=0;$a<$count_field;$a++){
                            if(trim($select[$a])==$val){
                                $vals[] = $val;
                            }
                        }
                    }

                    if($vals) update_usermeta($user_id, $slug, $vals);
                }

            }else if($custom_field['type']=='file'){

                $attach_id = rcl_upload_meta_file($custom_field,$user_id);
                if($attach_id) update_user_meta($user_id, $slug, $attach_id);


            }else{
                if($_POST[$slug]) update_usermeta($user_id, $slug, $_POST[$slug]);
            }
        }

    }

    function get_files_scripts(){

        if($this->files) return false;
        return '<script type="text/javascript">
            jQuery(function(){
                jQuery("#profile-page form#your-profile").attr("enctype","multipart/form-data");
                jQuery("form").submit(function(event){
                    var error = false;
                    jQuery(this).find(".meta-file").each(function(){
                        var maxsize = jQuery(this).data("size");
                        var fileInput = jQuery(this)[0];
                        var filesize = fileInput.files[0];
                        if(!filesize) return;
                        filesize = filesize.size/1024/1024;
                        if(filesize>maxsize){
                            jQuery(this).parent().css("border","1px solid red").css("padding","2px");
                            jQuery("#edit-post-rcl").attr("disabled",false).attr("value","'.__('To publish','wp-recall').'");
                            error = true;
                        }else{
                            jQuery(this).parent().removeAttr("style");
                        }
                    });
                    if(error){
                        alert("'.__('File size exceeded!','wp-recall').'");
                        return false;
                    }
                });
            });
        </script>';
    }

}

function rcl_upload_meta_file($custom_field,$user_id,$post_id=0){

    $slug = $custom_field['slug'];
    $maxsize = ($custom_field['sizefile'])? $custom_field['sizefile']: 2;

    if(!$_FILES[$slug]['tmp_name']) return false;

    if ($_FILES[$slug]["size"] > $maxsize*1024*1024){
        wp_die( __('File size exceeded!','wp-recall'));
    }

    $accept = array();
    $attachment = array();
    if($custom_field['field_select']){
        $valid_types = array_map('trim',explode(',',$custom_field['field_select']));
        $filetype = wp_check_filetype_and_ext( $_FILES[$slug]['tmp_name'], $_FILES[$slug]['name'] );

        if (!in_array($filetype['ext'], $valid_types)){ 
            wp_die( __('Prohibited file type!','wp-recall'));
        }
    }

    $file = wp_handle_upload( $_FILES[$slug], array('test_form' => FALSE) );

    if($file['url']){

        if($post_id) $file_id = get_post_meta($post_id,$slug,1);
        else $file_id = get_user_meta($user_id,$slug,1);
        if($file_id) wp_delete_attachment($file_id);

        $attachment = array(
            'post_mime_type' => $file['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['file'])),
            'post_name' => $slug.'-'.$user_id.'-'.$post_id,
            'post_content' => '',
            'guid' => $file['url'],
            'post_parent' => $post_id,
            'post_author' => $user_id,
            'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment( $attachment, $file['file'], $post_id );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file['file'] );
        wp_update_attachment_metadata( $attach_id, $attach_data );

        return $attach_id;

    }
}

function rcl_get_custom_fields($post_id,$posttype=false,$id_form=false){

    if($post_id){
            $post = get_post($post_id);
            $posttype = $post->post_type;
        }

    switch($posttype){
        case 'post':
                if(isset($post)) $id_form = get_post_meta($post->ID,'publicform-id',1);
                if(!$id_form) $id_form = 1;
                $id_field = 'rcl_fields_post_'.$id_form;
        break;
        default: $id_field = 'rcl_fields_'.$posttype;
    }

    return get_option($id_field);
}

function rcl_get_custom_post_meta($post_id){

    $get_fields = rcl_get_custom_fields($post_id);

    if($get_fields){
        $show_custom_field = '';
        $cf = new Rcl_Custom_Fields();
        foreach($get_fields as $custom_field){
            $custom_field = apply_filters('rcl_custom_post_meta',$custom_field);
            if(!$custom_field||!isset($custom_field['slug'])||!$custom_field['slug']) continue;
            $p_meta = get_post_meta($post_id,$custom_field['slug'],true);
            $show_custom_field .= $cf->get_field_value($custom_field,$p_meta);
        }

        return $show_custom_field;
    }
}

if (!is_admin())
    add_filter('the_content','rcl_concat_post_meta',10);
function rcl_concat_post_meta($content){
    global $post,$rcl_options;
    if(!isset($rcl_options['pm_rcl'])||!$rcl_options['pm_rcl'])return $content;
    $pm = rcl_get_custom_post_meta($post->ID);
    if(!$rcl_options['pm_place']) $content .= $pm;
    else $content = $pm.$content;
    return $content;
}

add_action('wp','rcl_download_file');
function rcl_download_file(){
    global $user_ID,$wpdb;

    if ( !isset( $_GET['rcl-download-file'] ) ) return false;
    $id_file = base64_decode($_GET['rcl-download-file']);

    if ( !$user_ID||!wp_verify_nonce( $_GET['_wpnonce'], 'user-'.$user_ID ) ) return false;

    $file = get_post($id_file);

    if(!$file) wp_die(__('File does not exist on the server!','wp-recall'));

    $path = get_attached_file($id_file);

    header( 'Content-Disposition: attachment; filename="'.basename($path).'"' );
    header( "Content-Transfer-Encoding: binary");
    header( 'Pragma: no-cache');
    header( 'Expires: 0');
    header( 'Content-Length: '.filesize($path));
    header( 'Accept-Ranges: bytes' );
    header( 'Content-Type: application/octet-stream' );
    readfile($path);
    exit;
}

if(!is_admin()) add_action('wp','rcl_delete_file');
function rcl_delete_file(){
    global $user_ID,$rcl_options;

    if ( !isset( $_GET['rcl-delete-file'] ) ) return false;
    $id_file = base64_decode($_GET['rcl-delete-file']);

    if ( !$user_ID||!wp_verify_nonce( $_GET['_wpnonce'], 'user-'.$user_ID ) ) return false;

    $file = get_post($id_file);

    if(!$file) wp_die(__('File does not exist on the server!','wp-recall'));

    wp_delete_attachment($file->ID);

    if($file->post_parent){
        wp_redirect(rcl_format_url(get_permalink($rcl_options['public_form_page_rcl'])).'rcl-post-edit='.$file->post_parent);
    }else{
        wp_redirect(rcl_format_url(get_author_posts_url($user_ID),'profile').'&file=deleted');
    }

    exit;
}

if(is_admin()) add_action('admin_init','rcl_delete_file_admin');
function rcl_delete_file_admin(){
    global $user_ID,$rcl_options;

    if ( !isset( $_GET['rcl-delete-file'] ) ) return false;
    $id_file = base64_decode($_GET['rcl-delete-file']);

    if ( !$user_ID||!wp_verify_nonce( $_GET['_wpnonce'], 'user-'.$user_ID ) ) return false;

    $file = get_post($id_file);

    if(!$file) wp_die(__('File does not exist on the server!','wp-recall'));

    wp_delete_attachment($file->ID);

    wp_redirect(admin_url('user-edit.php?user_id='.$_GET['user_id']));

    exit;
}

add_action('delete_attachment','rcl_delete_file_meta');
function rcl_delete_file_meta($post_id){
    $post = get_post($post_id);
    $slug = explode('-',$post->post_name);
    if($post->post_parent) delete_post_meta($post->post_parent,$slug,$post_id);
    else delete_user_meta($post->post_author,$slug,$post_id);
}

add_action('wp','rcl_delete_file_notice');
function rcl_delete_file_notice(){
    if (isset($_GET['file'])&&$_GET['file']='deleted') rcl_notice_text(__('File has deleted','wp-recall'),'success');
}

