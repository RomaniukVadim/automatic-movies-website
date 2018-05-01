<?php

//активация указанного дополнения
function rcl_activate_addon($addon,$activate=true,$dirpath=false){
    //global $active_addons;
    
    //if(!$active_addons) 
        $active_addons = get_site_option('rcl_active_addons');
    
    if(isset($active_addons[$addon])) return false;
    
    $paths = ($dirpath)? array($dirpath): array(RCL_TAKEPATH.'add-on',RCL_PATH.'add-on');

    foreach($paths as $k=>$path){
        if ( false !== strpos($path, '\\') ) $path = str_replace('\\','/',$path);
        $index_src = $path.'/'.$addon.'/index.php';
        
        if(!is_readable($index_src)) continue;

        if(file_exists($index_src)){
            $addon_headers = rcl_get_addon_headers($addon);
            
            $active_addons[$addon] = $addon_headers;
            $active_addons[$addon]['path'] = $path.'/'.$addon;
            $active_addons[$addon]['priority'] = (!$k)? 1: 0;
            
            $install_src = $path.'/'.$addon.'/activate.php';
            
            if($activate&&file_exists($install_src)) include_once($install_src);
            include_once($index_src);
            update_site_option('rcl_active_addons',$active_addons);
            
            do_action('rcl_activate_'.$addon,$active_addons[$addon]);
            //print_r($active_addons);exit;
            return true;

        }
    }

    return false;
}
//деактивация указанного дополнения
function rcl_deactivate_addon($addon,$deactivate=true){
    $active_addons = get_site_option('rcl_active_addons');
    $paths = array(RCL_TAKEPATH.'add-on',RCL_PATH.'add-on');

    foreach($paths as $path){
        if($deactivate&&is_readable($path.'/'.$addon.'/deactivate.php')){
            include_once($path.'/'.$addon.'/deactivate.php');
            break;
        }
    }

    unset($active_addons[$addon]);

    update_site_option('rcl_active_addons',$active_addons);

    do_action('rcl_deactivate_'.$addon);
}
//удаление дополнения
function rcl_delete_addon($addon,$delete=true){
    $active_addons = get_site_option('rcl_active_addons');
    $paths = array(RCL_TAKEPATH.'add-on',RCL_PATH.'add-on');

    foreach($paths as $path){
        if($delete&&is_readable($path.'/'.$addon.'/delete.php')) include_once($path.'/'.$addon.'/delete.php');
        rcl_remove_dir($path.'/'.$addon);
    }

    if(isset($active_addons[$addon])) 
        unset($active_addons[$addon]);

    update_site_option('rcl_active_addons',$active_addons);

    do_action('rcl_delete_'.$addon);
}

function rcl_include_addon($path,$addon=false){
    include_once($path);
}

function rcl_register_shutdown(){
    global $rcl_error;
    
    $error = error_get_last();
    
    if ($error && ($error['type'] == E_ERROR || $error['type'] == E_PARSE || $error['type'] == E_COMPILE_ERROR)) {
        
        $addon = rcl_get_addon_dir($error['file']);
        
        if(!$addon) exit();
        
        $active_addons = get_site_option('rcl_active_addons');
        unset($active_addons[$addon]);
        update_site_option('rcl_active_addons',$active_addons);
        
        $rcl_error .= sprintf("Add-on %s has caused an error and was disabled. The error text: %s","<b>".strtoupper($addon)."</b>","<br>Fatal Error: ".$error['message']." in ".str_replace('\\','/',$error['file']).":".$error['line']."<br>");
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.admin_url('admin.php?page=manage-addon-recall&update-addon=error-activate&error-text='.$rcl_error).'";';
        echo '</script>';
        exit();
    }

}

//парсим содержимое файла info.txt дополнения
function rcl_parse_addon_info($info){
    $addon_data = array();
    $cnt = count($info);

    if($cnt==1) $info = explode(';',$info[0]);

    foreach((array)$info as $string){

        if($cnt>1) $string = str_replace(';','',$string);
        
        if ( false !== strpos($string, ':') ){
            $str = explode(':',$string);
            $title = strtolower(str_replace(' ','-',trim($str[0])));
            if(substr($title, 0, 3) == pack('CCC', 0xef, 0xbb, 0xbf)) {
                $title = substr($title, 3);
            }
            $val = trim(str_replace($str[0].':','',$string));
            $addon_data[$title] = $val;
        }

    }
    
    return $addon_data;
}

function rcl_get_addon_headers($addon_name){
    
    $paths = array(RCL_PATH.'add-on',RCL_TAKEPATH.'add-on') ;
    
    $data = array();
    foreach($paths as $path){
        $addon_dir = $path.'/'.$addon_name;
        $index_src = $addon_dir.'/index.php';
        if(!is_dir($addon_dir)||!file_exists($index_src)) continue;
        $info_src = $addon_dir.'/info.txt';
        if(file_exists($info_src)){
            $file_data = file($info_src);
            $data = rcl_parse_addon_info($file_data);                       
            break;
        } 
    }
    
    return $data;
}

add_action('rcl_before_include_addons','rcl_check_active_template',10);
function rcl_check_active_template(){
    global $active_addons,$rcl_options,$rcl_template;
    
    $templates = rcl_get_install_templates();
    
    if($templates){
        //Если найденный шаблон указан как используемый, то активируем его
        if(!$rcl_template){
            foreach ($templates as $addon_id => $data){

                rcl_activate_addon($addon_id);

                update_option('rcl_active_template',$addon_id);
                
                $rcl_template = $addon_id;
                $active_addons[$addon_id] = $data;
                
                return true;
            }
        }
    }
    
    //Если ни один шаблон не активен
    if(!$templates){
        //ищем шаблоны в папке дополнений
        $templates = rcl_search_templates();
        
        if(!$templates){
            return false;
        }
        
        if($rcl_template){
            //Если найденный шаблон указан как используемый, то активируем его
            if(isset($templates[$rcl_template])){
                rcl_activate_addon($rcl_template);
                $rcl_template = $addon_id;
                $active_addons[$rcl_template] = $templates[$rcl_template];
                return true;
            }
        }
        
        //если используемых шаблонов не указано, то активируем первый попавшийся
        foreach ($templates as $addon_id => $data){

            rcl_activate_addon($addon_id);

            update_option('rcl_active_template',$addon_id);
            $rcl_template = $addon_id;
            $active_addons[$addon_id] = $data;
            
            return true;
        }

    }

}

//Подключаем шаблон личного кабинета
function rcl_include_template_office(){
    global $rcl_options,$active_addons,$rcl_template;
    
    //Если ни один шаблон не активен
    if(!$rcl_template){
        //если опять ничего не найдено
        echo '<h3>'.__('Templates office not found!','wp-recall').'</h3>';
    }else{
        //Если шаблон найден и активирован, то подключаем
        rcl_include_template('office.php',$active_addons[$rcl_template]['path']);           
    }
}

function rcl_get_install_templates(){
    global $rcl_options,$active_addons;
    
    $list = array();
    
    if(!$active_addons) return $list;

    foreach($active_addons as $addon_id=>$addon){
        if(!isset($addon['template'])) continue;
        $list[$addon_id] = $addon;
    }

    return $list;
}

function rcl_search_templates(){
    $paths = array(RCL_PATH.'add-on',RCL_TAKEPATH.'add-on') ;
    
    $templates = array();
    foreach($paths as $path){
        if(!file_exists($path)) continue;
        
        $addons = scandir($path,1);
        
        if(!$addons) continue;
        
        foreach($addons as $namedir){
            $addon_dir = $path.'/'.$namedir;
            $index_src = $addon_dir.'/index.php';
            if(!is_dir($addon_dir)||!file_exists($index_src)) continue;
            $info_src = $addon_dir.'/info.txt';
            if(file_exists($info_src)){
                $file_data = file($info_src);
                $data = rcl_parse_addon_info($file_data); 
                if(!isset($data['template'])) continue;
                $data['path'] = $addon_dir;
                $templates[$namedir] = $data;
            }
        }
    }
    
    return $templates;
}

require_once("rcl_update.php");